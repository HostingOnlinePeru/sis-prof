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

<section class="stats" aria-label="Resumen de clientes">
    <article class="stat">
        <p class="label">Clientes</p>
        <p class="value">{{ $totalClients }}</p>
    </article>
    <article class="stat">
        <p class="label">Con email</p>
        <p class="value">{{ $totalClientsWithEmail }}</p>
    </article>
    <article class="stat">
        <p class="label">Con RUC</p>
        <p class="value">{{ $totalClientsWithRuc }}</p>
    </article>
</section>

<section class="workspace">
    <aside>
        <div class="panel">
            <div class="sp-section-title">
                <h3>{{ $editingClient ? 'Editar cliente' : 'Crear cliente' }}</h3>
                <a class="button secondary" href="{{ route('clients.index') }}" data-ajax-link data-nav="clients">Listado de clientes</a>
            </div>

            <form class="form-grid" method="post" action="{{ $editingClient ? route('clients.update', $editingClient) : route('clients.store') }}" data-ajax-form>
                @csrf
                @if ($editingClient)
                    @method('PUT')
                @endif

                <div>
                    <label for="name">Nombre del Cliente</label>
                    <input id="name" name="name" value="{{ old('name', $editingClient?->name) }}" required placeholder="Persona o contacto a quien va dirigida la proforma">
                    <div class="muted" style="margin-top: 7px;">Este nombre aparecerá en el PDF en Dirigido a.</div>
                </div>

                <div>
                    <label for="company_name">Empresa</label>
                    <input id="company_name" name="company_name" value="{{ old('company_name', $editingClient?->company_name) }}" placeholder="Nombre de la empresa">
                    <div class="muted" style="margin-top: 7px;">Este dato aparecerá en el PDF en Empresa.</div>
                </div>

                <div>
                    <label for="document_number">RUC</label>
                    <input id="document_number" name="document_number" value="{{ old('document_number', $editingClient?->document_number) }}" placeholder="Ej. 20123456789">
                </div>

                <div>
                    <label for="phone">Teléfono</label>
                    <input id="phone" name="phone" value="{{ old('phone', $editingClient?->phone) }}" placeholder="Teléfono del cliente">
                </div>

                <div>
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $editingClient?->email) }}" placeholder="correo@empresa.com">
                    <div class="muted" style="margin-top: 7px;">Se usará para enviar la proforma por correo desde la aplicación.</div>
                </div>

                <div class="actions">
                    <button class="button" type="submit">{{ $editingClient ? 'Actualizar cliente' : 'Guardar cliente' }}</button>
                </div>
            </form>
        </div>
    </aside>

    <section>
        <div class="panel">
            <div class="sp-section-title">
                <h3>Clientes registrados</h3>
                <a class="button blue" href="{{ route('clients.index') }}" data-ajax-link data-nav="clients">Nuevo cliente</a>
            </div>

            <form class="search" method="get" action="{{ route('clients.index') }}" data-ajax-form>
                <input name="q" value="{{ request('q') }}" placeholder="Buscar por nombre, empresa, RUC, email o teléfono">
                <button class="button secondary" type="submit">Buscar</button>
            </form>

            @if ($clients->isEmpty())
                <div class="empty">Todavía no hay clientes registrados.</div>
            @else
                <div class="products-list">
                    @foreach ($clients as $client)
                        <article class="panel product-card">
                            <div>
                                <h4>{{ $client->name }}</h4>
                                <div class="file-meta">
                                    <span>Empresa: {{ $client->company_name ?: '-' }}</span>
                                    <span>RUC: {{ $client->document_number ?: '-' }}</span>
                                    <span>Teléfono: {{ $client->phone ?: '-' }}</span>
                                    <span>Email: {{ $client->email ?: '-' }}</span>
                                </div>
                            </div>
                            <div style="display: flex; gap: 10px; flex-wrap: wrap; justify-content: flex-end;">
                                <a class="button secondary" href="{{ route('clients.index', ['edit' => $client->id]) }}" data-ajax-link data-nav="clients" title="Editar" aria-label="Editar cliente">
                                    <svg class="button-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                        <path d="M12 20h9"/>
                                        <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>
                                    </svg>
                                </a>
                                <form method="post" action="{{ route('clients.destroy', $client) }}" data-ajax-form onsubmit="return confirm('¿Eliminar este cliente?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="button secondary" type="submit" title="Borrar" aria-label="Borrar cliente">
                                        <svg class="button-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                            <path d="M3 6h18"/>
                                            <path d="M8 6V4h8v2"/>
                                            <path d="M19 6l-1 14H6L5 6"/>
                                            <path d="M10 11v6M14 11v6"/>
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
