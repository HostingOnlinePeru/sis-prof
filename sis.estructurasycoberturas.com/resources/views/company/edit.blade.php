<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Empresa - Sistema de Proformas</title>
    <style>
        :root {
            color-scheme: dark;
            --bg: #07090d;
            --sidebar: #0d263d;
            --sidebar-deep: #0a1624;
            --panel: #111820;
            --field: #0c1118;
            --line: rgba(255, 255, 255, .10);
            --text: #f6f8fb;
            --muted: #9aa8b7;
            --amber: #f59e0b;
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

        .shell {
            display: grid;
            grid-template-columns: 260px minmax(0, 1fr);
            min-height: 100vh;
        }

        .sidebar {
            background: linear-gradient(180deg, #0f3554 0%, var(--sidebar) 58%, var(--sidebar-deep) 100%);
            border-right: 1px solid rgba(255, 255, 255, .08);
            padding: 28px 22px;
        }

        .brand {
            border-bottom: 1px solid rgba(255, 255, 255, .12);
            margin-bottom: 24px;
            padding-bottom: 24px;
            text-align: center;
        }

        .avatar {
            width: 72px;
            height: 72px;
            display: grid;
            place-items: center;
            margin: 0 auto 14px;
            border-radius: 50%;
            background: #f8fafc;
            color: #0f3554;
            font-size: 28px;
            font-weight: 800;
            object-fit: contain;
            padding: 8px;
        }

        .brand h1 {
            margin: 0;
            font-size: 20px;
        }

        .brand p {
            margin: 6px 0 0;
            color: rgba(255, 255, 255, .70);
            font-size: 13px;
        }

        .nav {
            display: grid;
            gap: 8px;
        }

        .nav a, .nav button {
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
            transition: background .18s ease, color .18s ease, transform .18s ease, box-shadow .18s ease;
        }

        .nav a:hover, .nav button:hover, .nav .active {
            background: linear-gradient(90deg, rgba(245, 158, 11, .22), rgba(255, 255, 255, .10));
            color: #fff;
            box-shadow: inset 3px 0 0 #fbbf24;
            transform: translateX(3px);
        }

        .icon {
            width: 24px;
            height: 24px;
            display: grid;
            place-items: center;
            border-radius: 7px;
            background: rgba(255, 255, 255, .12);
            font-size: 13px;
            font-weight: 800;
        }

        .main {
            min-width: 0;
            padding: 30px;
            background:
                radial-gradient(circle at top right, rgba(245, 158, 11, .11), transparent 34%),
                #090b10;
        }

        .top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 24px;
        }

        .top h2 {
            margin: 0;
            font-size: 26px;
            line-height: 1.2;
        }

        .top p {
            margin: 7px 0 0;
            color: var(--muted);
        }

        .panel {
            background: linear-gradient(180deg, rgba(255, 255, 255, .055), rgba(255, 255, 255, .025));
            border: 1px solid var(--line);
            border-radius: 8px;
            box-shadow: 0 18px 45px rgba(0, 0, 0, .24);
            padding: 22px;
        }

        .notice {
            background: rgba(22, 163, 74, .12);
            border: 1px solid rgba(34, 197, 94, .35);
            border-radius: 8px;
            color: #bbf7d0;
            margin-bottom: 18px;
            padding: 12px 14px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .field.full {
            grid-column: 1 / -1;
        }

        label {
            display: block;
            color: #d8e0ea;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        input, select {
            width: 100%;
            min-height: 44px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--field);
            color: var(--text);
            font: inherit;
            outline: none;
            padding: 0 13px;
            transition: border-color .18s ease, box-shadow .18s ease, background .18s ease;
        }

        input[type="file"] {
            padding: 10px 13px;
        }

        input:hover, select:hover {
            border-color: rgba(245, 158, 11, .38);
        }

        input:focus, select:focus {
            border-color: rgba(245, 158, 11, .78);
            box-shadow: 0 0 0 4px rgba(245, 158, 11, .13);
            background: #0f1722;
        }

        .error {
            color: #fecaca;
            font-size: 13px;
            margin-top: 7px;
        }

        .logo-row {
            display: grid;
            grid-template-columns: 112px minmax(0, 1fr);
            gap: 14px;
            align-items: center;
        }

        .preview {
            width: 112px;
            height: 76px;
            display: grid;
            place-items: center;
            border: 1px dashed rgba(255, 255, 255, .22);
            border-radius: 8px;
            background: rgba(255, 255, 255, .04);
            color: var(--muted);
            font-size: 12px;
            text-align: center;
            overflow: hidden;
        }

        .preview img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            padding: 8px;
        }

        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 22px;
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 44px;
            border: 0;
            border-radius: 8px;
            padding: 0 18px;
            background: var(--amber);
            color: #160d02;
            cursor: pointer;
            font: inherit;
            font-weight: 800;
            box-shadow: 0 12px 26px rgba(245, 158, 11, .18);
            transition: transform .18s ease, box-shadow .18s ease, background .18s ease;
        }

        .button:hover {
            background: #fbbf24;
            box-shadow: 0 18px 36px rgba(245, 158, 11, .28);
            transform: translateY(-2px);
        }

        .button.secondary {
            background: #1d2733;
            color: #e5edf6;
            border: 1px solid var(--line);
            box-shadow: none;
        }

        .button.secondary:hover {
            background: #263546;
            box-shadow: 0 14px 30px rgba(0, 0, 0, .24);
        }

        .button-icon {
            width: 20px;
            height: 20px;
            display: inline-block;
        }

        @media (max-width: 960px) {
            .shell, .grid {
                grid-template-columns: 1fr;
            }

            .field.full {
                grid-column: auto;
            }

            .top, .actions {
                align-items: stretch;
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    @php
        $dashboardLogo = \App\Http\Controllers\CompanyProfileController::publicLogoUrl($company->dashboard_logo_path ?: $company->proforma_logo_path ?: $company->logo_path);
        $proformaLogo = \App\Http\Controllers\CompanyProfileController::publicLogoUrl($company->proforma_logo_path ?: $company->dashboard_logo_path ?: $company->logo_path);
    @endphp

    <div class="shell">
        <aside class="sidebar">
            <div class="brand">
                @if ($dashboardLogo)
                    <img class="avatar" src="{{ $dashboardLogo }}" alt="Logo de empresa">
                @else
                    <div class="avatar">EM</div>
                @endif
                <h1>{{ $company->business_name ?: 'Sistema de Proformas' }}</h1>
                <p>{{ auth()->user()->email }}</p>
            </div>

            <nav class="nav" aria-label="Menu principal">
                <a href="{{ route('dashboard.local') }}"><span class="icon">IN</span><span>Inicio</span></a>
                <a href="/admin/proformas"><span class="icon">PF</span><span>Proformas</span></a>
                <a href="/admin/clients"><span class="icon">CL</span><span>Clientes</span></a>
                <a href="/admin/products"><span class="icon">PR</span><span>Productos</span></a>
                <a href="{{ route('documents.index') }}"><span class="icon">DC</span><span>Documentos</span></a>
                <a class="active" href="{{ route('company.edit') }}"><span class="icon">EM</span><span>Empresa</span></a>
                <form method="post" action="/admin/logout">
                    @csrf
                    <button type="submit"><span class="icon">SA</span><span>Salir</span></button>
                </form>
            </nav>
        </aside>

        <main class="main">
            <header class="top">
                <div>
                    <h2>Datos de la Empresa</h2>
                    <p>Esta información se usará en el dashboard y en las proformas generadas.</p>
                </div>
                <a class="button secondary" href="{{ route('dashboard.local') }}" aria-label="Ir al escritorio">
                    <svg class="button-icon" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3h11A2.5 2.5 0 0 1 20 5.5v8A2.5 2.5 0 0 1 17.5 16h-11A2.5 2.5 0 0 1 4 13.5v-8Z" fill="none" stroke="currentColor" stroke-width="2"/>
                        <path d="M9 21h6M12 16v5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2"/>
                    </svg>
                    <span>Escritorio</span>
                </a>
            </header>

            @if (session('status'))
                <div class="notice">{{ session('status') }}</div>
            @endif

            <form class="panel" method="post" action="{{ route('company.update') }}" enctype="multipart/form-data">
                @csrf

                <div class="grid">
                    <div class="field">
                        <label for="business_name">Nombre de la Empresa</label>
                        <input id="business_name" name="business_name" value="{{ old('business_name', $company->business_name) }}" required>
                        @error('business_name') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field">
                        <label for="tax_id">RUC</label>
                        <input id="tax_id" name="tax_id" value="{{ old('tax_id', $company->tax_id) }}">
                        @error('tax_id') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field">
                        <label for="default_currency">Moneda</label>
                        <select id="default_currency" name="default_currency" required>
                            <option value="PEN" @selected(old('default_currency', $company->default_currency ?: 'PEN') === 'PEN')>Soles (PEN)</option>
                            <option value="USD" @selected(old('default_currency', $company->default_currency) === 'USD')>Dólares (USD)</option>
                        </select>
                        @error('default_currency') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field">
                        <label for="phone">Teléfono Fijo</label>
                        <input id="phone" name="phone" value="{{ old('phone', $company->phone) }}">
                        @error('phone') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field">
                        <label for="mobile_phone">Teléfono Móvil</label>
                        <input id="mobile_phone" name="mobile_phone" value="{{ old('mobile_phone', $company->mobile_phone) }}">
                        @error('mobile_phone') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field full">
                        <label for="address">Dirección de la Empresa</label>
                        <input id="address" name="address" value="{{ old('address', $company->address) }}">
                        @error('address') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field full">
                        <label for="dashboard_logo">Subir logo de la empresa</label>
                        <div class="logo-row">
                            <div class="preview">
                                @if ($dashboardLogo)
                                    <img src="{{ $dashboardLogo }}" alt="Logo de dashboard">
                                @else
                                    Sin logo
                                @endif
                            </div>
                            <input id="dashboard_logo" name="dashboard_logo" type="file" accept="image/*">
                        </div>
                        @error('dashboard_logo') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field full">
                        <label for="proforma_logo">Logo de proforma</label>
                        <div class="logo-row">
                            <div class="preview">
                                @if ($proformaLogo)
                                    <img src="{{ $proformaLogo }}" alt="Logo de proforma">
                                @else
                                    Sin logo
                                @endif
                            </div>
                            <input id="proforma_logo" name="proforma_logo" type="file" accept="image/*">
                        </div>
                        @error('proforma_logo') <div class="error">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="actions">
                    <button class="button" type="submit">Guardar</button>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
