@php
    $activeCompany = app(\App\Support\CompanyContext::class)->active();
    $defaultConfiguredTerms = \App\Models\TermTemplate::query()->where('active', true)->latest()->value('content')
        ?: \App\Models\TermTemplate::query()->latest()->value('content')
        ?: '';
    $rawProformaTerms = old('terms', $proforma->terms);
    if ($rawProformaTerms === null || trim(strip_tags((string) $rawProformaTerms)) === '') {
        $rawProformaTerms = $defaultConfiguredTerms;
    }
    $termsContent = html_entity_decode((string) $rawProformaTerms, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $items = old('items');

    if (! $items) {
        $items = $proforma->exists
            ? $proforma->items->map(fn ($item) => [
                'product_id' => $item->product_id,
                'description' => $item->description,
                'unit' => $item->unit,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
            ])->all()
            : [[
                'product_id' => null,
                'description' => '',
                'unit' => 'UND',
                'quantity' => 1,
                'unit_price' => 0,
            ]];
    }

    $productOptions = function ($selected = null) use ($products) {
        foreach ($products as $product) {
            echo '<option value="'.$product->id.'"'
                .' data-description="'.e($product->description).'"'
                .' data-unit="'.e($product->unit).'"'
                .' data-price="'.e($product->price).'"'
                .((string) $selected === (string) $product->id ? ' selected' : '')
                .'>'.e($product->name).'</option>';
        }
    };
@endphp

@if (session('status'))
    <div class="notice">{{ session('status') }}</div>
@endif

@if ($errors->any())
    <div class="errors">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<form class="form-grid" method="post" action="{{ $proforma->exists ? route('proformas.update', $proforma) : route('proformas.store') }}" enctype="multipart/form-data" data-ajax-form data-proforma-form>
    @csrf
    @if ($proforma->exists)
        @method('PUT')
    @endif

    <section class="panel">
        <div class="sp-section-title">
            <h3>Datos de la proforma</h3>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <a class="button secondary" href="{{ route('proformas.index') }}" data-ajax-link data-nav="proformas">Listado</a>
                @if ($proforma->exists)
                    <a class="button secondary" href="{{ route('proformas.pdf', $proforma) }}" target="_blank">Ver PDF</a>
                    <a class="button secondary" href="{{ route('proformas.email', $proforma) }}" data-ajax-link data-nav="proformas">
                        <svg class="button-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path d="M4 4h16v16H4z"/>
                            <path d="m4 7 8 6 8-6"/>
                        </svg>
                        <span>Enviar correo</span>
                    </a>
                @endif
            </div>
        </div>

        <div class="company-grid">
            @if ($proforma->exists)
                <div class="field">
                    <label>Número correlativo</label>
                    <input value="{{ $proforma->number }}" disabled>
                </div>
            @endif

            <div class="field">
                <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-bottom: 7px;">
                    <label for="client_id" style="margin-bottom: 0;">Cliente</label>
                    <button class="button secondary" type="button" data-open-modal="clientQuickModal" style="min-height: 34px; padding: 0 12px;">
                        <svg class="button-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"/>
                            <circle cx="9.5" cy="7" r="4"/>
                            <path d="M19 8v6"/>
                            <path d="M16 11h6"/>
                        </svg>
                        <span>Generar cliente</span>
                    </button>
                </div>
                <select id="client_id" name="client_id" required>
                    <option value="">Seleccionar cliente</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}" @selected((string) old('client_id', $proforma->client_id) === (string) $client->id)>
                            {{ $client->name }}{{ $client->company_name ? ' - '.$client->company_name : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="subject">Asunto</label>
                <input id="subject" name="subject" value="{{ old('subject', $proforma->subject) }}" placeholder="Ej. Proforma por suministro e instalación">
            </div>

            <div class="field">
                <label for="issue_date">Fecha</label>
                <input id="issue_date" name="issue_date" type="date" value="{{ old('issue_date', $proforma->issue_date?->format('Y-m-d') ?: now()->format('Y-m-d')) }}" required>
            </div>

            <div class="field">
                <label for="valid_until">Válida hasta</label>
                <input id="valid_until" name="valid_until" type="date" value="{{ old('valid_until', $proforma->valid_until?->format('Y-m-d')) }}">
            </div>

            @php
                $activeCompany = app(\App\Support\CompanyContext::class)->active();
                $enabledCurrencies = \App\Support\LatamCurrencies::enabledForCompany($activeCompany, (bool) auth()->user()?->canUseMultiCurrency());
                $selectedProformaCurrency = old('currency', $proforma->currency ?: ($activeCompany?->default_currency ?: 'PEN'));
                if (! isset($enabledCurrencies[$selectedProformaCurrency]) && $proforma->exists && $proforma->currency) {
                    $enabledCurrencies[$proforma->currency] = \App\Support\LatamCurrencies::get($proforma->currency);
                }
            @endphp

            @if (count($enabledCurrencies) > 1)
                <div class="field">
                    <label for="currency">Moneda</label>
                    <select id="currency" name="currency" required>
                        @foreach ($enabledCurrencies as $code => $cItem)
                            <option value="{{ $code }}" @selected($selectedProformaCurrency === $code)>
                                {{ $cItem['symbol'] }} — {{ $cItem['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @else
                @php
                    $onlyCurrency = reset($enabledCurrencies) ?: \App\Support\LatamCurrencies::get('PEN');
                @endphp
                <div class="field">
                    <label>Moneda</label>
                    <input value="{{ $onlyCurrency['symbol'] }} — {{ $onlyCurrency['name'] }}" disabled>
                    <input type="hidden" name="currency" value="{{ $onlyCurrency['code'] }}">
                </div>
            @endif

            <div class="field">
                <label for="template">Modelo PDF</label>
                <select id="template" name="template" required>
                    <option value="commercial" @selected(old('template', $proforma->template) === 'commercial')>Modelo 1</option>
                    <option value="technical" @selected(old('template', $proforma->template) === 'technical')>Modelo 2</option>
                </select>
            </div>

        </div>
    </section>

    <section class="panel">
        <div class="sp-section-title">
            <h3>Ítems de la proforma</h3>
            <button class="button blue" type="button" data-proforma-add>
                <svg class="button-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                    <path d="M12 5v14"/>
                    <path d="M5 12h14"/>
                </svg>
                <span>Agregar ítem</span>
            </button>
        </div>

        <div class="form-grid" data-proforma-items>
            @foreach ($items as $index => $item)
                <article class="panel" data-proforma-row>
                    <div class="actions proforma-item-actions">
                        <button class="button secondary" type="button" data-proforma-remove>Quitar ítem</button>
                    </div>
                    <div class="company-grid">
                        @if (auth()->user()?->canUseProductsModule())
                            <div class="field">
                                <label>Producto</label>
                                <select name="items[{{ $index }}][product_id]" data-product-select>
                                    <option value="">Descripción manual</option>
                                    {!! $productOptions($item['product_id'] ?? null) !!}
                                </select>
                            </div>
                        @else
                            <input type="hidden" name="items[{{ $index }}][product_id]" value="">
                        @endif

                        <div class="field">
                            <label>Unidad</label>
                            <input name="items[{{ $index }}][unit]" value="{{ $item['unit'] ?? 'UND' }}" required>
                        </div>

                        <div class="field full">
                            <label>Descripción</label>
                            <div class="rich-toolbar" aria-label="Formato de la descripción">
                                <div class="tool-group">
                                    <button class="tool-button" type="button" data-editor-command="bold" title="Negrita" aria-label="Negrita"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 4h8a4 4 0 0 1 4 4 4 4 0 0 1-4 4H6z"/><path d="M6 12h9a4 4 0 0 1 4 4 4 4 0 0 1-4 4H6z"/></svg></button>
                                    <button class="tool-button" type="button" data-editor-command="underline" title="Subrayado" aria-label="Subrayado"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 3v7a6 6 0 0 0 6 6 6 6 0 0 0 6-6V3"/><line x1="4" y1="21" x2="20" y2="21"/></svg></button>
                                    <button class="tool-button" type="button" data-editor-command="insertUnorderedList" title="Lista" aria-label="Lista"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg></button>
                                    <button class="tool-button" type="button" data-editor-command="insertOrderedList" title="Lista numerada" aria-label="Lista numerada"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="10" y1="6" x2="21" y2="6"/><line x1="10" y1="12" x2="21" y2="12"/><line x1="10" y1="18" x2="21" y2="18"/><path d="M4 6h1v4"/><path d="M4 10h2"/><path d="M6 18H4c0-1 2-2 2-3s-1-1.5-2-1"/></svg></button>
                                </div>
                                <div class="tool-group">
                                    <button class="tool-button" type="button" data-editor-command="upper" title="MAYÚSCULAS" aria-label="MAYÚSCULAS"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m3 16 4.5-9 4.5 9"/><path d="M4.5 13h6"/><path d="M18 16V8"/><path d="M15 11l3-3 3 3"/></svg></button>
                                    <button class="tool-button" type="button" data-editor-command="lower" title="minúsculas" aria-label="minúsculas"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m3 16 4.5-9 4.5 9"/><path d="M4.5 13h6"/><path d="M18 8v8"/><path d="M15 13l3 3 3-3"/></svg></button>
                                    <button class="tool-button" type="button" data-editor-command="removeFormat" title="Limpiar formato" aria-label="Limpiar formato"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m7 21-4.3-4.3a1 1 0 0 1 0-1.4l10-10a1 1 0 0 1 1.4 0l6 6a1 1 0 0 1 0 1.4L13 21z"/><path d="M22 21H7"/><path d="m5 11 9 9"/></svg></button>
                                </div>
                            </div>
                            <div class="rich-editor proforma-description-editor" contenteditable="true" role="textbox" aria-multiline="true" data-rich-editor data-target="#proforma_item_description_{{ $index }}">{!! $item['description'] ?? '' !!}</div>
                            <input id="proforma_item_description_{{ $index }}" name="items[{{ $index }}][description]" type="hidden" value="{{ $item['description'] ?? '' }}" required>
                        </div>

                        <div class="field">
                            <label>Cantidad</label>
                            <input name="items[{{ $index }}][quantity]" type="number" step="0.01" min="0.01" value="{{ $item['quantity'] ?? 1 }}" required data-proforma-calc>
                        </div>

                        <div class="field">
                            <label>Precio unitario</label>
                            <input name="items[{{ $index }}][unit_price]" type="number" step="0.01" min="0" value="{{ $item['unit_price'] ?? 0 }}" required data-proforma-calc>
                        </div>

                        <div class="field">
                            <label>Total ítem</label>
                            <input value="0.00" disabled data-line-total>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <template data-proforma-template>
            <article class="panel" data-proforma-row>
                <div class="actions proforma-item-actions">
                    <button class="button secondary" type="button" data-proforma-remove>Quitar ítem</button>
                </div>
                <div class="company-grid">
                    @if (auth()->user()?->canUseProductsModule())
                        <div class="field">
                            <label>Producto</label>
                            <select name="items[__INDEX__][product_id]" data-product-select>
                                <option value="">Descripción manual</option>
                                {!! $productOptions() !!}
                            </select>
                        </div>
                    @else
                        <input type="hidden" name="items[__INDEX__][product_id]" value="">
                    @endif
                    <div class="field">
                        <label>Unidad</label>
                        <input name="items[__INDEX__][unit]" value="UND" required>
                    </div>
                    <div class="field full">
                        <label>Descripción</label>
                        <div class="rich-toolbar" aria-label="Formato de la descripción">
                            <div class="tool-group">
                                <button class="tool-button" type="button" data-editor-command="bold" title="Negrita" aria-label="Negrita"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 4h8a4 4 0 0 1 4 4 4 4 0 0 1-4 4H6z"/><path d="M6 12h9a4 4 0 0 1 4 4 4 4 0 0 1-4 4H6z"/></svg></button>
                                <button class="tool-button" type="button" data-editor-command="underline" title="Subrayado" aria-label="Subrayado"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 3v7a6 6 0 0 0 6 6 6 6 0 0 0 6-6V3"/><line x1="4" y1="21" x2="20" y2="21"/></svg></button>
                                <button class="tool-button" type="button" data-editor-command="insertUnorderedList" title="Lista" aria-label="Lista"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg></button>
                                <button class="tool-button" type="button" data-editor-command="insertOrderedList" title="Lista numerada" aria-label="Lista numerada"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="10" y1="6" x2="21" y2="6"/><line x1="10" y1="12" x2="21" y2="12"/><line x1="10" y1="18" x2="21" y2="18"/><path d="M4 6h1v4"/><path d="M4 10h2"/><path d="M6 18H4c0-1 2-2 2-3s-1-1.5-2-1"/></svg></button>
                            </div>
                            <div class="tool-group">
                                <button class="tool-button" type="button" data-editor-command="upper" title="MAYÚSCULAS" aria-label="MAYÚSCULAS"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m3 16 4.5-9 4.5 9"/><path d="M4.5 13h6"/><path d="M18 16V8"/><path d="M15 11l3-3 3 3"/></svg></button>
                                <button class="tool-button" type="button" data-editor-command="lower" title="minúsculas" aria-label="minúsculas"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m3 16 4.5-9 4.5 9"/><path d="M4.5 13h6"/><path d="M18 8v8"/><path d="M15 13l3 3 3-3"/></svg></button>
                                <button class="tool-button" type="button" data-editor-command="removeFormat" title="Limpiar formato" aria-label="Limpiar formato"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m7 21-4.3-4.3a1 1 0 0 1 0-1.4l10-10a1 1 0 0 1 1.4 0l6 6a1 1 0 0 1 0 1.4L13 21z"/><path d="M22 21H7"/><path d="m5 11 9 9"/></svg></button>
                            </div>
                        </div>
                        <div class="rich-editor proforma-description-editor" contenteditable="true" role="textbox" aria-multiline="true" data-rich-editor data-target="#proforma_item_description___INDEX__"></div>
                        <input id="proforma_item_description___INDEX__" name="items[__INDEX__][description]" type="hidden" value="" required>
                    </div>
                    <div class="field">
                        <label>Cantidad</label>
                        <input name="items[__INDEX__][quantity]" type="number" step="0.01" min="0.01" value="1" required data-proforma-calc>
                    </div>
                    <div class="field">
                        <label>Precio unitario</label>
                        <input name="items[__INDEX__][unit_price]" type="number" step="0.01" min="0" value="0" required data-proforma-calc>
                    </div>
                    <div class="field">
                        <label>Total ítem</label>
                        <input value="0.00" disabled data-line-total>
                    </div>
                </div>
            </article>
        </template>
    </section>

    <section class="panel">
        <div class="sp-section-title">
            <div>
                <h3 style="margin:0;">Términos y condiciones</h3>
                <p class="muted" style="margin:4px 0 0;font-size:12.5px;">Se cargan automáticamente tus términos predeterminados. Puedes personalizarlos para esta proforma.</p>
            </div>
            <button class="button secondary" type="button" data-open-modal="termsEditorModal">Editar términos y condiciones</button>
        </div>
        <div id="proforma_terms_preview" class="term-preview" style="padding:14px 16px;border-radius:8px;background:rgba(0,0,0,.28);border:1px solid var(--line);margin-top:6px;">
            @if (trim(strip_tags($termsContent)) !== '')
                {!! $termsContent !!}
            @else
                <span class="muted">Aún no se han definido términos y condiciones predeterminados. Haz clic en «Editar términos y condiciones» para redactarlos.</span>
            @endif
        </div>
        <input id="proforma_terms_input" name="terms" type="hidden" value="{{ $termsContent }}">
    </section>

    @if (auth()->user()?->canUsePhotoGallery())
        <section class="panel">
            <div class="sp-section-title">
                <h3>Fotos para la proforma (Galería de fotos)</h3>
                @if (isset($galleryPhotos) && $galleryPhotos->isNotEmpty())
                    <button class="button secondary" type="button" data-open-modal="galleryPhotosModal">
                        <svg class="button-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path d="M3 7h7l2 2h9v9a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3z"/>
                        </svg>
                        <span>Elegir de Galería de fotos</span>
                    </button>
                @endif
            </div>

            <div class="company-grid">
                <div class="field">
                    <label for="photos">Subir fotos desde tu equipo</label>
                    <input id="photos" name="photos[]" type="file" accept="image/*" multiple data-photo-input>
                    <div class="muted" style="margin-top: 7px;">Puedes incrustar hasta 4 fotos (subidas o desde tu Galería de fotos), máximo 20 MB por archivo. Aparecerán al final del PDF.</div>
                    @error('photos') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label>Fotos actuales en la proforma</label>
                    @if ($proforma->photos->isEmpty())
                        <div class="empty" style="padding: 18px;" data-photo-empty>Todavía no hay fotos en esta proforma.</div>
                    @else
                        <div class="files view-grid">
                            @foreach ($proforma->photos as $photo)
                                @php
                                    $photoUrl = \App\Http\Controllers\CompanyProfileController::publicLogoUrl($photo->path);
                                @endphp
                                <article class="file">
                                    @if ($photoUrl)
                                        <img src="{{ $photoUrl }}" alt="Foto de proforma" style="width: 100%; max-height: 120px; object-fit: cover; border-radius: 8px;">
                                    @else
                                        <div class="file-icon">IMG</div>
                                    @endif
                                    <div>
                                        <h4>{{ $photo->original_name ?: 'Foto '.$loop->iteration }}</h4>
                                        <label style="display: flex; align-items: center; gap: 8px; margin-top: 8px;">
                                            <input name="remove_photos[]" type="checkbox" value="{{ $photo->id }}" style="width: auto;">
                                            Quitar del PDF
                                        </label>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @endif
                    <div class="files view-grid" data-photo-preview-target style="display: none; margin-top: 10px;"></div>
                </div>
            </div>

            @if (isset($galleryPhotos) && $galleryPhotos->isNotEmpty())
                <div id="galleryPhotosModal" class="modal-backdrop" aria-hidden="true">
                    <div class="modal-content panel">
                        <div class="modal-header">
                            <h3>Incrustar fotos desde tu Galería</h3>
                            <button class="icon-button" type="button" data-close-modal aria-label="Cerrar">×</button>
                        </div>
                        <p class="muted" style="margin: 0 0 12px;">Selecciona las fotos de tu galería que deseas incrustar en el PDF de esta proforma (máx. 4 en total):</p>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 12px; max-height: 360px; overflow-y: auto;">
                            @foreach ($galleryPhotos as $gDoc)
                                @php $gUrl = \App\Http\Controllers\CompanyProfileController::publicLogoUrl($gDoc->file_path); @endphp
                                @if ($gUrl)
                                    <label style="position: relative; display: block; cursor: pointer; border: 1px solid var(--line); border-radius: 8px; overflow: hidden; background: #0b1219; padding: 6px;">
                                        <input type="checkbox" name="gallery_photos[]" value="{{ $gDoc->id }}" style="position: absolute; top: 10px; left: 10px; width: auto; z-index: 2;">
                                        <img src="{{ $gUrl }}" alt="{{ $gDoc->title }}" style="width: 100%; height: 96px; object-fit: cover; border-radius: 6px; display: block;">
                                        <span style="display: block; font-size: 12px; margin-top: 6px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $gDoc->title }}</span>
                                    </label>
                                @endif
                            @endforeach
                        </div>
                        <div class="actions" style="margin-top: 16px;">
                            <button class="button" type="button" data-close-modal>Listo</button>
                        </div>
                    </div>
                </div>
            @endif
        </section>
    @endif

    <section class="panel">
        <div class="stats" style="margin-bottom: 0;">
            <article class="stat">
                <p class="label">Subtotal</p>
                <p class="value" data-proforma-total="subtotal">0.00</p>
            </article>
            <article class="stat">
                <p class="label">IGV</p>
                <p class="value" data-proforma-total="tax">0.00</p>
            </article>
            <article class="stat">
                <p class="label">Total</p>
                <p class="value" data-proforma-total="total">0.00</p>
            </article>
        </div>

        <div class="actions">
            <a class="button secondary" href="{{ route('proformas.index') }}" data-ajax-link data-nav="proformas">Cancelar</a>
            <button class="button" type="submit">{{ $proforma->exists ? 'Actualizar proforma' : 'Guardar proforma' }}</button>
        </div>
    </section>
</form>

<div id="termsEditorModal" class="modal-backdrop" aria-hidden="true">
    <div class="modal-content panel">
        <div class="modal-header">
            <h3>Editar términos y condiciones</h3>
            <button class="icon-button" type="button" data-close-modal aria-label="Cerrar">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                    <path d="M18 6 6 18"/>
                    <path d="m6 6 12 12"/>
                </svg>
            </button>
        </div>

        <div class="rich-toolbar" aria-label="Herramientas del editor">
            <div class="tool-group">
                <button class="tool-button" type="button" data-editor-command="bold" title="Negrita" aria-label="Negrita"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 4h8a4 4 0 0 1 4 4 4 4 0 0 1-4 4H6z"/><path d="M6 12h9a4 4 0 0 1 4 4 4 4 0 0 1-4 4H6z"/></svg></button>
                <button class="tool-button" type="button" data-editor-command="underline" title="Subrayado" aria-label="Subrayado"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 3v7a6 6 0 0 0 6 6 6 6 0 0 0 6-6V3"/><line x1="4" y1="21" x2="20" y2="21"/></svg></button>
                <button class="tool-button" type="button" data-editor-command="insertUnorderedList" title="Lista" aria-label="Lista"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg></button>
                <button class="tool-button" type="button" data-editor-command="insertOrderedList" title="Lista numerada" aria-label="Lista numerada"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="10" y1="6" x2="21" y2="6"/><line x1="10" y1="12" x2="21" y2="12"/><line x1="10" y1="18" x2="21" y2="18"/><path d="M4 6h1v4"/><path d="M4 10h2"/><path d="M6 18H4c0-1 2-2 2-3s-1-1.5-2-1"/></svg></button>
            </div>
            <div class="tool-group">
                <button class="tool-button" type="button" data-editor-command="upper" title="MAYÚSCULAS" aria-label="MAYÚSCULAS"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m3 16 4.5-9 4.5 9"/><path d="M4.5 13h6"/><path d="M18 16V8"/><path d="M15 11l3-3 3 3"/></svg></button>
                <button class="tool-button" type="button" data-editor-command="lower" title="minúsculas" aria-label="minúsculas"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m3 16 4.5-9 4.5 9"/><path d="M4.5 13h6"/><path d="M18 8v8"/><path d="M15 13l3 3 3-3"/></svg></button>
                <button class="tool-button" type="button" data-editor-command="removeFormat" title="Limpiar formato" aria-label="Limpiar formato"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m7 21-4.3-4.3a1 1 0 0 1 0-1.4l10-10a1 1 0 0 1 1.4 0l6 6a1 1 0 0 1 0 1.4L13 21z"/><path d="M22 21H7"/><path d="m5 11 9 9"/></svg></button>
            </div>
        </div>
        <div class="rich-editor" contenteditable="true" data-rich-editor data-target="#proforma_terms_input">{!! $termsContent !!}</div>
        <div class="actions">
            <button class="button" type="button" data-close-modal>Listo</button>
        </div>
    </div>
</div>

<div id="clientQuickModal" class="modal-backdrop" aria-hidden="true">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Generar cliente</h3>
            <button class="icon-button" type="button" data-close-modal aria-label="Cerrar">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                    <path d="M18 6 6 18"/>
                    <path d="m6 6 12 12"/>
                </svg>
            </button>
        </div>

        <form class="form-grid" method="post" action="{{ route('proformas.clients.store') }}" data-client-modal-form>
            @csrf
            <div data-client-modal-errors></div>

            <div>
                <label for="quick_client_name">Nombre del Cliente</label>
                <input id="quick_client_name" name="name" required placeholder="Persona o contacto">
            </div>

            <div>
                <label for="quick_client_company_name">Empresa</label>
                <input id="quick_client_company_name" name="company_name" placeholder="Nombre de la empresa">
            </div>

            <div>
                <label for="quick_client_document_number">RUC</label>
                <input id="quick_client_document_number" name="document_number" placeholder="Ej. 20123456789">
            </div>

            <div>
                <label for="quick_client_phone">Teléfono</label>
                <input id="quick_client_phone" name="phone" placeholder="Teléfono del cliente">
            </div>

            <div>
                <label for="quick_client_email">Email</label>
                <input id="quick_client_email" name="email" type="email" placeholder="correo@empresa.com">
            </div>

            <div class="actions">
                <button class="button secondary" type="button" data-close-modal>Cancelar</button>
                <button class="button" type="submit">Guardar cliente</button>
            </div>
        </form>
    </div>
</div>
