@php
    $statusLabels = [
        'created' => 'Creada',
        'sent' => 'Enviada',
        'accepted' => 'Aceptada',
        'cancelled' => 'Cancelada',
    ];
    $companyCurrencySymbol = \App\Support\LatamCurrencies::symbol(app(\App\Support\CompanyContext::class)->active()?->default_currency);
@endphp

<section class="sp-grid" aria-label="Indicadores">
    <article class="sp-card feature">
        <div class="sp-kpi-top">
            <p class="sp-label">Total cotizado</p>
            <span class="sp-kpi-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </span>
        </div>
        <p class="sp-value money">{{ $companyCurrencySymbol }} {{ number_format((float) $stats['total'], 2) }}</p>
    </article>
    <article class="sp-card">
        <div class="sp-kpi-top">
            <p class="sp-label">Proformas</p>
            <span class="sp-kpi-icon" style="color:#60a5fa;" aria-hidden="true">
                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M8 13h8M8 17h6"/></svg>
            </span>
        </div>
        <p class="sp-value">{{ $stats['proformas'] }}</p>
    </article>
    <article class="sp-card">
        <div class="sp-kpi-top">
            <p class="sp-label">Clientes</p>
            <span class="sp-kpi-icon" style="color:#34d399;" aria-hidden="true">
                <svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </span>
        </div>
        <p class="sp-value">{{ $stats['clientes'] }}</p>
    </article>
    <article class="sp-card">
        <div class="sp-kpi-top">
            <p class="sp-label">Productos</p>
            <span class="sp-kpi-icon" style="color:#c084fc;" aria-hidden="true">
                <svg viewBox="0 0 24 24"><path d="M12 3 4 7.5 12 12l8-4.5L12 3z"/><path d="M4 7.5v9L12 21l8-4.5v-9"/><path d="M12 12v9"/></svg>
            </span>
        </div>
        <p class="sp-value">{{ $stats['productos'] }}</p>
    </article>
</section>

