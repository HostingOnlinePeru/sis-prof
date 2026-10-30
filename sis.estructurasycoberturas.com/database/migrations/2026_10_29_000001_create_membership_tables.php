<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership_plans', function (Blueprint $table) {
            $table->id();
            $table->string('tier')->default('basic'); // basic, premium
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedSmallInteger('months');
            $table->decimal('price_usd', 10, 2);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('membership_plan_id')->nullable()->constrained('membership_plans')->nullOnDelete();
            $table->string('tier')->default('basic'); // basic, premium
            $table->string('status')->default('pending'); // pending, paid, failed, granted
            $table->string('source')->default('stripe'); // stripe, courtesy
            $table->unsignedSmallInteger('months');
            $table->decimal('amount_usd', 10, 2)->default(0);
            $table->string('stripe_session_id')->nullable()->unique();
            $table->string('stripe_payment_intent')->nullable();
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->foreignId('granted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('notes')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('membership_tier')->default('basic')->after('is_active');
            $table->timestamp('membership_ends_at')->nullable()->after('membership_tier');
        });

        $now = now();

        DB::table('membership_plans')->insert([
            // Planes Básicos
            ['tier' => 'basic', 'name' => 'Trimestral', 'slug' => 'basico-trimestral', 'months' => 3, 'price_usd' => 5, 'is_featured' => false, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['tier' => 'basic', 'name' => 'Semestral', 'slug' => 'basico-semestral', 'months' => 6, 'price_usd' => 10, 'is_featured' => false, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['tier' => 'basic', 'name' => 'Anual', 'slug' => 'basico-anual', 'months' => 12, 'price_usd' => 20, 'is_featured' => true, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            // Planes Premium
            ['tier' => 'premium', 'name' => 'Trimestral', 'slug' => 'premium-trimestral', 'months' => 3, 'price_usd' => 10, 'is_featured' => false, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['tier' => 'premium', 'name' => 'Semestral', 'slug' => 'premium-semestral', 'months' => 6, 'price_usd' => 20, 'is_featured' => false, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['tier' => 'premium', 'name' => 'Anual', 'slug' => 'premium-anual', 'months' => 12, 'price_usd' => 35, 'is_featured' => true, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ]);

        $basicAnnualPlanId = DB::table('membership_plans')->where('slug', 'basico-anual')->value('id');
        $premiumAnnualPlanId = DB::table('membership_plans')->where('slug', 'premium-anual')->value('id');

        // Toldos Sánchez -> Plan Básico de 1 año
        $basicUsers = DB::table('users')
            ->where('role', '!=', 'super_admin')
            ->where(function ($query) {
                $query->where('email', 'toldosasanchez10@gmail.com')
                    ->orWhere('name', 'like', '%toldos%');
            })
            ->pluck('id');

        foreach ($basicUsers as $userId) {
            $endsAt = $now->copy()->addMonths(12);

            DB::table('subscriptions')->insert([
                'user_id' => $userId,
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

            DB::table('users')->where('id', $userId)->update([
                'membership_tier' => 'basic',
                'membership_ends_at' => $endsAt,
            ]);
        }

        // Hosting Online Perú -> Plan Premium de 1 año
        $premiumUsers = DB::table('users')
            ->where('role', '!=', 'super_admin')
            ->where(function ($query) {
                $query->where('email', 'miguelmundaca79@gmail.com')
                    ->orWhere('name', 'like', '%hosting%');
            })
            ->pluck('id');

        foreach ($premiumUsers as $userId) {
            $endsAt = $now->copy()->addMonths(12);

            DB::table('subscriptions')->insert([
                'user_id' => $userId,
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

            DB::table('users')->where('id', $userId)->update([
                'membership_tier' => 'premium',
                'membership_ends_at' => $endsAt,
            ]);
        }

        // El resto de cuentas existentes recibe la prueba gratuita de 7 días en Plan Básico
        DB::table('users')
            ->where('role', '!=', 'super_admin')
            ->whereNull('membership_ends_at')
            ->update([
                'membership_tier' => 'basic',
                'membership_ends_at' => $now->copy()->addDays(7),
            ]);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'membership_tier')) {
                $table->dropColumn('membership_tier');
            }
            if (Schema::hasColumn('users', 'membership_ends_at')) {
                $table->dropColumn('membership_ends_at');
            }
        });

        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('membership_plans');
    }
};
