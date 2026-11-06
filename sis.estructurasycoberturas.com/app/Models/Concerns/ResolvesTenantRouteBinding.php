<?php

namespace App\Models\Concerns;

use App\Support\CompanyContext;
use App\Support\TenantDatabaseManager;

trait ResolvesTenantRouteBinding
{
    public function resolveRouteBinding($value, $field = null)
    {
        $company = app(CompanyContext::class)->active();
        if ($company) {
            TenantDatabaseManager::connect($company);
        }

        return parent::resolveRouteBinding($value, $field);
    }
}
