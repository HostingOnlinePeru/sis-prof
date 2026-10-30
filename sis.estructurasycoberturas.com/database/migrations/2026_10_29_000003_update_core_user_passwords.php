<?php

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

        // 1. Super Admin
        DB::table('users')
            ->where(function ($q) {
                $q->where('email', 'superadmin@sistema.com')
                    ->orWhere('role', 'super_admin');
            })
            ->update([
                'password' => Hash::make('SisProf#Admin2026!Pro'),
                'updated_at' => now(),
            ]);

        // 2. Toldos Sánchez
        DB::table('users')
            ->where('email', 'toldosasanchez10@gmail.com')
            ->update([
                'password' => Hash::make('Toldos$Sanchez2026!Pe'),
                'updated_at' => now(),
            ]);

        // 3. Hosting Online Perú
        DB::table('users')
            ->where('email', 'miguelmundaca79@gmail.com')
            ->update([
                'password' => Hash::make('Hosting#Online2026!Pro'),
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        //
    }
};
