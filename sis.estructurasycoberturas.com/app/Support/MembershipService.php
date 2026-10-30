<?php

namespace App\Support;

use App\Models\Subscription;
use Illuminate\Support\Facades\DB;

class MembershipService
{
    /**
     * Activa una suscripción: suma los meses a partir del vencimiento actual
     * (si aún está vigente) o desde hoy, y actualiza el nivel (basic/premium). Es idempotente.
     */
    public static function activate(Subscription $subscription, string $status = 'paid', array $extra = []): Subscription
    {
        return DB::transaction(function () use ($subscription, $status, $extra) {
            $subscription = Subscription::query()->with('plan')->lockForUpdate()->findOrFail($subscription->id);

            if ($subscription->isCompleted()) {
                return $subscription;
            }

            $user = $subscription->user()->lockForUpdate()->first();
            $tier = $subscription->plan?->tier ?: ($subscription->tier ?: 'basic');

            $start = ($user->membership_ends_at && $user->membership_ends_at->isFuture())
                ? $user->membership_ends_at->copy()
                : now();
            $end = $start->copy()->addMonths($subscription->months);

            $subscription->update(array_merge([
                'tier' => $tier,
                'status' => $status,
                'starts_at' => $start,
                'ends_at' => $end,
                'paid_at' => now(),
            ], $extra));

            $user->update([
                'membership_tier' => $tier,
                'membership_ends_at' => $end,
            ]);

            return $subscription;
        });
    }
}
