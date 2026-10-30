<?php

namespace App\Http\Controllers;

use App\Models\MembershipPlan;
use App\Models\Subscription;
use App\Support\AppShell;
use App\Support\StripeGateway;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class MembershipController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $user = $request->user();

        return AppShell::render($request, [
            'activePage' => 'membership',
            'subtitle' => 'Elige tu plan y paga de forma segura con Stripe.',
            'title' => 'Mi Membresía',
        ], 'membership.partial', [
            'user' => $user,
            'plans' => MembershipPlan::query()->where('is_active', true)->orderBy('months')->get(),
            'payments' => $user->subscriptions()->with('plan')->latest()->take(20)->get(),
            'stripeReady' => StripeGateway::isConfigured(),
            'cancelled' => $request->boolean('cancelado'),
        ]);
    }

    public function checkout(Request $request, MembershipPlan $plan): RedirectResponse
    {
        abort_unless($plan->is_active, 404);

        if (! StripeGateway::isConfigured()) {
            return back()->withErrors(['membership' => 'Los pagos con Stripe aún no están configurados. Inténtalo más tarde.']);
        }

        $user = $request->user();

        $subscription = Subscription::query()->create([
            'user_id' => $user->id,
            'membership_plan_id' => $plan->id,
            'tier' => $plan->tier,
            'status' => 'pending',
            'source' => 'stripe',
            'months' => $plan->months,
            'amount_usd' => $plan->price_usd,
        ]);

        try {
            $session = StripeGateway::createCheckoutSession($user, $plan, $subscription);
        } catch (Throwable $e) {
            $subscription->update(['status' => 'failed', 'notes' => mb_substr($e->getMessage(), 0, 250)]);
            Log::error('Stripe checkout error', ['error' => $e->getMessage()]);

            return back()->withErrors(['membership' => 'No se pudo iniciar el pago: '.$e->getMessage()]);
        }

        $subscription->update(['stripe_session_id' => $session['id']]);

        return redirect()->away($session['url']);
    }

    public function success(Request $request): RedirectResponse
    {
        $sessionId = (string) $request->query('session_id', '');

        $subscription = Subscription::query()
            ->where('stripe_session_id', $sessionId)
            ->where('user_id', $request->user()->id)
            ->first();

        if (! $subscription) {
            return redirect()->route('membership.index')->withErrors(['membership' => 'No encontramos el pago indicado.']);
        }

        try {
            $completed = StripeGateway::completeFromSession(StripeGateway::retrieveSession($sessionId));
        } catch (Throwable $e) {
            Log::error('Stripe verify error', ['error' => $e->getMessage()]);
            $completed = null;
        }

        if (! $completed) {
            return redirect()->route('membership.index')
                ->with('status', 'Estamos confirmando tu pago con Stripe. Tu membresía se activará en unos instantes.');
        }

        return redirect()->route('membership.index')
            ->with('status', '¡Pago confirmado! Tu membresía está activa hasta el '.$completed->ends_at->format('d/m/Y').'.');
    }

    public function webhook(Request $request): Response
    {
        $payload = $request->getContent();

        if (! StripeGateway::verifyWebhookSignature($payload, $request->header('Stripe-Signature'))) {
            return response('Firma inválida', 400);
        }

        $event = json_decode($payload, true) ?: [];
        $type = $event['type'] ?? '';
        $session = $event['data']['object'] ?? [];

        if (in_array($type, ['checkout.session.completed', 'checkout.session.async_payment_succeeded'], true)) {
            StripeGateway::completeFromSession($session);
        } elseif (in_array($type, ['checkout.session.expired', 'checkout.session.async_payment_failed'], true)) {
            Subscription::query()
                ->where('stripe_session_id', $session['id'] ?? '')
                ->where('status', 'pending')
                ->update(['status' => 'failed']);
        }

        return response('ok', 200);
    }
}
