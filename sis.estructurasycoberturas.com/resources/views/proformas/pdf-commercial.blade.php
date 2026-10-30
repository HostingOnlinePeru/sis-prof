<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 24px 28px; }
        * { box-sizing: border-box; }
        body {
            color: #172033;
            font-family: Helvetica, Arial, DejaVu Sans, sans-serif;
            font-size: 10.2px;
            line-height: 1.45;
            margin: 0;
        }
        .page {
            min-height: 1044px;
            position: relative;
        }
        .top-rule {
            background: #0f3b57;
            height: 10px;
            margin-bottom: 18px;
            width: 100%;
        }
        .top-rule span {
            background: #f5a400;
            display: block;
            height: 10px;
            width: 31%;
        }
        .header {
            display: table;
            margin-bottom: 16px;
            width: 100%;
        }
        .brand, .document-card {
            display: table-cell;
            vertical-align: top;
        }
        .brand { width: 58%; }
        .document-card {
            background: #f7f9fc;
            border: 1px solid #dce3ee;
            padding: 14px 16px;
            width: 42%;
        }
        .logo {
            display: inline-block;
            max-height: 72px;
            max-width: 220px;
            vertical-align: top;
        }
        .brand-name {
            color: #0f3b57;
            font-size: 16px;
            font-weight: 700;
            line-height: 1.22;
            margin-top: 8px;
            text-transform: uppercase;
        }
        .brand-meta {
            color: #40536d;
            margin-top: 5px;
        }
        .document-title {
            color: #0f3b57;
            font-size: 31px;
            font-weight: 700;
            letter-spacing: 0;
            line-height: .95;
            margin: 0 0 10px;
            text-align: right;
        }
        .meta-row {
            display: table;
            margin-top: 4px;
            width: 100%;
        }
        .meta-row strong,
        .meta-row span {
            display: table-cell;
        }
        .meta-row strong {
            color: #52637a;
            width: 44%;
        }
        .meta-row span {
            font-weight: 800;
            text-align: right;
        }
        .subject {
            background: #fff8e8;
            border: 1px solid #f2c66f;
            color: #172033;
            font-weight: 700;
            margin: 14px 0 16px;
            padding: 9px 12px;
        }
        .client-panel {
            border: 1px solid #dce3ee;
            display: table;
            margin-bottom: 16px;
            width: 100%;
        }
        .client-panel .cell {
            display: table-cell;
            padding: 12px 14px;
            vertical-align: top;
            width: 50%;
        }
        .client-panel .cell:first-child {
            border-right: 1px solid #dce3ee;
        }
        .eyebrow {
            color: #f5a400;
            font-size: 8.8px;
            font-weight: 700;
            letter-spacing: .45px;
            text-transform: uppercase;
        }
        .client-name {
            color: #172033;
            font-size: 17px;
            font-weight: 700;
            line-height: 1.15;
            margin: 4px 0 8px;
        }
        .field-line { margin-bottom: 3px; }
        .field-line strong {
            color: #0f3b57;
            display: inline-block;
            min-width: 72px;
        }
        table.items {
            border-collapse: collapse;
            margin-bottom: 14px;
            width: 100%;
        }
        .items th {
            background: #0f3b57;
            border-right: 1px solid rgba(255,255,255,.22);
            color: #fff;
            font-size: 9px;
            font-weight: 700;
            padding: 9px 8px;
            text-align: left;
            text-transform: uppercase;
        }
        .items th:last-child { border-right: 0; }
        .items td {
            border: 1px solid #d5dce7;
            padding: 8px;
            vertical-align: top;
        }
        .items tbody tr:nth-child(even) td {
            background: #fafcff;
        }
        .row-no {
            color: #0f3b57;
            font-weight: 700;
            text-align: center;
            width: 7%;
        }
        .num {
            text-align: right;
            white-space: nowrap;
        }
        .center { text-align: center; }
        .description {
            vertical-align: top;
        }
        .description p { margin: 0 0 4px; }
        .description ul, .description ol { margin: 3px 0 4px 14px; padding: 0; }
        .summary {
            display: table;
            margin-top: 4px;
            width: 100%;
        }
        .terms, .totals-wrap {
            display: table-cell;
            vertical-align: top;
        }
        .terms {
            padding-right: 18px;
            width: 58%;
        }
        .totals-wrap { width: 42%; }
        .terms-box {
            background: #f7f9fc;
            border: 1px solid #dce3ee;
            padding: 11px 13px;
        }
        .section-title {
            color: #0f3b57;
            font-size: 10.5px;
            font-weight: 700;
            margin: 0 0 7px;
            text-transform: uppercase;
        }
        .terms-content {
            color: #1f2937;
            font-size: 9.6px;
        }
        .terms-content p { margin: 3px 0; }
        .terms-content ul,
        .terms-content ol {
            margin: 4px 0 4px 16px;
            padding: 0;
        }
        .totals {
            border-collapse: collapse;
            margin-left: auto;
            width: 100%;
        }
        .totals td {
            border-bottom: 1px solid #d5dce7;
            padding: 8px 10px;
        }
        .totals td:first-child {
            color: #52637a;
            font-weight: 700;
            text-transform: uppercase;
        }
        .grand-total td {
            background: #f5a400;
            border-bottom: 0;
            color: #111827;
            font-size: 16px;
            font-weight: 700;
            padding: 12px 10px;
        }
        .photos {
            margin-top: 18px;
            page-break-inside: avoid;
        }
        .photos-grid {
            display: table;
            width: 100%;
        }
        .photo-cell {
            display: inline-block;
            margin: 0 8px 8px 0;
            vertical-align: top;
            width: 31.7%;
        }
        .photo-cell img {
            border: 1px solid #d5dce7;
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
    <div class="top-rule"><span></span></div>

    <div class="header">
        <div class="brand">
            @if ($logoDataUri)
                <img class="logo" src="{{ $logoDataUri }}" alt="Logo">
            @endif
            <div class="brand-name">{{ $companyName }}</div>
            <div class="brand-meta">
                RUC: {{ $company?->tax_id ?: '-' }}<br>
                {{ $company?->address ?: '' }}
            </div>
        </div>
        <div class="document-card">
            <h1 class="document-title">PROFORMA</h1>
            <div class="meta-row"><strong>Número:</strong><span>{{ $proforma->number }}</span></div>
            <div class="meta-row"><strong>Fecha:</strong><span>{{ $proforma->issue_date?->format('d/m/Y') }}</span></div>
            <div class="meta-row"><strong>Válida hasta:</strong><span>{{ $proforma->valid_until?->format('d/m/Y') ?: '-' }}</span></div>
            <div class="meta-row"><strong>Moneda:</strong><span>{{ $proforma->currency }}</span></div>
        </div>
    </div>

    <div class="subject">Asunto: {{ $proforma->subject ?: 'Propuesta comercial' }}</div>

    <div class="client-panel">
        <div class="cell">
            <div class="eyebrow">Dirigido a</div>
            <div class="client-name">{{ $proforma->client->name }}</div>
            <div class="field-line"><strong>Empresa:</strong> {{ $clientCompany }}</div>
            <div class="field-line"><strong>RUC:</strong> {{ $proforma->client->document_number ?: '-' }}</div>
        </div>
        <div class="cell">
            <div class="eyebrow">Contacto</div>
            <div class="field-line"><strong>Teléfono:</strong> {{ $proforma->client->phone ?: '-' }}</div>
            <div class="field-line"><strong>Email:</strong> {{ $proforma->client->email ?: '-' }}</div>
            <div class="field-line"><strong>Atención:</strong> {{ $proforma->client->name }}</div>
        </div>
    </div>

    <table class="items">
        <thead>
            <tr>
                <th style="width: 7%; text-align: center;">No.</th>
                <th>Descripción</th>
                <th style="width: 12%;">Unidad</th>
                <th style="width: 12%; text-align: center;">Cantidad</th>
                <th style="width: 14%; text-align: right;">Precio</th>
                <th style="width: 15%; text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($proforma->items as $item)
                <tr>
                    <td class="row-no">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="description">{!! $item->description !!}</td>
                    <td>{{ $item->unit }}</td>
                    <td class="center">{{ number_format((float) $item->quantity, 2) }}</td>
                    <td class="num">{{ $currency }} {{ number_format((float) $item->unit_price, 2) }}</td>
                    <td class="num">{{ $currency }} {{ number_format((float) $item->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <div class="terms">
            <div class="terms-box">
                <div class="section-title">Términos y condiciones</div>
                @if ($proforma->terms)
                    <div class="terms-content">{!! $proforma->terms !!}</div>
                @else
                    <div class="terms-content">La presente proforma mantiene validez hasta la fecha indicada.</div>
                @endif
            </div>
        </div>
        <div class="totals-wrap">
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
            <div class="photos-grid">
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
        </div>
    @endif

    <div class="site-ribbon">www.toldosyestructurasperu.com</div>
</div>
</body>
</html>
