<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'user_id', 'membership_plan_id', 'tier', 'status', 'source', 'months', 'amount_usd',
        'stripe_session_id', 'stripe_payment_intent', 'starts_at', 'ends_at', 'paid_at',
        'granted_by', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'months' => 'integer',
            'amount_usd' => 'decimal:2',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'paid_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(MembershipPlan::class, 'membership_plan_id');
    }

    public function isCompleted(): bool
    {
        return in_array($this->status, ['paid', 'granted'], true);
    }

    public function tierLabel(): string
    {
        return ($this->tier ?? $this->plan?->tier) === 'premium' ? 'Premium' : 'Básico';
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'paid' => 'Pagado',
            'granted' => 'Asignado',
            'failed' => 'Fallido',
            default => 'Pendiente',
        };
    }
}
