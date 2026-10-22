<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistema de Proformas</title>
    <style>
        :root {
            color-scheme: dark;
            --bg: #07090d;
            --panel: #111820;
            --panel-2: #182332;
            --line: rgba(255, 255, 255, .09);
            --text: #f6f8fb;
            --muted: #9aa8b7;
            --amber: #f59e0b;
            --blue: #1f5f8b;
            --green: #16a34a;
            --red: #ef4444;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: var(--bg);
            color: var(--text);
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .sp-dashboard-shell {
            display: grid;
            grid-template-columns: 260px minmax(0, 1fr);
            min-height: 100vh;
        }

        .sp-sidebar {
            background: linear-gradient(180deg, #0f3554 0%, #0d263d 55%, #0a1624 100%);
            border-right: 1px solid rgba(255, 255, 255, .08);
            padding: 28px 22px;
            position: sticky;
            top: 0;
            height: 100vh;
        }

        .sp-user {
            text-align: center;
            padding-bottom: 26px;
            border-bottom: 1px solid rgba(255, 255, 255, .12);
            margin-bottom: 24px;
        }

        .sp-avatar {
            width: 72px;
            height: 72px;
            display: grid;
            place-items: center;
            margin: 0 auto 14px;
            border-radius: 50%;
            background: #f8fafc;
            color: #0f3554;
            font-weight: 800;
            font-size: 28px;
            box-shadow: 0 14px 34px rgba(0, 0, 0, .28);
        }

        .sp-logo {
            object-fit: contain;
            padding: 8px;
        }

        .sp-user h1 {
            margin: 0;
            font-size: 20px;
            line-height: 1.2;
        }

        .sp-user p {
            margin: 6px 0 0;
            color: rgba(255, 255, 255, .7);
            font-size: 13px;
        }

        .sp-nav {
            display: grid;
            gap: 8px;
        }

        .sp-nav a, .sp-nav button {
            width: 100%;
            border: 0;
            border-radius: 8px;
            background: transparent;
            color: rgba(255, 255, 255, .82);
            display: grid;
            grid-template-columns: 28px 1fr;
            align-items: center;
            gap: 10px;
            padding: 11px 12px;
            text-align: left;
            font: inherit;
            cursor: pointer;
            position: relative;
            transition: background .18s ease, color .18s ease, transform .18s ease, box-shadow .18s ease;
        }

        .sp-nav a:hover, .sp-nav button:hover, .sp-nav .active {
            background: linear-gradient(90deg, rgba(245, 158, 11, .22), rgba(255, 255, 255, .10));
            color: #fff;
            box-shadow: inset 3px 0 0 #fbbf24;
            transform: translateX(3px);
        }

        .sp-nav a:hover .sp-icon, .sp-nav button:hover .sp-icon, .sp-nav .active .sp-icon {
            background: #fbbf24;
            color: #172033;
        }

        .sp-icon {
            width: 24px;
            height: 24px;
            display: grid;
            place-items: center;
            border-radius: 7px;
            background: rgba(255, 255, 255, .12);
            font-size: 13px;
            font-weight: 800;
            transition: background .18s ease, color .18s ease, transform .18s ease;
        }

        .sp-main {
            min-width: 0;
            padding: 28px 30px 42px;
            background:
                radial-gradient(circle at top right, rgba(245, 158, 11, .11), transparent 34%),
                #090b10;
        }

        .sp-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 28px;
        }

        .sp-title h2 {
            margin: 0;
            font-size: 26px;
            line-height: 1.2;
        }

        .sp-title p {
            margin: 7px 0 0;
            color: var(--muted);
        }

        .sp-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .sp-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            border-radius: 8px;
            padding: 0 15px;
            background: var(--amber);
            color: #160d02;
            font-weight: 800;
            box-shadow: 0 12px 26px rgba(245, 158, 11, .18);
            transition: transform .18s ease, box-shadow .18s ease, background .18s ease, border-color .18s ease;
        }

        .sp-button:hover {
            background: #fbbf24;
            box-shadow: 0 18px 36px rgba(245, 158, 11, .28);
            transform: translateY(-2px);
        }

        .sp-button.secondary {
            background: #1d2733;
            color: #e5edf6;
            border: 1px solid var(--line);
            box-shadow: none;
        }

        .sp-button.secondary:hover {
            background: #263546;
            border-color: rgba(245, 158, 11, .42);
            box-shadow: 0 14px 30px rgba(0, 0, 0, .24);
        }

        .sp-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(150px, 1fr));
            gap: 18px;
            margin-bottom: 18px;
        }

        .sp-card {
            background: linear-gradient(180deg, rgba(255, 255, 255, .055), rgba(255, 255, 255, .025));
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 18px;
            box-shadow: 0 18px 45px rgba(0, 0, 0, .22);
            transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease, background .18s ease;
        }

        .sp-card:hover {
            border-color: rgba(245, 158, 11, .34);
            box-shadow: 0 24px 55px rgba(0, 0, 0, .32);
            transform: translateY(-3px);
        }

        .sp-card.feature {
            background: linear-gradient(135deg, #143d61 0%, #0e2338 62%, #111820 100%);
        }

        .sp-card.feature:hover {
            background: linear-gradient(135deg, #184b75 0%, #102c48 62%, #121d2b 100%);
        }

        .sp-label {
            margin: 0 0 10px;
            color: var(--muted);
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .sp-value {
            margin: 0;
            font-size: 30px;
            line-height: 1;
            font-weight: 850;
        }

        .sp-value.money {
            color: #fbbf24;
        }

        .sp-content {
            display: grid;
            grid-template-columns: minmax(0, 1.7fr) minmax(280px, .9fr);
            gap: 18px;
        }

        .sp-section-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
        }

        .sp-section-title h3 {
            margin: 0;
            font-size: 18px;
        }

        .sp-table {
            width: 100%;
            border-collapse: collapse;
        }

        .sp-table th, .sp-table td {
            padding: 13px 10px;
            border-bottom: 1px solid var(--line);
            text-align: left;
            font-size: 14px;
        }

        .sp-table th {
            color: var(--muted);
            font-size: 12px;
            text-transform: uppercase;
        }

        .sp-table tbody tr {
            transition: background .18s ease;
        }

        .sp-table tbody tr:hover {
            background: rgba(245, 158, 11, .075);
        }

        .sp-status {
            display: inline-flex;
            border-radius: 999px;
            padding: 5px 9px;
            background: rgba(245, 158, 11, .14);
            color: #fbbf24;
            font-size: 12px;
            font-weight: 800;
        }

        .sp-quick {
            display: grid;
            gap: 10px;
        }

        .sp-quick a {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 13px 14px;
            background: rgba(255, 255, 255, .035);
            color: #e8eef5;
            transition: border-color .18s ease, background .18s ease, transform .18s ease, box-shadow .18s ease;
        }

        .sp-quick a:hover {
            border-color: rgba(245, 158, 11, .55);
            background: rgba(245, 158, 11, .08);
            box-shadow: 0 14px 28px rgba(0, 0, 0, .22);
            transform: translateX(4px);
        }

        .sp-quick a:hover strong {
            background: #fbbf24;
            color: #172033;
        }

        .sp-quick strong {
            display: grid;
            place-items: center;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .10);
            transition: background .18s ease, color .18s ease;
        }

        .sp-empty {
            color: var(--muted);
            padding: 18px 0 4px;
        }

        @media (max-width: 960px) {
            .sp-dashboard-shell {
                grid-template-columns: 1fr;
            }

            .sp-sidebar {
                position: static;
                height: auto;
            }

            .sp-grid, .sp-content {
                grid-template-columns: 1fr;
            }

            .sp-topbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .sp-actions {
                justify-content: flex-start;
            }
        }
    </style>
</head>
<body>
    @php
        $company = $company ?? \App\Models\CompanySetting::first();
        $dashboardLogoUrl = $dashboardLogoUrl ?? \App\Http\Controllers\CompanyProfileController::publicLogoUrl($company?->dashboard_logo_path ?: $company?->proforma_logo_path ?: $company?->logo_path);
    @endphp
    <div class="sp-dashboard-shell">
        <aside class="sp-sidebar">
            <div class="sp-user">
                @if ($dashboardLogoUrl)
                    <img class="sp-avatar sp-logo" src="{{ $dashboardLogoUrl }}" alt="Logo de empresa">
                @else
                    <div class="sp-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
                @endif
                <h1>{{ $company?->business_name ?: 'Sistema de Proformas' }}</h1>
                <p>{{ auth()->user()->email }}</p>
            </div>

            <nav class="sp-nav" aria-label="Menu principal">
                <a class="active" href="{{ route('dashboard.local') }}"><span class="sp-icon">IN</span><span>Inicio</span></a>
                <a href="/admin/proformas"><span class="sp-icon">PF</span><span>Proformas</span></a>
                <a href="/admin/clients"><span class="sp-icon">CL</span><span>Clientes</span></a>
                <a href="/admin/products"><span class="sp-icon">PR</span><span>Productos</span></a>
                <a href="{{ route('documents.index') }}"><span class="sp-icon">DC</span><span>Documentos</span></a>
                <a href="/admin/term-templates"><span class="sp-icon">TC</span><span>Términos</span></a>
                <a href="{{ route('company.edit') }}"><span class="sp-icon">EM</span><span>Empresa</span></a>
                <form method="post" action="/admin/logout">
                    @csrf
                    <button type="submit"><span class="sp-icon">SA</span><span>Salir</span></button>
                </form>
            </nav>
        </aside>

        <main class="sp-main">
            <header class="sp-topbar">
                <div class="sp-title">
                    <h2>Dashboard de Proformas</h2>
                    <p>Resumen operativo para crear, revisar y enviar cotizaciones.</p>
                </div>
                <div class="sp-actions">
                    <a class="sp-button secondary" href="{{ route('products.index', ['create' => 1]) }}">Nuevo producto</a>
                    <a class="sp-button secondary" href="/admin/clients/create">Nuevo cliente</a>
                    <a class="sp-button" href="/admin/proformas/create">Nueva proforma</a>
                </div>
            </header>

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
                        <a class="sp-button secondary" href="/admin/proformas">Ver todas</a>
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentProformas as $proforma)
                                    <tr>
                                        <td>{{ $proforma->number }}</td>
                                        <td>{{ $proforma->client?->name ?? 'Sin cliente' }}</td>
                                        <td><span class="sp-status">{{ ucfirst($proforma->status ?? 'borrador') }}</span></td>
                                        <td>{{ $proforma->currency ?? 'PEN' }} {{ number_format((float) $proforma->total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </article>

                <aside class="sp-card">
                    <div class="sp-section-title">
                        <h3>Accesos rapidos</h3>
                    </div>
                    <div class="sp-quick">
                        <a href="/admin/proformas/create"><span>Crear proforma</span><strong>+</strong></a>
                        <a href="/admin/clients/create"><span>Registrar cliente</span><strong>+</strong></a>
                        <a href="/admin/products/create"><span>Agregar producto</span><strong>+</strong></a>
                        <a href="/admin/documents/create"><span>Subir documento</span><strong>+</strong></a>
                    </div>
                </aside>
            </section>
        </main>
    </div>
</body>
</html>
