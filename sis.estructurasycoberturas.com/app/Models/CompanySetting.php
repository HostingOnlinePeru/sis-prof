<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    protected $fillable = [
        'user_id',
        'db_path',
        'business_name',
        'commercial_name',
        'tax_id',
        'default_currency',
        'default_proforma_template',
        'email',
        'phone',
        'mobile_phone',
        'whatsapp',
        'address',
        'website',
        'logo_path',
        'dashboard_logo_path',
        'proforma_logo_path',
        'default_terms',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
