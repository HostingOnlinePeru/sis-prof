<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('company_settings') && ! Schema::hasColumn('company_settings', 'secondary_currency')) {
            Schema::table('company_settings', function (Blueprint $table) {
                $table->string('secondary_currency', 10)->nullable()->after('default_currency');
            });
        }

        if (Schema::hasTable('users') && Schema::hasTable('company_settings')) {
            $premiumUserIds = DB::table('users')
                ->where('membership_tier', 'premium')
                ->pluck('id');

            if ($premiumUserIds->isNotEmpty()) {
                DB::table('company_settings')
                    ->whereIn('user_id', $premiumUserIds)
                    ->whereNull('secondary_currency')
                    ->update(['secondary_currency' => 'USD']);
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('company_settings') && Schema::hasColumn('company_settings', 'secondary_currency')) {
            Schema::table('company_settings', function (Blueprint $table) {
                $table->dropColumn('secondary_currency');
            });
        }
    }
};
