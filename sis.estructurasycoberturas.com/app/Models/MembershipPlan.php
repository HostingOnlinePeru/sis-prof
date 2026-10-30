<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipPlan extends Model
{
    protected $fillable = ['tier', 'name', 'slug', 'months', 'price_usd', 'is_featured', 'is_active'];

    protected function casts(): array
    {
        return [
            'months' => 'integer',
            'price_usd' => 'decimal:2',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function isPremium(): bool
    {
        return $this->tier === 'premium';
    }

    public function tierLabel(): string
    {
        return $this->isPremium() ? 'Premium' : 'Básico';
    }

    public function fullName(): string
    {
        return 'Plan '.$this->tierLabel().' · '.$this->name;
    }

    public function monthlyPrice(): float
    {
        return round((float) $this->price_usd / max(1, $this->months), 2);
    }

    public function durationLabel(): string
    {
        return $this->months === 12 ? '1 año' : $this->months.' meses';
    }
}
