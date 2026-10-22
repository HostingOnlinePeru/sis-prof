@php
    $totalProformas = \App\Models\Proforma::count();
    $totalClientes = \App\Models\Client::count();
    $totalProductos = \App\Models\Product::count();
    $totalDocumentos = \App\Models\Document::count();
    $montoTotal = \App\Models\Proforma::sum('total');
    $proformasEnviadas = \App\Models\Proforma::where('status', 'sent')->count();
@endphp

<x-filament-panels::page>
    <style>
        .sp-shell {
            background: #0b0f17;
            border: 1px solid #202938;
            border-radius: 10px;
            box-shadow: 0 28px 80px rgba(0, 0, 0, .36);
            display: grid;
            grid-template-columns: 230px minmax(0, 1fr);
            min-height: 620px;
            overflow: hidden;
        }

        .sp-sidebar {
            background: linear-gradient(180deg, #0f2e4a 0%, #0b1f34 100%);
            border-right: 1px solid rgba(255, 255, 255, .08);
            color: #e6f0fb;
            padding: 28px 22px;
        }

        .sp-avatar {
            align-items: center;
            background: #f8fafc;
            border: 8px solid rgba(255, 255, 255, .08);
            border-radius: 999px;
            color: #0f2e4a;
            display: flex;
            font-size: 34px;
            font-weight: 800;
            height: 92px;
            justify-content: center;
            margin: 0 auto 14px;
            width: 92px;
        }

        .sp-user {
            margin-bottom: 28px;
            text-align: center;
        }

        .sp-user strong {
            display: block;
            font-size: 18px;
            letter-spacing: .02em;
        }

        .sp-user span {
            color: #b7cbe0;
            display: block;
            font-size: 12px;
            margin-top: 4px;
        }

        .sp-nav {
            display: grid;
            gap: 8px;
        }

        .sp-nav a {
            align-items: center;
            border-radius: 8px;
            color: #dce9f7;
            display: grid;
            font-size: 14px;
            gap: 12px;
            grid-template-columns: 24px 1fr;
            padding: 11px 12px;
            text-decoration: none;
        }

        .sp-nav a:hover,
        .sp-nav a.is-active {
            background: rgba(255, 255, 255, .11);
            color: #fff;
        }

        .sp-main {
            background: #10151f;
            color: #e5edf7;
            padding: 26px 30px 30px;
        }

        .sp-top {
            align-items: center;
            display: flex;
            justify-content: space-between;
            margin-bottom: 22px;
        }

        .sp-top h1 {
            font-size: 24px;
            font-weight: 750;
            margin: 0;
        }

        .sp-menu {
            color: #91a4ba;
            font-size: 24px;
        }

        .sp-stats {
            display: grid;
            gap: 18px;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            margin-bottom: 20px;
        }

        .sp-card {
            background: #172131;
            border: 1px solid #273348;
            border-radius: 8px;
            box-shadow: 0 14px 30px rgba(0, 0, 0, .22);
            padding: 18px;
        }

        .sp-card.is-primary {
            background: linear-gradient(135deg, #12395b, #0d2741);
            border-color: #1b527c;
        }

        .sp-card small {
            color: #9fb1c6;
            display: block;
            font-size: 12px;
            margin-bottom: 8px;
        }

        .sp-card strong {
            color: #fff;
            display: block;
            font-size: 31px;
            font-weight: 600;
            line-height: 1;
        }

        .sp-grid {
            display: grid;
            gap: 20px;
            grid-template-columns: minmax(0, 1.7fr) minmax(260px, .8fr);
        }

        .sp-panel {
            background: #151d2a;
            border: 1px solid #263247;
            border-radius: 8px;
            box-shadow: 0 14px 30px rgba(0, 0, 0, .18);
            padding: 18px;
        }

        .sp-panel h2 {
            color: #fff;
            font-size: 16px;
            margin: 0 0 16px;
        }

        .sp-bars {
            display: grid;
            gap: 13px;
        }

        .sp-bar {
            display: grid;
            gap: 10px;
            grid-template-columns: 90px 1fr 44px;
            align-items: center;
            color: #cbd5e1;
            font-size: 13px;
        }

        .sp-track {
            background: #263247;
            border-radius: 999px;
            height: 12px;
            overflow: hidden;
        }

        .sp-fill {
            background: linear-gradient(90deg, #ffb020, #f97316);
            border-radius: 999px;
            display: block;
            height: 100%;
        }

        .sp-actions {
            display: grid;
            gap: 12px;
        }

        .sp-action {
            background: #0f2e4a;
            border: 1px solid #214d73;
            border-radius: 8px;
            color: #fff;
            display: block;
            font-weight: 700;
            padding: 13px 14px;
            text-align: center;
            text-decoration: none;
        }

        .sp-action.is-orange {
            background: #ea7a00;
            border-color: #f59e0b;
            color: #111;
        }

        .sp-progress {
            align-items: center;
            display: flex;
            justify-content: center;
            margin: 16px auto;
        }

        .sp-ring {
            align-items: center;
            background:
                radial-gradient(circle at center, #151d2a 0 54%, transparent 55%),
                conic-gradient(#f59e0b 0 45%, #12395b 45% 100%);
            border-radius: 999px;
            display: flex;
            font-size: 22px;
            font-weight: 800;
            height: 126px;
            justify-content: center;
            width: 126px;
        }

        .sp-muted {
            color: #9fb1c6;
            font-size: 13px;
            line-height: 1.6;
            margin: 0;
            text-align: center;
        }

        @media (max-width: 980px) {
            .sp-shell {
                grid-template-columns: 1fr;
            }

            .sp-stats,
            .sp-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="sp-shell">
        @php
            $company = \App\Models\CompanySetting::first();
            $dashboardLogo = \App\Http\Controllers\CompanyProfileController::publicLogoUrl($company?->dashboard_logo_path ?: $company?->proforma_logo_path ?: $company?->logo_path);
        @endphp
        <aside class="sp-sidebar">
            @if ($dashboardLogo)
                <img class="sp-avatar" src="{{ $dashboardLogo }}" alt="Logo de empresa" style="object-fit: contain; background: transparent; border: none; border-radius: 0;">
            @else
                <div class="sp-avatar">{{ strtoupper(substr($company?->business_name ?: 'SP', 0, 2)) }}</div>
            @endif
            <div class="sp-user">
                <strong>{{ strtoupper($company?->business_name ?: 'ADMIN') }}</strong>
                <span>{{ auth()->user()?->email ?: 'admin@sistema.com' }}</span>
            </div>

            <nav class="sp-nav">
                <a href="{{ \App\Filament\Pages\Escritorio::getUrl() }}" class="is-active"><span>⌂</span><span>Escritorio</span></a>
                <a href="{{ \App\Filament\Resources\Proformas\ProformaResource::getUrl() }}"><span>▣</span><span>Proformas</span></a>
                <a href="{{ \App\Filament\Resources\Clients\ClientResource::getUrl() }}"><span>◉</span><span>Clientes</span></a>
                <a href="{{ \App\Filament\Resources\Products\ProductResource::getUrl() }}"><span>◆</span><span>Productos</span></a>
                <a href="{{ \App\Filament\Resources\Documents\DocumentResource::getUrl() }}"><span>▤</span><span>Documentos</span></a>
                <a href="{{ \App\Filament\Resources\CompanySettings\CompanySettingResource::getUrl() }}"><span>⚙</span><span>Empresa</span></a>
            </nav>
        </aside>

        <main class="sp-main">
            <div class="sp-top">
                <h1>Dashboard de Proformas</h1>
                <div class="sp-menu">☰</div>
            </div>

            <section class="sp-stats">
                <div class="sp-card is-primary">
                    <small>Total cotizado</small>
                    <strong>S/ {{ number_format((float) $montoTotal, 0) }}</strong>
                </div>

                <div class="sp-card">
                    <small>Proformas</small>
                    <strong>{{ $totalProformas }}</strong>
                </div>

                <div class="sp-card">
                    <small>Clientes</small>
                    <strong>{{ $totalClientes }}</strong>
                </div>

                <div class="sp-card">
                    <small>Productos</small>
                    <strong>{{ $totalProductos }}</strong>
                </div>
            </section>

            <section class="sp-grid">
                <div class="sp-panel">
                    <h2>Resumen operativo</h2>
                    <div class="sp-bars">
                        <div class="sp-bar">
                            <span>Proformas</span>
                            <span class="sp-track"><span class="sp-fill" style="width: {{ min($totalProformas * 18, 100) }}%"></span></span>
                            <span>{{ $totalProformas }}</span>
                        </div>
                        <div class="sp-bar">
                            <span>Enviadas</span>
                            <span class="sp-track"><span class="sp-fill" style="width: {{ min($proformasEnviadas * 20, 100) }}%"></span></span>
                            <span>{{ $proformasEnviadas }}</span>
                        </div>
                        <div class="sp-bar">
                            <span>Clientes</span>
                            <span class="sp-track"><span class="sp-fill" style="width: {{ min($totalClientes * 18, 100) }}%"></span></span>
                            <span>{{ $totalClientes }}</span>
                        </div>
                        <div class="sp-bar">
                            <span>Documentos</span>
                            <span class="sp-track"><span class="sp-fill" style="width: {{ min($totalDocumentos * 18, 100) }}%"></span></span>
                            <span>{{ $totalDocumentos }}</span>
                        </div>
                    </div>
                </div>

                <div class="sp-panel">
                    <h2>Acciones rápidas</h2>
                    <div class="sp-actions">
                        <a class="sp-action is-orange" href="{{ \App\Filament\Resources\Proformas\ProformaResource::getUrl('create') }}">Nueva proforma</a>
                        <a class="sp-action" href="{{ \App\Filament\Resources\Clients\ClientResource::getUrl('create') }}">Nuevo cliente</a>
                        <a class="sp-action" href="{{ \App\Filament\Resources\Products\ProductResource::getUrl('create') }}">Nuevo producto</a>
                    </div>

                    <div class="sp-progress">
                        <div class="sp-ring">45%</div>
                    </div>

                    <p class="sp-muted">Panel inicial listo para controlar clientes, productos, documentos y proformas desde el menú lateral.</p>
                </div>
            </section>
        </main>
    </div>
</x-filament-panels::page>
