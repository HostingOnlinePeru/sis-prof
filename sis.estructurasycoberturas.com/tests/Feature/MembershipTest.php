<?php

namespace Tests\Feature;

use App\Models\CompanySetting;
use App\Models\MembershipPlan;
use App\Models\Subscription;
use App\Models\User;
use App\Support\TenantDatabaseManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MembershipTest extends TestCase
{
    use RefreshDatabase;

    private array $tempTenantFiles = [];

    protected function tearDown(): void
    {
        foreach ($this->tempTenantFiles as $file) {
            if (is_file($file)) {
                @unlink($file);
            }
        }
        parent::tearDown();
    }

    private function createTenantWithCompany(array $userOverrides = []): User
    {
        $user = User::factory()->create(array_merge([
            'role' => 'tenant',
            'is_active' => true,
        ], $userOverrides));

        $tempDb = sys_get_temp_dir().DIRECTORY_SEPARATOR.'tenant_test_'.uniqid().'.sqlite';
        $this->tempTenantFiles[] = $tempDb;

        $company = CompanySetting::query()->create([
            'user_id' => $user->id,
            'business_name' => 'Empresa Demo SAC',
            'default_currency' => 'PEN',
            'default_proforma_template' => 'commercial',
            'db_path' => $tempDb,
        ]);

        TenantDatabaseManager::ensureDatabaseExists($company);

        return $user;
    }

    public function test_new_tenant_receives_seven_days_free_trial_on_basic_tier(): void
    {
        $user = User::factory()->create(['role' => 'tenant']);

        $this->assertTrue($user->hasActiveMembership());
        $this->assertTrue($user->isOnTrial());
        $this->assertFalse($user->isPremium());
        $this->assertEquals(1, $user->maxCompanies());
        $this->assertFalse($user->canUseMultiCurrency());
        $this->assertFalse($user->canUsePhotoGallery());
        $this->assertEquals(User::TRIAL_DAYS, $user->membershipDaysLeft());
    }

    public function test_basic_vs_premium_feature_restrictions(): void
    {
        $basicUser = $this->createTenantWithCompany(['membership_tier' => 'basic']);
        $premiumUser = $this->createTenantWithCompany(['membership_tier' => 'premium']);

        // Basic user cannot access Photo Gallery nor create a 2nd company
        $this->actingAs($basicUser)
            ->get(route('documents.index'))
            ->assertRedirect(route('membership.index'));

        $this->assertFalse($basicUser->canCreateCompany());

        // Premium user can access Photo Gallery and create up to 2 companies
        $this->actingAs($premiumUser)
            ->get(route('documents.index'))
            ->assertOk();

        $this->assertTrue($premiumUser->canCreateCompany());
        $this->assertTrue($premiumUser->canUseMultiCurrency());
    }

    public function test_stripe_checkout_and_webhook_activate_premium_membership_idempotently(): void
    {
        Storage::fake('local');
        config([
            'services.stripe.secret' => 'sk_test_fake123456',
            'services.stripe.webhook_secret' => 'whsec_test_secret',
        ]);

        Http::fake([
            'https://api.stripe.com/v1/checkout/sessions' => Http::response([
                'id' => 'cs_test_session_001',
                'url' => 'https://checkout.stripe.com/c/pay/cs_test_session_001',
            ], 200),
            'https://api.stripe.com/v1/checkout/sessions/cs_test_session_001' => Http::response([
                'id' => 'cs_test_session_001',
                'payment_status' => 'paid',
                'payment_intent' => 'pi_test_001',
            ], 200),
        ]);

        $user = $this->createTenantWithCompany([
            'membership_tier' => 'basic',
            'membership_ends_at' => now()->subDay(),
        ]);

        $plan = MembershipPlan::query()->where('slug', 'premium-semestral')->firstOrFail();

        $response = $this->actingAs($user)->post(route('membership.checkout', $plan));
        $response->assertRedirect('https://checkout.stripe.com/c/pay/cs_test_session_001');

        $subscription = Subscription::query()->where('user_id', $user->id)->firstOrFail();
        $this->assertEquals('pending', $subscription->status);
        $this->assertEquals('premium', $subscription->tier);

        $payload = json_encode([
            'id' => 'evt_test_001',
            'type' => 'checkout.session.completed',
            'data' => [
                'object' => [
                    'id' => 'cs_test_session_001',
                    'payment_status' => 'paid',
                    'payment_intent' => 'pi_test_001',
                ],
            ],
        ]);
        $timestamp = time();
        $signature = hash_hmac('sha256', $timestamp.'.'.$payload, 'whsec_test_secret');

        $this->call('POST', route('stripe.webhook'), [], [], [], [
            'HTTP_STRIPE_SIGNATURE' => "t={$timestamp},v1={$signature}",
            'CONTENT_TYPE' => 'application/json',
        ], $payload)->assertOk();

        $user->refresh();
        $subscription->refresh();

        $this->assertEquals('paid', $subscription->status);
        $this->assertTrue($user->hasActiveMembership());
        $this->assertTrue($user->isPremium());
        $this->assertEquals('Premium · Semestral', $user->currentPlanName());
    }

    public function test_superadmin_can_grant_courtesy_plan_and_configure_stripe(): void
    {
        Storage::fake('local');

        $admin = User::factory()->create([
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        $tenant = $this->createTenantWithCompany([
            'membership_tier' => 'basic',
            'membership_ends_at' => now()->addDays(5),
        ]);

        $plan = MembershipPlan::query()->where('slug', 'premium-anual')->firstOrFail();

        $this->actingAs($admin)
            ->post(route('superadmin.subscriptions.grant'), [
                'user_id' => $tenant->id,
                'membership_plan_id' => $plan->id,
                'notes' => 'Cortesía VIP',
            ])
            ->assertRedirect(route('superadmin.subscriptions.index'));

        $tenant->refresh();
        $this->assertGreaterThan(360, $tenant->membershipDaysLeft());
        $this->assertTrue($tenant->isPremium());
        $this->assertEquals('Premium · Anual', $tenant->currentPlanName());
    }
}
