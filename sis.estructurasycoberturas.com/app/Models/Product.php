<?php

namespace App\Models;

use App\Models\Concerns\BelongsToActiveCompany;
use App\Models\Concerns\ResolvesTenantRouteBinding;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use ResolvesTenantRouteBinding;

    protected $connection = 'tenant';

    protected $fillable = [
        'product_category_id',
        'sku',
        'name',
        'description',
        'unit',
        'price',
        'tax_rate',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'tax_rate' => 'decimal:2',
            'active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Product $product): void {
            if ($product->active !== null && ! isset($product->attributes['is_active'])) {
                $product->is_active = $product->active;
            }
            if ($product->product_category_id && ! isset($product->attributes['category_id'])) {
                $product->category_id = $product->product_category_id;
            }
        });
    }

    public function proformaItems()
    {
        return $this->hasMany(ProformaItem::class);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function company()
    {
        return $this->belongsTo(CompanySetting::class, 'company_id');
    }
}
