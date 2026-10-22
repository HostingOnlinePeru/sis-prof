@php
    $formatBytes = function ($bytes) {
        $bytes = (float) $bytes;
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2).' MB';
        }

        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 2).' KB';
        }

        return number_format($bytes, 0).' B';
    };

    $isPhotoFolder = $currentFolder && (
        mb_strtolower(trim($currentFolder->name)) === 'fotos'
        || collect($breadcrumbs)->contains(fn ($folder) => mb_strtolower(trim($folder->name)) === 'fotos')
    );
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

<section class="stats" aria-label="Resumen de fotos">
    <article class="stat">
        <p class="label">Fotos</p>
        <p class="value">{{ $totalDocuments }}</p>
    </article>
    <article class="stat">
        <p class="label">Carpetas</p>
        <p class="value">{{ $totalFolders }}</p>
    </article>
    <article class="stat">
        <p class="label">Espacio usado</p>
        <p class="value">{{ $formatBytes($totalStorage) }}</p>
    </article>
</section>

<section class="workspace">
    <aside>
        <div class="panel">
            <h3>{{ $currentFolder ? 'Crear subcarpeta' : 'Crear carpeta' }}</h3>
            <form class="form-grid" method="post" action="{{ route('documents.folders.store') }}" data-ajax-form>
                @csrf
                <div>
                    <label for="parent_id">Dentro de</label>
                    <select id="parent_id" name="parent_id">
                        <option value="">Repositorio principal</option>
                        @foreach ($folderOptions as $folderOption)
                            <option value="{{ $folderOption->id }}" @selected($currentFolder?->id === $folderOption->id)>{{ $folderOption->fullName() }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="folder_name">Nombre de carpeta</label>
                    <input id="folder_name" name="name" placeholder="Ej. Certificados, Fichas técnicas">
                </div>
                <button class="button" type="submit">{{ $currentFolder ? 'Crear subcarpeta' : 'Crear carpeta' }}</button>
            </form>
        </div>

        <div class="panel" style="margin-top: 18px;">
            <h3>Carpetas</h3>
            <div class="folders">
                @if ($currentFolder)
                    <a class="folder" href="{{ $currentFolder->parent ? route('documents.index', ['folder' => $currentFolder->parent_id]) : route('documents.index') }}" data-ajax-link data-nav="documents">
                        <div>
                            <strong>Subir nivel</strong>
                            <span>{{ $currentFolder->parent ? $currentFolder->parent->name : 'Repositorio principal' }}</span>
                        </div>
                        <span>↑</span>
                    </a>
                @endif

                @foreach ($folders as $folder)
                    <a class="folder {{ $currentFolder?->id === $folder->id ? 'active' : '' }}" href="{{ route('documents.index', ['folder' => $folder->id]) }}" data-ajax-link data-nav="documents">
                        <div>
                            <strong>{{ $folder->name }}</strong>
                        </div>
                        <span>{{ $folder->documents_count }}</span>
                    </a>
                @endforeach

                @if ($folders->isEmpty())
                    <div class="empty" style="padding: 18px;">No hay subcarpetas en este nivel.</div>
                @endif
            </div>
        </div>
    </aside>

    <section>
        <div id="documentUploadModal" class="modal-backdrop" aria-hidden="true">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Subir archivo</h3>
                    <button class="icon-button" type="button" data-close-modal aria-label="Cerrar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path d="M18 6 6 18"/>
                            <path d="m6 6 12 12"/>
                        </svg>
                    </button>
                </div>
            <form class="form-grid" method="post" action="{{ route('documents.upload') }}" enctype="multipart/form-data" data-ajax-form>
                @csrf
                <div>
                    <label for="document_folder_id">Carpeta</label>
                    <select id="document_folder_id" name="document_folder_id">
                        <option value="">Sin carpeta</option>
                        @foreach ($folderOptions as $folderOption)
                            <option value="{{ $folderOption->id }}" @selected($currentFolder?->id === $folderOption->id)>{{ $folderOption->fullName() }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="file">Archivo</label>
                    <input id="file" name="file" type="file" required>
                    <div class="muted" style="margin-top: 7px;">Máximo 20 MB por archivo.</div>
                </div>
                <div class="actions">
                    <button class="button secondary" type="button" data-close-modal>Cancelar</button>
                    <button class="button" type="submit">Subir archivo</button>
                </div>
            </form>
            </div>
        </div>

        <div class="panel" style="margin-top: 18px;">
            @if ($currentFolder)
                <div class="file-meta" style="margin-bottom: 12px;">
                    <a class="badge" href="{{ route('documents.index') }}" data-ajax-link data-nav="documents">Repositorio principal</a>
                    @foreach ($breadcrumbs as $breadcrumb)
                        <span>/</span>
                        <a class="badge" href="{{ route('documents.index', ['folder' => $breadcrumb->id]) }}" data-ajax-link data-nav="documents">{{ $breadcrumb->name }}</a>
                    @endforeach
                </div>
            @endif

            <div class="sp-section-title">
                <h3>{{ $currentFolder ? 'Fotos en '.$currentFolder->name : 'Fotos de la galería' }}</h3>
                <div class="section-tools">
                    @unless ($isPhotoFolder)
                    <div class="view-toggle" aria-label="Cambiar vista de archivos">
                        <button class="active" type="button" data-file-view="list" aria-label="Vista de lista" aria-pressed="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                <path d="M8 6h13"/>
                                <path d="M8 12h13"/>
                                <path d="M8 18h13"/>
                                <path d="M3 6h.01"/>
                                <path d="M3 12h.01"/>
                                <path d="M3 18h.01"/>
                            </svg>
                        </button>
                        <button type="button" data-file-view="grid" aria-label="Vista de cuadrícula" aria-pressed="false">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                <path d="M4 4h7v7H4z"/>
                                <path d="M13 4h7v7h-7z"/>
                                <path d="M4 13h7v7H4z"/>
                                <path d="M13 13h7v7h-7z"/>
                            </svg>
                        </button>
                    </div>
                    @endunless
                    <button class="button" type="button" data-open-modal="documentUploadModal">
                        <svg class="button-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path d="M12 3v12"/>
                            <path d="m7 8 5-5 5 5"/>
                            <path d="M5 15v3a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3v-3"/>
                        </svg>
                        <span>Subir archivo</span>
                    </button>
                </div>
            </div>

            <form class="search" method="get" action="{{ route('documents.index') }}" data-ajax-form>
                @if ($currentFolder)
                    <input type="hidden" name="folder" value="{{ $currentFolder->id }}">
                @endif
                <input name="q" value="{{ request('q') }}" placeholder="Buscar por título o archivo">
                <button class="button secondary" type="submit">Buscar</button>
            </form>

            @if ($documents->isEmpty())
                <div class="empty">Todavía no hay archivos en esta vista.</div>
            @else
                <div
                    class="files {{ $isPhotoFolder ? 'view-grid' : 'view-list' }}"
                    data-file-view-target
                    @if ($isPhotoFolder) data-force-file-view="grid" @endif
                >
                    @foreach ($documents as $document)
                        @php
                            $extension = strtoupper(pathinfo($document->original_name ?: $document->file_path, PATHINFO_EXTENSION) ?: 'DOC');
                            $isImage = str_starts_with((string) $document->mime_type, 'image/');
                            $previewUrl = $isImage ? \App\Http\Controllers\CompanyProfileController::publicLogoUrl($document->file_path) : null;
                        @endphp
                        @if ($previewUrl)
                            <article class="file image-file">
                                <button
                                    class="file-thumb"
                                    type="button"
                                    data-image-preview="{{ $previewUrl }}"
                                    data-image-title="Vista previa"
                                    aria-label="Ver imagen"
                                >
                                    <img src="{{ $previewUrl }}" alt="Imagen del repositorio" loading="lazy">
                                </button>
                            </article>
                        @else
                            <article class="file">
                                <div class="file-icon">{{ substr($extension, 0, 4) }}</div>
                                <div>
                                    <h4>{{ $document->title }}</h4>
                                    <div class="file-meta">
                                        <span>{{ $document->original_name ?: basename($document->file_path) }}</span>
                                        <span>{{ $formatBytes($document->file_size) }}</span>
                                        <span>{{ $document->updated_at?->format('d/m/Y H:i') }}</span>
                                    </div>
                                </div>
                                <a class="button secondary" href="{{ route('documents.download', $document) }}">Descargar</a>
                            </article>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>

        <div id="imagePreviewModal" class="modal-backdrop" aria-hidden="true">
            <div class="modal-content image-preview-modal" role="dialog" aria-modal="true" aria-labelledby="imagePreviewTitle">
                <div class="modal-header">
                    <h3 id="imagePreviewTitle" data-image-preview-title>Vista previa</h3>
                    <button class="icon-button" type="button" data-close-modal aria-label="Cerrar vista previa">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path d="M18 6 6 18"/>
                            <path d="m6 6 12 12"/>
                        </svg>
                    </button>
                </div>
                <img class="image-preview-large" src="" alt="Vista previa" data-image-preview-img>
            </div>
        </div>
    </section>
</section>
