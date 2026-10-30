<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 24px 28px; }
        * { box-sizing: border-box; }
        body {
            color: #111827;
            font-family: Helvetica, Arial, DejaVu Sans, sans-serif;
            font-size: 10.2px;
            line-height: 1.45;
            margin: 0;
        }
        .page {
            min-height: 1044px;
            position: relative;
        }
        .header-band {
            background: #111827;
            color: white;
            display: table;
            margin-bottom: 18px;
            padding: 18px 20px;
            width: 100%;
        }
        .brand, .doc {
            display: table-cell;
            vertical-align: middle;
        }
        .brand { width: 62%; }
        .doc {
            text-align: right;
            width: 38%;
        }
        .logo-box {
            background: white;
            display: inline-block;
            margin-right: 14px;
            padding: 8px;
            vertical-align: middle;
            width: 112px;
        }
        .logo {
            max-height: 58px;
            max-width: 96px;
        }
        .brand-text {
            display: inline-block;
            vertical-align: middle;
            width: 290px;
        }
        .brand-name {
            font-size: 15px;
            font-weight: 700;
            line-height: 1.22;
            text-transform: uppercase;
        }
        .brand-meta {
            color: #cbd5e1;
            font-size: 9.5px;
            margin-top: 4px;
        }
        .doc h1 {
            color: #f8b51d;
            font-size: 31px;
            font-weight: 700;
            line-height: .95;
            margin: 0 0 8px;
        }
        .doc-number {
            color: #e5e7eb;
            font-size: 12px;
            font-weight: 700;
        }
        .info-grid {
            display: table;
            margin-bottom: 16px;
            width: 100%;
        }
        .info-card {
            border: 1px solid #d4dae5;
            display: table-cell;
            padding: 12px 14px;
            vertical-align: top;
            width: 33.333%;
        }
        .info-card + .info-card {
            border-left: 0;
        }
        .card-title {
            color: #64748b;
            font-size: 8.8px;
            font-weight: 700;
            letter-spacing: .45px;
            margin-bottom: 6px;
            text-transform: uppercase;
        }
        .main-name {
            color: #111827;
            font-size: 16px;
            font-weight: 700;
            line-height: 1.15;
            margin-bottom: 7px;
        }
        .line { margin-bottom: 3px; }
        .line strong {
            color: #111827;
            display: inline-block;
            min-width: 66px;
        }
        .subject-row {
            background: #eef6ff;
            border-left: 5px solid #1976d2;
            margin-bottom: 14px;
            padding: 10px 12px;
        }
        .subject-row strong {
            color: #0f3b57;
        }
        table.items {
            border-collapse: collapse;
            margin-bottom: 14px;
            width: 100%;
        }
        .items th {
            background: #1976d2;
            color: white;
            font-size: 9px;
            font-weight: 700;
            padding: 9px 8px;
            text-align: left;
            text-transform: uppercase;
        }
        .items td {
            border-bottom: 1px solid #d4dae5;
            border-left: 1px solid #e2e8f0;
            padding: 9px 8px;
            vertical-align: top;
        }
        .items td:last-child {
            border-right: 1px solid #e2e8f0;
        }
        .description { vertical-align: top; }
        .description p { margin: 0 0 4px; }
        .description ul, .description ol { margin: 3px 0 4px 14px; padding: 0; }
        .qty {
            font-weight: 700;
            text-align: center;
        }
        .num {
            text-align: right;
            white-space: nowrap;
        }
        .summary {
            display: table;
            margin-top: 2px;
            width: 100%;
        }
        .conditions,
        .total-panel {
            display: table-cell;
            vertical-align: top;
        }
        .conditions {
            padding-right: 18px;
            width: 57%;
        }
        .conditions-box {
            border: 1px solid #d4dae5;
            padding: 11px 13px;
        }
        .section-title {
            color: #111827;
            font-size: 10.5px;
            font-weight: 700;
            margin: 0 0 7px;
            text-transform: uppercase;
        }
        .terms-content {
            color: #263244;
            font-size: 9.8px;
        }
        .terms-content p { margin: 3px 0; }
        .terms-content ul,
        .terms-content ol {
            margin: 4px 0 4px 16px;
            padding: 0;
        }
        .total-panel { width: 43%; }
        .totals {
            border-collapse: collapse;
            width: 100%;
        }
        .totals td {
            border-bottom: 1px solid #d4dae5;
            padding: 8px 10px;
        }
        .totals td:first-child {
            color: #64748b;
            font-weight: 700;
            text-transform: uppercase;
        }
        .grand-total td {
            background: #111827;
            border-bottom: 0;
            color: white;
            font-size: 16px;
            font-weight: 700;
            padding: 13px 10px;
        }
        .grand-total td:first-child {
            color: #f8b51d;
        }
        .photos {
            margin-top: 18px;
            page-break-inside: avoid;
        }
        .photo-cell {
            display: inline-block;
            margin: 0 8px 8px 0;
            vertical-align: top;
            width: 31.7%;
        }
        .photo-cell img {
            border: 1px solid #d4dae5;
            height: 118px;
            object-fit: cover;
            width: 100%;
        }
        .site-ribbon {
            background: #050505;
            bottom: 0;
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            left: 0;
            letter-spacing: .35px;
            padding: 10px 16px;
            position: absolute;
            text-align: center;
            width: 100%;
        }
    </style>
