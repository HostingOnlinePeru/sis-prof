<?php

namespace App\Http\Controllers;

use App\Models\Proforma;
use App\Support\ProformaPdf;
use Illuminate\Http\Request;

class ProformaPdfController extends Controller
{
    public function __invoke(Request $request, Proforma $proforma)
    {
        $pdf = ProformaPdf::make($proforma);

        return $request->boolean('download')
            ? $pdf->download($proforma->number.'.pdf')
            : $pdf->stream($proforma->number.'.pdf');
    }
}
