<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 18px 22px; }
        * { box-sizing: border-box; }
        body { margin: 0; padding: 0; font-family: Helvetica, Arial, sans-serif; }
.tpl-page {width: 100%; min-height: 1040px; font-family: Helvetica, Arial, sans-serif; font-size: 10px; color: #073b3f; position: relative;}
.tpl-header {display: table; width: 100%; background: #ffffff;}
.tpl-header-left {display: table-cell; width: 50%; vertical-align: middle; padding: 18px 10px 18px 4px;}
.tpl-header-right {display: table-cell; width: 50%; vertical-align: top; padding: 14px 4px 14px 10px;}
.tpl-main-title {font-size: 40px; font-weight: 800; color: #073b3f; line-height: 1; text-transform: uppercase; letter-spacing: -1px;}
.tpl-logo {max-height: 50px; max-width: 210px; margin-bottom: 6px;}
.tpl-company-name {font-size: 14px; font-weight: 700; color: #073b3f; margin-bottom: 6px;}
.tpl-contact-row {font-size: 9.5px; color: #073b3f; line-height: 1.7;}
.tpl-dot {display: inline-block; width: 7px; height: 7px; background: #073b3f; border-radius: 4px; margin-right: 6px;}
.tpl-body {background: #0a4a4f; color: #ffffff; padding: 20px 24px 22px 24px;}
.tpl-section-title {font-size: 12px; font-weight: 700; text-transform: uppercase; color: #ffffff; margin: 18px 0 7px 0; letter-spacing: 0.3px;}
.tpl-section-first {margin-top: 0;}
.tpl-field-row {display: table; width: 100%;}
.tpl-field-label {display: table-cell; width: 24%; font-size: 10px; color: #d9ecec; padding: 4px 0; vertical-align: bottom;}
.tpl-field-value {display: table-cell; width: 76%; font-size: 10px; font-weight: 700; color: #ffffff; padding: 4px 0 3px 8px; border-bottom: 1px solid #9cc5c5; vertical-align: bottom;}
.tpl-subject {font-size: 10px; color: #ffffff; line-height: 1.5; padding: 4px 0; border-bottom: 1px solid #9cc5c5;}
.tpl-items-table {width: 100%; border-collapse: collapse; margin-top: 4px;}
.tpl-items-table th {padding: 7px 6px; font-size: 9px; font-weight: 700; text-transform: uppercase; color: #ffd95a; border-bottom: 2px solid #ffffff; text-align: left;}
.tpl-items-table td {padding: 7px 6px; font-size: 9.5px; color: #ffffff; border-bottom: 1px solid #5f9494; vertical-align: top; line-height: 1.4;}
.tpl-items-table .col-item {width: 6%; text-align: center;}
.tpl-items-table .col-desc {text-align: left;}
.tpl-items-table .col-unit {width: 11%; text-align: center;}
.tpl-items-table .col-qty {width: 9%; text-align: center;}
.tpl-items-table .col-price {width: 15%; text-align: right;}
.tpl-items-table .col-total {width: 16%; text-align: right; font-weight: 700;}
.tpl-summary-section {display: table; width: 100%; margin-top: 18px;}
.tpl-summary-terms {display: table-cell; width: 56%; vertical-align: top; padding-right: 18px;}
.tpl-summary-totals {display: table-cell; width: 44%; vertical-align: top;}
.tpl-terms-body {font-size: 9px; color: #e6f2f2; line-height: 1.5; border-top: 1px solid #9cc5c5; padding-top: 6px;}
.tpl-totals-table {width: 100%; border-collapse: collapse;}
.tpl-totals-table td {padding: 7px 8px; font-size: 10px; color: #ffffff; border-bottom: 1px solid #9cc5c5;}
.tpl-totals-label {color: #d9ecec; font-weight: 600;}
.tpl-col-right {text-align: right;}
.tpl-grand-total td {background: #ffd95a; color: #073b3f; font-size: 13px; font-weight: 800; border: none; padding: 9px 8px;}
.tpl-grand-total .tpl-totals-label {color: #073b3f; font-weight: 800;}
.tpl-photos-section {margin-top: 18px; page-break-inside: avoid;}
.tpl-photos-grid {width: 100%;}
.tpl-photo-cell {display: inline-block; width: 31%; margin-right: 2%; vertical-align: top;}
.tpl-photo-cell img {width: 100%; height: 110px; border: 1px solid #9cc5c5; object-fit: cover;}
.tpl-footer {width: 100%; text-align: right; background: #ffffff; height: 16px; line-height: 0;}
.tpl-footer-accent {display: inline-block; width: 150px; height: 16px; background: #ffd95a; border-left: 8px solid #073b3f;}
.tpl-two-cols {display: table; width: 100%; margin-bottom: 4px;}
.tpl-cols-a {display: table-cell; width: 46%; vertical-align: top; padding-right: 14px;}
.tpl-cols-b {display: table-cell; width: 54%; vertical-align: top; padding-left: 14px;}
.tpl-two-cols .tpl-field-label {width: 34%;}
.tpl-two-cols .tpl-field-value {width: 66%;}
    </style>
</head>
<body>
@php
    $proformaLogo = $company?->proforma_logo_path ?: $company?->dashboard_logo_path ?: $company?->logo_path;
    $logoDataUri = \App\Http\Controllers\CompanyProfileController::pdfImageDataUri($proformaLogo);
    $currency = \App\Support\LatamCurrencies::symbol($proforma->currency);
    $currencyCode = $proforma->currency ?: 'PEN';
    $clientCompany = $proforma->client?->company_name ?: $proforma->client?->name;
    $clientName = $proforma->client?->name;
    $clientTaxId = $proforma->client?->document_number ?: $proforma->client?->tax_id;
    $clientPhone = $proforma->client?->phone ?: $proforma->client?->whatsapp;
    $clientEmail = $proforma->client?->email;
    $clientAddress = $proforma->client?->address;
    $companyName = $company?->commercial_name ?: $company?->business_name ?: 'Sistema de Proformas';
    $companyTaxId = $company?->tax_id;
    $companyPhone = $company?->phone;
    $companyEmail = $company?->email;
    $companyWebsite = $company?->website;
    $companyAddress = $company?->address;
    $proformaNumber = $proforma->number ?: $proforma->proforma_number;
    $proformaDate = $proforma->issue_date;
    $validUntil = $proforma->valid_until ?: $proforma->expiration_date;
    $subject = $proforma->subject;
    $terms = $proforma->terms;
    $subtotal = $proforma->subtotal;
    $taxTotal = $proforma->tax_total ?? $proforma->tax ?? 0;
    $total = $proforma->total;
    $items = $proforma->items;
    $photos = $proforma->photos;
@endphp

<div class="tpl-page">
  <div class="tpl-header">
    <div class="tpl-header-left">
      <div class="tpl-main-title">Proforma</div>
    </div>
    <div class="tpl-header-right">
      @if($logoDataUri)
        <img class="tpl-logo" src="{{ $logoDataUri }}" alt="Logo">
      @endif
      <div class="tpl-company-name">{{ $companyName }}</div>
      @if($companyTaxId)<div class="tpl-contact-row"><span class="tpl-dot"></span>RUC: {{ $companyTaxId }}</div>@endif
      @if($companyPhone)<div class="tpl-contact-row"><span class="tpl-dot"></span>{{ $companyPhone }}</div>@endif
      @if($companyWebsite)<div class="tpl-contact-row"><span class="tpl-dot"></span>{{ $companyWebsite }}</div>@endif
      @if($companyEmail)<div class="tpl-contact-row"><span class="tpl-dot"></span>{{ $companyEmail }}</div>@endif
      @if($companyAddress)<div class="tpl-contact-row"><span class="tpl-dot"></span>{{ $companyAddress }}</div>@endif
    </div>
  </div>

  <div class="tpl-body">
    <div class="tpl-two-cols">
      <div class="tpl-cols-a">
        <div class="tpl-section-title tpl-section-first">Información de la Proforma</div>
        <div class="tpl-field-row"><span class="tpl-field-label">N° Proforma</span><span class="tpl-field-value">{{ $proformaNumber }}</span></div>
        <div class="tpl-field-row"><span class="tpl-field-label">Fecha de emisión</span><span class="tpl-field-value">{{ $proformaDate?->format('d/m/Y') }}</span></div>
        <div class="tpl-field-row"><span class="tpl-field-label">Válida hasta</span><span class="tpl-field-value">{{ $validUntil?->format('d/m/Y') ?: '-' }}</span></div>
        <div class="tpl-field-row"><span class="tpl-field-label">Moneda</span><span class="tpl-field-value">{{ $currencyCode }} ({{ $currency }})</span></div>
      </div>
      <div class="tpl-cols-b">
        <div class="tpl-section-title tpl-section-first">Datos del Cliente</div>
        <div class="tpl-field-row"><span class="tpl-field-label">Cliente</span><span class="tpl-field-value">{{ $clientCompany ?: $clientName }}</span></div>
        <div class="tpl-field-row"><span class="tpl-field-label">Atención</span><span class="tpl-field-value">{{ $clientName ?: '-' }}</span></div>
        <div class="tpl-field-row"><span class="tpl-field-label">RUC / Doc.</span><span class="tpl-field-value">{{ $clientTaxId ?: '-' }}</span></div>
        <div class="tpl-field-row"><span class="tpl-field-label">Teléfono</span><span class="tpl-field-value">{{ $clientPhone ?: '-' }}</span></div>
        <div class="tpl-field-row"><span class="tpl-field-label">Email</span><span class="tpl-field-value">{{ $clientEmail ?: '-' }}</span></div>
        <div class="tpl-field-row"><span class="tpl-field-label">Dirección</span><span class="tpl-field-value">{{ $clientAddress ?: '-' }}</span></div>
      </div>
    </div>

    @if($subject)
      <div class="tpl-section-title">Asunto</div>
      <div class="tpl-subject">{{ $subject }}</div>
    @endif

    <div class="tpl-section-title">Detalle de Ítems</div>
    <table class="tpl-items-table">
      <thead>
        <tr>
          <th class="col-item">Ítem</th>
          <th class="col-desc">Descripción</th>
          <th class="col-unit">Unidad</th>
          <th class="col-qty">Cant.</th>
          <th class="col-price">P. Unit</th>
          <th class="col-total">Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($items as $item)
          <tr>
            <td class="col-item">{{ str_pad((string)$loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
            <td class="col-desc">{!! $item->description !!}</td>
            <td class="col-unit">{{ $item->unit }}</td>
            <td class="col-qty">{{ number_format((float)$item->quantity, 2) }}</td>
            <td class="col-price">{{ $currency }} {{ number_format((float)$item->unit_price, 2) }}</td>
            <td class="col-total">{{ $currency }} {{ number_format((float)$item->total, 2) }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="tpl-summary-section">
      <div class="tpl-summary-terms">
        <div class="tpl-section-title tpl-section-first">Términos y Condiciones</div>
        <div class="tpl-terms-body">
          @if($terms)
            {!! $terms !!}
          @else
            <p>Precios expresados en {{ $currencyCode }}. Válido hasta la fecha indicada.</p>
          @endif
        </div>
      </div>
      <div class="tpl-summary-totals">
        <table class="tpl-totals-table">
          <tr><td class="tpl-totals-label">Subtotal</td><td class="tpl-col-right"><strong>{{ $currency }} {{ number_format((float)$subtotal, 2) }}</strong></td></tr>
          <tr><td class="tpl-totals-label">IGV (18%)</td><td class="tpl-col-right"><strong>{{ $currency }} {{ number_format((float)$taxTotal, 2) }}</strong></td></tr>
          <tr class="tpl-grand-total"><td class="tpl-totals-label">TOTAL</td><td class="tpl-col-right">{{ $currency }} {{ number_format((float)$total, 2) }}</td></tr>
        </table>
      </div>
    </div>

    @if ($photos->isNotEmpty())
      <div class="tpl-photos-section">
        <div class="tpl-section-title">Fotos Referenciales</div>
        <div class="tpl-photos-grid">
          @foreach ($photos->take(3) as $photo)
            @php
              $photoDataUri = \App\Http\Controllers\CompanyProfileController::pdfImageDataUri($photo->path ?: $photo->photo_path);
            @endphp
            @if ($photoDataUri)
              <div class="tpl-photo-cell"><img src="{{ $photoDataUri }}" alt="Foto"></div>
            @endif
          @endforeach
        </div>
      </div>
    @endif
  </div>

  <div class="tpl-footer"><span class="tpl-footer-accent"></span></div>
</div>
</body>
</html>
