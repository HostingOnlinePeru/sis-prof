<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('template_purchases')) {
            DB::table('template_purchases')
                ->where('source', 'courtesy')
                ->delete();
        }
    }

    public function down(): void
    {
    }
};
