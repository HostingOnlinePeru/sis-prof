<?php

namespace App\Support;

use App\Models\CompanySetting;
use App\Models\Proforma;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPdf;

class ProformaPdf
{
    public static function make(Proforma $proforma, ?CompanySetting $company = null): DomPdf
    {
        $proforma->loadMissing(['company', 'client', 'items.product', 'documents', 'photos']);

        $view = $proforma->template === 'technical'
            ? 'proformas.pdf-technical'
            : 'proformas.pdf-commercial';

        return Pdf::loadView($view, [
            'company' => $company ?: $proforma->company,
            'proforma' => $proforma,
        ])->setPaper('a4');
    }
}
