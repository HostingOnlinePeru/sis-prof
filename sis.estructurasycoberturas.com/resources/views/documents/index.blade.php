<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Documentos - Sistema de Proformas</title>
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
            --green: #22c55e;
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

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 44px;
            border: 0;
            border-radius: 8px;
            padding: 0 16px;
            background: var(--amber);
            color: #160d02;
            cursor: pointer;
            font: inherit;
            font-weight: 800;
            box-shadow: 0 12px 26px rgba(245, 158, 11, .18);
            transition: transform .18s ease, box-shadow .18s ease, background .18s ease, border-color .18s ease;
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
            border-color: rgba(245, 158, 11, .42);
            box-shadow: 0 14px 30px rgba(0, 0, 0, .24);
        }

        .button-icon {
            width: 20px;
            height: 20px;
            display: inline-block;
            flex: 0 0 auto;
        }

        .notice {
            background: rgba(34, 197, 94, .12);
            border: 1px solid rgba(34, 197, 94, .35);
            border-radius: 8px;
            color: #bbf7d0;
            margin-bottom: 18px;
            padding: 12px 14px;
        }

        .errors {
            background: rgba(239, 68, 68, .12);
            border: 1px solid rgba(239, 68, 68, .35);
            border-radius: 8px;
            color: #fecaca;
            margin-bottom: 18px;
            padding: 12px 14px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(160px, 1fr));
            gap: 16px;
            margin-bottom: 18px;
        }

        .stat, .panel, .folder, .file {
            background: linear-gradient(180deg, rgba(255, 255, 255, .055), rgba(255, 255, 255, .025));
            border: 1px solid var(--line);
            border-radius: 8px;
            box-shadow: 0 18px 45px rgba(0, 0, 0, .22);
        }

        .stat {
            padding: 18px;
            transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
        }

        .stat:hover, .folder:hover, .file:hover {
            border-color: rgba(245, 158, 11, .34);
            box-shadow: 0 24px 55px rgba(0, 0, 0, .32);
            transform: translateY(-3px);
        }

        .label {
            margin: 0 0 8px;
            color: var(--muted);
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .value {
            margin: 0;
            font-size: 28px;
            font-weight: 850;
        }

        .workspace {
            display: grid;
            grid-template-columns: minmax(280px, .85fr) minmax(0, 1.65fr);
            gap: 18px;
        }

        .panel {
            padding: 18px;
        }

        .panel h3 {
            margin: 0 0 14px;
            font-size: 18px;
        }

        .form-grid {
            display: grid;
            gap: 12px;
        }

        label {
            display: block;
            color: #d8e0ea;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 7px;
        }

        input, select, textarea {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--field);
            color: var(--text);
            font: inherit;
            outline: none;
            padding: 11px 13px;
            transition: border-color .18s ease, box-shadow .18s ease, background .18s ease;
        }

        textarea {
            min-height: 82px;
            resize: vertical;
        }

        input:hover, select:hover, textarea:hover {
            border-color: rgba(245, 158, 11, .38);
        }

        input:focus, select:focus, textarea:focus {
            border-color: rgba(245, 158, 11, .78);
            box-shadow: 0 0 0 4px rgba(245, 158, 11, .13);
            background: #0f1722;
        }

        .folders {
            display: grid;
            gap: 10px;
            margin-top: 14px;
        }

        .folder {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            padding: 13px;
            transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease, background .18s ease;
        }

        .folder.active {
            border-color: rgba(245, 158, 11, .55);
            background: rgba(245, 158, 11, .09);
        }

        .folder strong {
            display: block;
            margin-bottom: 4px;
        }

        .folder span, .muted {
            color: var(--muted);
            font-size: 13px;
        }

        .search {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 10px;
            margin-bottom: 14px;
        }

        .files {
            display: grid;
            gap: 10px;
        }

        .file {
            display: grid;
            grid-template-columns: 54px minmax(0, 1fr) auto;
            gap: 14px;
            align-items: center;
            padding: 14px;
            transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
        }

        .file-icon {
            width: 54px;
            height: 54px;
            display: grid;
            place-items: center;
            border-radius: 8px;
            background: rgba(245, 158, 11, .16);
            color: #fbbf24;
            font-weight: 900;
        }

        .file h4 {
            margin: 0 0 5px;
            overflow-wrap: anywhere;
        }

        .file-meta {
            color: var(--muted);
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            font-size: 13px;
        }

        .empty {
            border: 1px dashed rgba(255, 255, 255, .20);
            border-radius: 8px;
            color: var(--muted);
            padding: 28px;
            text-align: center;
        }

        @media (max-width: 1050px) {
            .shell, .workspace, .stats {
                grid-template-columns: 1fr;
            }

            .top, .search {
                align-items: stretch;
                grid-template-columns: 1fr;
            }

            .file {
                grid-template-columns: 44px minmax(0, 1fr);
            }

            .file .button {
                grid-column: 1 / -1;
            }
        }
    </style>
