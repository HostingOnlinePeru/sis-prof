<?php

namespace App\Models;

use App\Models\Concerns\BelongsToActiveCompany;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $connection = 'tenant';

    protected $fillable = [
        'name',
        'company_name',
        'document_type',
        'document_number',
        'contact_name',
        'email',
        'phone',
        'whatsapp',
        'address',
        'notes',
    ];

    public function proformas()
    {
        return $this->hasMany(Proforma::class);
    }

    public function company()
    {
        return $this->belongsTo(CompanySetting::class, 'company_id');
    }
}
