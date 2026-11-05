<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProformaPhoto extends Model
{
    protected $connection = 'tenant';
    protected $fillable = [
        'proforma_id',
        'path',
        'photo_path',
        'original_name',
        'caption',
        'sort',
    ];

    protected static function booted(): void
    {
        static::saving(function (ProformaPhoto $photo): void {
            if ($photo->path && ! $photo->photo_path) {
                $photo->photo_path = $photo->path;
            } elseif ($photo->photo_path && ! $photo->path) {
                $photo->path = $photo->photo_path;
            }
        });
    }

    public function proforma()
    {
        return $this->belongsTo(Proforma::class);
    }
}