</head>
<body>
@php
    $proformaLogo = $company?->proforma_logo_path ?: $company?->dashboard_logo_path ?: $company?->logo_path;
    $logoDataUri = null;
    if ($proformaLogo && \Illuminate\Support\Facades\Storage::disk('public')->exists($proformaLogo)) {
        $fullLogoPath = storage_path('app/public/'.$proformaLogo);
        if (file_exists($fullLogoPath)) {
            $logoMime = mime_content_type($fullLogoPath);
            if (str_ends_with(strtolower($proformaLogo), '.svg')) {
                $logoMime = 'image/svg+xml';
            }
            $logoDataUri = 'data:'.$logoMime.';base64,'.base64_encode(file_get_contents($fullLogoPath));
        }
    }
    $currency = \App\Support\LatamCurrencies::symbol($proforma->currency);
    $currencyLabel = \App\Support\LatamCurrencies::shortOptionLabel($proforma->currency ?: 'PEN');
    $clientCompany = $proforma->client->company_name ?: $proforma->client->name;
    $companyName = $company?->commercial_name ?: $company?->business_name ?: 'Sistema de Proformas';
@endphp

<div class="page">
    <div class="header-band">
        <div class="brand">
            @if ($logoDataUri)
                <span class="logo-box"><img class="logo" src="{{ $logoDataUri }}" alt="Logo"></span>
            @endif
            <span class="brand-text">
                <span class="brand-name">{{ $companyName }}</span>
                <span class="brand-meta">
                    RUC: {{ $company?->tax_id ?: '-' }}<br>
                    {{ $company?->address ?: '' }}
                </span>
            </span>
        </div>
        <div class="doc">
            <h1>PROFORMA</h1>
            <div class="doc-number">{{ $proforma->number }}</div>
        </div>
    </div>

    <div class="info-grid">
        <div class="info-card">
            <div class="card-title">Dirigido a</div>
            <div class="main-name">{{ $proforma->client->name }}</div>
            <div class="line"><strong>Empresa:</strong> {{ $clientCompany }}</div>
            <div class="line"><strong>RUC:</strong> {{ $proforma->client->document_number ?: '-' }}</div>
        </div>
        <div class="info-card">
            <div class="card-title">Contacto</div>
            <div class="line"><strong>Teléfono:</strong> {{ $proforma->client->phone ?: '-' }}</div>
            <div class="line"><strong>Email:</strong> {{ $proforma->client->email ?: '-' }}</div>
            <div class="line"><strong>Moneda:</strong> {{ $proforma->currency }}</div>
        </div>
        <div class="info-card">
            <div class="card-title">Datos de emisión</div>
            <div class="line"><strong>Fecha:</strong> {{ $proforma->issue_date?->format('d/m/Y') }}</div>
            <div class="line"><strong>Validez:</strong> {{ $proforma->valid_until?->format('d/m/Y') ?: '-' }}</div>
            <div class="line"><strong>IGV:</strong> 18%</div>
        </div>
    </div>

    <div class="subject-row"><strong>Asunto:</strong> {{ $proforma->subject ?: 'Propuesta comercial' }}</div>

    <table class="items">
        <thead>
            <tr>
                <th style="width: 10%; text-align: center;">Cant.</th>
                <th>Descripción técnica / producto</th>
                <th style="width: 13%;">Unidad</th>
                <th style="width: 16%; text-align: right;">Precio</th>
                <th style="width: 17%; text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($proforma->items as $item)
                <tr>
                    <td class="qty">{{ number_format((float) $item->quantity, 2) }}</td>
                    <td class="description">{!! $item->description !!}</td>
                    <td>{{ $item->unit }}</td>
                    <td class="num">{{ $currency }} {{ number_format((float) $item->unit_price, 2) }}</td>
                    <td class="num">{{ $currency }} {{ number_format((float) $item->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <div class="conditions">
            <div class="conditions-box">
                <div class="section-title">Condiciones comerciales</div>
                @if ($proforma->terms)
                    <div class="terms-content">{!! $proforma->terms !!}</div>
                @else
                    <div class="terms-content">La presente proforma mantiene validez hasta la fecha indicada.</div>
                @endif
            </div>
        </div>
        <div class="total-panel">
            <table class="totals">
                <tr><td>Subtotal</td><td class="num">{{ $currency }} {{ number_format((float) $proforma->subtotal, 2) }}</td></tr>
                <tr><td>IGV 18%</td><td class="num">{{ $currency }} {{ number_format((float) $proforma->tax_total, 2) }}</td></tr>
                <tr class="grand-total"><td>Total</td><td class="num">{{ $currency }} {{ number_format((float) $proforma->total, 2) }}</td></tr>
            </table>
        </div>
    </div>

    @if ($proforma->photos->isNotEmpty())
        <div class="photos">
            <div class="section-title">Fotos referenciales</div>
            @foreach ($proforma->photos->take(3) as $photo)
                @php
                    $photoDataUri = null;
                    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($photo->path)) {
                        $fullPhotoPath = storage_path('app/public/'.$photo->path);
                        if (file_exists($fullPhotoPath)) {
                            $photoMime = mime_content_type($fullPhotoPath);
                            if (str_ends_with(strtolower($photo->path), '.svg')) {
                                $photoMime = 'image/svg+xml';
                            }
                            $photoDataUri = 'data:'.$photoMime.';base64,'.base64_encode(file_get_contents($fullPhotoPath));
                        }
                    }
                @endphp
                @if ($photoDataUri)
                    <div class="photo-cell"><img src="{{ $photoDataUri }}" alt="Foto de proforma"></div>
                @endif
            @endforeach
        </div>
    @endif

    <div class="site-ribbon">www.toldosyestructurasperu.com</div>
</div>
</body>
</html>
