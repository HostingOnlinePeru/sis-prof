<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('membership_plans')) {
            return;
        }

        $now = now();

        $standardPlans = [
            [
                'tier' => 'standard',
                'name' => 'Trimestral',
                'slug' => 'estandar-trimestral',
                'months' => 3,
                'price_usd' => 10,
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'tier' => 'standard',
                'name' => 'Semestral',
                'slug' => 'estandar-semestral',
                'months' => 6,
                'price_usd' => 20,
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'tier' => 'standard',
                'name' => 'Anual',
                'slug' => 'estandar-anual',
                'months' => 12,
                'price_usd' => 35,
                'is_featured' => true,
                'is_active' => true,
            ],
        ];

        foreach ($standardPlans as $plan) {
            $exists = DB::table('membership_plans')->where('slug', $plan['slug'])->exists();
            if (! $exists) {
                DB::table('membership_plans')->insert(array_merge($plan, [
                    'created_at' => $now,
                    'updated_at' => $now,
                ]));
            } else {
                DB::table('membership_plans')->where('slug', $plan['slug'])->update([
                    'price_usd' => $plan['price_usd'],
                    'updated_at' => $now,
                ]);
            }
        }

        $premiumPrices = [
            'premium-trimestral' => 15,
            'premium-semestral' => 25,
            'premium-anual' => 45,
        ];

        foreach ($premiumPrices as $slug => $priceUsd) {
            DB::table('membership_plans')->where('slug', $slug)->update([
                'price_usd' => $priceUsd,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('membership_plans')) {
            DB::table('membership_plans')->where('tier', 'standard')->delete();
        }
    }
};
