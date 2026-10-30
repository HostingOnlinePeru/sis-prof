<?php

namespace App\Support;

use App\Models\CompanySetting;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class TenantDatabaseManager
{
    public static function getDatabasePath(CompanySetting $company): string
    {
        if ($company->db_path && File::exists($company->db_path)) {
            return $company->db_path;
        }

        return database_path("tenants/company_{$company->id}.sqlite");
    }

    public static function ensureDatabaseExists(CompanySetting $company): string
    {
        $dir = database_path('tenants');

        if (! File::exists($dir)) {
            File::makeDirectory($dir, 0777, true);
            @chmod($dir, 0777);
        }

        $dbPath = static::getDatabasePath($company);

        $isNew = ! File::exists($dbPath);

        if ($isNew) {
            File::put($dbPath, '');
            @chmod($dbPath, 0666);
            if ($company->db_path !== $dbPath) {
                try {
                    $company->update(['db_path' => $dbPath]);
                } catch (\Throwable $e) {
                    // Ignore if central DB is temporarily read-only
                }
            }
        }

        static::configureConnection($dbPath);

        try {
            if ($isNew || ! Schema::connection('tenant')->hasTable('clients')) {
                static::runTenantMigrations();
            } else {
                static::ensureTenantColumns();
            }
        } catch (\Throwable $e) {
            report($e);
        }

        return $dbPath;
    }

    public static function ensureTenantColumns(): void
    {
        $schema = Schema::connection('tenant');

        if ($schema->hasTable('documents') && ! $schema->hasColumn('documents', 'document_folder_id')) {
            $schema->table('documents', function (Blueprint $table) use ($schema) {
                $table->unsignedBigInteger('document_folder_id')->nullable();
                if (! $schema->hasColumn('documents', 'title')) {
                    $table->string('title')->nullable();
                }
                if (! $schema->hasColumn('documents', 'category')) {
                    $table->string('category')->nullable();
                }
                if (! $schema->hasColumn('documents', 'original_name')) {
                    $table->string('original_name')->nullable();
                }
                if (! $schema->hasColumn('documents', 'mime_type')) {
                    $table->string('mime_type')->nullable();
                }
                if (! $schema->hasColumn('documents', 'description')) {
                    $table->text('description')->nullable();
                }
                if (! $schema->hasColumn('documents', 'active')) {
                    $table->boolean('active')->default(true);
                }
            });
        }

        if (! $schema->hasTable('document_proforma')) {
            $schema->create('document_proforma', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('document_id');
                $table->unsignedBigInteger('proforma_id');
                $table->timestamps();
            });
        }

        if ($schema->hasTable('proforma_photos') && ! $schema->hasColumn('proforma_photos', 'path')) {
            $schema->table('proforma_photos', function (Blueprint $table) use ($schema) {
                $table->string('path')->nullable();
                if (! $schema->hasColumn('proforma_photos', 'original_name')) {
                    $table->string('original_name')->nullable();
                }
                if (! $schema->hasColumn('proforma_photos', 'sort')) {
                    $table->unsignedInteger('sort')->default(0);
                }
            });
        }

        if ($schema->hasTable('proforma_items') && ! $schema->hasColumn('proforma_items', 'unit')) {
            $schema->table('proforma_items', function (Blueprint $table) use ($schema) {
                $table->string('unit')->default('UND');
                if (! $schema->hasColumn('proforma_items', 'discount_rate')) {
                    $table->decimal('discount_rate', 5, 2)->default(0);
                }
                if (! $schema->hasColumn('proforma_items', 'tax_rate')) {
                    $table->decimal('tax_rate', 5, 2)->default(18);
                }
                if (! $schema->hasColumn('proforma_items', 'subtotal')) {
                    $table->decimal('subtotal', 12, 2)->default(0);
                }
                if (! $schema->hasColumn('proforma_items', 'discount_amount')) {
                    $table->decimal('discount_amount', 12, 2)->default(0);
                }
                if (! $schema->hasColumn('proforma_items', 'tax_amount')) {
                    $table->decimal('tax_amount', 12, 2)->default(0);
                }
                if (! $schema->hasColumn('proforma_items', 'total')) {
                    $table->decimal('total', 12, 2)->default(0);
                }
                if (! $schema->hasColumn('proforma_items', 'sort')) {
                    $table->unsignedInteger('sort')->default(0);
                }
            });
        }

        if ($schema->hasTable('term_templates') && ! $schema->hasColumn('term_templates', 'name')) {
            $schema->table('term_templates', function (Blueprint $table) {
                $table->string('name')->nullable();
            });
        }
        if ($schema->hasTable('term_templates') && ! $schema->hasColumn('term_templates', 'active')) {
            $schema->table('term_templates', function (Blueprint $table) {
                $table->boolean('active')->default(true);
            });
        }
    }

    public static function connect(CompanySetting $company): void
    {
        $dbPath = static::ensureDatabaseExists($company);
        static::configureConnection($dbPath);
    }

    public static function configureConnection(string $dbPath): void
    {
        config(['database.connections.tenant.database' => $dbPath]);
        DB::purge('tenant');
        DB::reconnect('tenant');
    }

    public static function runTenantMigrations(): void
    {
        Artisan::call('migrate', [
            '--database' => 'tenant',
            '--path' => 'database/migrations/tenant',
            '--force' => true,
        ]);
    }
}
