<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $tables = [
        'clients',
        'proformas',
        'products',
        'product_categories',
        'term_templates',
        'documents',
        'document_folders',
    ];

    public function up(): void
    {
        $companyId = DB::table('company_settings')->orderBy('id')->value('id');

        if (! $companyId) {
            $companyId = DB::table('company_settings')->insertGetId([
                'business_name' => 'Empresa principal',
                'default_currency' => 'PEN',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $blueprint): void {
                $blueprint->foreignId('company_id')->nullable()->after('id')->constrained('company_settings')->cascadeOnDelete();
            });

            DB::table($table)->whereNull('company_id')->update(['company_id' => $companyId]);
        }
    }

    public function down(): void
    {
        foreach (array_reverse($this->tables) as $table) {
            Schema::table($table, function (Blueprint $blueprint): void {
                $blueprint->dropConstrainedForeignId('company_id');
            });
        }
    }
};
