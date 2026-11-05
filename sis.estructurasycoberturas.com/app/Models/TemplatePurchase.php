<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TemplatePurchase extends Model
{
    protected $fillable = [
        'user_id',
        'template_slug',
        'amount_usd',
        'status',
        'source',
        'stripe_session_id',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'amount_usd' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
