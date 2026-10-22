<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('proformas')->where('status', 'draft')->update(['status' => 'created']);
        DB::table('proformas')->where('status', 'void')->update(['status' => 'cancelled']);
    }

    public function down(): void
    {
        DB::table('proformas')->where('status', 'created')->update(['status' => 'draft']);
        DB::table('proformas')->where('status', 'cancelled')->update(['status' => 'void']);
    }
};
