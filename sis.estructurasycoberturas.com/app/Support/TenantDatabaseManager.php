<?php

namespace App\Support;

use App\Models\CompanySetting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

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
            File::makeDirectory($dir, 0755, true);
        }

        $dbPath = static::getDatabasePath($company);

        $isNew = ! File::exists($dbPath);

        if ($isNew) {
            File::put($dbPath, '');
            if ($company->db_path !== $dbPath) {
                $company->update(['db_path' => $dbPath]);
            }
        }

        static::configureConnection($dbPath);

        if ($isNew) {
            static::runTenantMigrations();
        }

        return $dbPath;
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
