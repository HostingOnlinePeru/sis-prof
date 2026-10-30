@php
    $statusLabels = [
        'created' => 'Creada',
        'sent' => 'Enviada',
        'accepted' => 'Aceptada',
        'cancelled' => 'Cancelada',
    ];
    $companyCurrencySymbol = \App\Support\LatamCurrencies::symbol(app(\App\Support\CompanyContext::class)->active()?->default_currency);
@endphp

@if (session('status'))
    <div class="notice">{{ session('status') }}</div>
@endif

<section class="stats" aria-label="Resumen de proformas">
    <article class="stat">
        <p class="label">Proformas</p>
        <p class="value">{{ $totalProformas }}</p>
    </article>
    <article class="stat">
        <p class="label">Creadas</p>
        <p class="value">{{ $totalCreated }}</p>
    </article>
    <article class="stat">
        <p class="label">Total cotizado</p>
        <p class="value">{{ $companyCurrencySymbol }} {{ number_format((float) $totalQuoted, 2) }}</p>
    </article>
</section>

<section class="panel">
    <div class="sp-section-title">
        <h3>Proformas registradas</h3>
        <a class="button blue" href="{{ route('proformas.create') }}" data-ajax-link data-nav="proformas">
            <svg class="button-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                <path d="M12 5v14"/>
                <path d="M5 12h14"/>
            </svg>
            <span>Nueva proforma</span>
        </a>
    </div>

    <form class="search" method="get" action="{{ route('proformas.index') }}" data-ajax-form>
        <input name="q" value="{{ request('q') }}" placeholder="Buscar por número, cliente, RUC o asunto">
        <button class="button secondary" type="submit">Buscar</button>
    </form>

    @if ($proformas->isEmpty())
        <div class="empty">Todavía no hay proformas registradas.</div>
    @else
        <table class="sp-table">
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($proformas as $proforma)
                    <tr>
                        <td>{{ $proforma->number }}</td>
                        <td>{{ $proforma->client?->name ?: '-' }}</td>
                        <td>{{ $proforma->issue_date?->format('d/m/Y') }}</td>
                        <td>
                            <span class="sp-status">{{ $statusLabels[$proforma->status] ?? $proforma->status }}</span>
                            <form method="post" action="{{ route('proformas.status.update', $proforma) }}" data-ajax-form style="display: flex; gap: 6px; margin-top: 8px;">
                                @csrf
                                @method('PATCH')
                                <label class="sr-only" for="status_{{ $proforma->id }}">Cambiar estado</label>
                                <select id="status_{{ $proforma->id }}" name="status" aria-label="Cambiar estado de {{ $proforma->number }}">
                                    <option value="accepted" @selected($proforma->status === 'accepted')>Aceptada</option>
                                    <option value="cancelled" @selected($proforma->status === 'cancelled')>Cancelada</option>
                                </select>
                                <button class="button secondary" type="submit">Guardar</button>
                            </form>
                        </td>
                        <td>{{ \App\Support\LatamCurrencies::symbol($proforma->currency) }} {{ number_format((float) $proforma->total, 2) }}</td>
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
                                <form method="post" action="{{ route('proformas.destroy', $proforma) }}" data-ajax-form onsubmit="return confirm('¿Eliminar esta proforma?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="button secondary" type="submit" title="Borrar" aria-label="Borrar proforma">
                                        <svg class="button-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                            <path d="M3 6h18"/>
                                            <path d="M8 6V4h8v2"/>
                                            <path d="M19 6l-1 14H6L5 6"/>
                                            <path d="M10 11v6M14 11v6"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</section>
