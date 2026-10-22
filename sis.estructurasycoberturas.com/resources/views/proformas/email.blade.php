@if (session('status'))
    <div id="emailStatusModal" class="modal-backdrop is-open" aria-hidden="false" style="display: flex;">
        <div class="modal-content" role="dialog" aria-modal="true" aria-labelledby="emailStatusTitle" style="max-width: 460px;">
            <div class="modal-header">
                <h3 id="emailStatusTitle">Correo enviado</h3>
                <button class="icon-button" type="button" data-close-modal aria-label="Cerrar">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <path d="M18 6 6 18"/>
                        <path d="m6 6 12 12"/>
                    </svg>
                </button>
            </div>
            <div style="padding: 8px 2px 2px; color: #bbf7d0; font-size: 17px; font-weight: 800;">
                {{ session('status') }}
            </div>
        </div>
    </div>
@endif

@if ($errors->any())
    <div class="errors">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<section class="stats" aria-label="Resumen de envío">
    <article class="stat">
        <p class="label">Proforma</p>
        <p class="value">{{ $proforma->number }}</p>
    </article>
    <article class="stat">
        <p class="label">Cliente</p>
        <p class="value" style="font-size: 20px;">{{ $proforma->client?->name ?: '-' }}</p>
    </article>
    <article class="stat">
        <p class="label">Total</p>
        <p class="value">{{ $proforma->currency }} {{ number_format((float) $proforma->total, 2) }}</p>
    </article>
</section>

