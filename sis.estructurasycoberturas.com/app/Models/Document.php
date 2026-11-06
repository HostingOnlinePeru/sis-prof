<?php

namespace App\Models;

use App\Models\Concerns\BelongsToActiveCompany;
use App\Models\Concerns\ResolvesTenantRouteBinding;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use ResolvesTenantRouteBinding;

    protected $connection = 'tenant';

    protected $fillable = [
        'document_folder_id',
        'title',
        'category',
        'file_path',
        'original_name',
        'mime_type',
        'file_size',
        'description',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
            'file_size' => 'integer',
        ];
    }

    public function folder()
    {
        return $this->belongsTo(DocumentFolder::class, 'document_folder_id');
    }

    public function proformas()
    {
        return $this->belongsToMany(Proforma::class)->withTimestamps();
    }

    public function company()
    {
        return $this->belongsTo(CompanySetting::class, 'company_id');
    }
}
