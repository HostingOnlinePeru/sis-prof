<?php

namespace App\Models;

use App\Models\Concerns\BelongsToActiveCompany;
use Illuminate\Database\Eloquent\Model;

class Proforma extends Model
{
    protected $connection = 'tenant';

    private const IGV_RATE = 0.18;

    protected $fillable = [
        'number',
        'client_id',
        'issue_date',
        'valid_until',
        'status',
        'template',
        'currency',
        'subject',
        'notes',
        'terms',
        'subtotal',
        'discount_total',
        'tax_total',
        'total',
        'sent_at',
    ];

    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
            'valid_until' => 'date',
            'sent_at' => 'datetime',
            'subtotal' => 'decimal:2',
            'discount_total' => 'decimal:2',
            'tax_total' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Proforma $proforma): void {
            if (! $proforma->status) {
                $proforma->status = 'created';
            }

            if ($proforma->number) {
                return;
            }

            $year = ($proforma->issue_date ?? now())->format('Y');
            // The number remains globally unique even though the records are
            // isolated by company; the database has a unique constraint on it.
            $next = static::withoutGlobalScopes()
                ->where('number', 'like', "PF-{$year}-%")
                ->count() + 1;

            $proforma->number = sprintf('PF-%s-%04d', $year, $next);
        });
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function company()
    {
        return $this->belongsTo(CompanySetting::class, 'company_id');
    }

    public function items()
    {
        return $this->hasMany(ProformaItem::class)->orderBy('sort');
    }

    public function documents()
    {
        return $this->belongsToMany(Document::class)->withTimestamps();
    }

    public function photos()
    {
        return $this->hasMany(ProformaPhoto::class)->orderBy('sort');
    }

    public function recalculateTotals(): void
    {
        $items = $this->items()->get();
        $subtotal = round((float) $items->sum('subtotal'), 2);
        $taxTotal = round($subtotal * self::IGV_RATE, 2);

        $this->forceFill([
            'subtotal' => $subtotal,
            'discount_total' => 0,
            'tax_total' => $taxTotal,
            'total' => round($subtotal + $taxTotal, 2),
        ])->saveQuietly();
    }

    public function whatsappUrl(): string
    {
        $phone = preg_replace('/\D+/', '', (string) $this->client?->whatsapp);
        $message = sprintf(
            'Hola %s, le comparto la proforma %s por un total de %s %s.',
            $this->client?->name,
            $this->number,
            $this->currency,
            number_format((float) $this->total, 2)
        );

        return 'https://wa.me/'.$phone.'?text='.rawurlencode($message);
    }
}
