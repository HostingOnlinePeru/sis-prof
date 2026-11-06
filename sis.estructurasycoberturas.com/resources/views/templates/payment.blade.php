<style>
.tpl-pay-wrapper {max-width: 1100px; margin: 0 auto; padding-bottom: 40px;}
.tpl-pay-back {display: inline-flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; color: var(--muted); text-decoration: none; margin-bottom: 20px; transition: color 0.15s ease;}
.tpl-pay-back:hover {color: #f8fafc;}
.tpl-pay-grid {display: grid; grid-template-columns: 1.4fr 1fr; gap: 28px; align-items: start;}
.tpl-pay-card {background: linear-gradient(180deg, rgba(255, 255, 255, 0.04), rgba(255, 255, 255, 0.015)); border: 1px solid var(--line); border-radius: 18px; padding: 26px; box-shadow: 0 20px 45px rgba(0, 0, 0, 0.35);}
.tpl-pay-header {display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--line); padding-bottom: 18px; margin-bottom: 22px;}
.tpl-pay-header-left {display: flex; align-items: center; gap: 12px;}
.tpl-pay-icon {width: 42px; height: 42px; border-radius: 10px; background: rgba(99, 102, 241, 0.15); border: 1px solid rgba(99, 102, 241, 0.3); display: flex; align-items: center; justify-content: center; color: #a5b4fc;}
.tpl-pay-title {margin: 0; font-size: 18px; font-weight: 700; color: #f8fafc;}
.tpl-pay-subtitle {font-size: 12px; color: var(--muted); margin-top: 2px;}
.tpl-pay-ssl {display: inline-flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 700; color: #34d399; background: rgba(52, 211, 153, 0.1); border: 1px solid rgba(52, 211, 153, 0.3); padding: 5px 10px; border-radius: 9999px; text-transform: uppercase;}
.tpl-pay-methods {display: flex; gap: 12px; margin-bottom: 22px;}
.tpl-pay-method-tab {flex: 1; display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; border-radius: 12px; background: rgba(99, 102, 241, 0.12); border: 1.5px solid #6366f1; color: #f8fafc; font-size: 13px; font-weight: 600;}
.tpl-pay-brands {display: flex; align-items: center; gap: 6px;}
.tpl-brand-pill {font-size: 10px; font-weight: 800; padding: 3px 6px; border-radius: 4px; background: rgba(255, 255, 255, 0.1); color: #f8fafc; letter-spacing: 0.5px;}
.tpl-field-group {margin-bottom: 18px;}
.tpl-field-label {display: block; font-size: 12px; font-weight: 600; color: #cbd5e1; margin-bottom: 7px; text-transform: uppercase; letter-spacing: 0.5px;}
.tpl-field-input {width: 100%; box-sizing: border-box; background: rgba(15, 23, 42, 0.8); border: 1px solid var(--line); border-radius: 10px; padding: 11px 14px; font-size: 14px; color: #f8fafc; outline: none; transition: border-color 0.15s ease, box-shadow 0.15s ease;}
.tpl-field-input:focus {border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25);}
.tpl-field-row {display: grid; grid-template-columns: 1fr 1fr; gap: 14px;}
.tpl-stripe-notice {background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.3); border-radius: 12px; padding: 14px 16px; margin-bottom: 20px; font-size: 12.5px; color: #fde68a; line-height: 1.5;}
.tpl-stripe-live {background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.3); border-radius: 12px; padding: 14px 16px; margin-bottom: 20px; font-size: 12.5px; color: #86efac; line-height: 1.5;}
.tpl-btn-pay {width: 100%; background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%); color: #ffffff; border: none; padding: 14px 20px; border-radius: 12px; font-size: 15px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; box-shadow: 0 10px 25px rgba(37, 99, 235, 0.35); transition: transform 0.15s ease, box-shadow 0.15s ease, opacity 0.15s ease;}
.tpl-btn-pay:hover {transform: translateY(-2px); box-shadow: 0 14px 30px rgba(37, 99, 235, 0.5); opacity: 0.96;}
.tpl-trust-grid {display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 22px; border-top: 1px solid var(--line); padding-top: 18px;}
.tpl-trust-item {display: flex; align-items: center; gap: 8px; font-size: 11.5px; color: var(--muted);}
.tpl-summary-preview {background: #0c1322; border: 1px solid var(--line); border-radius: 12px; padding: 16px; margin-bottom: 18px; display: flex; gap: 14px; align-items: center;}
.tpl-summary-thumb {width: 60px; height: 75px; background: #ffffff; border-radius: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.4); flex-shrink: 0; display: flex; flex-direction: column; justify-content: space-between; padding: 5px;}
.tpl-summary-info {flex-grow: 1; overflow: hidden;}
.tpl-summary-title {font-size: 15px; font-weight: 700; color: #f8fafc; margin: 0 0 4px 0;}
.tpl-summary-badge {display: inline-block; font-size: 10.5px; font-weight: 700; padding: 2px 8px; border-radius: 9999px; background: rgba(245, 158, 11, 0.2); color: #fde68a; border: 1px solid rgba(245, 158, 11, 0.35); text-transform: uppercase;}
.tpl-breakdown-table {width: 100%; border-collapse: collapse; margin-bottom: 20px;}
.tpl-breakdown-table tr td {padding: 10px 0; font-size: 13px; color: #94a3b8; border-bottom: 1px solid rgba(255, 255, 255, 0.05);}
.tpl-breakdown-table tr td:last-child {text-align: right; color: #f8fafc; font-weight: 600;}
.tpl-breakdown-total td {font-size: 16px !important; font-weight: 800 !important; color: #f8fafc !important; border-bottom: none !important; padding-top: 14px !important;}
.tpl-breakdown-total td:last-child {color: #38bdf8 !important; font-size: 20px !important;}
.tpl-benefits-box {background: rgba(255, 255, 255, 0.02); border: 1px dashed var(--line); border-radius: 12px; padding: 14px; margin-top: 14px;}
.tpl-benefits-title {font-size: 11.5px; font-weight: 700; color: #cbd5e1; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;}
.tpl-benefit-item {display: flex; align-items: flex-start; gap: 8px; font-size: 12px; color: var(--muted); margin-bottom: 6px; line-height: 1.4;}
.tpl-benefit-item:last-child {margin-bottom: 0;}
@media (max-width: 860px) {.tpl-pay-grid {grid-template-columns: 1fr;}}
</style>

<div class="tpl-pay-wrapper">
    <a href="{{ route('templates.index') }}" class="tpl-pay-back" data-ajax-link data-nav="templates">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" style="width:16px;height:16px;"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        <span>Volver al Catálogo de Plantillas</span>
    </a>

    @if ($errors->any())
        <div class="errors" style="margin-bottom: 22px;">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="tpl-pay-grid">
        {{-- COLUMNA IZQUIERDA: FORMULARIO Y PASARELA STRIPE --}}
        <div class="tpl-pay-card">
            <div class="tpl-pay-header">
                <div class="tpl-pay-header-left">
                    <div class="tpl-pay-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:22px;height:22px;"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </div>
                    <div>
                        <h2 class="tpl-pay-title">Pasarela de Pago Seguro</h2>
                        <div class="tpl-pay-subtitle">Transacción directa y encriptada de extremo a extremo</div>
                    </div>
                </div>
                <div class="tpl-pay-ssl">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:12px;height:12px;"><polyline points="20 6 9 17 4 12"/></svg>
                    SSL 256-BIT
                </div>
            </div>

            <div class="tpl-pay-methods">
                <div class="tpl-pay-method-tab">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <input type="radio" checked readonly style="accent-color: #6366f1;">
                        <span>Tarjeta de Crédito / Débito (Stripe)</span>
                    </div>
                    <div class="tpl-pay-brands">
                        <span class="tpl-brand-pill" style="color:#60a5fa;">VISA</span>
                        <span class="tpl-brand-pill" style="color:#f87171;">MC</span>
                        <span class="tpl-brand-pill" style="color:#38bdf8;">AMEX</span>
                    </div>
                </div>
            </div>

            @if (! $stripeReady)
                <div class="tpl-stripe-notice">
                    <strong>ℹ️ Pasarela Stripe en modo de preparación:</strong><br>
                    Esta interfaz de cobro está completamente estructurada y lista para procesar tarjetas con Stripe. Para habilitar los cobros reales en vivo, ingresa las credenciales de Stripe (Publishable Key y Secret Key) en el panel de <strong>Super Administrador &rarr; Membresías &rarr; Configurar Stripe</strong>.
                </div>
            @else
                <div class="tpl-stripe-live">
                    <strong>✓ Pasarela Stripe conectada y lista:</strong><br>
                    El pago se procesará a través de la infraestructura segura de Stripe Checkout con cifrado bancario.
                </div>
            @endif

            <form action="{{ route('templates.checkout', $template['slug']) }}" method="POST">
                @csrf

                <div class="tpl-field-group">
                    <label class="tpl-field-label" for="cardholder_name">Nombre en la tarjeta</label>
                    <input type="text" id="cardholder_name" name="cardholder_name" class="tpl-field-input" placeholder="Ej. MIGUEL MUNDACA" value="{{ $company?->business_name ?: $user->name }}" required>
                </div>

                <div class="tpl-field-group">
                    <label class="tpl-field-label" for="card_number">Número de tarjeta</label>
                    <div style="position:relative;">
                        <input type="text" id="card_number" name="card_number" class="tpl-field-input" placeholder="4242 &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; 4242" maxlength="19" autocomplete="cc-number">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="position:absolute;right:14px;top:13px;width:18px;height:18px;color:var(--muted);"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    </div>
                </div>

                <div class="tpl-field-row">
                    <div class="tpl-field-group">
                        <label class="tpl-field-label" for="card_exp">Vencimiento (MM/AA)</label>
                        <input type="text" id="card_exp" name="card_exp" class="tpl-field-input" placeholder="MM / AA" maxlength="7" autocomplete="cc-exp">
                    </div>
                    <div class="tpl-field-group">
                        <label class="tpl-field-label" for="card_cvc">CVC / Seguridad</label>
                        <input type="password" id="card_cvc" name="card_cvc" class="tpl-field-input" placeholder="123" maxlength="4" autocomplete="cc-csc">
                    </div>
                </div>

                <button type="submit" class="tpl-btn-pay">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" style="width:18px;height:18px;"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <span>Pagar ${{ number_format($priceUsd, 2) }} USD con Stripe y Desbloquear</span>
                </button>
            </form>

            <div class="tpl-trust-grid">
                <div class="tpl-trust-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2" style="width:16px;height:16px;flex-shrink:0;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    <span>Cifrado bancario AES-256</span>
                </div>
                <div class="tpl-trust-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#38bdf8" stroke-width="2" style="width:16px;height:16px;flex-shrink:0;"><polyline points="20 6 9 17 4 12"/></svg>
                    <span>Desbloqueo inmediato de por vida</span>
                </div>
            </div>
        </div>

        {{-- COLUMNA DERECHA: RESUMEN DE COMPRA --}}
        <div class="tpl-pay-card">
            <h3 style="margin: 0 0 16px 0; font-size: 16px; font-weight: 700; color: #f8fafc;">Resumen del Pedido</h3>

            <div class="tpl-summary-preview">
                <div class="tpl-summary-thumb">
                    <div style="height: 14px; background: {{ $template['styles']['primary_color'] ?? '#073b3f' }}; border-radius: 2px;"></div>
                    <div style="height: 4px; width: 60%; background: {{ $template['styles']['accent_color'] ?? '#ffd95a' }}; border-radius: 1px;"></div>
                    <div style="height: 3px; background: #e2e8f0; border-radius: 1px;"></div>
                    <div style="height: 3px; width: 80%; background: #e2e8f0; border-radius: 1px;"></div>
                    <div style="height: 8px; background: {{ $template['styles']['secondary_color'] ?? '#0a4a4f' }}; border-radius: 1px;"></div>
                </div>
                <div class="tpl-summary-info">
                    <h4 class="tpl-summary-title">{{ $template['name'] }}</h4>
                    <span class="tpl-summary-badge">Licencia Premium</span>
                    <p style="margin: 6px 0 0 0; font-size: 11.5px; color: var(--muted); line-height: 1.4;">
                        {{ \Illuminate\Support\Str::limit($template['description'], 85) }}
                    </p>
                </div>
            </div>

            <table class="tpl-breakdown-table">
                <tbody>
                    <tr>
                        <td>Modelo de cotización</td>
                        <td>{{ $template['name'] }}</td>
                    </tr>
                    <tr>
                        <td>Tipo de licencia</td>
                        <td>Permanente (Pago único)</td>
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
                        <td>Comisiones por transacción</td>
                        <td>$0.00 USD</td>
                    </tr>
                    <tr class="tpl-breakdown-total">
                        <td>Total a pagar</td>
                        <td>${{ number_format($priceUsd, 2) }} USD</td>
                    </tr>
                </tbody>
            </table>

            <div style="text-align: right; font-size: 12px; color: var(--muted); margin-top: -12px; margin-bottom: 16px;">
                Monto referencial en moneda local: <strong style="color: #cbd5e1;">S/. {{ number_format($approxPen, 2) }} PEN</strong>
            </div>

            <div class="tpl-benefits-box">
                <div class="tpl-benefits-title">¿Qué incluye tu compra?</div>
                <div class="tpl-benefit-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2.5" style="width:14px;height:14px;flex-shrink:0;margin-top:2px;"><polyline points="20 6 9 17 4 12"/></svg>
                    <span>Uso ilimitado en todas las proformas de tu empresa.</span>
                </div>
                <div class="tpl-benefit-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2.5" style="width:14px;height:14px;flex-shrink:0;margin-top:2px;"><polyline points="20 6 9 17 4 12"/></svg>
                    <span>Adaptación automática de tu logo, colores, RUC y datos.</span>
                </div>
                <div class="tpl-benefit-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2.5" style="width:14px;height:14px;flex-shrink:0;margin-top:2px;"><polyline points="20 6 9 17 4 12"/></svg>
                    <span>Exportación instantánea en PDF de alta calidad para tus clientes.</span>
                </div>
                <div class="tpl-benefit-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2.5" style="width:14px;height:14px;flex-shrink:0;margin-top:2px;"><polyline points="20 6 9 17 4 12"/></svg>
                    <span>Pago único: sin mensualidades adicionales por este diseño.</span>
                </div>
            </div>
        </div>
    </div>
</div>
