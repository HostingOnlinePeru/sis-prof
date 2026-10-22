<?php

namespace App\Http\Controllers;

use App\Mail\ProformaEmail;
use App\Models\CompanySetting;
use App\Models\Document;
use App\Models\Proforma;
use App\Support\AppShell;
use App\Support\CompanyContext;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProformaEmailController extends Controller
{
    public function create(Request $request, Proforma $proforma): View|JsonResponse
    {
        $proforma->load(['client', 'documents']);
        $company = app(CompanyContext::class)->active();
        $logoPath = $company?->proforma_logo_path
            ?: $company?->dashboard_logo_path
            ?: $company?->logo_path;
        $defaultMessage = sprintf(
            "Estimado(a) %s,\n\nLe enviamos adjunta la proforma %s, preparada de acuerdo con la información solicitada.\n\nNuestra propuesta está pensada para brindarle una solución práctica, segura y de buena calidad para su proyecto. Quedamos atentos para resolver cualquier consulta, ajustar detalles si fuera necesario y coordinar los siguientes pasos.\n\nSerá un gusto poder atenderlo.",
            $proforma->client?->name ?: 'cliente',
            $proforma->number
        );

        return AppShell::render($request, [
            'activePage' => 'proformas',
            'subtitle' => 'Envía la proforma en PDF al correo del cliente y adjunta documentos del repositorio.',
            'title' => 'Enviar proforma por correo',
        ], 'proformas.email', [
            'documents' => Document::query()
                ->with('folder.parent.parent.parent')
                ->where('active', true)
                ->orderBy('title')
                ->get(),
            'proforma' => $proforma,
            'company' => $company,
            'companyLogoUrl' => CompanyProfileController::publicLogoUrl($logoPath),
            'selectedDocuments' => $proforma->documents->pluck('id')->all(),
            'defaultMessage' => $defaultMessage,
        ]);
    }

    public function send(Request $request, Proforma $proforma): RedirectResponse
    {
        $companyId = app(CompanyContext::class)->id();

        $data = $request->validate([
            'to' => ['required', 'email', 'max:255'],
            'cc' => ['nullable', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            'documents' => ['nullable', 'array'],
            'documents.*' => [Rule::exists(Document::class, 'id')],
        ]);

        $proforma->load(['client', 'items.product', 'documents', 'photos']);
        $company = app(CompanyContext::class)->active();
        $documents = Document::query()
            ->whereIn('id', $data['documents'] ?? [])
            ->where('active', true)
            ->get();

        $mail = Mail::to($data['to']);

        if (! empty($data['cc'])) {
            $mail->cc($data['cc']);
        }

        $mail->send(new ProformaEmail(
            proforma: $proforma,
            company: $company,
            bodyMessage: $data['message'],
            documents: $documents,
        ));

        $proforma->forceFill([
            'status' => 'sent',
            'sent_at' => now(),
        ])->save();

        return redirect()
            ->route('proformas.email', $proforma)
            ->with('status', 'Correo enviado correctamente.');
    }
}