<form class="form-grid" method="post" action="{{ route('proformas.email.send', $proforma) }}" data-ajax-form>
    @csrf

    <section class="panel">
        <div class="sp-section-title">
            <h3>Correo al cliente</h3>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <a class="button secondary" href="{{ route('proformas.edit', $proforma) }}" data-ajax-link data-nav="proformas">Editar proforma</a>
                <a class="button secondary" href="{{ route('proformas.pdf', $proforma) }}" target="_blank">Ver PDF</a>
            </div>
        </div>

        <div class="company-grid">
            <div class="field">
                <label for="to">Para</label>
                <input id="to" name="to" type="email" value="{{ old('to', $proforma->client?->email) }}" required placeholder="correo@cliente.com">
            </div>

            <div class="field">
                <label for="cc">Copia</label>
                <input id="cc" name="cc" type="email" value="{{ old('cc') }}" placeholder="opcional@empresa.com">
            </div>

            <div class="field full">
                <label for="message">Mensaje</label>
                <textarea id="message" name="message" required style="min-height: 180px;">{{ old('message', $defaultMessage) }}</textarea>
            </div>

            <div class="field full">
                <div style="border-top: 1px dashed rgba(148, 163, 184, .65); margin: 4px 0 14px;"></div>
                <div style="display: flex; gap: 18px; align-items: flex-start; padding: 18px; border: 1px solid rgba(148, 163, 184, .25); border-radius: 8px; background: rgba(15, 23, 42, .45);">
                    @if ($companyLogoUrl)
                        <img src="{{ $companyLogoUrl }}" alt="Logo de empresa" style="width: 112px; max-height: 84px; object-fit: contain; background: #fff; border-radius: 6px; padding: 8px;">
                    @endif
                    <div style="color: #dbeafe; line-height: 1.55;">
                        <strong style="display: block; color: #fff; font-size: 18px;">{{ $company?->business_name ?: 'Sistema de Proformas' }}</strong>
                        @if ($company?->tax_id)
                            <span style="display: block;">RUC: {{ $company->tax_id }}</span>
                        @endif
                        @if ($company?->phone)
                            <span style="display: block;">Teléfono Móvil 1: {{ $company->phone }}</span>
                        @endif
                        @if ($company?->mobile_phone)
                            <span style="display: block;">Teléfono Móvil 2: {{ $company->mobile_phone }}</span>
                        @endif
                        @if ($company?->email)
                            <span style="display: block;">Correo: {{ $company->email }}</span>
                        @endif
                        @if ($company?->address)
                            <span style="display: block;">Dirección: {{ $company->address }}</span>
                        @endif
                        @if ($company?->website)
                            <span style="display: block; color: #93c5fd; font-weight: 700;">{{ preg_replace('/^https?:\/\//', '', $company->website) }}</span>
                        @endif
                    </div>
                </div>
                <div class="hint">Esta firma se agregará automáticamente al final del correo enviado.</div>
            </div>
        </div>
    </section>

    @php
        $selectedDocumentIds = collect(old('documents', $selectedDocuments))->map(fn ($id) => (int) $id)->all();
        $selectedRepositoryDocuments = $documents->whereIn('id', $selectedDocumentIds);
        $documentsByFolder = $documents->groupBy(fn ($document) => $document->folder?->fullName() ?: 'Sin carpeta');
    @endphp

    <section class="workspace">
        <aside class="panel">
            <h3>PDF principal</h3>
            <div class="empty" style="text-align: left;">
                Se adjuntará automáticamente el PDF de la proforma:
                <strong>{{ $proforma->number }}.pdf</strong>
            </div>
        </aside>

        <section class="panel">
            <div class="sp-section-title">
                <h3>Documentos adjuntos</h3>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <button class="button secondary" type="button" data-open-modal="repositoryPickerModal" title="Inspeccionar repositorio">
                        <svg class="button-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path d="M3 7h5l2 3h11v9H3z"/>
                            <path d="M3 7v12"/>
                        </svg>
                        <span>Inspeccionar repositorio</span>
                    </button>
                    <button class="button" type="button" data-open-modal="repositoryPickerModal">
                        <svg class="button-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path d="M4 4h16v16H4z"/>
                            <path d="M8 8h8"/>
                            <path d="M8 12h8"/>
                            <path d="M8 16h5"/>
                        </svg>
                        <span>Elegir archivos</span>
                    </button>
                </div>
            </div>
            @if ($documents->isEmpty())
                <div class="empty">No hay documentos disponibles en el repositorio.</div>
            @else
                <div class="empty" style="text-align: left;" data-document-summary>
                    <span data-document-empty @if (! $selectedRepositoryDocuments->isEmpty()) style="display: none;" @endif>
                        No hay documentos seleccionados. Usa <strong>Elegir archivos</strong> para adjuntar documentos del repositorio.
                    </span>
                    <div data-document-selected @if ($selectedRepositoryDocuments->isEmpty()) style="display: none;" @endif>
                        <strong>Adjuntos seleccionados:</strong>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(118px, 1fr)); gap: 12px; margin-top: 10px;" data-document-selected-list>
                            @foreach ($selectedRepositoryDocuments as $document)
                                @php
                                    $summaryPreviewUrl = str_starts_with((string) $document->mime_type, 'image/')
                                        ? \App\Http\Controllers\CompanyProfileController::publicLogoUrl($document->file_path)
                                        : null;
                                @endphp
                                <span style="position: relative; display: block; min-height: 96px; border: 1px solid rgba(148, 163, 184, .25); border-radius: 8px; overflow: hidden; background: #0b1219;">
                                    <button type="button" data-remove-document="{{ $document->id }}" aria-label="Quitar adjunto" style="position: absolute; z-index: 2; top: 6px; right: 6px; width: 28px; height: 28px; border: 0; border-radius: 999px; background: rgba(15, 23, 42, .9); color: #fff; cursor: pointer;">×</button>
                                    @if ($summaryPreviewUrl)
                                        <img src="{{ $summaryPreviewUrl }}" alt="{{ $document->title }}" style="display: block; width: 100%; height: 96px; object-fit: cover;">
                                    @else
                                        <span style="display: grid; place-items: center; min-height: 96px; padding: 12px; color: #dbeafe; font-weight: 800;">{{ $document->title }}</span>
                                    @endif
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </section>
    </section>

    <div id="repositoryPickerModal" class="modal-backdrop" aria-hidden="true">
        <div class="modal-content" role="dialog" aria-modal="true" aria-labelledby="repositoryPickerTitle">
            <div class="modal-header">
                <h3 id="repositoryPickerTitle">Elegir archivos del repositorio</h3>
                <button class="icon-button" type="button" data-close-modal aria-label="Cerrar">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <path d="M18 6 6 18"/>
                        <path d="m6 6 12 12"/>
                    </svg>
                </button>
            </div>

            @if ($documents->isEmpty())
                <div class="empty">No hay archivos cargados en el repositorio.</div>
            @else
                <div class="form-grid">
                    @foreach ($documentsByFolder as $folderName => $folderDocuments)
                        <details class="folder" open style="display: block;">
                            <summary style="cursor: pointer; font-weight: 800;">{{ $folderName }}</summary>
                            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(118px, 1fr)); gap: 12px; margin-top: 12px;">
                                @foreach ($folderDocuments as $document)
                                    @php
                                        $isImageDocument = str_starts_with((string) $document->mime_type, 'image/');
                                        $documentPreviewUrl = $isImageDocument
                                            ? \App\Http\Controllers\CompanyProfileController::publicLogoUrl($document->file_path)
                                            : null;
                                    @endphp

                                    @if ($documentPreviewUrl)
                                        <label title="{{ $document->title }}" style="position: relative; display: block; min-height: 112px; cursor: pointer; border: 1px solid rgba(148, 163, 184, .25); border-radius: 8px; overflow: hidden; background: #0b1219;">
                                            <input
                                                name="documents[]"
                                                type="checkbox"
                                                value="{{ $document->id }}"
                                                data-document-choice
                                                data-document-title="{{ $document->title }}"
                                                data-document-folder="{{ $document->folder?->fullName() ?: 'Sin carpeta' }}"
                                                data-document-preview="{{ $documentPreviewUrl }}"
                                                @checked(in_array($document->id, $selectedDocumentIds))
                                                style="position: absolute; z-index: 2; top: 8px; left: 8px; width: auto;"
                                            >
                                            <img src="{{ $documentPreviewUrl }}" alt="{{ $document->title }}" loading="lazy" style="display: block; width: 100%; height: 112px; object-fit: cover;">
                                        </label>
                                    @else
                                        <label class="folder" style="cursor: pointer; grid-column: 1 / -1;">
                                            <span style="display: flex; align-items: center; gap: 10px;">
                                                <input
                                                    name="documents[]"
                                                    type="checkbox"
                                                    value="{{ $document->id }}"
                                                    data-document-choice
                                                    data-document-title="{{ $document->title }}"
                                                    data-document-folder="{{ $document->folder?->fullName() ?: 'Sin carpeta' }}"
                                                    data-document-preview=""
                                                    @checked(in_array($document->id, $selectedDocumentIds))
                                                    style="width: auto;"
                                                >
                                                <span>{{ $document->title }}</span>
                                            </span>
                                            <span>{{ $document->original_name ?: 'Archivo' }}</span>
                                        </label>
                                    @endif
                                @endforeach
                            </div>
                        </details>
                    @endforeach
                </div>
            @endif

            <div class="actions" style="margin-top: 18px;">
                <a class="button secondary" href="{{ route('documents.index') }}" target="_blank">Abrir repositorio</a>
                <button class="button" type="button" data-close-modal>Adjuntar seleccionados</button>
            </div>
        </div>
    </div>

    <section class="panel">
        <div class="actions">
            <a class="button secondary" href="{{ route('proformas.index') }}" data-ajax-link data-nav="proformas">Cancelar</a>
            <button class="button" type="submit">
                <svg class="button-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                    <path d="m22 2-7 20-4-9-9-4Z"/>
                    <path d="M22 2 11 13"/>
                </svg>
                <span>Enviar correo</span>
            </button>
        </div>
    </section>
</form>
