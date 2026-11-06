<?php

namespace App\Models;

use App\Models\Concerns\BelongsToActiveCompany;
use App\Models\Concerns\ResolvesTenantRouteBinding;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use ResolvesTenantRouteBinding;

    protected $connection = 'tenant';

    protected $fillable = [
        'name',
        'description',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function company()
    {
        return $this->belongsTo(CompanySetting::class, 'company_id');
    }
}
