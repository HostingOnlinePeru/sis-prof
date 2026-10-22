<?php

namespace App\Models\Concerns;

use App\Support\CompanyContext;
use Illuminate\Database\Eloquent\Builder;

trait BelongsToActiveCompany
{
    protected static function bootBelongsToActiveCompany(): void
    {
        static::addGlobalScope('active_company', function (Builder $builder): void {
            $companyId = app(CompanyContext::class)->id();

            if ($companyId) {
                $builder->where($builder->getModel()->getTable().'.company_id', $companyId);
            }
        });

        static::creating(function (self $model): void {
            if (! $model->company_id) {
                $model->company_id = app(CompanyContext::class)->id();
            }
        });
    }
}
