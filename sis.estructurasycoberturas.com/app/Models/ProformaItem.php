<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProformaItem extends Model
{
    protected $connection = 'tenant';
    protected $fillable = [
        'proforma_id',
        'product_id',
        'description',
        'unit',
        'quantity',
        'unit_price',
        'discount_rate',
        'tax_rate',
        'subtotal',
        'discount_amount',
        'tax_amount',
        'total',
        'sort',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
            'unit_price' => 'decimal:2',
            'discount_rate' => 'decimal:2',
            'tax_rate' => 'decimal:2',
            'subtotal' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (ProformaItem $item): void {
            $subtotal = (float) $item->quantity * (float) $item->unit_price;

            $item->subtotal = round($subtotal, 2);
            $item->discount_rate = 0;
            $item->discount_amount = 0;
            $item->tax_rate = 0;
            $item->tax_amount = 0;
            $item->total = round($subtotal, 2);
        });

        static::saved(fn (ProformaItem $item) => $item->proforma?->recalculateTotals());
        static::deleted(fn (ProformaItem $item) => $item->proforma?->recalculateTotals());
    }

    public function proforma()
    {
        return $this->belongsTo(Proforma::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
