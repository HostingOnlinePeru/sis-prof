<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->string('default_currency', 3)->default('PEN');
            $table->string('mobile_phone')->nullable();
            $table->string('dashboard_logo_path')->nullable();
            $table->string('proforma_logo_path')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->dropColumn([
                'default_currency',
                'mobile_phone',
                'dashboard_logo_path',
                'proforma_logo_path',
            ]);
        });
    }
};
