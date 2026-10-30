<?php

namespace App\Support;

use App\Models\MembershipPlan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Throwable;

/**
 * Integración con Stripe Checkout mediante la API REST (sin SDK).
 */
class StripeGateway
{
    private const API = 'https://api.stripe.com/v1';
    private const SETTINGS_FILE = 'stripe_settings.enc';

    public static function settings(): array
    {
        $stored = [];

        if (Storage::disk('local')->exists(self::SETTINGS_FILE)) {
            try {
                $decrypted = Crypt::decryptString(Storage::disk('local')->get(self::SETTINGS_FILE));
                $stored = json_decode($decrypted, true) ?: [];
            } catch (Throwable) {
                $stored = [];
            }
        }

        return [
            'key' => $stored['key'] ?? config('services.stripe.key'),
            'secret' => $stored['secret'] ?? config('services.stripe.secret'),
            'webhook_secret' => $stored['webhook_secret'] ?? config('services.stripe.webhook_secret'),
        ];
    }

    public static function saveSettings(array $input): void
    {
        $current = self::settings();

        $next = [
            'key' => array_key_exists('key', $input) && filled($input['key']) ? trim((string) $input['key']) : ($current['key'] ?? null),
            'secret' => array_key_exists('secret', $input) && filled($input['secret']) ? trim((string) $input['secret']) : ($current['secret'] ?? null),
            'webhook_secret' => array_key_exists('webhook_secret', $input) && filled($input['webhook_secret']) ? trim((string) $input['webhook_secret']) : ($current['webhook_secret'] ?? null),
        ];

        Storage::disk('local')->put(self::SETTINGS_FILE, Crypt::encryptString(json_encode($next)));
    }

    public static function secret(): ?string
    {
        return self::settings()['secret'] ?: null;
    }

    public static function publicKey(): ?string
    {
        return self::settings()['key'] ?: null;
    }

    public static function webhookSecret(): ?string
    {
        return self::settings()['webhook_secret'] ?: null;
    }

    public static function isConfigured(): bool
    {
        return filled(self::secret());
    }

    public static function mode(): ?string
    {
        $secret = (string) self::secret();

        if ($secret === '') {
            return null;
        }

        return str_starts_with($secret, 'sk_live_') ? 'live' : 'test';
    }

    public static function createCheckoutSession(User $user, MembershipPlan $plan, Subscription $subscription): array
    {
        $response = Http::withToken((string) self::secret())
            ->asForm()
            ->post(self::API.'/checkout/sessions', [
                'mode' => 'payment',
                'customer_email' => $user->email,
                'client_reference_id' => (string) $subscription->id,
                'success_url' => route('membership.success').'?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('membership.index').'?cancelado=1',
                'line_items' => [[
                    'quantity' => 1,
                    'price_data' => [
                        'currency' => 'usd',
                        'unit_amount' => (int) round((float) $plan->price_usd * 100),
                        'product_data' => [
                            'name' => 'SISPROF - '.$plan->fullName().' ('.$plan->durationLabel().')',
                        ],
                    ],
                ]],
                'metadata' => [
                    'subscription_id' => $subscription->id,
                    'user_id' => $user->id,
                    'plan' => $plan->slug,
                    'tier' => $plan->tier,
                ],
            ]);

        if ($response->failed()) {
            throw new RuntimeException($response->json('error.message') ?: 'No se pudo iniciar el pago con Stripe.');
        }

        return $response->json();
    }

    public static function retrieveSession(string $sessionId): array
    {
        $response = Http::withToken((string) self::secret())
            ->get(self::API.'/checkout/sessions/'.urlencode($sessionId));

        if ($response->failed()) {
            throw new RuntimeException($response->json('error.message') ?: 'No se pudo verificar el pago con Stripe.');
        }

        return $response->json();
    }

    public static function verifyWebhookSignature(string $payload, ?string $header, int $tolerance = 300): bool
    {
        $secret = self::webhookSecret();

        if (! $secret || ! $header) {
            return false;
        }

        $timestamp = null;
        $signatures = [];

        foreach (explode(',', $header) as $part) {
            [$key, $value] = array_pad(explode('=', trim($part), 2), 2, null);
            if ($key === 't') {
                $timestamp = (int) $value;
            } elseif ($key === 'v1') {
                $signatures[] = $value;
            }
        }

        if (! $timestamp || empty($signatures) || abs(time() - $timestamp) > $tolerance) {
            return false;
        }

        $expected = hash_hmac('sha256', $timestamp.'.'.$payload, $secret);

        foreach ($signatures as $signature) {
            if (hash_equals($expected, (string) $signature)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Marca la suscripción como pagada y extiende la membresía (idempotente).
     */
    public static function completeFromSession(array $session): ?Subscription
    {
        if (($session['payment_status'] ?? null) !== 'paid') {
            return null;
        }

        $subscription = Subscription::query()->where('stripe_session_id', $session['id'] ?? '')->first();

        if (! $subscription) {
            return null;
        }

        return MembershipService::activate($subscription, 'paid', [
            'stripe_payment_intent' => is_string($session['payment_intent'] ?? null) ? $session['payment_intent'] : null,
        ]);
    }
}
