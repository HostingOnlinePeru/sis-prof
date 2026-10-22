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

<section class="stats" aria-label="Resumen de términos">
    <article class="stat">
        <p class="label">Término único</p>
        <p class="value">{{ $totalTerms }}</p>
    </article>
    <article class="stat">
        <p class="label">Estado</p>
        <p class="value">{{ $totalActiveTerms ? 'Activo' : 'Pendiente' }}</p>
    </article>
    <article class="stat">
        <p class="label">Uso</p>
        <p class="value">PDF</p>
    </article>
</section>

<section class="workspace">
    <aside>
        <div class="panel">
            <h3>Términos y condiciones</h3>

            @if ($terms->isEmpty())
                <div class="empty">Aún no has configurado los términos y condiciones de esta empresa.</div>
            @else
                <div class="products-list">
                    @foreach ($terms as $term)
                        <article class="panel product-card">
                            <div>
                                <h4>{{ $term->name }}</h4>
                                <div class="file-meta">
                                    <span class="badge">Activo</span>
                                    <span>{{ $term->updated_at?->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="term-preview">{!! $term->content !!}</div>
                            </div>
                            <a class="button secondary" href="{{ route('terms.index', ['edit' => $term->id]) }}" data-ajax-link data-nav="terms">Editar</a>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </aside>

    <section>
        <div class="panel">
            <h3>{{ $editingTerm ? 'Editar términos y condiciones' : 'Crear términos y condiciones' }}</h3>

            <form class="form-grid" method="post" action="{{ $editingTerm ? route('terms.update', $editingTerm) : route('terms.store') }}" data-ajax-form>
                @csrf
                @if ($editingTerm)
                    @method('PUT')
                @endif

                <input id="name" name="name" type="hidden" value="{{ old('name', $editingTerm?->name ?: 'Términos y condiciones') }}">

                <div>
                    <div class="rich-toolbar" aria-label="Herramientas del editor">
                        <div class="tool-group">
                            <button class="tool-button" type="button" data-editor-command="bold" title="Negrita" aria-label="Negrita"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 4h8a4 4 0 0 1 4 4 4 4 0 0 1-4 4H6z"/><path d="M6 12h9a4 4 0 0 1 4 4 4 4 0 0 1-4 4H6z"/></svg></button>
                            <button class="tool-button" type="button" data-editor-command="italic" title="Cursiva" aria-label="Cursiva"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="19" y1="4" x2="10" y2="4"/><line x1="14" y1="20" x2="5" y2="20"/><line x1="15" y1="4" x2="9" y2="20"/></svg></button>
                            <button class="tool-button" type="button" data-editor-command="underline" title="Subrayado" aria-label="Subrayado"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 3v7a6 6 0 0 0 6 6 6 6 0 0 0 6-6V3"/><line x1="4" y1="21" x2="20" y2="21"/></svg></button>
                            <button class="tool-button" type="button" data-editor-command="strikeThrough" title="Tachado" aria-label="Tachado"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M16 4H9a3 3 0 0 0-2.83 4M14 12a4 4 0 0 1 0 8H6"/><line x1="4" y1="12" x2="20" y2="12"/></svg></button>
                        </div>
                        <div class="tool-group">
                            <button class="tool-button" type="button" data-editor-command="formatBlock" data-editor-value="p" title="Párrafo" aria-label="Párrafo"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M13 4v16"/><path d="M17 4v16"/><path d="M19 4H9.5a4.5 4.5 0 0 0 0 9H13"/></svg></button>
                            <button class="tool-button" type="button" data-editor-command="formatBlock" data-editor-value="h1" title="Título 1" aria-label="Título 1"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12h8"/><path d="M4 18V6"/><path d="M12 18V6"/><path d="m17 12 3-2v8"/></svg></button>
                            <button class="tool-button" type="button" data-editor-command="formatBlock" data-editor-value="h2" title="Título 2" aria-label="Título 2"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12h8"/><path d="M4 18V6"/><path d="M12 18V6"/><path d="M21 18h-4c0-4 4-3 4-6 0-1.5-1-2.5-2.5-2.5S16 10.5 16 12"/></svg></button>
                            <button class="tool-button" type="button" data-editor-command="formatBlock" data-editor-value="h3" title="Título 3" aria-label="Título 3"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12h8"/><path d="M4 18V6"/><path d="M12 18V6"/><path d="M17.5 10.5c.8-1.2 2.1-1.5 3.5-1 1.2.5 1.5 1.8 1 3-.3.8-1 1.2-2 1.5 1.2.3 2 .8 2.3 1.8.5 1.2.1 2.5-1 3-1.4.5-2.7.2-3.5-1"/></svg></button>
                            <button class="tool-button" type="button" data-editor-command="formatBlock" data-editor-value="blockquote" title="Cita" aria-label="Cita"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 2v6c0 1.25.75 2 2 2h4c0 2.5-1 4-3 5.5"/><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 2v6c0 1.25.75 2 2 2h4c0 2.5-1 4-3 5.5"/></svg></button>
                        </div>
                        <div class="tool-group">
                            <button class="tool-button" type="button" data-editor-command="insertUnorderedList" title="Lista con viñetas" aria-label="Lista con viñetas"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg></button>
                            <button class="tool-button" type="button" data-editor-command="insertOrderedList" title="Lista numerada" aria-label="Lista numerada"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="10" y1="6" x2="21" y2="6"/><line x1="10" y1="12" x2="21" y2="12"/><line x1="10" y1="18" x2="21" y2="18"/><path d="M4 6h1v4"/><path d="M4 10h2"/><path d="M6 18H4c0-1 2-2 2-3s-1-1.5-2-1"/></svg></button>
                        </div>
                        <div class="tool-group">
                            <button class="tool-button" type="button" data-editor-command="justifyLeft" title="Alinear a la izquierda" aria-label="Alinear a la izquierda"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="17" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="15" y1="18" x2="3" y2="18"/></svg></button>
                            <button class="tool-button" type="button" data-editor-command="justifyCenter" title="Centrar" aria-label="Centrar"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="10" x2="6" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="16" y1="18" x2="8" y2="18"/></svg></button>
                            <button class="tool-button" type="button" data-editor-command="justifyRight" title="Alinear a la derecha" aria-label="Alinear a la derecha"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="21" y1="10" x2="7" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="21" y1="18" x2="9" y2="18"/></svg></button>
                            <button class="tool-button" type="button" data-editor-command="justifyFull" title="Justificar" aria-label="Justificar"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="21" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="21" y1="18" x2="3" y2="18"/></svg></button>
                        </div>
                        <div class="tool-group">
                            <button class="tool-button" type="button" data-editor-command="indent" title="Aumentar sangría" aria-label="Aumentar sangría"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="13 8 17 12 13 16"/><line x1="21" y1="12" x2="9" y2="12"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="18" x2="3" y2="18"/></svg></button>
                            <button class="tool-button" type="button" data-editor-command="outdent" title="Disminuir sangría" aria-label="Disminuir sangría"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="11 16 7 12 11 8"/><line x1="3" y1="12" x2="15" y2="12"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="18" x2="3" y2="18"/></svg></button>
                            <button class="tool-button" type="button" data-editor-command="insertHorizontalRule" title="Línea horizontal" aria-label="Línea horizontal"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/></svg></button>
                        </div>
                        <div class="tool-group">
                            <button class="tool-button" type="button" data-editor-command="upper" title="Convertir a mayúsculas" aria-label="Convertir a mayúsculas"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m3 16 4.5-9 4.5 9"/><path d="M4.5 13h6"/><path d="M18 16V8"/><path d="M15 11l3-3 3 3"/></svg></button>
                            <button class="tool-button" type="button" data-editor-command="lower" title="Convertir a minúsculas" aria-label="Convertir a minúsculas"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m3 16 4.5-9 4.5 9"/><path d="M4.5 13h6"/><path d="M18 8v8"/><path d="M15 13l3 3 3-3"/></svg></button>
                            <button class="tool-button" type="button" data-editor-command="removeFormat" title="Limpiar formato" aria-label="Limpiar formato"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m7 21-4.3-4.3a1 1 0 0 1 0-1.4l10-10a1 1 0 0 1 1.4 0l6 6a1 1 0 0 1 0 1.4L13 21z"/><path d="M22 21H7"/><path d="m5 11 9 9"/></svg></button>
                        </div>
                    </div>
                    <div class="rich-editor" contenteditable="true" data-rich-editor data-target="#content_input">{!! old('content', $editingTerm?->content) !!}</div>
                    <input id="content_input" name="content" type="hidden" value="{{ old('content', $editingTerm?->content) }}">
                    <div class="muted" style="margin-top: 8px;">Este será el único texto de términos y condiciones utilizado en las proformas de esta empresa.</div>
                </div>

                <div class="actions">
                    <button class="button" type="submit">{{ $editingTerm ? 'Guardar cambios' : 'Guardar términos y condiciones' }}</button>
                </div>
            </form>
        </div>
    </section>
</section>
