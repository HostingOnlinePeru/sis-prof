@php
    $statusLabels = [
        'created' => 'Creada',
        'sent' => 'Enviada',
        'accepted' => 'Aceptada',
        'cancelled' => 'Cancelada',
    ];
@endphp

<section class="sp-grid" aria-label="Indicadores">
    <article class="sp-card feature">
        <p class="sp-label">Total cotizado</p>
        <p class="sp-value money">S/. {{ number_format((float) $stats['total'], 2) }}</p>
    </article>
    <article class="sp-card">
        <p class="sp-label">Proformas</p>
        <p class="sp-value">{{ $stats['proformas'] }}</p>
    </article>
    <article class="sp-card">
        <p class="sp-label">Clientes</p>
        <p class="sp-value">{{ $stats['clientes'] }}</p>
    </article>
    <article class="sp-card">
        <p class="sp-label">Productos</p>
        <p class="sp-value">{{ $stats['productos'] }}</p>
    </article>
</section>

<section class="sp-content">
    <article class="sp-card">
        <div class="sp-section-title">
            <h3>Últimas proformas</h3>
            <a class="button secondary" href="{{ route('proformas.index') }}" data-ajax-link data-nav="proformas">Ver todas</a>
        </div>

        @if ($recentProformas->isEmpty())
            <p class="sp-empty">Todavía no hay proformas registradas. Usa el botón Nueva proforma para crear la primera.</p>
        @else
            <table class="sp-table">
                <thead>
                    <tr>
                        <th>Número</th>
                        <th>Cliente</th>
                        <th>Estado</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentProformas as $proforma)
                        <tr>
                            <td>{{ $proforma->number }}</td>
                            <td>{{ $proforma->client?->name ?? 'Sin cliente' }}</td>
                            <td><span class="sp-status">{{ $statusLabels[$proforma->status] ?? $proforma->status }}</span></td>
                            <td>{{ $proforma->currency ?? 'PEN' }} {{ number_format((float) $proforma->total, 2) }}</td>
                            <td>
                                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                    <a class="button secondary" href="{{ route('proformas.edit', $proforma) }}" data-ajax-link data-nav="proformas" title="Editar" aria-label="Editar proforma">
                                        <svg class="button-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                            <path d="M12 20h9"/>
                                            <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>
                                        </svg>
                                    </a>
                                    <a class="button secondary" href="{{ route('proformas.pdf', $proforma) }}" target="_blank" title="Ver PDF" aria-label="Ver PDF">
                                        <svg class="button-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                            <path d="M7 3h7l5 5v13H7z"/>
                                            <path d="M14 3v6h5"/>
                                            <path d="M10 13h6M10 17h6"/>
                                        </svg>
                                    </a>
                                    <a class="button secondary" href="{{ route('proformas.pdf', ['proforma' => $proforma, 'download' => 1]) }}" title="Descargar PDF" aria-label="Descargar PDF">
                                        <svg class="button-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                            <path d="M12 3v12"/>
                                            <path d="m7 10 5 5 5-5"/>
                                            <path d="M5 21h14"/>
                                        </svg>
                                    </a>
                                    <a class="button secondary" href="{{ route('proformas.email', $proforma) }}" data-ajax-link data-nav="proformas" title="Enviar correo" aria-label="Enviar correo">
                                        <svg class="button-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                            <path d="M4 4h16v16H4z"/>
                                            <path d="m4 7 8 6 8-6"/>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </article>

    <aside class="sp-card">
        <div class="sp-section-title">
            <h3>Accesos rápidos</h3>
        </div>
        <div class="sp-quick">
            <a href="{{ route('proformas.create') }}" data-ajax-link data-nav="proformas"><span>Crear proforma</span><strong>+</strong></a>
            <a href="{{ route('clients.index') }}" data-ajax-link data-nav="clients"><span>Registrar cliente</span><strong>+</strong></a>
            <a href="{{ route('products.index', ['create' => 1]) }}" data-ajax-link data-nav="products"><span>Agregar producto</span><strong>+</strong></a>
            <a href="{{ route('documents.index') }}" data-ajax-link data-nav="documents"><span>Galería de fotos</span><strong>+</strong></a>
            <a href="{{ route('terms.index') }}" data-ajax-link data-nav="terms"><span>Términos y condiciones</span><strong>+</strong></a>
        </div>
    </aside>
</section>
