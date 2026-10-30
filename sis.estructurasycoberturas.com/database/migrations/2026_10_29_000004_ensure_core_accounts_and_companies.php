<?php

use App\Models\CompanySetting;
use App\Support\TenantDatabaseManager;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('users')) {
            return;
        }

        $now = now();
        $endsAt = $now->copy()->addMonths(12);

        // 1. Super Admin (superadmin@sistema.com)
        $superAdmin = DB::table('users')
            ->where('email', 'superadmin@sistema.com')
            ->orWhere('role', 'super_admin')
            ->first();

        if ($superAdmin) {
            DB::table('users')->where('id', $superAdmin->id)->update([
                'name' => 'SISPROF Admin',
                'email' => 'superadmin@sistema.com',
                'password' => Hash::make('SisProf#Admin2026!Pro'),
                'role' => 'super_admin',
                'is_active' => true,
                'updated_at' => $now,
            ]);
        } else {
            DB::table('users')->insert([
                'name' => 'SISPROF Admin',
                'email' => 'superadmin@sistema.com',
                'password' => Hash::make('SisProf#Admin2026!Pro'),
                'role' => 'super_admin',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // 2. Toldos Sánchez (toldosasanchez10@gmail.com) -> Plan Básico 1 Año
        $sanchez = DB::table('users')
            ->where('email', 'toldosasanchez10@gmail.com')
            ->orWhere(function ($q) {
                $q->where('role', '!=', 'super_admin')
                    ->where('name', 'like', '%toldos%');
            })
            ->first();

        if ($sanchez) {
            $sanchezId = $sanchez->id;
            DB::table('users')->where('id', $sanchezId)->update([
                'name' => 'Toldos Sánchez',
                'email' => 'toldosasanchez10@gmail.com',
                'password' => Hash::make('Toldos$Sanchez2026!Pe'),
                'role' => 'tenant',
                'is_active' => true,
                'membership_tier' => 'basic',
                'membership_ends_at' => $endsAt,
                'updated_at' => $now,
            ]);
        } else {
            $sanchezId = DB::table('users')->insertGetId([
                'name' => 'Toldos Sánchez',
                'email' => 'toldosasanchez10@gmail.com',
                'password' => Hash::make('Toldos$Sanchez2026!Pe'),
                'role' => 'tenant',
                'is_active' => true,
                'membership_tier' => 'basic',
                'membership_ends_at' => $endsAt,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        if (Schema::hasTable('company_settings')) {
            $sanchezCompany = CompanySetting::query()->where('user_id', $sanchezId)->first();
            if (! $sanchezCompany) {
                $sanchezCompany = CompanySetting::query()
                    ->where('business_name', 'like', '%Toldos%')
                    ->orderBy('id')
                    ->first();

                if ($sanchezCompany) {
                    $sanchezCompany->update(['user_id' => $sanchezId]);
                } else {
                    $sanchezCompany = CompanySetting::query()->create([
                        'user_id' => $sanchezId,
                        'business_name' => 'Toldos Sánchez',
                        'tax_id' => '20601797560',
                        'phone' => '942 668 304',
                        'website' => 'www.toldosyestructurasperu.com',
                        'default_currency' => 'PEN',
                        'default_proforma_template' => 'commercial',
                    ]);
                }
            }
            TenantDatabaseManager::ensureDatabaseExists($sanchezCompany);
        }

        if (Schema::hasTable('subscriptions') && Schema::hasTable('membership_plans')) {
            $basicAnnualPlanId = DB::table('membership_plans')->where('slug', 'basico-anual')->value('id');
            if ($basicAnnualPlanId && ! DB::table('subscriptions')->where('user_id', $sanchezId)->exists()) {
                DB::table('subscriptions')->insert([
                    'user_id' => $sanchezId,
                    'membership_plan_id' => $basicAnnualPlanId,
                    'tier' => 'basic',
                    'status' => 'granted',
                    'source' => 'courtesy',
                    'months' => 12,
                    'amount_usd' => 20,
                    'starts_at' => $now,
                    'ends_at' => $endsAt,
                    'paid_at' => $now,
                    'notes' => 'Plan Básico Anual asignado (1 año)',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        // 3. Hosting Online Perú (miguelmundaca79@gmail.com) -> Plan Premium 1 Año
        $hosting = DB::table('users')
            ->where('email', 'miguelmundaca79@gmail.com')
            ->orWhere(function ($q) {
                $q->where('role', '!=', 'super_admin')
                    ->where('name', 'like', '%hosting%');
            })
            ->first();

        if ($hosting) {
            $hostingId = $hosting->id;
            DB::table('users')->where('id', $hostingId)->update([
                'name' => 'Hosting Online Perú',
                'email' => 'miguelmundaca79@gmail.com',
                'password' => Hash::make('Hosting#Online2026!Pro'),
                'role' => 'tenant',
                'is_active' => true,
                'membership_tier' => 'premium',
                'membership_ends_at' => $endsAt,
                'updated_at' => $now,
            ]);
        } else {
            $hostingId = DB::table('users')->insertGetId([
                'name' => 'Hosting Online Perú',
                'email' => 'miguelmundaca79@gmail.com',
                'password' => Hash::make('Hosting#Online2026!Pro'),
                'role' => 'tenant',
                'is_active' => true,
                'membership_tier' => 'premium',
                'membership_ends_at' => $endsAt,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        if (Schema::hasTable('company_settings')) {
            $hostingCompany = CompanySetting::query()->where('user_id', $hostingId)->first();
            if (! $hostingCompany) {
                $hostingCompany = CompanySetting::query()
                    ->where('business_name', 'like', '%Hosting%')
                    ->orderBy('id')
                    ->first();

                if ($hostingCompany) {
                    $hostingCompany->update([
                        'user_id' => $hostingId,
                        'secondary_currency' => $hostingCompany->secondary_currency ?: 'USD',
                    ]);
                } else {
                    $hostingCompany = CompanySetting::query()->create([
                        'user_id' => $hostingId,
                        'business_name' => 'Hosting Online Perú',
                        'default_currency' => 'PEN',
                        'secondary_currency' => 'USD',
                        'default_proforma_template' => 'commercial',
                    ]);
                }
            }
            TenantDatabaseManager::ensureDatabaseExists($hostingCompany);
        }

        if (Schema::hasTable('subscriptions') && Schema::hasTable('membership_plans')) {
            $premiumAnnualPlanId = DB::table('membership_plans')->where('slug', 'premium-anual')->value('id');
            if ($premiumAnnualPlanId && ! DB::table('subscriptions')->where('user_id', $hostingId)->exists()) {
                DB::table('subscriptions')->insert([
                    'user_id' => $hostingId,
                    'membership_plan_id' => $premiumAnnualPlanId,
                    'tier' => 'premium',
                    'status' => 'granted',
                    'source' => 'courtesy',
                    'months' => 12,
                    'amount_usd' => 35,
                    'starts_at' => $now,
                    'ends_at' => $endsAt,
                    'paid_at' => $now,
                    'notes' => 'Plan Premium Anual asignado (1 año)',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    public function down(): void
    {
        //
    }
};
