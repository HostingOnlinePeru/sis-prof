<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Document;
use App\Models\Product;
use App\Models\Proforma;
use App\Models\TermTemplate;
use App\Support\AppShell;
use App\Support\CompanyContext;
use App\Support\LatamCurrencies;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ProformaController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $proformas = Proforma::query()
            ->with('client')
            ->when($request->filled('q'), function ($query) use ($request): void {
                $query->where(function ($query) use ($request): void {
                    $query->where('number', 'like', '%'.$request->string('q').'%')
                        ->orWhere('subject', 'like', '%'.$request->string('q').'%')
                        ->orWhereHas('client', function ($query) use ($request): void {
                            $query->where('name', 'like', '%'.$request->string('q').'%')
                                ->orWhere('company_name', 'like', '%'.$request->string('q').'%')
                                ->orWhere('document_number', 'like', '%'.$request->string('q').'%');
                        });
                });
            })
            ->latest()
            ->get();

        return AppShell::render($request, [
            'activePage' => 'proformas',
            'subtitle' => 'Crea, edita y genera proformas con productos, impuestos y documentos adjuntos.',
            'title' => 'Proformas',
        ], 'proformas.index', [
            'proformas' => $proformas,
            'totalCreated' => Proforma::query()->where('status', 'created')->count(),
            'totalProformas' => Proforma::query()->count(),
            'totalQuoted' => Proforma::query()->sum('total'),
        ]);
    }

    public function create(Request $request): View|JsonResponse
    {
        $company = app(CompanyContext::class)->active();
        $defaultCurrency = $company?->default_currency ?: 'PEN';
        $defaultTerms = TermTemplate::query()->where('active', true)->latest()->value('content')
            ?: TermTemplate::query()->latest()->value('content');

        return $this->renderForm($request, new Proforma([
            'issue_date' => now(),
            'valid_until' => now()->addDays(15),
            'status' => 'created',
            'template' => $company?->default_proforma_template ?: 'commercial',
            'currency' => $defaultCurrency,
            'terms' => $defaultTerms,
        ]));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedData($request);

        $proforma = Proforma::query()->create($validated['proforma']);
        $this->syncItems($proforma, $validated['items']);
        $this->syncPhotos($request, $proforma);
        $proforma->recalculateTotals();

        return redirect()
            ->route('proformas.edit', $proforma)
            ->with('status', 'Proforma generada correctamente.');
    }

    public function edit(Request $request, Proforma $proforma): View|JsonResponse
    {
        $proforma->load(['items.product', 'photos']);

        return $this->renderForm($request, $proforma);
    }

    public function update(Request $request, Proforma $proforma): RedirectResponse
    {
        $validated = $this->validatedData($request);

        $proforma->update($validated['proforma']);
        $proforma->items()->delete();
        $this->syncItems($proforma, $validated['items']);
        $this->syncPhotos($request, $proforma);
        $proforma->recalculateTotals();

        return redirect()
            ->route('proformas.edit', $proforma)
            ->with('status', 'Proforma actualizada correctamente.');
    }

    public function destroy(Proforma $proforma): RedirectResponse
    {
        $proforma->delete();

        return redirect()
            ->route('proformas.index')
            ->with('status', 'Proforma eliminada correctamente.');
    }

    public function updateStatus(Request $request, Proforma $proforma): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:accepted,cancelled'],
        ]);

        $proforma->update(['status' => $data['status']]);

        return redirect()
            ->route('proformas.index')
            ->with('status', 'Estado de la proforma actualizado correctamente.');
    }

    public function storeClient(Request $request): JsonResponse
    {
        $client = Client::query()->create($request->validate([
            'name' => ['required', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'document_number' => ['nullable', 'string', 'max:20'],
            'phone' => ['nullable', 'string', 'max:40'],
            'email' => ['nullable', 'email', 'max:255'],
        ]) + [
            'document_type' => 'RUC',
        ]);

        return response()->json([
            'client' => [
                'id' => $client->id,
                'label' => trim($client->name.($client->company_name ? ' - '.$client->company_name : '')),
            ],
            'message' => 'Cliente creado correctamente.',
        ]);
    }

    private function renderForm(Request $request, Proforma $proforma): View|JsonResponse
    {
        $canUseGallery = (bool) $request->user()?->canUsePhotoGallery();
        $canUseProducts = (bool) $request->user()?->canUseProductsModule();

        return AppShell::render($request, [
            'activePage' => 'proformas',
            'subtitle' => 'Selecciona cliente y redacta los ítems de tu cotización; los totales se calculan automáticamente.',
            'title' => $proforma->exists ? 'Editar Proforma' : 'Generar Proforma',
        ], 'proformas.form', [
            'clients' => Client::query()->orderBy('name')->get(),
            'products' => $canUseProducts
                ? Product::query()->where('active', true)->orderBy('name')->get()
                : collect(),
            'proforma' => $proforma->loadMissing('photos'),
            'galleryPhotos' => $canUseGallery
                ? Document::query()->where('active', true)->where('mime_type', 'like', 'image/%')->latest()->get()
                : collect(),
        ]);
    }

    private function validatedData(Request $request): array
    {
        $company = app(CompanyContext::class)->active();
        $canUseMultiCurrency = (bool) $request->user()?->canUseMultiCurrency();
        $enabledCurrencies = LatamCurrencies::enabledForCompany($company, $canUseMultiCurrency);
        $allowedCodes = array_keys($enabledCurrencies);
        $primaryCurrency = $company?->default_currency ?: 'PEN';

        $data = $request->validate([
            'client_id' => ['required', Rule::exists(Client::class, 'id')],
            'issue_date' => ['required', 'date'],
            'valid_until' => ['nullable', 'date'],
            'template' => ['required', 'in:commercial,technical'],
            'currency' => ['nullable', Rule::in(LatamCurrencies::codes())],
            'subject' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'terms' => ['nullable', 'string', 'max:10000'],
            'remove_photos' => ['nullable', 'array'],
            'remove_photos.*' => ['exists:proforma_photos,id'],
            'gallery_photos' => ['nullable', 'array', 'max:4'],
            'gallery_photos.*' => [Rule::exists(Document::class, 'id')],
            'photos' => ['nullable', 'array', 'max:4'],
            'photos.*' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (! $value instanceof \Illuminate\Http\UploadedFile || ! $value->isValid()) {
                        return;
                    }
                    if ($value->getSize() > 20480 * 1024) {
                        $fail('Cada foto no debe pesar más de 20 MB.');
                        return;
                    }
                    $ext = strtolower($value->getClientOriginalExtension());
                    if (! in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'], true)) {
                        $fail('Cada foto debe ser un archivo de imagen válido (JPG, PNG, GIF, WEBP o SVG).');
                    }
                },
            ],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['nullable', Rule::exists(Product::class, 'id')],
            'items.*.description' => ['required', 'string', 'max:5000'],
            'items.*.unit' => ['required', 'string', 'max:20'],
            'items.*.quantity' => ['required', 'numeric', 'min:0.01'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0'],
        ]);

        foreach ($data['items'] as &$item) {
            $item['description'] = strip_tags($item['description'], [
                'b', 'br', 'div', 'li', 'ol', 'p', 'span', 'strong', 'u', 'ul',
            ]);
        }
        unset($item);

        $chosenCurrency = $data['currency'] ?? $primaryCurrency;
        if (! $canUseMultiCurrency || ! in_array($chosenCurrency, $allowedCodes, true)) {
            $chosenCurrency = $primaryCurrency;
        }

        $defaultTerms = TermTemplate::query()->where('active', true)->latest()->value('content')
            ?: TermTemplate::query()->latest()->value('content');
        $rawTerms = $data['terms'] ?? null;
        $resolvedTerms = ($rawTerms !== null && trim(strip_tags($rawTerms)) !== '')
            ? $rawTerms
            : $defaultTerms;

        return [
            'items' => $data['items'],
            'proforma' => [
                'client_id' => $data['client_id'],
                'issue_date' => $data['issue_date'],
                'valid_until' => $data['valid_until'] ?? null,
                'template' => $data['template'],
                'currency' => $chosenCurrency,
                'subject' => $data['subject'] ?? null,
                'notes' => $data['notes'] ?? null,
                'terms' => $resolvedTerms,
            ],
        ];
    }

    private function syncPhotos(Request $request, Proforma $proforma): void
    {
        if (! $request->user()?->canUsePhotoGallery()) {
            return;
        }

        $removeIds = $request->input('remove_photos', []);

        if ($removeIds) {
            $photosToRemove = $proforma->photos()->whereIn('id', $removeIds)->get();

            foreach ($photosToRemove as $photo) {
                $isSharedWithGallery = Document::query()->where('file_path', $photo->path)->exists();
                if (! $isSharedWithGallery) {
                    Storage::disk('public')->delete($photo->path);
                }
                $photo->delete();
            }
        }

        $existingCount = $proforma->photos()->count();
        $newPhotos = $request->file('photos', []);
        $galleryPhotoIds = $request->input('gallery_photos', []);
        $galleryDocs = $galleryPhotoIds
            ? Document::query()->whereIn('id', $galleryPhotoIds)->where('active', true)->get()
            : collect();

        if ($existingCount + count($newPhotos) + $galleryDocs->count() > 4) {
            throw ValidationException::withMessages([
                'photos' => 'La proforma solo puede tener hasta 4 fotos en total.',
            ]);
        }

        $sort = $existingCount;

        foreach ($galleryDocs as $doc) {
            $sort++;
            $proforma->photos()->create([
                'path' => $doc->file_path,
                'original_name' => $doc->original_name ?: $doc->title,
                'sort' => $sort,
            ]);
        }

        foreach ($newPhotos as $photo) {
            $sort++;
            $proforma->photos()->create([
                'path' => $photo->store('proformas/photos', 'public'),
                'original_name' => $photo->getClientOriginalName(),
                'sort' => $sort,
            ]);
        }
    }

    private function syncItems(Proforma $proforma, array $items): void
    {
        foreach (array_values($items) as $index => $item) {
            $proforma->items()->create([
                'product_id' => $item['product_id'] ?? null,
                'description' => $item['description'],
                'unit' => $item['unit'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'discount_rate' => 0,
                'tax_rate' => 0,
                'sort' => $index + 1,
            ]);
        }
    }
}
