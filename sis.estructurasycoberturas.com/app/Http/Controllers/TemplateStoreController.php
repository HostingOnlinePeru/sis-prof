<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\CompanySetting;
use App\Models\Proforma;
use App\Models\TemplatePurchase;
use App\Support\AppShell;
use App\Support\CompanyContext;
use App\Support\StripeGateway;
use App\Support\TemplateCatalog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;

class TemplateStoreController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $user = $request->user();
        $templates = TemplateCatalog::forUser($user);
        $company = app(CompanyContext::class)->active();

        return AppShell::render($request, [
            'activePage' => 'templates',
            'subtitle' => 'Explora el catálogo de modelos disponibles para tus proformas. Todos los planes incluyen los modelos gratuitos.',
            'title' => 'Plantillas de Proformas',
        ], 'templates.index', [
            'user' => $user,
            'company' => $company,
            'templates' => $templates,
            'stripeReady' => StripeGateway::isConfigured(),
            'defaultTemplate' => $company?->default_proforma_template ?: 'commercial',
            'cancelled' => $request->boolean('cancelado'),
        ]);
    }

    public function preview(Request $request, string $slug): Response|View
    {
        $template = TemplateCatalog::find($slug);
        abort_unless($template, 404, 'Plantilla no encontrada');

        $company = app(CompanyContext::class)->active() ?: new CompanySetting([
            'commercial_name' => 'Toldos, Carpas y Estructuras Sánchez SAC',
            'tax_id' => '20601234567',
            'phone' => '+51 987 654 321',
            'email' => 'ventas@toldossanchez.com',
            'website' => 'www.toldossanchez.com',
            'address' => 'Av. Los Ficus 123, San Juan de Lurigancho, Lima',
            'default_currency' => 'PEN',
        ]);

        $mockClient = new Client([
            'name' => 'Constructora e Inmobiliaria Horizonte SAC',
            'company_name' => 'Constructora Horizonte',
            'document_number' => '20556677889',
            'phone' => '+51 912 345 678',
            'email' => 'contacto@horizonte.pe',
            'address' => 'Av. Javier Prado Este 4560, Surco, Lima',
        ]);

        $mockProforma = new Proforma([
            'number' => 'PF-2026-0045',
            'issue_date' => now(),
            'valid_until' => now()->addDays(15),
            'currency' => 'PEN',
            'subject' => 'Fabricación e instalación de toldos tensados para patio principal',
            'subtotal' => 16000.00,
            'discount_total' => 0.00,
            'tax_total' => 2880.00,
            'total' => 18880.00,
            'template' => $slug,
            'terms' => '<b>Validez de la oferta:</b> 15 días calendario.<br><b>Forma de pago:</b> 50% de adelanto y 50% contra entrega e instalación.<br><b>Garantía:</b> 2 años en lona tensada y estructura de acero galvanizado.',
        ]);

        $mockProforma->setRelation('company', $company);
        $mockProforma->setRelation('client', $mockClient);
        $mockProforma->setRelation('photos', collect());
        $mockProforma->setRelation('items', collect([
            (object) [
                'description' => '<b>Toldo tensado arquitectónico 10x8m</b> con estructura metálica electrogalvanizada y cubierta de membrana PVC ignífuga de alta resistencia.',
                'unit' => 'GLB',
                'quantity' => 1,
                'unit_price' => 11500.00,
                'total' => 11500.00,
            ],
            (object) [
                'description' => '<b>Sistema de anclaje con zapatas de concreto y cables de acero inoxidable</b> de 1/2 pulgada con tensores de alta tensión.',
                'unit' => 'JGO',
                'quantity' => 1,
                'unit_price' => 2500.00,
                'total' => 2500.00,
            ],
            (object) [
                'description' => '<b>Servicio de transporte, izaje, montaje e instalación</b> en obra por personal homologado con seguro SCTR.',
                'unit' => 'SERV',
                'quantity' => 1,
                'unit_price' => 2000.00,
                'total' => 2000.00,
            ],
        ]));

        if ($request->boolean('pdf')) {
            $viewName = match ($slug) {
                'technical' => 'proformas.pdf-technical',
                'modelo-northline-teal' => 'proformas.templates.modelo-northline-teal',
                default => 'proformas.pdf-commercial',
            };

            return Pdf::loadView($viewName, [
                'company' => $company,
                'proforma' => $mockProforma,
            ])->setPaper('a4')->stream('preview-'.$slug.'.pdf');
        }

        $viewName = match ($slug) {
            'technical' => 'proformas.pdf-technical',
            'modelo-northline-teal' => 'proformas.templates.modelo-northline-teal',
            default => 'proformas.pdf-commercial',
        };

        return response(view($viewName, [
            'company' => $company,
            'proforma' => $mockProforma,
        ])->render());
    }

    public function checkout(Request $request, string $slug): RedirectResponse
    {
        $template = TemplateCatalog::find($slug);
        abort_unless($template, 404, 'Plantilla no encontrada');

        $user = $request->user();

        if ($template['is_free'] || $user->hasUnlockedTemplate($slug)) {
            return redirect()->route('templates.index')
                ->with('status', 'Esta plantilla ya se encuentra desbloqueada en tu cuenta.');
        }

        $purchase = TemplatePurchase::query()->firstOrCreate(
            [
                'user_id' => $user->id,
                'template_slug' => $slug,
            ],
            [
                'amount_usd' => $template['price_usd'] ?? 5.00,
                'status' => 'pending',
                'source' => 'stripe',
            ]
        );

        if (! StripeGateway::isConfigured()) {
            // Direct unlock in testing or if Stripe is not yet configured
            $purchase->update([
                'status' => 'completed',
                'source' => 'courtesy',
                'notes' => 'Desbloqueo de activación directa',
            ]);

            return redirect()->route('templates.index')
                ->with('status', "¡Plantilla \"{$template['name']}\" desbloqueada exitosamente para tus proformas!");
        }

        try {
            $session = StripeGateway::createTemplateCheckoutSession($user, $template, $purchase);
            $purchase->update(['stripe_session_id' => $session['id']]);

            return redirect()->away($session['url']);
        } catch (Throwable $e) {
            Log::error('Template Stripe checkout error', ['error' => $e->getMessage()]);

            return back()->withErrors(['template' => 'No se pudo iniciar el pago: '.$e->getMessage()]);
        }
    }

    public function success(Request $request): RedirectResponse
    {
        $sessionId = (string) $request->query('session_id', '');
        $purchaseId = (int) $request->query('purchase_id', 0);

        $purchase = TemplatePurchase::query()
            ->where('user_id', $request->user()->id)
            ->where(function ($q) use ($sessionId, $purchaseId) {
                if ($sessionId) {
                    $q->where('stripe_session_id', $sessionId);
                }
                if ($purchaseId) {
                    $q->orWhere('id', $purchaseId);
                }
            })
            ->first();

        if ($purchase) {
            $purchase->update([
                'status' => 'completed',
                'notes' => 'Pago confirmado con Stripe',
            ]);

            $template = TemplateCatalog::find($purchase->template_slug);
            $name = $template['name'] ?? 'la plantilla';

            return redirect()->route('templates.index')
                ->with('status', "¡Pago confirmado! La plantilla \"{$name}\" ya está desbloqueada en tu cuenta.");
        }

        return redirect()->route('templates.index')
            ->with('status', 'Tu pago ha sido procesado. La plantilla ya está disponible.');
    }

    public function setDefault(Request $request, string $slug): RedirectResponse
    {
        $template = TemplateCatalog::find($slug);
        abort_unless($template, 404);

        $user = $request->user();
        if (! $template['is_free'] && ! $user->hasUnlockedTemplate($slug)) {
            return back()->withErrors(['template' => 'Debes desbloquear la plantilla antes de usarla como predeterminada.']);
        }

        $company = app(CompanyContext::class)->active();
        if ($company) {
            $company->update(['default_proforma_template' => $slug]);
        }

        return redirect()->route('templates.index')
            ->with('status', "Se estableció \"{$template['name']}\" como tu modelo de proforma predeterminado.");
    }
}
