<?php

namespace App\Models;

use App\Models\Concerns\BelongsToActiveCompany;
use Illuminate\Database\Eloquent\Model;

class TermTemplate extends Model
{
    protected $connection = 'tenant';

    protected $fillable = [
        'name',
        'title',
        'content',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (TermTemplate $item): void {
            if ($item->name && ! $item->title) {
                $item->title = $item->name;
            } elseif ($item->title && ! $item->name) {
                $item->name = $item->title;
            }
        });
    }

    public function company()
    {
        return $this->belongsTo(CompanySetting::class, 'company_id');
    }
}
