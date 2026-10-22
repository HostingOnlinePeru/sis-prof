<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProformaPhoto extends Model
{
    protected $connection = 'tenant';
    protected $fillable = [
        'proforma_id',
        'path',
        'original_name',
        'sort',
    ];

    public function proforma()
    {
        return $this->belongsTo(Proforma::class);
    }
}
