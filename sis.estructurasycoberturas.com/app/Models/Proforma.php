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
        'proforma_number',
        'client_id',
        'issue_date',
        'valid_until',
        'expiration_date',
        'status',
        'template',
        'currency',
        'subject',
        'notes',
        'terms',
        'subtotal',
        'discount_total',
        'tax',
        'tax_total',
        'total',
        'sent_at',
    ];

    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
            'valid_until' => 'date',
            'expiration_date' => 'date',
            'sent_at' => 'datetime',
            'subtotal' => 'decimal:2',
            'discount_total' => 'decimal:2',
            'tax' => 'decimal:2',
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

            $currentNumber = $proforma->number ?: $proforma->proforma_number;

            if (! $currentNumber) {
                $year = ($proforma->issue_date ?? now())->format('Y');
                $prefix = "PF-{$year}-";

                $allNumbers = static::withoutGlobalScopes()
                    ->where(function ($q) use ($prefix) {
                        $q->where('number', 'like', "{$prefix}%")
                            ->orWhere('proforma_number', 'like', "{$prefix}%");
                    })
                    ->get(['number', 'proforma_number']);

                $maxSeq = 0;
                foreach ($allNumbers as $row) {
                    $val = $row->number ?: $row->proforma_number;
                    if (preg_match('/^PF-\d{4}-(\d+)$/', (string) $val, $m)) {
                        $seq = (int) $m[1];
                        if ($seq > $maxSeq) {
                            $maxSeq = $seq;
                        }
                    }
                }

                $next = $maxSeq + 1;
                $currentNumber = sprintf('PF-%s-%04d', $year, $next);
            }

            if (static::hasTableColumn('number')) {
                $proforma->number = $currentNumber;
            }
            if (static::hasTableColumn('proforma_number')) {
                $proforma->proforma_number = $currentNumber;
            }

            if (static::hasTableColumn('expiration_date') && $proforma->valid_until) {
                $proforma->expiration_date = $proforma->valid_until;
            } elseif (static::hasTableColumn('valid_until') && ! $proforma->valid_until && isset($proforma->attributes['expiration_date'])) {
                $proforma->valid_until = $proforma->attributes['expiration_date'];
            }

            if (static::hasTableColumn('tax') && $proforma->tax_total !== null) {
                $proforma->tax = $proforma->tax_total;
            }
        });

        static::updating(function (Proforma $proforma): void {
            if (static::hasTableColumn('proforma_number') && $proforma->number && ! $proforma->proforma_number) {
                $proforma->proforma_number = $proforma->number;
            } elseif (static::hasTableColumn('number') && $proforma->proforma_number && ! $proforma->number) {
                $proforma->number = $proforma->proforma_number;
            }

            if (static::hasTableColumn('expiration_date') && $proforma->valid_until) {
                $proforma->expiration_date = $proforma->valid_until;
            }
        });
    }

    public static function hasTableColumn(string $column): bool
    {
        static $columnCache = [];

        try {
            $connName = (new static)->getConnectionName() ?: 'tenant';
            if (! isset($columnCache[$connName])) {
                $columnCache[$connName] = (new static)->getConnection()->getSchemaBuilder()->getColumnListing('proformas');
            }

            return in_array($column, $columnCache[$connName], true);
        } catch (\Throwable $e) {
            return false;
        }
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
        $total = round($subtotal + $taxTotal, 2);

        $attributes = [
            'subtotal' => $subtotal,
            'discount_total' => 0,
            'tax_total' => $taxTotal,
            'total' => $total,
        ];

        try {
            $connection = $this->getConnection();
            $schema = $connection->getSchemaBuilder();
            if ($schema->hasColumn($this->getTable(), 'tax')) {
                $attributes['tax'] = $taxTotal;
            }
            if ($schema->hasColumn($this->getTable(), 'proforma_number') && ! $this->proforma_number) {
                $attributes['proforma_number'] = $this->number;
            }
        } catch (\Throwable $e) {
            // Ignore schema check on failure
        }

        $this->forceFill($attributes)->saveQuietly();
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