</head>
<body>
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
    @endphp

    <div class="shell">
        <aside class="sidebar">
            <div class="brand">
                @if ($dashboardLogoUrl)
                    <img class="avatar" src="{{ $dashboardLogoUrl }}" alt="Logo de empresa">
                @else
                    <div class="avatar">DC</div>
                @endif
                <h1>{{ $company?->business_name ?: 'Sistema de Proformas' }}</h1>
                <p>{{ auth()->user()->email }}</p>
            </div>

            <nav class="nav" aria-label="Menú principal">
                <a href="{{ route('dashboard.local') }}"><span class="icon">IN</span><span>Inicio</span></a>
                <a href="/admin/proformas"><span class="icon">PF</span><span>Proformas</span></a>
                <a href="/admin/clients"><span class="icon">CL</span><span>Clientes</span></a>
                <a href="/admin/products"><span class="icon">PR</span><span>Productos</span></a>
                <a class="active" href="{{ route('documents.index') }}"><span class="icon">DC</span><span>Documentos</span></a>
                <a href="/admin/term-templates"><span class="icon">TC</span><span>Términos</span></a>
                <a href="{{ route('company.edit') }}"><span class="icon">EM</span><span>Empresa</span></a>
                <form method="post" action="/admin/logout">
                    @csrf
                    <button type="submit"><span class="icon">SA</span><span>Salir</span></button>
                </form>
            </nav>
        </aside>

        <main class="main">
            <header class="top">
                <div>
                    <h2>Repositorio de Documentos</h2>
                    <p>Crea carpetas y guarda archivos para adjuntarlos luego al enviar proformas.</p>
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

            @if ($errors->any())
                <div class="errors">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <section class="stats" aria-label="Resumen de documentos">
                <article class="stat">
                    <p class="label">Archivos</p>
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
                        <h3>Crear carpeta</h3>
                        <form class="form-grid" method="post" action="{{ route('documents.folders.store') }}">
                            @csrf
                            <div>
                                <label for="folder_name">Nombre de carpeta</label>
                                <input id="folder_name" name="name" placeholder="Ej. Certificados, Fichas técnicas">
                            </div>
                            <button class="button" type="submit">Crear carpeta</button>
                        </form>
                    </div>

                    <div class="panel" style="margin-top: 18px;">
                        <h3>Carpetas</h3>
                        <div class="folders">
                            @foreach ($folders as $folder)
                                <a class="folder {{ $currentFolder?->id === $folder->id ? 'active' : '' }}" href="{{ route('documents.index', ['folder' => $folder->id]) }}">
                                    <div>
                                        <strong>{{ $folder->name }}</strong>
                                    </div>
                                    <span>{{ $folder->documents_count }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </aside>

                <section>
                    <div class="panel">
                        <h3>Subir archivo</h3>
                        <form class="form-grid" method="post" action="{{ route('documents.upload') }}" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <label for="document_folder_id">Carpeta</label>
                                <select id="document_folder_id" name="document_folder_id">
                                    <option value="">Sin carpeta</option>
                                    @foreach ($folders as $folder)
                                        <option value="{{ $folder->id }}" @selected($currentFolder?->id === $folder->id)>{{ $folder->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="file">Archivo</label>
                                <input id="file" name="file" type="file" required>
                                <div class="muted" style="margin-top: 7px;">Máximo 20 MB por archivo.</div>
                            </div>
                            <button class="button" type="submit">Subir archivo</button>
                        </form>
                    </div>

                    <div class="panel" style="margin-top: 18px;">
                        <h3>{{ $currentFolder ? 'Archivos en '.$currentFolder->name : 'Archivos del repositorio' }}</h3>

                        <form class="search" method="get" action="{{ route('documents.index') }}">
                            @if ($currentFolder)
                                <input type="hidden" name="folder" value="{{ $currentFolder->id }}">
                            @endif
                            <input name="q" value="{{ request('q') }}" placeholder="Buscar por título o archivo">
                            <button class="button secondary" type="submit">Buscar</button>
                        </form>

                        @if ($documents->isEmpty())
                            <div class="empty">Todavía no hay archivos en esta vista.</div>
                        @else
                            <div class="files">
                                @foreach ($documents as $document)
                                    @php
                                        $extension = strtoupper(pathinfo($document->original_name ?: $document->file_path, PATHINFO_EXTENSION) ?: 'DOC');
                                    @endphp
                                    <article class="file">
                                        <div class="file-icon">{{ mb_substr($extension, 0, 4) }}</div>
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
                                @endforeach
                            </div>
                        @endif
                    </div>
                </section>
            </section>
        </main>
    </div>
</body>
</html>
