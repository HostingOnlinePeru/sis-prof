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
.mb-brand-pill {font-size: 10px; font-weight: 800; padding: 3px 6px; border-radius: 4px; background: rgba(255, 255, 255, 0.1); color: #f8fafc; letter-spacing: 0.5px;}
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
                        <span class="mb-brand-pill" style="color:#60a5fa;">VISA</span>
                        <span class="mb-brand-pill" style="color:#f87171;">MC</span>
                        <span class="mb-brand-pill" style="color:#38bdf8;">AMEX</span>
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
