<?php

namespace App\Http\Controllers;

use App\Models\MembershipPlan;
use App\Models\Subscription;
use App\Models\User;
use App\Support\AppShell;
use App\Support\MembershipService;
use App\Support\StripeGateway;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuperAdminSubscriptionController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $tenants = User::query()->where('role', '!=', 'super_admin');

        $stats = [
            'active' => (clone $tenants)->where('membership_ends_at', '>', now())->count(),
            'expiring' => (clone $tenants)->whereBetween('membership_ends_at', [now(), now()->addDays(7)])->count(),
            'expired' => (clone $tenants)->where(fn ($q) => $q->whereNull('membership_ends_at')->orWhere('membership_ends_at', '<=', now()))->count(),
            'revenue' => (float) Subscription::query()->where('status', 'paid')->sum('amount_usd'),
        ];

        $stripeSettings = StripeGateway::settings();

        return AppShell::render($request, [
            'activePage' => 'saas_memberships',
            'subtitle' => 'Pagos de Stripe, vencimientos y asignación de planes.',
            'title' => 'Membresías SaaS',
        ], 'superadmin.subscriptions.partial', [
            'stats' => $stats,
            'plans' => MembershipPlan::query()->orderBy('months')->get(),
            'tenants' => User::query()->where('role', '!=', 'super_admin')->orderBy('name')->get(),
            'payments' => Subscription::query()->with(['user', 'plan'])->latest()->take(100)->get(),
            'stripeConfigured' => StripeGateway::isConfigured(),
            'stripeMode' => StripeGateway::mode(),
            'stripeKey' => $stripeSettings['key'] ?? '',
            'stripeSecretMasked' => filled($stripeSettings['secret']) ? substr($stripeSettings['secret'], 0, 8).'••••••••'.substr($stripeSettings['secret'], -4) : '',
            'stripeWebhookMasked' => filled($stripeSettings['webhook_secret']) ? substr($stripeSettings['webhook_secret'], 0, 8).'••••••••'.substr($stripeSettings['webhook_secret'], -4) : '',
            'webhookUrl' => route('stripe.webhook'),
        ]);
    }

    public function saveStripe(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'key' => ['nullable', 'string', 'max:255'],
            'secret' => ['nullable', 'string', 'max:255'],
            'webhook_secret' => ['nullable', 'string', 'max:255'],
        ]);

        StripeGateway::saveSettings($data);

        return redirect()->route('superadmin.subscriptions.index')
            ->with('status', 'Credenciales de Stripe guardadas correctamente.');
    }

    public function updatePlan(Request $request, MembershipPlan $plan): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'price_usd' => ['required', 'numeric', 'min:1', 'max:9999'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $plan->update([
            'name' => $data['name'],
            'price_usd' => $data['price_usd'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('superadmin.subscriptions.index')
            ->with('status', "Plan {$plan->name} actualizado (\${$plan->price_usd} USD).");
    }

    public function grant(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'membership_plan_id' => ['required', 'exists:membership_plans,id'],
            'notes' => ['nullable', 'string', 'max:250'],
        ]);

        $user = User::query()->findOrFail($data['user_id']);
        $plan = MembershipPlan::query()->findOrFail($data['membership_plan_id']);

        $subscription = Subscription::query()->create([
            'user_id' => $user->id,
            'membership_plan_id' => $plan->id,
            'tier' => $plan->tier,
            'status' => 'pending',
            'source' => 'courtesy',
            'months' => $plan->months,
            'amount_usd' => 0,
            'granted_by' => $request->user()->id,
            'notes' => $data['notes'] ?? null,
        ]);

        $subscription = MembershipService::activate($subscription, 'granted');

        return redirect()->route('superadmin.subscriptions.index')
            ->with('status', "{$plan->fullName()} asignado a {$user->name}. Vence el {$subscription->ends_at->format('d/m/Y')}.");
    }
}
