<style>
.mb-pay-wrapper {max-width: 1100px; margin: 0 auto; padding-bottom: 40px;}
.mb-pay-back {display: inline-flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; color: var(--muted); text-decoration: none; margin-bottom: 20px; transition: color 0.15s ease;}
.mb-pay-back:hover {color: #f8fafc;}
.mb-pay-grid {display: grid; grid-template-columns: 1.4fr 1fr; gap: 28px; align-items: start;}
.mb-pay-card {background: linear-gradient(180deg, rgba(255, 255, 255, 0.04), rgba(255, 255, 255, 0.015)); border: 1px solid var(--line); border-radius: 18px; padding: 26px; box-shadow: 0 20px 45px rgba(0, 0, 0, 0.35);}
.mb-pay-header {display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--line); padding-bottom: 18px; margin-bottom: 22px;}
.mb-pay-header-left {display: flex; align-items: center; gap: 12px;}
.mb-pay-icon {width: 42px; height: 42px; border-radius: 10px; background: rgba(99, 102, 241, 0.15); border: 1px solid rgba(99, 102, 241, 0.3); display: flex; align-items: center; justify-content: center; color: #a5b4fc;}
.mb-pay-title {margin: 0; font-size: 18px; font-weight: 700; color: #f8fafc;}
.mb-pay-subtitle {font-size: 12px; color: var(--muted); margin-top: 2px;}
.mb-pay-ssl {display: inline-flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 700; color: #34d399; background: rgba(52, 211, 153, 0.1); border: 1px solid rgba(52, 211, 153, 0.3); padding: 5px 10px; border-radius: 9999px; text-transform: uppercase;}
.mb-pay-methods {display: flex; gap: 12px; margin-bottom: 22px;}
.mb-pay-method-tab {flex: 1; display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; border-radius: 12px; background: rgba(99, 102, 241, 0.12); border: 1.5px solid #6366f1; color: #f8fafc; font-size: 13px; font-weight: 600;}
.mb-pay-brands {display: flex; align-items: center; gap: 6px;}
.mb-brand-logo {display: inline-block; height: 24px; width: 38px; border-radius: 4px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3); border: 1px solid rgba(255, 255, 255, 0.12); vertical-align: middle; flex-shrink: 0; transition: transform 0.15s ease;}
.mb-brand-logo:hover {transform: translateY(-1px); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);}
.mb-field-group {margin-bottom: 18px;}
.mb-field-label {display: block; font-size: 12px; font-weight: 600; color: #cbd5e1; margin-bottom: 7px; text-transform: uppercase; letter-spacing: 0.5px;}
.mb-field-input {width: 100%; box-sizing: border-box; background: rgba(15, 23, 42, 0.8); border: 1px solid var(--line); border-radius: 10px; padding: 11px 14px; font-size: 14px; color: #f8fafc; outline: none; transition: border-color 0.15s ease, box-shadow 0.15s ease;}
.mb-field-input:focus {border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25);}
.mb-field-row {display: grid; grid-template-columns: 1fr 1fr; gap: 14px;}
.mb-stripe-notice {background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.3); border-radius: 12px; padding: 14px 16px; margin-bottom: 20px; font-size: 12.5px; color: #fde68a; line-height: 1.5;}
.mb-stripe-live {background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.3); border-radius: 12px; padding: 14px 16px; margin-bottom: 20px; font-size: 12.5px; color: #86efac; line-height: 1.5;}
.mb-btn-checkout {width: 100%; background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%); color: #ffffff; border: none; padding: 14px 20px; border-radius: 12px; font-size: 15px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; box-shadow: 0 10px 25px rgba(37, 99, 235, 0.35); transition: transform 0.15s ease, box-shadow 0.15s ease, opacity 0.15s ease;}
.mb-btn-checkout:hover {transform: translateY(-2px); box-shadow: 0 14px 30px rgba(37, 99, 235, 0.5); opacity: 0.96;}
.mb-trust-row {display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 22px; border-top: 1px solid var(--line); padding-top: 18px;}
.mb-trust-col {display: flex; align-items: center; gap: 8px; font-size: 11.5px; color: var(--muted);}
.mb-summary-box {background: #0c1322; border: 1px solid var(--line); border-radius: 12px; padding: 16px; margin-bottom: 18px; display: flex; gap: 14px; align-items: center;}
.mb-summary-icon {width: 54px; height: 54px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;}
.mb-summary-icon.is-basic {background: rgba(245, 158, 11, 0.16); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.35);}
.mb-summary-icon.is-standard {background: rgba(14, 165, 233, 0.16); color: #38bdf8; border: 1px solid rgba(14, 165, 233, 0.35);}
.mb-summary-icon.is-premium {background: rgba(168, 85, 247, 0.16); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.35);}
.mb-summary-info {flex-grow: 1; overflow: hidden;}
.mb-summary-title {font-size: 16px; font-weight: 700; color: #f8fafc; margin: 0 0 4px 0;}
.mb-summary-tag {display: inline-block; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 9999px; text-transform: uppercase;}
.mb-summary-tag.is-basic {background: rgba(245, 158, 11, 0.2); color: #fde68a; border: 1px solid rgba(245, 158, 11, 0.35);}
.mb-summary-tag.is-standard {background: rgba(14, 165, 233, 0.2); color: #bae6fd; border: 1px solid rgba(14, 165, 233, 0.35);}
.mb-summary-tag.is-premium {background: rgba(168, 85, 247, 0.2); color: #e9d5ff; border: 1px solid rgba(168, 85, 247, 0.35);}
.mb-table-summary {width: 100%; border-collapse: collapse; margin-bottom: 20px;}
.mb-table-summary tr td {padding: 10px 0; font-size: 13px; color: #94a3b8; border-bottom: 1px solid rgba(255, 255, 255, 0.05);}
.mb-table-summary tr td:last-child {text-align: right; color: #f8fafc; font-weight: 600;}
.mb-table-total td {font-size: 16px !important; font-weight: 800 !important; color: #f8fafc !important; border-bottom: none !important; padding-top: 14px !important;}
.mb-table-total td:last-child {color: #38bdf8 !important; font-size: 20px !important;}
.mb-features-card {background: rgba(255, 255, 255, 0.02); border: 1px dashed var(--line); border-radius: 12px; padding: 14px; margin-top: 14px;}
.mb-features-header {font-size: 11.5px; font-weight: 700; color: #cbd5e1; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;}
.mb-feat-row {display: flex; align-items: flex-start; gap: 8px; font-size: 12px; color: var(--muted); margin-bottom: 6px; line-height: 1.4;}
.mb-feat-row:last-child {margin-bottom: 0;}
@media (max-width: 860px) {.mb-pay-grid {grid-template-columns: 1fr;}}
</style>

@php
    $tier = $plan->tier;
    $tierClass = match($tier) {
        'premium', 'corporate' => 'is-premium',
        'standard' => 'is-standard',
        default => 'is-basic',
    };
@endphp

<div class="mb-pay-wrapper">
    <a href="{{ route('membership.index') }}" class="mb-pay-back" data-ajax-link data-nav="membership">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" style="width:16px;height:16px;"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        <span>Volver a Planes y Membresías</span>
    </a>

    @if ($errors->any())
        <div class="errors" style="margin-bottom: 22px;">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="mb-pay-grid">
        {{-- COLUMNA IZQUIERDA: FORMULARIO Y PASARELA STRIPE --}}
        <div class="mb-pay-card">
            <div class="mb-pay-header">
                <div class="mb-pay-header-left">
                    <div class="mb-pay-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:22px;height:22px;"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </div>
                    <div>
                        <h2 class="mb-pay-title">Pasarela de Pago Seguro</h2>
                        <div class="mb-pay-subtitle">Transacción directa y encriptada de extremo a extremo</div>
                    </div>
                </div>
                <div class="mb-pay-ssl">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:12px;height:12px;"><polyline points="20 6 9 17 4 12"/></svg>
                    SSL 256-BIT
                </div>
            </div>

            <div class="mb-pay-methods">
                <div class="mb-pay-method-tab">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <input type="radio" checked readonly style="accent-color: #6366f1;">
                        <span>Tarjeta de Crédito / Débito (Stripe)</span>
                    </div>
                    <div class="mb-pay-brands">
                        {{-- VISA --}}
                        <svg class="mb-brand-logo" width="38" height="24" viewBox="0 0 38 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Visa" role="img">
                            <rect width="38" height="24" rx="4" fill="#FFFFFF"/>
                            <path d="M15.42 16.5H13.25L14.61 8.5H16.78L15.42 16.5ZM22.42 8.7C21.99 8.54 21.31 8.37 20.44 8.37C18.1 8.37 16.44 9.59 16.42 11.33C16.4 12.62 17.58 13.34 18.48 13.77C19.4 14.21 19.71 14.49 19.71 14.88C19.71 15.48 18.98 15.75 18.28 15.75C17.35 15.75 16.82 15.61 15.99 15.25L15.65 15.09L15.27 17.36C15.9 17.64 17.06 17.89 18.26 17.9C20.76 17.9 22.4 16.69 22.43 14.83C22.44 13.74 21.75 12.91 20.31 12.23C19.43 11.8 18.9 11.51 18.9 11.06C18.91 10.65 19.37 10.22 20.35 10.22C21.13 10.21 21.68 10.37 22.12 10.56L22.33 10.65L22.71 8.44C22.62 8.41 22.42 8.7 22.42 8.7ZM27.06 8.5H25.39C24.87 8.5 24.48 8.65 24.26 9.18L20.7 17.5H22.97C22.97 17.5 23.34 16.47 23.43 16.22C23.68 16.22 25.89 16.22 26.23 16.22C26.31 16.55 26.51 17.48 26.51 17.48H28.52L27.06 8.5ZM24.02 14.64C24.2 14.15 24.9 12.3 24.9 12.3C24.89 12.31 25.09 11.8 25.2 11.49L25.36 12.25C25.36 12.25 25.82 14.42 25.87 14.64H24.02ZM12.08 8.5L9.97 14.62L9.74 13.49C9.37 12.24 8.2 10.87 6.92 10.21L8.9 17.5H11.19L14.6 8.5H12.08Z" fill="#1A1F71"/>
                            <path d="M8.07 8.5H4.61L4.57 8.66C7.25 9.33 9.54 11.03 10.27 12.95L9.49 8.97C9.35 8.47 8.98 8.5 8.07 8.5Z" fill="#F7B600"/>
                        </svg>
                        {{-- MASTERCARD --}}
                        <svg class="mb-brand-logo" width="38" height="24" viewBox="0 0 38 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Mastercard" role="img">
                            <rect width="38" height="24" rx="4" fill="#FFFFFF"/>
                            <circle cx="14.5" cy="12" r="6.5" fill="#EB001B"/>
                            <circle cx="23.5" cy="12" r="6.5" fill="#F79E1B"/>
                            <path d="M 19 7.31 A 6.5 6.5 0 0 1 19 16.69 A 6.5 6.5 0 0 1 19 7.31 Z" fill="#FF5F00"/>
                        </svg>
                        {{-- AMERICAN EXPRESS --}}
                        <svg class="mb-brand-logo" width="38" height="24" viewBox="0 0 38 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="American Express" role="img">
                            <rect width="38" height="24" rx="4" fill="#006FCF"/>
                            <path d="M6 15.5L8.5 8.5H11L13.5 15.5H11.3L10.8 14H8.7L8.2 15.5H6ZM9.1 12.3H10.4L9.8 10.3L9.1 12.3ZM14.2 15.5V8.5H16.8L18.4 13L20 8.5H22.6V15.5H20.7V11.3L19.2 15.1H17.6L16.1 11.3V15.5H14.2ZM23.8 15.5V8.5H30V10.4H25.8V10.9H29.4V12.9H25.8V13.6H30V15.5H23.8Z" fill="#FFFFFF"/>
                        </svg>
                        {{-- DISCOVER --}}
                        <svg class="mb-brand-logo" width="38" height="24" viewBox="0 0 38 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Discover" role="img">
                            <rect width="38" height="24" rx="4" fill="#FFFFFF"/>
                            <path d="M6 14.5V9.5H8.8C10.5 9.5 11.6 10.5 11.6 12C11.6 13.5 10.5 14.5 8.8 14.5H6ZM7.6 13.2H8.7C9.7 13.2 10.2 12.7 10.2 12C10.2 11.3 9.7 10.8 8.7 10.8H7.6V13.2ZM12.7 14.5V9.5H14.2V14.5H12.7ZM19 14.7C17.5 14.7 16.3 13.5 16.3 12C16.3 10.5 17.5 9.3 19 9.3C20.5 9.3 21.7 10.5 21.7 12C21.7 13.5 20.5 14.7 19 14.7Z" fill="#231F20"/>
                            <circle cx="19" cy="12" r="2.7" fill="#F47216"/>
                            <path d="M22.8 14.5L24.8 9.5H26.4L28.4 14.5H26.8L26.4 13.4H24.8L24.4 14.5H22.8ZM25.1 12.2H26.1L25.6 10.8L25.1 12.2ZM28.5 14.5V9.5H32V10.7H29.9V11.4H31.7V12.6H29.9V13.3H32.1V14.5H28.5Z" fill="#231F20"/>
                        </svg>
                    </div>
                </div>
            </div>

            @if (! $stripeReady)
                <div class="mb-stripe-notice">
                    <strong>ℹ️ Pasarela Stripe en modo de preparación:</strong><br>
                    Esta interfaz de pago está lista y conectada al flujo de checkout. Para procesar transacciones reales en producción, ingresa las credenciales de Stripe (Publishable Key y Secret Key) en el panel de <strong>Super Administrador &rarr; Membresías &rarr; Configurar Stripe</strong>.
                </div>
            @else
                <div class="mb-stripe-live">
                    <strong>✓ Pasarela Stripe conectada y lista:</strong><br>
                    El pago se procesará a través de la infraestructura segura de Stripe Checkout con cifrado bancario.
                </div>
            @endif

            <form action="{{ route('membership.checkout', $plan) }}" method="POST">
                @csrf

                <div class="mb-field-group">
                    <label class="mb-field-label" for="cardholder_name">Nombre en la tarjeta</label>
                    <input type="text" id="cardholder_name" name="cardholder_name" class="mb-field-input" placeholder="Ej. MIGUEL MUNDACA" value="{{ $company?->business_name ?: $user->name }}" required>
                </div>

                <div class="mb-field-group">
                    <label class="mb-field-label" for="card_number">Número de tarjeta</label>
                    <div style="position:relative;">
                        <input type="text" id="card_number" name="card_number" class="mb-field-input" placeholder="4242 &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; 4242" maxlength="19" autocomplete="cc-number">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="position:absolute;right:14px;top:13px;width:18px;height:18px;color:var(--muted);"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    </div>
                </div>

                <div class="mb-field-row">
                    <div class="mb-field-group">
                        <label class="mb-field-label" for="card_exp">Vencimiento (MM/AA)</label>
                        <input type="text" id="card_exp" name="card_exp" class="mb-field-input" placeholder="MM / AA" maxlength="7" autocomplete="cc-exp">
                    </div>
                    <div class="mb-field-group">
                        <label class="mb-field-label" for="card_cvc">CVC / Seguridad</label>
                        <input type="password" id="card_cvc" name="card_cvc" class="mb-field-input" placeholder="123" maxlength="4" autocomplete="cc-csc">
                    </div>
                </div>

                <button type="submit" class="mb-btn-checkout">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" style="width:18px;height:18px;"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <span>Pagar ${{ number_format($priceUsd, 2) }} USD con Stripe y Activar Plan</span>
                </button>
            </form>

            <div class="mb-trust-row">
                <div class="mb-trust-col">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2" style="width:16px;height:16px;flex-shrink:0;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    <span>Cifrado bancario AES-256</span>
                </div>
                <div class="mb-trust-col">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#38bdf8" stroke-width="2" style="width:16px;height:16px;flex-shrink:0;"><polyline points="20 6 9 17 4 12"/></svg>
                    <span>Activación inmediata del servicio</span>
                </div>
            </div>
        </div>

        {{-- COLUMNA DERECHA: RESUMEN DEL PLAN --}}
        <div class="mb-pay-card">
            <h3 style="margin: 0 0 16px 0; font-size: 16px; font-weight: 700; color: #f8fafc;">Resumen de la Suscripción</h3>

            <div class="mb-summary-box">
                <div class="mb-summary-icon {{ $tierClass }}">
                    <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20M6 15h4"/></svg>
                </div>
                <div class="mb-summary-info">
                    <h4 class="mb-summary-title">{{ $plan->fullName() }}</h4>
                    <span class="mb-summary-tag {{ $tierClass }}">Plan {{ $plan->tierLabel() }} · {{ $plan->durationLabel() }}</span>
                    <p style="margin: 6px 0 0 0; font-size: 11.5px; color: var(--muted); line-height: 1.4;">
                        Equivalente a solo ${{ number_format($plan->monthlyPrice(), 2) }} USD / mes
                    </p>
                </div>
            </div>

            <table class="mb-table-summary">
                <tbody>
                    <tr>
                        <td>Membresía</td>
                        <td>{{ $plan->fullName() }}</td>
                    </tr>
                    <tr>
                        <td>Vigencia</td>
                        <td>{{ $plan->durationLabel() }} ({{ $plan->months }} meses)</td>
                    </tr>
                    <tr>
                        <td>Precio base</td>
                        <td>${{ number_format($priceUsd, 2) }} USD</td>
                    </tr>
                    <tr>
                        <td>Descuentos aplicados</td>
                        <td style="color: #34d399;">-$0.00 USD</td>
                    </tr>
                    <tr>
                        <td>Comisión de procesamiento</td>
                        <td>$0.00 USD</td>
                    </tr>
                    <tr class="mb-table-total">
                        <td>Total a pagar</td>
                        <td>${{ number_format($priceUsd, 2) }} USD</td>
                    </tr>
                </tbody>
            </table>

            <div style="text-align: right; font-size: 12px; color: var(--muted); margin-top: -12px; margin-bottom: 16px;">
                Monto referencial en moneda local: <strong style="color: #cbd5e1;">S/. {{ number_format($approxPen, 2) }} PEN</strong>
            </div>

            <div class="mb-features-card">
                <div class="mb-features-header">Beneficios incluidos en este plan:</div>
                @if ($plan->isPremium())
                    <div class="mb-feat-row">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2.5" style="width:14px;height:14px;flex-shrink:0;margin-top:2px;"><polyline points="20 6 9 17 4 12"/></svg>
                        <span><strong>Proformas ILIMITADAS</strong> mensuales</span>
                    </div>
                    <div class="mb-feat-row">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2.5" style="width:14px;height:14px;flex-shrink:0;margin-top:2px;"><polyline points="20 6 9 17 4 12"/></svg>
                        <span><strong>Hasta 2 Empresas independientes</strong> (Multi-empresa)</span>
                    </div>
                    <div class="mb-feat-row">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2.5" style="width:14px;height:14px;flex-shrink:0;margin-top:2px;"><polyline points="20 6 9 17 4 12"/></svg>
                        <span><strong>Módulo de Productos</strong> (hasta 20 catálogo)</span>
                    </div>
                    <div class="mb-feat-row">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2.5" style="width:14px;height:14px;flex-shrink:0;margin-top:2px;"><polyline points="20 6 9 17 4 12"/></svg>
                        <span><strong>Multimoneda PRO</strong> (2 monedas LATAM / USD)</span>
                    </div>
                    <div class="mb-feat-row">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2.5" style="width:14px;height:14px;flex-shrink:0;margin-top:2px;"><polyline points="20 6 9 17 4 12"/></svg>
                        <span><strong>Galería de Fotos</strong> en Proformas</span>
                    </div>
                    <div class="mb-feat-row">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2.5" style="width:14px;height:14px;flex-shrink:0;margin-top:2px;"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Emisión de Recibos y Guías de Remisión (50/mes)</span>
                    </div>
                @elseif ($plan->isStandard())
                    <div class="mb-feat-row">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2.5" style="width:14px;height:14px;flex-shrink:0;margin-top:2px;"><polyline points="20 6 9 17 4 12"/></svg>
                        <span><strong>100 proformas/mes</strong></span>
                    </div>
                    <div class="mb-feat-row">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2.5" style="width:14px;height:14px;flex-shrink:0;margin-top:2px;"><polyline points="20 6 9 17 4 12"/></svg>
                        <span><strong>Hasta 2 empresas registradas</strong></span>
                    </div>
                    <div class="mb-feat-row">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2.5" style="width:14px;height:14px;flex-shrink:0;margin-top:2px;"><polyline points="20 6 9 17 4 12"/></svg>
                        <span><strong>Módulo de Productos</strong> (hasta 20)</span>
                    </div>
                    <div class="mb-feat-row">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2.5" style="width:14px;height:14px;flex-shrink:0;margin-top:2px;"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>1 Moneda a elección (Todo LATAM / USD)</span>
                    </div>
                    <div class="mb-feat-row">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2.5" style="width:14px;height:14px;flex-shrink:0;margin-top:2px;"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Clientes ilimitados, correo y PDF</span>
                    </div>
                @else
                    <div class="mb-feat-row">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2.5" style="width:14px;height:14px;flex-shrink:0;margin-top:2px;"><polyline points="20 6 9 17 4 12"/></svg>
                        <span><strong>Máximo 50 proformas/mes</strong></span>
                    </div>
                    <div class="mb-feat-row">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2.5" style="width:14px;height:14px;flex-shrink:0;margin-top:2px;"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>1 Empresa registrada</span>
                    </div>
                    <div class="mb-feat-row">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2.5" style="width:14px;height:14px;flex-shrink:0;margin-top:2px;"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>1 Moneda a elección (Todo LATAM / USD)</span>
                    </div>
                    <div class="mb-feat-row">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2.5" style="width:14px;height:14px;flex-shrink:0;margin-top:2px;"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Clientes ilimitados</span>
                    </div>
                    <div class="mb-feat-row">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2.5" style="width:14px;height:14px;flex-shrink:0;margin-top:2px;"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Envío por correo y exportación PDF</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
