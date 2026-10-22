<!doctype html>
<html>
<head>
    <meta charset="utf-8">
</head>
@php
    $websiteHref = $company?->website
        ? (preg_match('/^https?:\/\//i', $company->website) ? $company->website : 'https://'.$company->website)
        : null;
@endphp
<body style="font-family: Arial, Helvetica, sans-serif; color: #1f2937; line-height: 1.5;">
    <p>{!! nl2br(e($bodyMessage)) !!}</p>

    <p style="margin-top: 18px;">
        <strong>Proforma:</strong> {{ $proforma->number }}<br>
        <strong>Total:</strong> {{ $proforma->currency }} {{ number_format((float) $proforma->total, 2) }}
    </p>

    <p style="margin-top: 18px;">
        Saludos,<br>
        {{ $company?->business_name ?: 'Sistema de Proformas' }}
    </p>

    <table role="presentation" cellpadding="0" cellspacing="0" style="margin-top: 26px; border-top: 1px solid #e5e7eb; padding-top: 18px; width: 100%; max-width: 640px;">
        <tr>
            @if ($companyLogoPath)
                <td style="width: 118px; vertical-align: top; padding-right: 18px;">
                    <img src="{{ $message->embed($companyLogoPath) }}" alt="Logo de {{ $company?->business_name }}" style="display: block; width: 100px; max-height: 76px; object-fit: contain;">
                </td>
            @endif
            <td style="vertical-align: top;">
                <strong style="display: block; color: #111827; font-size: 16px; margin-bottom: 4px;">
                    {{ $company?->business_name ?: 'Sistema de Proformas' }}
                </strong>
                @if ($company?->tax_id)
                    <span style="display: block; color: #4b5563;">RUC: {{ $company->tax_id }}</span>
                @endif
                @if ($company?->phone)
                    <span style="display: block; color: #4b5563;">Teléfono Móvil 1: {{ $company->phone }}</span>
                @endif
                @if ($company?->mobile_phone)
                    <span style="display: block; color: #4b5563;">Teléfono Móvil 2: {{ $company->mobile_phone }}</span>
                @endif
                @if ($company?->email)
                    <span style="display: block; color: #4b5563;">Correo: {{ $company->email }}</span>
                @endif
                @if ($company?->address)
                    <span style="display: block; color: #4b5563;">Dirección: {{ $company->address }}</span>
                @endif
                @if ($websiteHref)
                    <a href="{{ $websiteHref }}" style="display: inline-block; margin-top: 6px; color: #0f5ea8; font-weight: 700; text-decoration: none;">
                        {{ preg_replace('/^https?:\/\//', '', $company->website) }}
                    </a>
                @endif
            </td>
        </tr>
    </table>
</body>
</html>