<section class="sp-content">
    <article class="sp-card">
        <div class="sp-section-title">
            <div>
                <h3 style="margin:0;">Últimas proformas</h3>
                <p class="muted" style="margin:4px 0 0;">Seguimiento de tus cotizaciones emitidas recientemente.</p>
            </div>
            <a class="button secondary" href="{{ route('proformas.index') }}" data-ajax-link data-nav="proformas">Ver todas</a>
        </div>

        @if ($recentProformas->isEmpty())
            <div class="sp-empty" style="padding: 38px 24px;">
                <div style="width:52px;height:52px;margin:0 auto 12px;border-radius:14px;display:grid;place-items:center;background:rgba(245,158,11,.14);border:1px solid rgba(245,158,11,.32);color:#fbbf24;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:26px;height:26px;">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <path d="M14 2v6h6M12 11v6M9 14h6"/>
                    </svg>
                </div>
                <strong style="display:block;color:#f8fafc;font-size:15px;margin-bottom:6px;">Todavía no hay proformas registradas</strong>
                <p style="margin:0 0 16px;font-size:13px;">Crea tu primera cotización profesional en PDF lista para enviar por correo o WhatsApp.</p>
                <a class="button" href="{{ route('proformas.create') }}" data-ajax-link data-nav="proformas">+ Crear primera proforma</a>
            </div>
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
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </article>

    <aside class="sp-card">
        <div class="sp-section-title" style="margin-bottom: 16px;">
            <div>
                <h3 style="margin: 0;">Accesos rápidos</h3>
                <p class="muted" style="margin: 4px 0 0; font-size: 12.5px;">Panel de acciones directas de tu negocio.</p>
            </div>
            <span class="sp-quick-badge">PRO</span>
        </div>

        <div class="sp-quick">
            <a class="sp-quick-card is-primary" href="{{ route('proformas.create') }}" data-ajax-link data-nav="proformas">
                <div class="sp-quick-main">
                    <span class="sp-quick-icon amber" aria-hidden="true">
                        <svg viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <path d="M14 2v6h6"/>
                            <path d="M12 11v6M9 14h6"/>
                        </svg>
                    </span>
                    <div class="sp-quick-text">
                        <span class="sp-quick-title">Crear proforma</span>
                        <span class="sp-quick-sub">Generar nueva cotización comercial en PDF</span>
                    </div>
                </div>
                <span class="sp-quick-arrow" aria-hidden="true">
                    <svg viewBox="0 0 24 24"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
                </span>
            </a>

            <a class="sp-quick-card" href="{{ route('clients.index') }}" data-ajax-link data-nav="clients">
                <div class="sp-quick-top">
                    <span class="sp-quick-icon blue" aria-hidden="true">
                        <svg viewBox="0 0 24 24">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M19 8v6M16 11h6"/>
                        </svg>
                    </span>
                    <span class="sp-quick-arrow" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><path d="M7 17 17 7M7 7h10v10"/></svg>
                    </span>
                </div>
                <div class="sp-quick-text">
                    <span class="sp-quick-title">Registrar cliente</span>
                    <span class="sp-quick-sub">RUC/DNI, correo y teléfono</span>
                </div>
            </a>

            <a class="sp-quick-card" href="{{ route('products.index', ['create' => 1]) }}" data-ajax-link data-nav="products">
                <div class="sp-quick-top">
                    <span class="sp-quick-icon emerald" aria-hidden="true">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 3 4 7.5 12 12l8-4.5L12 3z"/>
                            <path d="M4 7.5v9L12 21l8-4.5v-9"/>
                            <path d="M12 12v9"/>
                        </svg>
                    </span>
                    <span class="sp-quick-arrow" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><path d="M7 17 17 7M7 7h10v10"/></svg>
                    </span>
                </div>
                <div class="sp-quick-text">
                    <span class="sp-quick-title">Agregar producto</span>
                    <span class="sp-quick-sub">Catálogo, categorías y precios</span>
                </div>
            </a>

            @if (auth()->user()?->canUsePhotoGallery())
                <a class="sp-quick-card" href="{{ route('documents.index') }}" data-ajax-link data-nav="documents">
                    <div class="sp-quick-top">
                        <span class="sp-quick-icon purple" aria-hidden="true">
                            <svg viewBox="0 0 24 24">
                                <rect x="3" y="4" width="18" height="16" rx="2"/>
                                <circle cx="8.5" cy="9.5" r="1.5"/>
                                <path d="m21 15-5-5L5 20"/>
                            </svg>
                        </span>
                        <span class="sp-quick-arrow" aria-hidden="true">
                            <svg viewBox="0 0 24 24"><path d="M7 17 17 7M7 7h10v10"/></svg>
                        </span>
                    </div>
                    <div class="sp-quick-text">
                        <span class="sp-quick-title">Galería de fotos</span>
                        <span class="sp-quick-sub">Imágenes para tus proformas</span>
                    </div>
                </a>
            @else
                <a class="sp-quick-card" href="{{ route('company.edit') }}" data-ajax-link data-nav="company">
                    <div class="sp-quick-top">
                        <span class="sp-quick-icon purple" aria-hidden="true">
                            <svg viewBox="0 0 24 24">
                                <path d="M3 21h18"/>
                                <path d="M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16"/>
                                <path d="M9 8h2M13 8h2M9 12h2M13 12h2M9 16h6"/>
                            </svg>
                        </span>
                        <span class="sp-quick-arrow" aria-hidden="true">
                            <svg viewBox="0 0 24 24"><path d="M7 17 17 7M7 7h10v10"/></svg>
                        </span>
                    </div>
                    <div class="sp-quick-text">
                        <span class="sp-quick-title">Mi empresa</span>
                        <span class="sp-quick-sub">Logo, firma y cuentas bancarias</span>
                    </div>
                </a>
            @endif

            <a class="sp-quick-card" href="{{ route('terms.index') }}" data-ajax-link data-nav="terms">
                <div class="sp-quick-top">
                    <span class="sp-quick-icon cyan" aria-hidden="true">
                        <svg viewBox="0 0 24 24">
                            <path d="M9 11l3 3L22 4"/>
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                        </svg>
                    </span>
                    <span class="sp-quick-arrow" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><path d="M7 17 17 7M7 7h10v10"/></svg>
                    </span>
                </div>
                <div class="sp-quick-text">
                    <span class="sp-quick-title">Términos y condiciones</span>
                    <span class="sp-quick-sub">Cláusulas, plazos y garantías</span>
                </div>
            </a>

            @if (auth()->user()?->canUsePhotoGallery())
                <a class="sp-quick-card" href="{{ route('company.edit') }}" data-ajax-link data-nav="company">
                    <div class="sp-quick-top">
                        <span class="sp-quick-icon rose" aria-hidden="true">
                            <svg viewBox="0 0 24 24">
                                <path d="M3 21h18"/>
                                <path d="M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16"/>
                                <path d="M9 8h2M13 8h2M9 12h2M13 12h2M9 16h6"/>
                            </svg>
                        </span>
                        <span class="sp-quick-arrow" aria-hidden="true">
                            <svg viewBox="0 0 24 24"><path d="M7 17 17 7M7 7h10v10"/></svg>
                        </span>
                    </div>
                    <div class="sp-quick-text">
                        <span class="sp-quick-title">Mi empresa</span>
                        <span class="sp-quick-sub">Logo, firma y cuentas bancarias</span>
                    </div>
                </a>
            @else
                <a class="sp-quick-card" href="{{ route('membership.index') }}" data-ajax-link data-nav="membership">
                    <div class="sp-quick-top">
                        <span class="sp-quick-icon rose" aria-hidden="true">
                            <svg viewBox="0 0 24 24">
                                <path d="m12 3 2.8 5.7 6.2.9-4.5 4.4 1.1 6.2L12 17.3 6.4 20.2l1.1-6.2L3 9.6l6.2-.9z"/>
                            </svg>
                        </span>
                        <span class="sp-quick-arrow" aria-hidden="true">
                            <svg viewBox="0 0 24 24"><path d="M7 17 17 7M7 7h10v10"/></svg>
                        </span>
                    </div>
                    <div class="sp-quick-text">
                        <span class="sp-quick-title">Mi membresía</span>
                        <span class="sp-quick-sub">Estado de plan y beneficios PRO</span>
                    </div>
                </a>
            @endif
        </div>
    </aside>
</section>
