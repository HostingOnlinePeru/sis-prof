<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'is_active', 'membership_tier', 'membership_ends_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'membership_ends_at' => 'datetime',
        ];
    }

    public const TRIAL_DAYS = 7;

    public const PRO_MAX_PRODUCTS = 20;

    protected static function booted(): void
    {
        static::creating(function (User $user) {
            if ($user->role !== 'super_admin') {
                if (empty($user->membership_tier)) {
                    $user->membership_tier = 'basic';
                }
                if (empty($user->membership_ends_at)) {
                    $user->membership_ends_at = now()->addDays(self::TRIAL_DAYS);
                }
            }
        });
    }

    public function companies()
    {
        return $this->hasMany(CompanySetting::class, 'user_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function hasActiveMembership(): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->membership_ends_at !== null && $this->membership_ends_at->isFuture();
    }

    public function membershipDaysLeft(): int
    {
        if (! $this->membership_ends_at || $this->membership_ends_at->isPast()) {
            return 0;
        }

        // Días calendario: baja 1 cada medianoche (activado ayer con 1 año => 364).
        return max(1, (int) now()->startOfDay()->diffInDays($this->membership_ends_at->copy()->startOfDay()));
    }

    public function isOnTrial(): bool
    {
        return ! $this->isSuperAdmin()
            && ! $this->subscriptions()->whereIn('status', ['paid', 'granted'])->exists();
    }

    public function isPremium(): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->membership_tier === 'premium';
    }

    public function currentTierLabel(): string
    {
        return $this->isPremium() ? 'Premium' : 'Básico';
    }

    public function maxCompanies(): int
    {
        return $this->isPremium() ? 2 : 1;
    }

    public function canCreateCompany(): bool
    {
        return $this->companies()->count() < $this->maxCompanies();
    }

    public function canUseMultiCurrency(): bool
    {
        return $this->isPremium();
    }

    public function canUsePhotoGallery(): bool
    {
        return $this->isPremium();
    }

    public function canUseProductsModule(): bool
    {
        return $this->isSuperAdmin() || $this->isPremium();
    }

    public function maxProducts(): int
    {
        return $this->canUseProductsModule() ? self::PRO_MAX_PRODUCTS : 0;
    }

    public function canCreateProduct(int $currentCount): bool
    {
        return $this->canUseProductsModule() && $currentCount < self::PRO_MAX_PRODUCTS;
    }

    public function currentPlanName(): ?string
    {
        $last = $this->subscriptions()
            ->whereIn('status', ['paid', 'granted'])
            ->with('plan')
            ->latest('ends_at')
            ->first();

        if ($last?->plan) {
            return $last->plan->tierLabel().' · '.$last->plan->name;
        }

        return $this->currentTierLabel();
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isTenant(): bool
    {
        return $this->role === 'tenant' || empty($this->role);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
