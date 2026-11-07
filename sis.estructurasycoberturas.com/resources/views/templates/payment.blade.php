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
.tpl-brand-logo {display: inline-block; height: 24px; width: 38px; border-radius: 4px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3); border: 1px solid rgba(255, 255, 255, 0.12); vertical-align: middle; flex-shrink: 0; transition: transform 0.15s ease;}
.tpl-brand-logo:hover {transform: translateY(-1px); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);}
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
                        {{-- VISA --}}
                        <svg class="tpl-brand-logo" width="38" height="24" viewBox="0 0 38 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Visa" role="img">
                            <rect width="38" height="24" rx="4" fill="#FFFFFF"/>
                            <path d="M15.42 16.5H13.25L14.61 8.5H16.78L15.42 16.5ZM22.42 8.7C21.99 8.54 21.31 8.37 20.44 8.37C18.1 8.37 16.44 9.59 16.42 11.33C16.4 12.62 17.58 13.34 18.48 13.77C19.4 14.21 19.71 14.49 19.71 14.88C19.71 15.48 18.98 15.75 18.28 15.75C17.35 15.75 16.82 15.61 15.99 15.25L15.65 15.09L15.27 17.36C15.9 17.64 17.06 17.89 18.26 17.9C20.76 17.9 22.4 16.69 22.43 14.83C22.44 13.74 21.75 12.91 20.31 12.23C19.43 11.8 18.9 11.51 18.9 11.06C18.91 10.65 19.37 10.22 20.35 10.22C21.13 10.21 21.68 10.37 22.12 10.56L22.33 10.65L22.71 8.44C22.62 8.41 22.42 8.7 22.42 8.7ZM27.06 8.5H25.39C24.87 8.5 24.48 8.65 24.26 9.18L20.7 17.5H22.97C22.97 17.5 23.34 16.47 23.43 16.22C23.68 16.22 25.89 16.22 26.23 16.22C26.31 16.55 26.51 17.48 26.51 17.48H28.52L27.06 8.5ZM24.02 14.64C24.2 14.15 24.9 12.3 24.9 12.3C24.89 12.31 25.09 11.8 25.2 11.49L25.36 12.25C25.36 12.25 25.82 14.42 25.87 14.64H24.02ZM12.08 8.5L9.97 14.62L9.74 13.49C9.37 12.24 8.2 10.87 6.92 10.21L8.9 17.5H11.19L14.6 8.5H12.08Z" fill="#1A1F71"/>
                            <path d="M8.07 8.5H4.61L4.57 8.66C7.25 9.33 9.54 11.03 10.27 12.95L9.49 8.97C9.35 8.47 8.98 8.5 8.07 8.5Z" fill="#F7B600"/>
                        </svg>
                        {{-- MASTERCARD --}}
                        <svg class="tpl-brand-logo" width="38" height="24" viewBox="0 0 38 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Mastercard" role="img">
                            <rect width="38" height="24" rx="4" fill="#FFFFFF"/>
                            <circle cx="14.5" cy="12" r="6.5" fill="#EB001B"/>
                            <circle cx="23.5" cy="12" r="6.5" fill="#F79E1B"/>
                            <path d="M 19 7.31 A 6.5 6.5 0 0 1 19 16.69 A 6.5 6.5 0 0 1 19 7.31 Z" fill="#FF5F00"/>
                        </svg>
                        {{-- AMERICAN EXPRESS --}}
                        <svg class="tpl-brand-logo" width="38" height="24" viewBox="0 0 38 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="American Express" role="img">
                            <rect width="38" height="24" rx="4" fill="#006FCF"/>
                            <path d="M6 15.5L8.5 8.5H11L13.5 15.5H11.3L10.8 14H8.7L8.2 15.5H6ZM9.1 12.3H10.4L9.8 10.3L9.1 12.3ZM14.2 15.5V8.5H16.8L18.4 13L20 8.5H22.6V15.5H20.7V11.3L19.2 15.1H17.6L16.1 11.3V15.5H14.2ZM23.8 15.5V8.5H30V10.4H25.8V10.9H29.4V12.9H25.8V13.6H30V15.5H23.8Z" fill="#FFFFFF"/>
                        </svg>
                        {{-- DISCOVER --}}
                        <svg class="tpl-brand-logo" width="38" height="24" viewBox="0 0 38 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Discover" role="img">
                            <rect width="38" height="24" rx="4" fill="#FFFFFF"/>
                            <path d="M6 14.5V9.5H8.8C10.5 9.5 11.6 10.5 11.6 12C11.6 13.5 10.5 14.5 8.8 14.5H6ZM7.6 13.2H8.7C9.7 13.2 10.2 12.7 10.2 12C10.2 11.3 9.7 10.8 8.7 10.8H7.6V13.2ZM12.7 14.5V9.5H14.2V14.5H12.7ZM19 14.7C17.5 14.7 16.3 13.5 16.3 12C16.3 10.5 17.5 9.3 19 9.3C20.5 9.3 21.7 10.5 21.7 12C21.7 13.5 20.5 14.7 19 14.7Z" fill="#231F20"/>
                            <circle cx="19" cy="12" r="2.7" fill="#F47216"/>
                            <path d="M22.8 14.5L24.8 9.5H26.4L28.4 14.5H26.8L26.4 13.4H24.8L24.4 14.5H22.8ZM25.1 12.2H26.1L25.6 10.8L25.1 12.2ZM28.5 14.5V9.5H32V10.7H29.9V11.4H31.7V12.6H29.9V13.3H32.1V14.5H28.5Z" fill="#231F20"/>
                        </svg>
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
