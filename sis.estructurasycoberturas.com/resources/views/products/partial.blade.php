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

<section class="stats" aria-label="Resumen de productos">
    <article class="stat">
        <p class="label">Productos</p>
        <p class="value">{{ $totalProducts }}</p>
    </article>
    <article class="stat">
        <p class="label">Activos</p>
        <p class="value">{{ $totalActiveProducts }}</p>
    </article>
    <article class="stat">
        <p class="label">Categorías</p>
        <p class="value">{{ $totalCategories }}</p>
    </article>
</section>

<section class="workspace">
    <aside>
        <div class="panel">
            <h3>Crear categoría</h3>
            <form class="form-grid" method="post" action="{{ route('products.categories.store') }}" data-ajax-form>
                @csrf
                <div>
                    <label for="category_name">Nombre de categoría</label>
                    <input id="category_name" name="name" placeholder="Ej. Toldos, estructuras, accesorios">
                </div>
                <div>
                    <label for="category_description">Descripción</label>
                    <textarea id="category_description" name="description" placeholder="Uso interno de esta categoría"></textarea>
                </div>
                <button class="button" type="submit">Crear categoría</button>
            </form>
        </div>

        <div class="panel" style="margin-top: 18px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                <h3 style="margin: 0;">Categorías</h3>
                @if ($currentCategory)
                    <a href="{{ route('products.index') }}" data-ajax-link data-nav="products" style="font-size: 12px; color: #fbbf24; font-weight: 700;">Ver todas</a>
                @endif
            </div>
            <div class="folders">
                @forelse ($categories as $category)
                    <div class="folder {{ $currentCategory?->id === $category->id ? 'active' : '' }}" style="display: flex; align-items: center; justify-content: space-between; gap: 10px;">
                        <a href="{{ route('products.index', ['category' => $category->id]) }}" data-ajax-link data-nav="products" style="flex: 1; min-width: 0; display: flex; align-items: center; justify-content: space-between; gap: 10px; color: inherit; text-decoration: none;">
                            <div style="min-width: 0;">
                                <strong style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $category->name }}</strong>
                                <span style="display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $category->description ?: 'Sin descripción' }}</span>
                            </div>
                            <span class="badge" style="flex-shrink: 0;">{{ $category->products_count }}</span>
                        </a>
                        <div style="display: flex; align-items: center; gap: 6px; flex-shrink: 0;">
                            <button type="button" class="button secondary" onclick="editCategoryModal({{ $category->toJson() }})" title="Editar categoría" aria-label="Editar categoría" style="padding: 0; width: 32px; height: 32px; min-height: 32px; display: inline-flex; align-items: center; justify-content: center; border-radius: 7px; cursor: pointer;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 15px; height: 15px; color: #60a5fa;">
                                    <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                                    <path d="m15 5 4 4"/>
                                </svg>
                            </button>
                            <form method="post" action="{{ route('products.categories.destroy', $category) }}" data-ajax-form onsubmit="return confirm('¿Estás seguro de eliminar la categoría &quot;{{ addslashes($category->name) }}&quot;? Los productos quedarán sin categoría.')" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="button secondary" title="Eliminar categoría" aria-label="Eliminar categoría" style="padding: 0; width: 32px; height: 32px; min-height: 32px; display: inline-flex; align-items: center; justify-content: center; border-radius: 7px; color: #ef4444; border-color: rgba(239, 68, 68, 0.3); cursor: pointer;">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 15px; height: 15px;">
                                        <path d="M3 6h18"/>
                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                        <line x1="10" x2="10" y1="11" y2="17"/>
                                        <line x1="14" x2="14" y1="11" y2="17"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="empty">Todavía no hay categorías creadas.</div>
                @endforelse
            </div>
        </div>
    </aside>

    <section>
        <div class="panel">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 16px;">
                <div>
                    <h3 style="margin: 0; font-size: 18px; color: #fff;">{{ $currentCategory ? 'Productos en: '.$currentCategory->name : 'Catálogo de productos' }}</h3>
                    <p style="margin: 4px 0 0; font-size: 13px; color: var(--muted);">{{ $products->count() }} producto(s) registrado(s)</p>
                </div>
                <button class="button" type="button" onclick="openProductModal()" style="display: inline-flex; align-items: center; gap: 8px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                        <path d="M5 12h14"/>
                        <path d="M12 5v14"/>
                    </svg>
                    <span>Crear nuevo producto</span>
                </button>
            </div>

            <form class="search" method="get" action="{{ route('products.index') }}" data-ajax-form style="margin-bottom: 18px;">
                @if ($currentCategory)
                    <input type="hidden" name="category" value="{{ $currentCategory->id }}">
                @endif
                <input name="q" value="{{ request('q') }}" placeholder="Buscar por nombre, código o descripción...">
                <button class="button secondary" type="submit">Buscar</button>
            </form>

            @if ($products->isEmpty())
                <div class="empty" style="padding: 40px 20px; text-align: center; color: var(--muted);">
                    <p style="margin: 0 0 12px;">Todavía no hay productos registrados en esta vista.</p>
                    <button class="button secondary" type="button" onclick="openProductModal()">+ Crear el primer producto</button>
                </div>
            @else
                <div class="products-list" style="display: grid; gap: 12px;">
                    @foreach ($products as $product)
                        <article class="panel product-card" style="display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; padding: 16px; background: rgba(255, 255, 255, .02); border: 1px solid var(--line); border-radius: 10px; transition: border-color .18s ease, background .18s ease;">
                            <div style="flex: 1; min-width: 0;">
                                <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 8px;">
                                    <h4 style="margin: 0; font-size: 16px; font-weight: 600; color: #fff;">{{ $product->name }}</h4>
                                    <span class="badge" style="background: {{ $product->active ? 'rgba(22, 163, 74, .2)' : 'rgba(239, 68, 68, .2)' }}; color: {{ $product->active ? '#4ade80' : '#f87171' }}; padding: 3px 10px; border-radius: 999px; font-size: 11px; font-weight: 600;">
                                        {{ $product->active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </div>
                                <div class="file-meta" style="display: flex; flex-wrap: wrap; gap: 14px; font-size: 13px; color: var(--muted); margin-bottom: 10px;">
                                    <span style="display: inline-flex; align-items: center; gap: 4px;"><strong style="color: #cbd5e1;">Cat:</strong> {{ $product->category?->name ?: 'Sin categoría' }}</span>
                                    @if ($product->sku)
                                        <span style="display: inline-flex; align-items: center; gap: 4px;"><strong style="color: #cbd5e1;">SKU:</strong> {{ $product->sku }}</span>
                                    @endif
                                    <span style="display: inline-flex; align-items: center; gap: 4px;"><strong style="color: #cbd5e1;">Unidad:</strong> {{ $product->unit }}</span>
                                    <span style="display: inline-flex; align-items: center; gap: 4px; color: #fbbf24; font-weight: 600;"><strong style="color: #cbd5e1;">Precio:</strong> {{ \App\Support\LatamCurrencies::symbol(app(\App\Support\CompanyContext::class)->active()?->default_currency) }} {{ number_format((float) $product->price, 2) }}</span>
                                </div>
                                <div style="margin-top: 6px; border-top: 1px solid rgba(255, 255, 255, 0.06); padding-top: 6px;">
                                    <button type="button" onclick="toggleAccordion('desc-{{ $product->id }}', this)" style="background: transparent; border: none; padding: 4px 0; color: #60a5fa; font-size: 13px; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; outline: none;">
                                        <span class="acc-arrow" style="display: inline-block; transition: transform 0.2s ease; font-size: 10px;">▶</span>
                                        <span class="acc-label">Ver descripción del producto</span>
                                    </button>
                                    <div id="desc-{{ $product->id }}" class="product-description" style="display: none; margin-top: 8px; padding: 12px 14px; background: rgba(0, 0, 0, 0.35); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; font-size: 13px; color: #cbd5e1; line-height: 1.5; white-space: pre-wrap;">{!! $product->description !!}</div>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px; flex-shrink: 0;">
                                <button type="button" class="button secondary" onclick="editProductModal({{ $product->toJson() }})" title="Editar producto" style="padding: 8px; width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; cursor: pointer;">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px; color: #60a5fa;">
                                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                                        <path d="m15 5 4 4"/>
                                    </svg>
                                </button>
                                <form method="post" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('¿Estás seguro de eliminar el producto &quot;{{ addslashes($product->name) }}&quot;?')" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button secondary" title="Eliminar producto" style="padding: 8px; width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; color: #ef4444; border-color: rgba(239, 68, 68, 0.3); cursor: pointer;">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                                            <path d="M3 6h18"/>
                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                            <line x1="10" x2="10" y1="11" y2="17"/>
                                            <line x1="14" x2="14" y1="11" y2="17"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
</section>

<div id="productModal" class="modal-backdrop" style="display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.75); z-index: 1000; align-items: center; justify-content: center; padding: 20px; backdrop-filter: blur(4px);">
    <div class="panel modal-content" style="width: 100%; max-width: 650px; max-height: 90vh; overflow-y: auto; background: #111820; border: 1px solid var(--line); border-radius: 12px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7); position: relative; padding: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid var(--line); padding-bottom: 14px;">
            <h3 id="modalTitle" style="margin: 0; font-size: 18px; color: #fff;">Crear nuevo producto</h3>
            <button type="button" onclick="closeProductModal()" style="background: transparent; border: none; color: var(--muted); cursor: pointer; font-size: 24px; line-height: 1; padding: 4px;">&times;</button>
        </div>

        <form id="productForm" class="form-grid" method="post" action="{{ route('products.store') }}" data-ajax-form>
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <div class="company-grid">
                <div class="field">
                    <label for="product_category_id">Categoría</label>
                    <select id="product_category_id" name="product_category_id">
                        <option value="">Sin categoría</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected((int) old('product_category_id', $currentCategory?->id) === $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label for="sku">Código / SKU</label>
                    <input id="sku" name="sku" value="{{ old('sku') }}" placeholder="Opcional">
                </div>

                <div class="field full">
                    <label for="name">Nombre del producto</label>
                    <input id="name" name="name" value="{{ old('name') }}" required placeholder="Ej. Toldo retráctil modelo premium">
                </div>

                <div class="field full">
                    <label for="product_description_editor">Descripción del producto</label>
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
                    <div id="product_description_editor" class="rich-editor proforma-description-editor" contenteditable="true" role="textbox" aria-multiline="true" data-rich-editor data-target="#description">{!! old('description') !!}</div>
                    <input id="description" name="description" type="hidden" value="{{ old('description') }}">
                </div>

                <div class="field">
                    <label for="unit">Unidad</label>
                    <input id="unit" name="unit" value="{{ old('unit', 'UND') }}" required>
                </div>

                <div class="field">
                    <label for="price">Precio</label>
                    <input id="price" name="price" type="number" step="0.01" min="0" value="{{ old('price', 0) }}" required>
                </div>

                <div class="field">
                    <label for="active">Estado</label>
                    <label style="display: flex; align-items: center; gap: 10px; min-height: 44px; color: #fff; cursor: pointer;">
                        <input id="active" name="active" type="checkbox" value="1" style="width: auto;" @checked(old('active', true))>
                        Producto activo
                    </label>
                </div>
            </div>

            <div class="actions" style="margin-top: 20px; padding-top: 16px; border-top: 1px solid var(--line); display: flex; justify-content: flex-end; gap: 12px;">
                <button class="button secondary" type="button" onclick="closeProductModal()">Cancelar</button>
                <button id="modalSubmitBtn" class="button" type="submit">Guardar producto</button>
            </div>
        </form>
    </div>
</div>

<div id="categoryModal" class="modal-backdrop" style="display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.75); z-index: 1000; align-items: center; justify-content: center; padding: 20px; backdrop-filter: blur(4px);">
    <div class="panel modal-content" style="width: 100%; max-width: 480px; background: #111820; border: 1px solid var(--line); border-radius: 12px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7); position: relative; padding: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid var(--line); padding-bottom: 14px;">
            <h3 id="categoryModalTitle" style="margin: 0; font-size: 18px; color: #fff;">Editar categoría</h3>
            <button type="button" onclick="closeCategoryModal()" style="background: transparent; border: none; color: var(--muted); cursor: pointer; font-size: 24px; line-height: 1; padding: 4px;">&times;</button>
        </div>

        <form id="categoryEditForm" class="form-grid" method="post" action="" data-ajax-form>
            @csrf
            @method('PUT')
            <div>
                <label for="edit_category_name">Nombre de categoría</label>
                <input id="edit_category_name" name="name" required placeholder="Ej. Toldos, estructuras, accesorios">
            </div>
            <div>
                <label for="edit_category_description">Descripción</label>
                <textarea id="edit_category_description" name="description" placeholder="Uso interno de esta categoría"></textarea>
            </div>
            <div class="actions" style="margin-top: 16px; padding-top: 14px; border-top: 1px solid var(--line); display: flex; justify-content: flex-end; gap: 12px;">
                <button class="button secondary" type="button" onclick="closeCategoryModal()">Cancelar</button>
                <button class="button" type="submit">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>

<script>
window.openProductModal = function openProductModal() {
    const modalTitle = document.getElementById('modalTitle');
    const productForm = document.getElementById('productForm');
    const formMethod = document.getElementById('formMethod');
    const modalSubmitBtn = document.getElementById('modalSubmitBtn');
    
    if (modalTitle) modalTitle.textContent = 'Crear nuevo producto';
    if (productForm) productForm.action = '{{ route("products.store") }}';
    if (formMethod) formMethod.value = 'POST';
    if (modalSubmitBtn) modalSubmitBtn.textContent = 'Guardar producto';
    
    const sku = document.getElementById('sku');
    const name = document.getElementById('name');
    const descEditor = document.getElementById('product_description_editor');
    const descInput = document.getElementById('description');
    const unit = document.getElementById('unit');
    const price = document.getElementById('price');
    const active = document.getElementById('active');
    const categorySelect = document.getElementById('product_category_id');

    if (sku) sku.value = '';
    if (name) name.value = '';
    if (descEditor) descEditor.innerHTML = '';
    if (descInput) descInput.value = '';
    if (unit) unit.value = 'UND';
    if (price) price.value = '0';
    if (active) active.checked = true;
    if (categorySelect) {
        @if ($currentCategory)
            categorySelect.value = '{{ $currentCategory->id }}';
        @else
            categorySelect.value = '';
        @endif
    }

    const modal = document.getElementById('productModal');
    if (modal) {
        modal.classList.add('is-open');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
};

window.editProductModal = function editProductModal(product) {
    const modalTitle = document.getElementById('modalTitle');
    const productForm = document.getElementById('productForm');
    const formMethod = document.getElementById('formMethod');
    const modalSubmitBtn = document.getElementById('modalSubmitBtn');

    if (modalTitle) modalTitle.textContent = 'Editar producto: ' + product.name;
    if (productForm) productForm.action = '/admin/productos/' + product.id;
    if (formMethod) formMethod.value = 'PUT';
    if (modalSubmitBtn) modalSubmitBtn.textContent = 'Actualizar producto';
    
    const categorySelect = document.getElementById('product_category_id');
    const sku = document.getElementById('sku');
    const name = document.getElementById('name');
    const descEditor = document.getElementById('product_description_editor');
    const descInput = document.getElementById('description');
    const unit = document.getElementById('unit');
    const price = document.getElementById('price');
    const active = document.getElementById('active');

    if (categorySelect) categorySelect.value = product.product_category_id || '';
    if (sku) sku.value = product.sku || '';
    if (name) name.value = product.name || '';
    if (descEditor) descEditor.innerHTML = product.description || '';
    if (descInput) descInput.value = product.description || '';
    if (unit) unit.value = product.unit || 'UND';
    if (price) price.value = product.price || 0;
    if (active) active.checked = Boolean(product.active);

    const modal = document.getElementById('productModal');
    if (modal) {
        modal.classList.add('is-open');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
};

window.closeProductModal = function closeProductModal() {
    const modal = document.getElementById('productModal');
    if (modal) {
        modal.classList.remove('is-open');
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }
};

window.editCategoryModal = function editCategoryModal(category) {
    const form = document.getElementById('categoryEditForm');
    const nameInput = document.getElementById('edit_category_name');
    const descInput = document.getElementById('edit_category_description');
    const title = document.getElementById('categoryModalTitle');

    if (form) form.action = '/admin/productos/categorias/' + category.id;
    if (nameInput) nameInput.value = category.name || '';
    if (descInput) descInput.value = category.description || '';
    if (title) title.textContent = 'Editar categoría: ' + (category.name || '');

    const modal = document.getElementById('categoryModal');
    if (modal) {
        modal.classList.add('is-open');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
};

window.closeCategoryModal = function closeCategoryModal() {
    const modal = document.getElementById('categoryModal');
    if (modal) {
        modal.classList.remove('is-open');
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }
};

window.toggleAccordion = function toggleAccordion(id, btn) {
    const el = document.getElementById(id);
    const arrow = btn?.querySelector('.acc-arrow');
    const label = btn?.querySelector('.acc-label');
    if (!el) return;
    
    if (el.style.display === 'none' || !el.style.display) {
        el.style.display = 'block';
        if (arrow) arrow.style.transform = 'rotate(90deg)';
        if (label) label.textContent = 'Ocultar descripción del producto';
    } else {
        el.style.display = 'none';
        if (arrow) arrow.style.transform = 'rotate(0deg)';
        if (label) label.textContent = 'Ver descripción del producto';
    }
};

document.addEventListener('click', function(e) {
    const modal = document.getElementById('productModal');
    if (e.target === modal) {
        closeProductModal();
    }
    const catModal = document.getElementById('categoryModal');
    if (e.target === catModal) {
        closeCategoryModal();
    }
});

@if (request('create') || $editingProduct || ($errors->any() && old('unit') !== null))
    setTimeout(() => {
        @if ($editingProduct && !$errors->any())
            window.editProductModal(@json($editingProduct));
        @elseif (!$errors->any())
            window.openProductModal();
        @else
            const modal = document.getElementById('productModal');
            if (modal) {
                modal.classList.add('is-open');
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        @endif
    }, 50);
@endif
</script>
