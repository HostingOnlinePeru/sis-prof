<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle }} - Sistema de Proformas</title>
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

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            background: var(--bg);
            color: var(--text);
        }

        a { color: inherit; text-decoration: none; }

        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        .app-sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: 260px;
            overflow-y: auto;
            background: linear-gradient(180deg, #0f3554 0%, var(--sidebar) 58%, var(--sidebar-deep) 100%);
            border-right: 1px solid rgba(255, 255, 255, .08);
            padding: 28px 22px;
            z-index: 30;
        }

        .app-brand {
            border-bottom: 1px solid rgba(255, 255, 255, .12);
            margin-bottom: 24px;
            padding-bottom: 24px;
            text-align: center;
        }

        .app-avatar { width: 108px; height: 108px; display: grid; place-items: center; margin: 0 auto 14px; border-radius: 12px; background: #f8fafc; color: #0f3554; font-size: 32px; font-weight: 800; object-fit: contain; padding: 5px; }
        img.app-avatar { background: transparent; padding: 0; border: none; box-shadow: none; }

        .app-brand h1 {
            margin: 0;
            font-size: 20px;
        }

        .app-brand p {
            margin: 6px 0 0;
            color: rgba(255, 255, 255, .70);
            font-size: 13px;
        }

        .company-switcher {
            margin-top: 14px;
        }

        .company-switcher label {
            display: block;
            margin-bottom: 6px;
            color: rgba(255, 255, 255, .72);
            font-size: 12px;
            font-weight: 700;
        }

        .company-switcher select {
            width: 100%;
            min-height: 38px;
            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: 7px;
            padding: 0 10px;
            background: rgba(5, 12, 20, .44);
            color: #fff;
            font: inherit;
        }

        .app-nav {
            display: grid;
            gap: 8px;
        }

        .app-nav a, .app-nav button {
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

        .app-nav a:hover, .app-nav button:hover, .app-nav .active {
            background: linear-gradient(90deg, rgba(245, 158, 11, .22), rgba(255, 255, 255, .10));
            color: #fff;
            box-shadow: inset 3px 0 0 #fbbf24;
            transform: translateX(3px);
        }

        .app-icon {
            width: 24px;
            height: 24px;
            display: grid;
            place-items: center;
            border-radius: 7px;
            background: rgba(255, 255, 255, .12);
            font-size: 13px;
            font-weight: 800;
        }

        .app-icon svg {
            width: 17px;
            height: 17px;
            stroke-width: 2.2;
        }

        .app-topbar {
            position: fixed;
            top: 0;
            left: 260px;
            right: 0;
            min-height: 96px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 24px 30px 18px;
            background:
                radial-gradient(circle at top right, rgba(245, 158, 11, .13), transparent 34%),
                rgba(9, 11, 16, .95);
            border-bottom: 1px solid rgba(255, 255, 255, .07);
            backdrop-filter: blur(10px);
            z-index: 20;
        }

        .app-topbar-leading {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
        }

        .mobile-menu-toggle {
            display: none;
            width: 44px;
            min-width: 44px;
            min-height: 44px;
            padding: 0;
            border: 1px solid rgba(255, 255, 255, .16);
            border-radius: 8px;
            background: rgba(255, 255, 255, .07);
            color: var(--text);
            cursor: pointer;
        }

        .mobile-menu-toggle svg {
            width: 22px;
            height: 22px;
        }

        .sidebar-backdrop {
            display: none;
        }

        .app-topbar h2 {
            margin: 0;
            font-size: 26px;
            line-height: 1.2;
        }

        .app-topbar p {
            margin: 7px 0 0;
            color: var(--muted);
        }

        .app-content {
            margin-left: 260px;
            min-height: 100vh;
            padding: 126px 30px 42px;
            background: #090b10;
        }

        .app-content.loading {
            opacity: .55;
            pointer-events: none;
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

        .button.blue {
            background: #2563eb;
            border: 1px solid rgba(147, 197, 253, .45);
            color: #eff6ff;
            box-shadow: 0 12px 26px rgba(37, 99, 235, .20);
        }

        .button.blue:hover {
            background: #3b82f6;
            border-color: rgba(191, 219, 254, .72);
            box-shadow: 0 18px 36px rgba(37, 99, 235, .30);
        }

        .button-icon {
            width: 20px;
            height: 20px;
            display: inline-block;
            flex: 0 0 auto;
        }

        .notice, .errors {
            border-radius: 8px;
            margin-bottom: 18px;
            padding: 12px 14px;
        }

        .notice {
            background: rgba(34, 197, 94, .12);
            border: 1px solid rgba(34, 197, 94, .35);
            color: #bbf7d0;
        }

        .errors {
            background: rgba(239, 68, 68, .12);
            border: 1px solid rgba(239, 68, 68, .35);
            color: #fecaca;
        }

        .stats, .sp-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(160px, 1fr));
            gap: 16px;
            margin-bottom: 18px;
        }

        .sp-grid {
            grid-template-columns: repeat(4, minmax(150px, 1fr));
        }

        .stat, .panel, .folder, .file, .sp-card {
            background: linear-gradient(180deg, rgba(255, 255, 255, .055), rgba(255, 255, 255, .025));
            border: 1px solid var(--line);
            border-radius: 8px;
            box-shadow: 0 18px 45px rgba(0, 0, 0, .22);
        }

        .stat, .panel, .sp-card { padding: 18px; }

        .stat, .folder, .file, .sp-card {
            transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease, background .18s ease;
        }

        .stat:hover, .folder:hover, .file:hover, .sp-card:hover {
            border-color: rgba(245, 158, 11, .34);
            box-shadow: 0 24px 55px rgba(0, 0, 0, .32);
            transform: translateY(-3px);
        }

        .sp-card.feature {
            background: linear-gradient(135deg, #143d61 0%, #0e2338 62%, #111820 100%);
        }

        .label, .sp-label {
            margin: 0 0 8px;
            color: var(--muted);
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .value, .sp-value {
            margin: 0;
            font-size: 28px;
            line-height: 1;
            font-weight: 850;
        }

        .sp-value.money { color: #fbbf24; }

        .workspace, .sp-content {
            display: grid;
            grid-template-columns: minmax(280px, .85fr) minmax(0, 1.65fr);
            gap: 18px;
        }

        .sp-content {
            grid-template-columns: minmax(0, 1.7fr) minmax(280px, .9fr);
        }

        .panel h3, .sp-section-title h3 {
            margin: 0 0 14px;
            font-size: 18px;
        }

        .form-grid {
            display: grid;
            gap: 12px;
        }

        .company-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .field.full { grid-column: 1 / -1; }

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

        input:hover, select:hover, textarea:hover { border-color: rgba(245, 158, 11, .38); }

        input:focus, select:focus, textarea:focus {
            border-color: rgba(245, 158, 11, .78);
            box-shadow: 0 0 0 4px rgba(245, 158, 11, .13);
            background: #0f1722;
        }

        .error {
            color: #fecaca;
            font-size: 13px;
            margin-top: 7px;
        }

        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 22px;
        }

        .proforma-item-actions {
            margin-top: 0;
            margin-bottom: 18px;
        }

        .logo-row {
            display: grid;
            grid-template-columns: 112px minmax(0, 1fr);
            gap: 14px;
            align-items: center;
        }

        .preview { width: 112px; height: 76px; display: grid; place-items: center; border: 1px dashed rgba(255, 255, 255, .22); border-radius: 8px; background: transparent; color: var(--muted); font-size: 12px; text-align: center; overflow: hidden; }
        .preview img { width: 100%; height: 100%; max-width: 100%; max-height: 100%; object-fit: contain; padding: 0; background: transparent; }

        .folders, .files, .products-list {display: grid; gap: 10px;}

        .folders { margin-top: 14px; }

        .folder {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            padding: 13px;
        }

        .folder.active {
            border-color: rgba(245, 158, 11, .55);
            background: rgba(245, 158, 11, .09);
        }

        .folder strong {display: block;}

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

        .file {
            display: grid;
            grid-template-columns: 54px minmax(0, 1fr) auto;
            gap: 14px;
            align-items: center;
            padding: 14px;
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

        .file-thumb {
            width: 54px;
            height: 54px;
            display: block;
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 8px;
            background: rgba(255, 255, 255, .04);
            box-shadow: 0 10px 24px rgba(0, 0, 0, .18);
            cursor: pointer;
            overflow: hidden;
            padding: 0;
            transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
        }

        .file-thumb:hover {
            border-color: rgba(245, 158, 11, .72);
            box-shadow: 0 14px 30px rgba(245, 158, 11, .16);
            transform: translateY(-2px);
        }

        .file-thumb img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
        }

        .file.image-file {
            grid-template-columns: 1fr;
            padding: 0;
            overflow: hidden;
        }

        .file.image-file .file-thumb {
            width: 100%;
            height: 180px;
            border: 0;
            border-radius: 8px;
            box-shadow: none;
        }

        .file h4 {
            margin: 0 0 5px;
            overflow-wrap: anywhere;
        }

        .files.view-grid {
            grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
        }

        .files.view-grid .file {
            grid-template-columns: 1fr;
            align-items: start;
            min-height: 210px;
        }

        .files.view-grid .file-icon {
            width: 50px;
            height: 50px;
        }

        .files.view-grid .file-thumb {
            width: 100%;
            height: 130px;
        }

        .files.view-grid .file.image-file {
            min-height: 0;
        }

        .files.view-grid .file.image-file .file-thumb {
            height: 190px;
        }

        .files.view-grid .file-meta {
            display: grid;
            gap: 6px;
        }

        .files.view-grid .button {
            width: 100%;
        }

        .section-tools {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 10px;
        }

        .view-toggle {
            display: inline-flex;
            gap: 4px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: rgba(255, 255, 255, .035);
            padding: 4px;
        }

        .view-toggle button {
            width: 38px;
            height: 34px;
            display: inline-grid;
            place-items: center;
            border: 0;
            border-radius: 6px;
            background: transparent;
            color: #aab8c7;
            cursor: pointer;
            transition: background .18s ease, color .18s ease, transform .18s ease;
        }

        .view-toggle button:hover,
        .view-toggle button.active {
            background: rgba(245, 158, 11, .20);
            color: #fff;
            transform: translateY(-1px);
        }

        .view-toggle svg {
            width: 18px;
            height: 18px;
        }

        .product-card {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 14px;
            align-items: center;
            padding: 14px;
        }

        .product-card h4 {
            margin: 0 0 6px;
            overflow-wrap: anywhere;
        }

        .product-description {
            color: #cbd5e1;
            font-size: 14px;
            line-height: 1.45;
            margin-top: 8px;
            white-space: pre-line;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            background: rgba(245, 158, 11, .14);
            color: #fbbf24;
            font-size: 12px;
            font-weight: 800;
            padding: 5px 9px;
        }

        .rich-toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 10px;
        }

        .tool-group {
            display: inline-flex;
            flex-wrap: wrap;
            gap: 4px;
            background: rgba(255, 255, 255, .035);
            border: 1px solid rgba(255, 255, 255, .08);
            padding: 4px;
            border-radius: 8px;
        }

        .tool-button {min-height: 32px; min-width: 32px; border: 1px solid transparent; border-radius: 6px; background: #1d2733; color: #e5edf6; cursor: pointer; font: inherit; font-size: 13px; font-weight: 800; padding: 0 8px; transition: background .18s ease, border-color .18s ease, transform .18s ease, color .18s ease; display: inline-flex; align-items: center; justify-content: center; gap: 4px;}
        .tool-button:hover {background: rgba(245, 158, 11, .20); border-color: rgba(245, 158, 11, .42); color: #fff; transform: translateY(-1px);}
        .tool-button svg {width: 16px; height: 16px; stroke: currentColor; fill: none; flex-shrink: 0; pointer-events: none;}

        .rich-editor {
            min-height: 240px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--field);
            color: var(--text);
            line-height: 1.55;
            outline: none;
            overflow-y: auto;
            padding: 14px;
            transition: border-color .18s ease, box-shadow .18s ease, background .18s ease;
        }

        .proforma-description-editor {
            min-height: 92px;
        }

        .rich-editor:focus {
            border-color: rgba(245, 158, 11, .78);
            box-shadow: 0 0 0 4px rgba(245, 158, 11, .13);
            background: #0f1722;
        }

        .rich-editor h1, .term-preview h1 { font-size: 20px; margin: 0 0 10px; color: #f8fafc; font-weight: 800; }
        .rich-editor h2, .term-preview h2 { font-size: 17px; margin: 0 0 8px; color: #f1f5f9; font-weight: 700; }
        .rich-editor h3, .term-preview h3 { font-size: 15px; margin: 0 0 6px; color: #e2e8f0; font-weight: 700; }
        .rich-editor p, .term-preview p { margin: 0 0 10px; }
        .rich-editor blockquote, .term-preview blockquote {
            border-left: 3px solid var(--amber);
            margin: 10px 0;
            padding-left: 14px;
            color: #94a3b8;
            font-style: italic;
        }
        .rich-editor ul, .rich-editor ol, .term-preview ul, .term-preview ol { margin: 6px 0 10px 20px; padding: 0; }
        .rich-editor hr, .term-preview hr { border: 0; border-top: 1px solid var(--line); margin: 14px 0; }

        .term-preview {
            color: #cbd5e1;
            font-size: 14px;
            line-height: 1.5;
            margin-top: 8px;
        }

        .file-meta {
            color: var(--muted);
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            font-size: 13px;
        }

        .empty, .sp-empty {
            border: 1px dashed rgba(255, 255, 255, .20);
            border-radius: 8px;
            color: var(--muted);
            padding: 28px;
            text-align: center;
        }

        .sp-section-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
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

        .sp-table tbody tr { transition: background .18s ease; }
        .sp-table tbody tr:hover { background: rgba(245, 158, 11, .075); }

        .sp-status {
            display: inline-flex;
            border-radius: 999px;
            padding: 5px 9px;
            background: rgba(245, 158, 11, .14);
            color: #fbbf24;
            font-size: 12px;
            font-weight: 800;
        }

        .sp-quick {display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px;}
        .sp-quick a.sp-quick-card {position: relative; display: flex; flex-direction: column; justify-content: space-between; gap: 14px; border: 1px solid rgba(255, 255, 255, .09); border-radius: 12px; padding: 16px; background: linear-gradient(165deg, rgba(255, 255, 255, .055) 0%, rgba(15, 23, 34, .75) 100%); color: #f1f5f9; overflow: hidden; box-shadow: 0 10px 26px rgba(0, 0, 0, .22); transition: transform .2s ease, border-color .2s ease, box-shadow .2s ease, background .2s ease;}
        .sp-quick a.sp-quick-card:hover {border-color: rgba(245, 158, 11, .55); background: linear-gradient(165deg, rgba(245, 158, 11, .11) 0%, rgba(19, 30, 44, .92) 100%); box-shadow: 0 18px 36px rgba(0, 0, 0, .38), 0 0 0 1px rgba(245, 158, 11, .20); transform: translateY(-3px);}
        .sp-quick a.sp-quick-card.is-primary {grid-column: 1 / -1; flex-direction: row; align-items: center; background: linear-gradient(135deg, rgba(245, 158, 11, .22) 0%, rgba(20, 61, 97, .55) 60%, rgba(17, 24, 32, .95) 100%); border-color: rgba(245, 158, 11, .42);}
        .sp-quick a.sp-quick-card.is-primary:hover {border-color: #fbbf24; box-shadow: 0 18px 38px rgba(245, 158, 11, .22);}
        .sp-quick-top {display: flex; align-items: center; justify-content: space-between; width: 100%; gap: 10px;}
        .sp-quick-main {display: flex; align-items: center; gap: 14px; min-width: 0;}
        .sp-quick-icon {width: 44px; height: 44px; border-radius: 11px; display: inline-grid; place-items: center; flex-shrink: 0; border: 1px solid rgba(255, 255, 255, .14); box-shadow: inset 0 1px 0 rgba(255, 255, 255, .18), 0 8px 18px rgba(0, 0, 0, .24); transition: transform .2s ease;}
        .sp-quick a.sp-quick-card:hover .sp-quick-icon {transform: scale(1.06);}
        .sp-quick-icon svg {width: 22px; height: 22px; stroke-width: 2; stroke: currentColor; fill: none;}
        .sp-quick-icon.amber {background: linear-gradient(135deg, rgba(245, 158, 11, .28), rgba(217, 119, 6, .12)); color: #fbbf24; border-color: rgba(245, 158, 11, .45);}
        .sp-quick-icon.blue {background: linear-gradient(135deg, rgba(59, 130, 246, .28), rgba(37, 99, 235, .12)); color: #60a5fa; border-color: rgba(59, 130, 246, .42);}
        .sp-quick-icon.emerald {background: linear-gradient(135deg, rgba(16, 185, 129, .28), rgba(5, 150, 105, .12)); color: #34d399; border-color: rgba(16, 185, 129, .42);}
        .sp-quick-icon.purple {background: linear-gradient(135deg, rgba(168, 85, 247, .28), rgba(126, 34, 206, .12)); color: #c084fc; border-color: rgba(168, 85, 247, .42);}
        .sp-quick-icon.cyan {background: linear-gradient(135deg, rgba(6, 182, 212, .28), rgba(8, 145, 178, .12)); color: #22d3ee; border-color: rgba(6, 182, 212, .42);}
        .sp-quick-icon.rose {background: linear-gradient(135deg, rgba(244, 63, 94, .26), rgba(225, 29, 72, .12)); color: #fb7185; border-color: rgba(244, 63, 94, .40);}
        .sp-quick-text {display: grid; gap: 3px; min-width: 0;}
        .sp-quick-title {font-size: 14.5px; font-weight: 800; color: #f8fafc; line-height: 1.25;}
        .sp-quick-sub {font-size: 12px; color: #94a3b8; line-height: 1.35;}
        .sp-quick-arrow {width: 30px; height: 30px; border-radius: 8px; display: inline-grid; place-items: center; background: rgba(255, 255, 255, .06); border: 1px solid rgba(255, 255, 255, .10); color: #cbd5e1; flex-shrink: 0; transition: background .2s ease, color .2s ease, transform .2s ease, border-color .2s ease;}
        .sp-quick a.sp-quick-card:hover .sp-quick-arrow {background: var(--amber); border-color: #fbbf24; color: #160d02; transform: translateX(2px);}
        .sp-quick-arrow svg {width: 15px; height: 15px; stroke-width: 2.4; stroke: currentColor; fill: none;}
        .sp-quick-badge {display: inline-flex; align-items: center; gap: 5px; padding: 4px 9px; border-radius: 999px; font-size: 10.5px; font-weight: 800; letter-spacing: .04em; text-transform: uppercase; background: rgba(245, 158, 11, .16); color: #fbbf24; border: 1px solid rgba(245, 158, 11, .34);}
        .sp-kpi-top {display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-bottom: 10px;}
        .sp-kpi-top .sp-label {margin: 0;}
        .sp-kpi-icon {width: 36px; height: 36px; border-radius: 9px; display: inline-grid; place-items: center; background: rgba(255, 255, 255, .07); border: 1px solid rgba(255, 255, 255, .10); color: #fbbf24;}
        .sp-kpi-icon svg {width: 18px; height: 18px; stroke-width: 2; stroke: currentColor; fill: none;}
        @media (max-width: 640px) { .sp-quick {grid-template-columns: 1fr;} }

        .modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 22px;
            background: rgba(0, 0, 0, .74);
            backdrop-filter: blur(4px);
        }

        .modal-backdrop.is-open { display: flex; }

        .modal-content {
            width: min(100%, 650px);
            max-height: 90vh;
            overflow-y: auto;
            background: #111820;
            border: 1px solid var(--line);
            border-radius: 8px;
            box-shadow: 0 26px 58px rgba(0, 0, 0, .62);
            padding: 24px;
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 20px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--line);
        }

        .modal-header h3 {
            margin: 0;
            font-size: 18px;
        }

        .icon-button {
            width: 38px;
            height: 38px;
            display: inline-grid;
            place-items: center;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #1d2733;
            color: #e5edf6;
            cursor: pointer;
            transition: background .18s ease, border-color .18s ease, color .18s ease, transform .18s ease;
        }

        .icon-button:hover {
            background: rgba(245, 158, 11, .18);
            border-color: rgba(245, 158, 11, .48);
            color: #fff;
            transform: translateY(-1px);
        }

        .icon-button svg {
            width: 18px;
            height: 18px;
        }

        .image-preview-modal {
            width: min(100%, 760px);
        }

        .image-preview-large {
            width: 100%;
            max-height: 70vh;
            display: block;
            object-fit: contain;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #05070b;
        }

        @media (max-width: 1050px) {
            .app-sidebar {
                position: fixed;
                inset: 0 auto 0 0;
                width: min(300px, calc(100vw - 46px));
                padding: 24px 20px;
                transform: translateX(-105%);
                transition: transform .24s ease;
                box-shadow: 20px 0 45px rgba(0, 0, 0, .42);
                z-index: 60;
            }

            .app-sidebar.is-open {
                transform: translateX(0);
            }

            .sidebar-backdrop {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, .58);
                opacity: 0;
                pointer-events: none;
                transition: opacity .24s ease;
                z-index: 50;
            }

            .sidebar-backdrop.is-visible {
                opacity: 1;
                pointer-events: auto;
            }

            body.menu-open {
                overflow: hidden;
            }

            .app-topbar {
                left: 0;
                min-height: 82px;
                padding: 14px 16px;
                gap: 12px;
            }

            .mobile-menu-toggle {
                display: inline-grid;
                place-items: center;
            }

            .app-topbar h2 {
                font-size: 21px;
            }

            .app-topbar p {
                margin-top: 4px;
                font-size: 13px;
            }

            #app-top-action .button {
                min-height: 40px;
                padding: 0 11px;
            }

            .app-content {
                margin-left: 0;
                padding: 106px 16px 32px;
            }

            .stats, .sp-grid, .workspace, .sp-content, .company-grid, .search {
                grid-template-columns: 1fr;
            }

            .field.full { grid-column: auto; }

            .file, .product-card { grid-template-columns: 1fr; }
            .file .button, .product-card .button { grid-column: 1 / -1; }
            .section-tools { justify-content: stretch; }
            .section-tools .button { flex: 1 1 auto; }
        }

        @media (max-width: 560px) {
            .app-topbar-leading {
                gap: 10px;
            }

            .app-topbar h2 {
                font-size: 19px;
            }

            .app-topbar p {
                display: none;
            }

            #app-top-action .button span {
                display: none;
            }

            #app-top-action .button {
                width: 40px;
                padding: 0;
            }
        }
        .membership-pill {display: inline-flex; align-items: center; gap: 6px; padding: 7px 12px; border-radius: 999px; background: rgba(245, 158, 11, .14); border: 1px solid rgba(245, 158, 11, .45); color: #fcd34d; font-size: 12px; font-weight: 800; white-space: nowrap; animation: membershipPulse 2.4s ease-in-out infinite;}
        .membership-pill.is-expired {background: rgba(239, 68, 68, .14); border-color: rgba(239, 68, 68, .45); color: #fca5a5;}
        @keyframes membershipPulse {0%, 100% {box-shadow: 0 0 0 0 rgba(245, 158, 11, .0);} 50% {box-shadow: 0 0 0 6px rgba(245, 158, 11, .12);}}
        @media (max-width: 760px) {.membership-pill {display: none;}}
    </style>
</head>
<body>
    <aside class="app-sidebar" id="app-sidebar">
        <div class="app-brand">
            @if ($dashboardLogoUrl)
                <img class="app-avatar" src="{{ $dashboardLogoUrl }}" alt="Logo de empresa">
            @elseif (auth()->user()?->isSuperAdmin())
                <div class="app-avatar" style="background: #1e3a8a; color: #60a5fa; font-weight: 900;">SIS</div>
            @else
                <div class="app-avatar">{{ strtoupper(substr($company?->business_name ?: 'SP', 0, 2)) }}</div>
            @endif

            @if (auth()->user()?->isSuperAdmin())
                <h1 style="font-size: 20px; color: #93c5fd; font-weight: 800;">{{ $company?->business_name ?: 'SISPROF' }}</h1>
                <p>Panel de Administración SaaS</p>
            @else
                <h1>{{ $company?->business_name ?: 'Sistema de Proformas' }}</h1>
                @if (auth()->user()?->isPremium() && isset($companies) && $companies->count() > 1)
                    <form class="company-switcher" method="post" action="{{ route('company.switch') }}">
                        @csrf
                        <label for="sidebar-company-select">Cambiar empresa ({{ $companies->count() }}/2)</label>
                        <select id="sidebar-company-select" name="company_id" onchange="this.form.submit()">
                            @foreach ($companies as $compItem)
                                <option value="{{ $compItem->id }}" @selected($company?->id === $compItem->id)>{{ $compItem->business_name }}</option>
                            @endforeach
                        </select>
                    </form>
                @endif
            @endif

        </div>

        <nav class="app-nav" aria-label="Menú principal">
            @if(auth()->user()?->isSuperAdmin())
                <a class="{{ $activePage === 'saas_users' ? 'active' : '' }}" href="{{ route('superadmin.users.index') }}" data-ajax-link data-nav="saas_users">
                    <span class="app-icon" style="background: rgba(37, 99, 235, 0.25); color: #60a5fa;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </span>
                    <span style="color: #93c5fd; font-weight: 700;">Gestión de Usuarios</span>
                </a>
                <a class="{{ $activePage === 'saas_memberships' ? 'active' : '' }}" href="{{ route('superadmin.subscriptions.index') }}" data-ajax-link data-nav="saas_memberships">
                    <span class="app-icon" style="background: rgba(37, 99, 235, 0.25); color: #60a5fa;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <rect x="2" y="5" width="20" height="14" rx="2"/>
                            <path d="M2 10h20M6 15h4"/>
                        </svg>
                    </span>
                    <span style="color: #93c5fd; font-weight: 700;">Membresías</span>
                </a>
            @else
                <a class="{{ $activePage === 'dashboard' ? 'active' : '' }}" href="{{ route('dashboard.local') }}" data-ajax-link data-nav="dashboard">
                    <span class="app-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path d="M3 11.5 12 4l9 7.5"/>
                            <path d="M5 10.5V20h14v-9.5"/>
                            <path d="M9 20v-6h6v6"/>
                        </svg>
                    </span>
                    <span>Inicio</span>
                </a>
                <a class="{{ $activePage === 'proformas' ? 'active' : '' }}" href="{{ route('proformas.index') }}" data-ajax-link data-nav="proformas">
                    <span class="app-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path d="M7 3h7l5 5v13H7z"/>
                            <path d="M14 3v6h5"/>
                            <path d="M10 13h6M10 17h6"/>
                        </svg>
                    </span>
                    <span>Proformas</span>
                </a>
                <a class="{{ $activePage === 'clients' ? 'active' : '' }}" href="{{ route('clients.index') }}" data-ajax-link data-nav="clients">
                    <span class="app-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"/>
                            <circle cx="9.5" cy="7" r="4"/>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </span>
                    <span>Clientes</span>
                </a>
                <a class="{{ $activePage === 'products' ? 'active' : '' }}" href="{{ route('products.index') }}" data-ajax-link data-nav="products">
                    <span class="app-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path d="m21 16-9 5-9-5V8l9-5 9 5z"/>
                            <path d="m3.3 7.7 8.7 5 8.7-5"/>
                            <path d="M12 22V12"/>
                        </svg>
                    </span>
                    <span>Productos</span>
                </a>
                @if (auth()->user()?->canUsePhotoGallery())
                    <a class="{{ $activePage === 'documents' ? 'active' : '' }}" href="{{ route('documents.index') }}" data-ajax-link data-nav="documents">
                        <span class="app-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                <path d="M3 7h7l2 2h9v9a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3z"/>
                                <path d="M3 7V5a2 2 0 0 1 2-2h5l2 2h4a2 2 0 0 1 2 2"/>
                            </svg>
                        </span>
                        <span>Galería de fotos</span>
                    </a>
                @endif
                <a class="{{ $activePage === 'terms' ? 'active' : '' }}" href="{{ route('terms.index') }}" data-ajax-link data-nav="terms">
                    <span class="app-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path d="M8 6h13M8 12h13M8 18h13"/>
                            <path d="M3 6h.01M3 12h.01M3 18h.01"/>
                        </svg>
                    </span>
                    <span>Términos</span>
                </a>
                <a class="{{ $activePage === 'company' ? 'active' : '' }}" href="{{ route('company.edit') }}" data-ajax-link data-nav="company">
                    <span class="app-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path d="M3 21h18"/>
                            <path d="M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16"/>
                            <path d="M9 7h1M14 7h1M9 11h1M14 11h1M9 15h1M14 15h1"/>
                        </svg>
                    </span>
                    <span>Empresa</span>
                </a>
                <a class="{{ $activePage === 'membership' ? 'active' : '' }}" href="{{ route('membership.index') }}" data-ajax-link data-nav="membership">
                    <span class="app-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path d="M12 2l3 6 6 .9-4.5 4.3 1 6.3L12 16.6 6.5 19.5l1-6.3L3 8.9 9 8z"/>
                        </svg>
                    </span>
                    <span>Membresía</span>
                </a>
            @endif
            <form method="post" action="/admin/logout">
                @csrf
                <button type="submit">
                    <span class="app-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path d="M10 17l5-5-5-5"/>
                            <path d="M15 12H3"/>
                            <path d="M12 3h7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-7"/>
                        </svg>
                    </span>
                    <span>Salir</span>
                </button>
            </form>
        </nav>
    </aside>

    <div class="sidebar-backdrop" id="sidebar-backdrop" aria-hidden="true"></div>

    <header class="app-topbar">
        <div class="app-topbar-leading">
            <button class="mobile-menu-toggle" id="mobile-menu-toggle" type="button" aria-label="Abrir menú" aria-controls="app-sidebar" aria-expanded="false">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2" aria-hidden="true">
                    <path d="M4 7h16M4 12h16M4 17h16"/>
                </svg>
            </button>
            <div>
                <h2 id="app-page-title">{{ $pageTitle }}</h2>
                <p id="app-page-subtitle">{{ $pageSubtitle }}</p>
            </div>
            @php $shellUser = auth()->user(); @endphp
            @if ($shellUser && ! $shellUser->isSuperAdmin() && $shellUser->membershipDaysLeft() <= 7)
                <a class="membership-pill {{ $shellUser->hasActiveMembership() ? '' : 'is-expired' }}" href="{{ route('membership.index') }}" data-ajax-link data-nav="membership" id="membership-pill">
                    {{ $shellUser->hasActiveMembership() ? 'Tu membresía vence en '.$shellUser->membershipDaysLeft().' día(s) · Renovar' : 'Membresía vencida · Renovar' }}
                </a>
            @endif
        </div>
        <div id="app-top-action">
            @if ($activePage !== 'dashboard' && ! auth()->user()?->isSuperAdmin())
                <a class="button secondary" href="{{ route('dashboard.local') }}" data-ajax-link data-nav="dashboard" aria-label="Ir al escritorio">
                    <svg class="button-icon" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3h11A2.5 2.5 0 0 1 20 5.5v8A2.5 2.5 0 0 1 17.5 16h-11A2.5 2.5 0 0 1 4 13.5v-8Z" fill="none" stroke="currentColor" stroke-width="2"/>
                        <path d="M9 21h6M12 16v5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2"/>
                    </svg>
                    <span>Escritorio</span>
                </a>
            @endif
        </div>
    </header>

    <main class="app-content" id="app-content">
        @include($contentView, $contentData)
    </main>

    <script>
        const content = document.getElementById('app-content');
        const pageTitle = document.getElementById('app-page-title');
        const pageSubtitle = document.getElementById('app-page-subtitle');
        const topAction = document.getElementById('app-top-action');
        const sidebar = document.getElementById('app-sidebar');
        const sidebarBackdrop = document.getElementById('sidebar-backdrop');
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const desktopUrl = @json(route('dashboard.local'));
        const isSuperAdmin = @json((bool) auth()->user()?->isSuperAdmin());

        function setMobileMenu(open) {
            const isOpen = Boolean(open);

            sidebar?.classList.toggle('is-open', isOpen);
            sidebarBackdrop?.classList.toggle('is-visible', isOpen);
            mobileMenuToggle?.setAttribute('aria-expanded', String(isOpen));
            mobileMenuToggle?.setAttribute('aria-label', isOpen ? 'Cerrar menú' : 'Abrir menú');
            document.body.classList.toggle('menu-open', isOpen);
        }

        mobileMenuToggle?.addEventListener('click', () => {
            setMobileMenu(! sidebar?.classList.contains('is-open'));
        });

        sidebarBackdrop?.addEventListener('click', () => setMobileMenu(false));

        sidebar?.addEventListener('click', (event) => {
            if (event.target.closest('a, button[type="submit"]')) {
                setMobileMenu(false);
            }
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth > 1050) {
                setMobileMenu(false);
            }
        });

        function desktopButton() {
            return `<a class="button secondary" href="${desktopUrl}" data-ajax-link data-nav="dashboard" aria-label="Ir al escritorio">
                <svg class="button-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3h11A2.5 2.5 0 0 1 20 5.5v8A2.5 2.5 0 0 1 17.5 16h-11A2.5 2.5 0 0 1 4 13.5v-8Z" fill="none" stroke="currentColor" stroke-width="2"></path>
                    <path d="M9 21h6M12 16v5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2"></path>
                </svg>
                <span>Escritorio</span>
            </a>`;
        }

        function setActive(activePage) {
            document.querySelectorAll('[data-nav]').forEach((item) => {
                item.classList.toggle('active', item.dataset.nav === activePage);
            });

            topAction.innerHTML = (activePage === 'dashboard' || isSuperAdmin) ? '' : desktopButton();
        }

        function documentFileView() {
            try {
                return localStorage.getItem('documentFileView') || 'list';
            } catch (error) {
                return 'list';
            }
        }

        function setDocumentFileView(view) {
            const nextView = view === 'grid' ? 'grid' : 'list';

            try {
                localStorage.setItem('documentFileView', nextView);
            } catch (error) {
                // Storage can be unavailable in some browser privacy modes.
            }

            syncDocumentFileView(nextView);
        }

        function syncDocumentFileView(view = documentFileView()) {
            const files = document.querySelector('[data-file-view-target]');
            const activeView = files?.dataset.forceFileView || view;

            if (files) {
                files.classList.toggle('view-grid', activeView === 'grid');
                files.classList.toggle('view-list', activeView !== 'grid');
            }

            document.querySelectorAll('[data-file-view]').forEach((button) => {
                const active = button.dataset.fileView === activeView;
                button.classList.toggle('active', active);
                button.setAttribute('aria-pressed', active ? 'true' : 'false');
            });
        }

        function moneyValue(value) {
            return Number.parseFloat(value || 0) || 0;
        }

        function formatMoney(value) {
            return moneyValue(value).toLocaleString('es-PE', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            });
        }

        function recalculateProforma(form) {
            if (! form) {
                return;
            }

            let subtotal = 0;

            form.querySelectorAll('[data-proforma-row]').forEach((row) => {
                const quantity = moneyValue(row.querySelector('[name$="[quantity]"]')?.value);
                const unitPrice = moneyValue(row.querySelector('[name$="[unit_price]"]')?.value);
                const rowSubtotal = quantity * unitPrice;

                subtotal += rowSubtotal;

                const lineTotal = row.querySelector('[data-line-total]');
                if (lineTotal) {
                    if ('value' in lineTotal) {
                        lineTotal.value = formatMoney(rowSubtotal);
                    } else {
                        lineTotal.textContent = formatMoney(rowSubtotal);
                    }
                }
            });

            const tax = subtotal * 0.18;
            const total = subtotal + tax;
            const totals = {
                subtotal,
                tax,
                total,
            };

            Object.entries(totals).forEach(([key, value]) => {
                const target = form.querySelector(`[data-proforma-total="${key}"]`);
                if (target) {
                    target.textContent = formatMoney(value);
                }
            });
        }

        function initializeProformaForms() {
            document.querySelectorAll('[data-proforma-form]').forEach((form) => {
                const rows = form.querySelectorAll('[data-proforma-row]').length;
                if (! form.dataset.nextIndex) {
                    form.dataset.nextIndex = String(rows);
                }
                recalculateProforma(form);
            });
        }

        function executeInjectedScripts(container) {
            if (! container) return;
            const scripts = Array.from(container.querySelectorAll('script'));
            scripts.forEach((oldScript) => {
                const newScript = document.createElement('script');
                Array.from(oldScript.attributes).forEach(attr => newScript.setAttribute(attr.name, attr.value));
                newScript.textContent = oldScript.textContent;
                if (oldScript.parentNode) {
                    oldScript.parentNode.replaceChild(newScript, oldScript);
                }
            });
        }

        function applyPayload(payload) {
            document.body.style.overflow = '';
            content.innerHTML = payload.html;
            executeInjectedScripts(content);
            pageTitle.textContent = payload.title;
            pageSubtitle.textContent = payload.subtitle;
            document.title = `${payload.title} - Sistema de Proformas`;
            setActive(payload.activePage);
            syncRichEditors();
            syncDocumentFileView();
            initializeProformaForms();
            content.classList.remove('loading');

            if (payload.dashboardLogoUrl !== undefined) {
                const brandContainer = document.querySelector('.app-brand');
                const avatarElement = brandContainer?.querySelector('.app-avatar');
                if (payload.dashboardLogoUrl) {
                    if (avatarElement) {
                        if (avatarElement.tagName === 'IMG') {
                            avatarElement.src = payload.dashboardLogoUrl;
                        } else {
                            avatarElement.outerHTML = `<img class="app-avatar" src="${payload.dashboardLogoUrl}" alt="Logo de empresa">`;
                        }
                    } else if (brandContainer) {
                        brandContainer.insertAdjacentHTML('afterbegin', `<img class="app-avatar" src="${payload.dashboardLogoUrl}" alt="Logo de empresa">`);
                    }
                } else {
                    const initials = (payload.companyName || 'SP').substring(0, 2).toUpperCase();
                    if (avatarElement) {
                        avatarElement.outerHTML = `<div class="app-avatar">${initials}</div>`;
                    }
                }
            }
            if (payload.companyName) {
                const brandH1 = document.querySelector('.app-brand h1');
                if (brandH1) brandH1.textContent = payload.companyName;
            }
        }

        function syncRichEditors() {
            document.querySelectorAll('[data-rich-editor]').forEach((editor) => {
                const input = document.querySelector(editor.dataset.target);

                if (input) {
                    input.value = editor.innerHTML.trim();
                    if (editor.dataset.target === '#proforma_terms_input') {
                        const preview = document.getElementById('proforma_terms_preview');
                        if (preview) {
                            preview.innerHTML = input.value || '<span class="muted">Sin términos personalizados. Se usarán los términos predeterminados al guardar.</span>';
                        }
                    }
                }
            });
        }

        function decodeRichText(value) {
            let decoded = value || '';

            for (let attempt = 0; attempt < 2; attempt += 1) {
                const parser = document.createElement('textarea');
                parser.innerHTML = decoded;
                const next = parser.value;

                if (next === decoded) {
                    break;
                }

                decoded = next;
            }

            return decoded;
        }

        function replaceSelection(transformer) {
            const selection = window.getSelection();

            if (! selection || selection.rangeCount === 0 || selection.isCollapsed) {
                return;
            }

            const range = selection.getRangeAt(0);
            const text = selection.toString();

            range.deleteContents();
            range.insertNode(document.createTextNode(transformer(text)));
            selection.removeAllRanges();
        }

        async function loadPage(url, push = true) {
            content.classList.add('loading');

            const response = await fetch(url, {
                headers: {
                    'Accept': 'application/json',
                    'X-App-Partial': '1',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            const payload = await response.json();
            applyPayload(payload);

            if (push) {
                history.pushState({}, '', response.redirected ? response.url : url);
            }
        }

        document.addEventListener('click', (event) => {
            const link = event.target.closest('[data-ajax-link]');

            if (! link) {
                return;
            }

            event.preventDefault();
            loadPage(link.href);
        });

        function openModal(id) {
            const modal = document.getElementById(id);

            if (! modal) {
                return;
            }

            modal.classList.add('is-open');
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modal) {
            if (! modal) {
                return;
            }

            modal.classList.remove('is-open');
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }

        document.addEventListener('click', (event) => {
            const openButton = event.target.closest('[data-open-modal]');

            if (openButton) {
                event.preventDefault();
                openModal(openButton.dataset.openModal);
                return;
            }

            const closeButton = event.target.closest('[data-close-modal]');

            if (closeButton) {
                event.preventDefault();
                closeModal(closeButton.closest('.modal-backdrop'));
                return;
            }

            const modal = event.target.closest('.modal-backdrop');

            if (modal && event.target === modal) {
                closeModal(modal);
            }
        });

        document.addEventListener('click', (event) => {
            const previewButton = event.target.closest('[data-image-preview]');

            if (! previewButton) {
                return;
            }

            event.preventDefault();

            const modal = document.getElementById('imagePreviewModal');
            const image = modal?.querySelector('[data-image-preview-img]');
            const title = modal?.querySelector('[data-image-preview-title]');
            const imageTitle = previewButton.dataset.imageTitle || 'Vista previa';

            if (image) {
                image.src = previewButton.dataset.imagePreview;
                image.alt = imageTitle;
            }

            if (title) {
                title.textContent = imageTitle;
            }

            openModal('imagePreviewModal');
        });

        document.addEventListener('click', (event) => {
            const button = event.target.closest('[data-file-view]');

            if (! button) {
                return;
            }

            event.preventDefault();
            setDocumentFileView(button.dataset.fileView);
        });

        function escapeHtml(value) {
            const element = document.createElement('div');
            element.textContent = value || '';
            return element.innerHTML;
        }

        function syncDocumentAttachmentSummary(form) {
            const summary = form?.querySelector('[data-document-summary]');
            const empty = summary?.querySelector('[data-document-empty]');
            const selected = summary?.querySelector('[data-document-selected]');
            const list = summary?.querySelector('[data-document-selected-list]');
            const checked = Array.from(form?.querySelectorAll('[data-document-choice]:checked') || []);

            if (! summary || ! empty || ! selected || ! list) {
                return;
            }

            empty.style.display = checked.length ? 'none' : '';
            selected.style.display = checked.length ? '' : 'none';
            list.innerHTML = checked.map((input) => {
                const title = escapeHtml(input.dataset.documentTitle);
                const preview = input.dataset.documentPreview || '';
                const id = escapeHtml(input.value);
                const media = preview
                    ? `<img src="${escapeHtml(preview)}" alt="${title}" style="display: block; width: 100%; height: 96px; object-fit: cover;">`
                    : `<span style="display: grid; place-items: center; min-height: 96px; padding: 12px; color: #dbeafe; font-weight: 800;">${title}</span>`;

                return `
                    <span style="position: relative; display: block; min-height: 96px; border: 1px solid rgba(148, 163, 184, .25); border-radius: 8px; overflow: hidden; background: #0b1219;">
                        <button type="button" data-remove-document="${id}" aria-label="Quitar adjunto" style="position: absolute; z-index: 2; top: 6px; right: 6px; width: 28px; height: 28px; border: 0; border-radius: 999px; background: rgba(15, 23, 42, .9); color: #fff; cursor: pointer;">×</button>
                        ${media}
                    </span>
                `;
            }).join('');
        }

        document.addEventListener('click', (event) => {
            const removeButton = event.target.closest('[data-remove-document]');

            if (! removeButton) {
                return;
            }

            event.preventDefault();
            const form = removeButton.closest('form');
            const input = form?.querySelector(`[data-document-choice][value="${CSS.escape(removeButton.dataset.removeDocument)}"]`);

            if (input) {
                input.checked = false;
            }

            syncDocumentAttachmentSummary(form);
        });

        document.addEventListener('change', (event) => {
            const choice = event.target.closest('[data-document-choice]');

            if (! choice) {
                return;
            }

            syncDocumentAttachmentSummary(choice.closest('form'));
        });

        document.addEventListener('change', (event) => {
            const input = event.target.closest('[data-photo-input]');

            if (! input) {
                return;
            }

            const form = input.closest('[data-proforma-form]');
            const target = form?.querySelector('[data-photo-preview-target]');
            const empty = form?.querySelector('[data-photo-empty]');
            const files = Array.from(input.files || []);

            if (! target) {
                return;
            }

            target.innerHTML = '';

            if (files.length === 0) {
                target.style.display = 'none';
                if (empty) empty.style.display = '';
                return;
            }

            if (empty) {
                empty.style.display = 'none';
            }

            target.style.display = 'grid';

            files.slice(0, 4).forEach((file) => {
                const imageUrl = URL.createObjectURL(file);
                const article = document.createElement('article');
                const image = document.createElement('img');
                const info = document.createElement('div');
                const title = document.createElement('h4');
                const meta = document.createElement('div');
                const status = document.createElement('span');

                article.className = 'file';
                image.src = imageUrl;
                image.alt = 'Foto seleccionada';
                image.style.cssText = 'width: 100%; max-height: 120px; object-fit: cover; border-radius: 8px;';
                title.textContent = file.name;
                meta.className = 'file-meta';
                status.textContent = 'Pendiente de guardar';
                meta.appendChild(status);
                info.append(title, meta);
                article.append(image, info);
                target.appendChild(article);
            });

            if (files.length > 4) {
                target.insertAdjacentHTML('beforeend', '<div class="errors"><div>Solo se guardarán hasta 4 fotos por proforma.</div></div>');
            }
        });

        document.addEventListener('change', (event) => {
            const input = event.target.closest('[data-logo-input]');

            if (! input || ! input.files || ! input.files[0]) {
                return;
            }

            const key = input.dataset.logoInput;
            const preview = document.querySelector(`[data-logo-preview="${key}"]`);
            const file = input.files[0];
            const url = URL.createObjectURL(file);

            if (preview) {
                preview.innerHTML = `<img src="${url}" alt="Vista previa del logo">`;
            }

            const brandContainer = document.querySelector('.app-brand');
            const avatarElement = brandContainer?.querySelector('.app-avatar');
            if (avatarElement) {
                if (avatarElement.tagName === 'IMG') {
                    avatarElement.src = url;
                } else {
                    avatarElement.outerHTML = `<img class="app-avatar" src="${url}" alt="Logo de empresa">`;
                }
            } else if (brandContainer) {
                brandContainer.insertAdjacentHTML('afterbegin', `<img class="app-avatar" src="${url}" alt="Logo de empresa">`);
            }
        });

        document.addEventListener('click', (event) => {
            const addButton = event.target.closest('[data-proforma-add]');

            if (addButton) {
                event.preventDefault();
                const form = addButton.closest('[data-proforma-form]');
                const template = form?.querySelector('[data-proforma-template]');
                const target = form?.querySelector('[data-proforma-items]');

                if (! form || ! template || ! target) {
                    return;
                }

                const index = Number.parseInt(form.dataset.nextIndex || '0', 10);
                target.insertAdjacentHTML('beforeend', template.innerHTML.replaceAll('__INDEX__', index));
                form.dataset.nextIndex = String(index + 1);
                recalculateProforma(form);
                return;
            }

            const removeButton = event.target.closest('[data-proforma-remove]');

            if (removeButton) {
                event.preventDefault();
                const form = removeButton.closest('[data-proforma-form]');
                const rows = form?.querySelectorAll('[data-proforma-row]');

                if (rows && rows.length > 1) {
                    removeButton.closest('[data-proforma-row]')?.remove();
                    recalculateProforma(form);
                }
            }
        });

        document.addEventListener('change', (event) => {
            const productSelect = event.target.closest('[data-product-select]');

            if (productSelect) {
                const option = productSelect.selectedOptions[0];
                const row = productSelect.closest('[data-proforma-row]');

                if (option && row) {
                    const description = row.querySelector('[name$="[description]"]');
                    const descriptionEditor = row.querySelector('[data-rich-editor]');
                    const unit = row.querySelector('[name$="[unit]"]');
                    const price = row.querySelector('[name$="[unit_price]"]');

                    if (description && option.dataset.description !== undefined) description.value = option.dataset.description;
                    if (descriptionEditor && option.dataset.description !== undefined) descriptionEditor.textContent = option.dataset.description;
                    if (unit && option.dataset.unit) unit.value = option.dataset.unit;
                    if (price && option.dataset.price) price.value = option.dataset.price;

                    recalculateProforma(productSelect.closest('[data-proforma-form]'));
                }
            }

        });

        document.addEventListener('input', (event) => {
            const field = event.target.closest('[data-proforma-calc]');

            if (field) {
                recalculateProforma(field.closest('[data-proforma-form]'));
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key !== 'Escape') {
                return;
            }

            setMobileMenu(false);
            closeModal(document.querySelector('.modal-backdrop.is-open'));
        });

        document.addEventListener('click', (event) => {
            const button = event.target.closest('[data-editor-command]');

            if (! button) {
                return;
            }

            event.preventDefault();

            const command = button.dataset.editorCommand;
            const editor = button.closest('.field, .panel, .modal-content, div')?.querySelector('[data-rich-editor]');

            if (editor) {
                editor.focus();
            }

            if (command === 'upper') {
                replaceSelection((value) => value.toUpperCase());
                syncRichEditors();
                return;
            }

            if (command === 'lower') {
                replaceSelection((value) => value.toLowerCase());
                syncRichEditors();
                return;
            }

            const value = button.dataset.editorValue || null;
            document.execCommand(command, false, value);
            syncRichEditors();
        });

        document.addEventListener('input', (event) => {
            if (event.target.matches('[data-rich-editor]')) {
                syncRichEditors();
            }
        });

        document.addEventListener('submit', async (event) => {
            const form = event.target.closest('[data-client-modal-form]');

            if (! form) {
                return;
            }

            event.preventDefault();

            const errorBox = form.querySelector('[data-client-modal-errors]');
            if (errorBox) {
                errorBox.innerHTML = '';
            }

            const response = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            if (response.status === 422) {
                const payload = await response.json();
                const messages = Object.values(payload.errors || {}).flat();

                if (errorBox) {
                    errorBox.innerHTML = `<div class="errors">${messages.map((message) => `<div>${message}</div>`).join('')}</div>`;
                }

                return;
            }

            if (! response.ok) {
                if (errorBox) {
                    errorBox.innerHTML = '<div class="errors"><div>No se pudo guardar el cliente. Intenta nuevamente.</div></div>';
                }

                return;
            }

            const payload = await response.json();
            const select = document.getElementById('client_id');

            if (select && payload.client) {
                let option = select.querySelector(`option[value="${payload.client.id}"]`);

                if (! option) {
                    option = document.createElement('option');
                    option.value = payload.client.id;
                    select.appendChild(option);
                }

                option.textContent = payload.client.label;
                option.selected = true;
                select.dispatchEvent(new Event('change', { bubbles: true }));
            }

            form.reset();
            closeModal(form.closest('.modal-backdrop'));
        });

        document.addEventListener('submit', async (event) => {
            const form = event.target.closest('[data-ajax-form]');

            if (! form) {
                return;
            }

            event.preventDefault();
            syncRichEditors();

            content.querySelectorAll(':scope > .errors').forEach((error) => error.remove());

            const oversizedFiles = [];
            form.querySelectorAll('input[type="file"]').forEach((input) => {
                Array.from(input.files || []).forEach((file) => {
                    if (file.size > 20 * 1024 * 1024) {
                        oversizedFiles.push(file.name);
                    }
                });
            });

            if (oversizedFiles.length > 0) {
                content.insertAdjacentHTML('afterbegin', `<div class="errors"><div>Estos archivos superan los 20 MB permitidos: ${oversizedFiles.join(', ')}</div></div>`);
                return;
            }

            if ((form.method || 'get').toLowerCase() === 'get') {
                const url = new URL(form.action);
                new FormData(form).forEach((value, key) => {
                    if (value !== '') {
                        url.searchParams.set(key, value);
                    }
                });
                loadPage(url.toString());
                return;
            }

            content.classList.add('loading');

            const response = await fetch(form.action, {
                method: form.method || 'post',
                body: new FormData(form),
                headers: {
                    'Accept': 'application/json',
                    'X-App-Partial': '1',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            if (response.status === 422) {
                const payload = await response.json();
                const messages = Object.values(payload.errors || {}).flat();
                const activeModal = document.querySelector('.modal-content');
                if (activeModal && activeModal.closest('.modal-backdrop')?.style.display !== 'none') {
                    const existing = activeModal.querySelector('.errors');
                    if (existing) existing.remove();
                    activeModal.insertAdjacentHTML('afterbegin', `<div class="errors" style="margin-bottom: 14px;">${messages.map((message) => `<div>${message}</div>`).join('')}</div>`);
                } else {
                    content.insertAdjacentHTML('afterbegin', `<div class="errors">${messages.map((message) => `<div>${message}</div>`).join('')}</div>`);
                }
                content.classList.remove('loading');
                return;
            }

            if (! response.ok) {
                const messagesByStatus = {
                    413: 'Las fotos o archivos superan el tamaño permitido por el servidor. Reduce el peso o sube menos archivos.',
                    419: 'La sesión venció. Recarga la página e intenta nuevamente.',
                    500: 'No se pudo guardar la proforma por un error interno. Intenta otra vez o revisamos el detalle.',
                };
                content.insertAdjacentHTML('afterbegin', `<div class="errors"><div>${messagesByStatus[response.status] || 'No se pudo guardar el formulario. Revisa los datos e intenta nuevamente.'}</div></div>`);
                content.classList.remove('loading');
                return;
            }

            if ((response.headers.get('content-type') || '').includes('application/json')) {
                const payload = await response.json();
                applyPayload(payload);

                if (response.redirected) {
                    history.pushState({}, '', response.url);
                }

                return;
            }

            if (response.redirected) {
                await loadPage(response.url, true);
                return;
            }

            location.reload();
        });

        syncDocumentFileView();
        initializeProformaForms();

        window.addEventListener('popstate', () => loadPage(location.href, false));
    </script>
</body>
</html>
