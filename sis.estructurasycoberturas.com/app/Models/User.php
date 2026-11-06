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

    public const BASIC_MAX_PROFORMAS_MONTH = 50;

    public const STANDARD_MAX_PROFORMAS_MONTH = 100;

    public const CORPORATE_MAX_RECEIPTS_MONTH = 50;

    public const CORPORATE_MAX_DISPATCH_GUIDES_MONTH = 50;

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

    public function templatePurchases()
    {
        return $this->hasMany(TemplatePurchase::class);
    }

    public function hasUnlockedTemplate(string $slug): bool
    {
        if (in_array($slug, ['commercial', 'technical'], true)) {
            return true;
        }

        return $this->templatePurchases()
            ->where('template_slug', $slug)
            ->where('status', 'completed')
            ->where('source', '!=', 'courtesy')
            ->exists();
    }

    public function unlockTemplate(string $slug, float $amount = 5.00, string $source = 'courtesy', ?string $stripeSessionId = null): TemplatePurchase
    {
        return $this->templatePurchases()->updateOrCreate(
            ['template_slug' => $slug],
            [
                'amount_usd' => $amount,
                'status' => 'completed',
                'source' => $source,
                'stripe_session_id' => $stripeSessionId,
                'notes' => 'Plantilla desbloqueada para la cuenta',
            ]
        );
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

    public function isBasic(): bool
    {
        if ($this->isSuperAdmin()) {
            return false;
        }

        return empty($this->membership_tier) || $this->membership_tier === 'basic';
    }

    public function isStandard(): bool
    {
        if ($this->isSuperAdmin()) {
            return false;
        }

        return $this->membership_tier === 'standard';
    }

    public function isPremium(): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return in_array($this->membership_tier, ['premium', 'corporate'], true);
    }

    public function isCorporate(): bool
    {
        return $this->isPremium();
    }

    public function currentTierLabel(): string
    {
        if ($this->isPremium()) {
            return 'Corporativo';
        }

        if ($this->isStandard()) {
            return 'Stándar';
        }

        return 'Básico';
    }

    public function maxProformasPerMonth(): ?int
    {
        if ($this->isSuperAdmin() || $this->isPremium()) {
            return null;
        }

        if ($this->isStandard()) {
            return self::STANDARD_MAX_PROFORMAS_MONTH;
        }

        return self::BASIC_MAX_PROFORMAS_MONTH;
    }

    public function canCreateProforma(int $currentMonthCount): bool
    {
        $max = $this->maxProformasPerMonth();

        return $max === null || $currentMonthCount < $max;
    }

    public function maxCompanies(): int
    {
        return ($this->isPremium() || $this->isStandard()) ? 2 : 1;
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
        return $this->isSuperAdmin() || $this->isPremium() || $this->isStandard();
    }

    public function maxProducts(): int
    {
        return $this->canUseProductsModule() ? self::PRO_MAX_PRODUCTS : 0;
    }

    public function canCreateProduct(int $currentCount): bool
    {
        return $this->canUseProductsModule() && $currentCount < self::PRO_MAX_PRODUCTS;
    }

    public function canIssueReceipts(): bool
    {
        return $this->isPremium();
    }

    public function maxReceiptsPerMonth(): int
    {
        return $this->canIssueReceipts() ? self::CORPORATE_MAX_RECEIPTS_MONTH : 0;
    }

    public function canGenerateDispatchGuides(): bool
    {
        return $this->isPremium();
    }

    public function maxDispatchGuidesPerMonth(): int
    {
        return $this->canGenerateDispatchGuides() ? self::CORPORATE_MAX_DISPATCH_GUIDES_MONTH : 0;
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
