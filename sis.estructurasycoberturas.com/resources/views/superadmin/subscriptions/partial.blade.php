<style>
.sm-grid {display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;}
.sm-card {background: linear-gradient(180deg, rgba(255, 255, 255, .055), rgba(255, 255, 255, .025)); border: 1px solid var(--line); border-radius: 16px; padding: 20px; box-shadow: 0 18px 45px rgba(0, 0, 0, .22); transition: transform .2s ease, border-color .2s ease;}
.sm-card:hover {transform: translateY(-2px); border-color: rgba(99, 102, 241, .4);}
.sm-label {font-size: 12px; font-weight: 700; text-transform: uppercase; color: var(--muted); letter-spacing: .05em;}
.sm-value {font-size: 28px; font-weight: 800; color: #f8fafc; margin-top: 6px;}
.sm-value.is-green {color: #86efac;}
.sm-value.is-amber {color: #fcd34d;}
.sm-value.is-red {color: #fca5a5;}
.sm-box {background: linear-gradient(180deg, rgba(255, 255, 255, .05), rgba(255, 255, 255, .02)); border: 1px solid var(--line); border-radius: 16px; padding: 24px; box-shadow: 0 18px 45px rgba(0, 0, 0, .22); margin-bottom: 24px;}
.sm-header-row {display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; margin-bottom: 14px;}
.sm-h2 {font-size: 18px; font-weight: 700; color: #f8fafc; margin: 0 0 4px;}
.sm-sub {font-size: 13px; color: var(--muted); margin: 0 0 16px;}
.sm-form {display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px; align-items: end;}
.sm-field label {display: block; font-size: 12px; font-weight: 600; color: #cbd5e1; margin-bottom: 6px;}
.sm-input {width: 100%; box-sizing: border-box; padding: 11px 14px; border: 1px solid var(--line); border-radius: 8px; background: var(--field); color: var(--text); font-size: 14px; outline: none; transition: border-color .18s ease, box-shadow .18s ease;}
.sm-input:focus {border-color: rgba(99, 102, 241, .78); box-shadow: 0 0 0 4px rgba(99, 102, 241, .15);}
.sm-btn {background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); color: #fff; min-height: 44px; padding: 0 20px; border-radius: 10px; font-size: 14px; font-weight: 700; border: none; cursor: pointer; box-shadow: 0 10px 25px -5px rgba(79, 70, 229, .4); transition: transform .2s ease, opacity .2s ease;}
.sm-btn:hover {opacity: .95; transform: translateY(-1px);}
.sm-btn-sec {background: rgba(255, 255, 255, .07); color: #e2e8f0; min-height: 38px; padding: 0 14px; border-radius: 8px; font-size: 13px; font-weight: 700; border: 1px solid var(--line); cursor: pointer; transition: background .18s ease, border-color .18s ease;}
.sm-btn-sec:hover {background: rgba(255, 255, 255, .12); border-color: rgba(99, 102, 241, .45);}
.sm-webhook-bar {display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; margin-top: 16px; padding: 12px 14px; border-radius: 10px; background: rgba(15, 23, 42, .65); border: 1px dashed rgba(148, 163, 184, .25); font-size: 13px; color: #cbd5e1;}
.sm-webhook-code {font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; color: #a5b4fc; word-break: break-all;}
.sm-tabs {display: inline-flex; padding: 4px; border-radius: 12px; background: rgba(255, 255, 255, .04); border: 1px solid var(--line); gap: 6px; margin-bottom: 16px;}
.sm-tab {border: 0; border-radius: 9px; padding: 8px 16px; font: inherit; font-size: 13px; font-weight: 800; color: var(--muted); background: transparent; cursor: pointer; transition: all .2s ease;}
.sm-tab.is-active {background: linear-gradient(135deg, #f59e0b, #fbbf24); color: #111827;}
.sm-tab-premium.is-active {background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff;}
.sm-plans-grid {display: none; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 16px;}
.sm-plans-grid.is-active {display: grid;}
.sm-plan-card {padding: 18px; border-radius: 14px; border: 1px solid var(--line); background: rgba(15, 23, 42, .45); display: grid; gap: 12px;}
.sm-table {width: 100%; border-collapse: collapse; font-size: 14px;}
.sm-th {padding: 12px 14px; font-size: 12px; font-weight: 700; text-transform: uppercase; color: var(--muted); background: rgba(255, 255, 255, .03); border-bottom: 1px solid var(--line); text-align: left;}
.sm-td {padding: 13px 14px; border-bottom: 1px solid rgba(255, 255, 255, .06); color: #cbd5e1;}
.sm-badge {display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 600;}
.sm-badge-ok {background: rgba(34, 197, 94, .15); color: #86efac; border: 1px solid rgba(34, 197, 94, .3);}
.sm-badge-warn {background: rgba(245, 158, 11, .15); color: #fcd34d; border: 1px solid rgba(245, 158, 11, .3);}
.sm-badge-bad {background: rgba(239, 68, 68, .15); color: #fca5a5; border: 1px solid rgba(239, 68, 68, .3);}
.sm-badge-info {background: rgba(99, 102, 241, .18); color: #a5b4fc; border: 1px solid rgba(99, 102, 241, .35);}
.sm-alert {border-radius: 12px; padding: 14px 18px; font-size: 14px; font-weight: 600; margin-bottom: 18px; background: rgba(34, 197, 94, .12); border: 1px solid rgba(34, 197, 94, .35); color: #86efac;}
</style>

@if (session('status'))
    <div class="sm-alert">{{ session('status') }}</div>
@endif

<div class="sm-grid">
    <div class="sm-card"><div class="sm-label">Membresías activas</div><div class="sm-value is-green">{{ $stats['active'] }}</div></div>
    <div class="sm-card"><div class="sm-label">Vencen en 7 días</div><div class="sm-value is-amber">{{ $stats['expiring'] }}</div></div>
    <div class="sm-card"><div class="sm-label">Vencidas</div><div class="sm-value is-red">{{ $stats['expired'] }}</div></div>
    <div class="sm-card"><div class="sm-label">Ingresos Stripe</div><div class="sm-value">${{ number_format($stats['revenue'], 2) }}</div></div>
</div>

<div class="sm-box">
    <div class="sm-header-row">
        <div>
            <h2 class="sm-h2">Pasarela de Pagos Stripe</h2>
            <p class="sm-sub" style="margin-bottom:0;">Configura tus llaves de Stripe para habilitar el cobro automático de membresías.</p>
        </div>
        @if ($stripeConfigured)
            <span class="sm-badge {{ $stripeMode === 'live' ? 'sm-badge-ok' : 'sm-badge-warn' }}">
                ● Stripe Conectado ({{ $stripeMode === 'live' ? 'Producción / Live' : 'Modo Prueba / Test' }})
            </span>
        @else
            <span class="sm-badge sm-badge-bad">● Pendiente de configurar</span>
        @endif
    </div>

    <form class="sm-form" method="post" action="{{ route('superadmin.subscriptions.stripe') }}">
        @csrf
        <div class="sm-field">
            <label for="stripe-key">Publishable Key (pk_live_... o pk_test_...)</label>
            <input id="stripe-key" name="key" class="sm-input" value="{{ $stripeKey }}" placeholder="pk_live_...">
        </div>
        <div class="sm-field">
            <label for="stripe-secret">Secret Key {{ $stripeSecretMasked ? '(actual: '.$stripeSecretMasked.')' : '' }}</label>
            <input id="stripe-secret" name="secret" type="password" class="sm-input" placeholder="{{ $stripeSecretMasked ?: 'sk_live_...' }}" autocomplete="new-password">
        </div>
        <div class="sm-field">
            <label for="stripe-webhook">Webhook Secret {{ $stripeWebhookMasked ? '(actual: '.$stripeWebhookMasked.')' : '' }}</label>
            <input id="stripe-webhook" name="webhook_secret" type="password" class="sm-input" placeholder="{{ $stripeWebhookMasked ?: 'whsec_...' }}" autocomplete="new-password">
        </div>
        <div>
            <button class="sm-btn" type="submit" id="stripe-save">Guardar llaves</button>
        </div>
    </form>

    <div class="sm-webhook-bar">
        <div>
            <strong>Webhook Endpoint (Stripe Dashboard):</strong>
            <span class="sm-webhook-code" id="stripe-webhook-url">{{ $webhookUrl }}</span>
            <span style="color:var(--muted); margin-left:6px;">(Evento: <code>checkout.session.completed</code>)</span>
        </div>
        <button type="button" class="sm-btn-sec" onclick="navigator.clipboard?.writeText('{{ $webhookUrl }}'); this.textContent='¡Copiado!'; setTimeout(()=>this.textContent='Copiar URL', 1800);">Copiar URL</button>
    </div>
</div>

<div class="sm-box">
    <div class="sm-header-row" style="margin-bottom:8px;">
        <div>
            <h2 class="sm-h2">Planes de Membresía (Básico y Premium)</h2>
            <p class="sm-sub" style="margin-bottom:0;">Ajusta los precios en dólares (USD) de cada plan por pestaña.</p>
        </div>
        <div class="sm-tabs" style="margin-bottom:0;">
            <button type="button" class="sm-tab is-active" id="sa-tab-basic" onclick="switchAdminPlanTab('basic')">Plan Básico</button>
            <button type="button" class="sm-tab sm-tab-premium" id="sa-tab-premium" onclick="switchAdminPlanTab('premium')">Plan Premium</button>
        </div>
    </div>

    <div class="sm-plans-grid is-active" id="sa-grid-basic">
        @foreach ($plans->where('tier', 'basic') as $plan)
            <form class="sm-plan-card" method="post" action="{{ route('superadmin.subscriptions.plans.update', $plan) }}">
                @csrf
                @method('PUT')
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <strong style="color:#f8fafc;">Plan Básico · {{ $plan->durationLabel() }}</strong>
                    <span class="sm-badge sm-badge-warn">Básico</span>
                </div>
                <div class="sm-field">
                    <label>Nombre del periodo</label>
                    <input name="name" class="sm-input" value="{{ $plan->name }}" required>
                </div>
                <div class="sm-field">
                    <label>Precio (USD)</label>
                    <input name="price_usd" type="number" step="0.01" min="1" class="sm-input" value="{{ $plan->price_usd }}" required>
                </div>
                <input type="hidden" name="is_active" value="1">
                <button type="submit" class="sm-btn-sec" style="width:100%;">Actualizar plan</button>
            </form>
        @endforeach
    </div>

    <div class="sm-plans-grid" id="sa-grid-premium">
        @foreach ($plans->where('tier', 'premium') as $plan)
            <form class="sm-plan-card" method="post" action="{{ route('superadmin.subscriptions.plans.update', $plan) }}">
                @csrf
                @method('PUT')
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <strong style="color:#f8fafc;">Plan Premium · {{ $plan->durationLabel() }}</strong>
                    <span class="sm-badge sm-badge-info">Premium</span>
                </div>
                <div class="sm-field">
                    <label>Nombre del periodo</label>
                    <input name="name" class="sm-input" value="{{ $plan->name }}" required>
                </div>
                <div class="sm-field">
                    <label>Precio (USD)</label>
                    <input name="price_usd" type="number" step="0.01" min="1" class="sm-input" value="{{ $plan->price_usd }}" required>
                </div>
                <input type="hidden" name="is_active" value="1">
                <button type="submit" class="sm-btn-sec" style="width:100%;">Actualizar plan</button>
            </form>
        @endforeach
    </div>
</div>

<div class="sm-box">
    <h2 class="sm-h2">Asignar plan de cortesía</h2>
    <p class="sm-sub">Activa, cambia de nivel (Básico / Premium) o extiende manualmente la membresía de un usuario.</p>
    <form class="sm-form" method="post" action="{{ route('superadmin.subscriptions.grant') }}">
        @csrf
        <div class="sm-field">
            <label for="grant-user">Usuario</label>
            <select id="grant-user" name="user_id" class="sm-input" required>
                @foreach ($tenants as $tenant)
                    <option value="{{ $tenant->id }}">{{ $tenant->name }} — {{ $tenant->email }}</option>
                @endforeach
            </select>
        </div>
        <div class="sm-field">
            <label for="grant-plan">Plan y Nivel</label>
            <select id="grant-plan" name="membership_plan_id" class="sm-input" required>
                <optgroup label="Plan Básico (1 empresa · Soles)">
                    @foreach ($plans->where('tier', 'basic') as $plan)
                        <option value="{{ $plan->id }}">Plan Básico · {{ $plan->name }} ({{ $plan->durationLabel() }})</option>
                    @endforeach
                </optgroup>
                <optgroup label="Plan Premium (2 empresas · Multimoneda · Galería)">
                    @foreach ($plans->where('tier', 'premium') as $plan)
                        <option value="{{ $plan->id }}">Plan Premium · {{ $plan->name }} ({{ $plan->durationLabel() }})</option>
                    @endforeach
                </optgroup>
            </select>
        </div>
        <div class="sm-field">
            <label for="grant-notes">Nota (opcional)</label>
            <input id="grant-notes" name="notes" class="sm-input" maxlength="250" placeholder="Ej. Asignación anual">
        </div>
        <div><button class="sm-btn" type="submit" id="grant-submit">Asignar plan</button></div>
    </form>
</div>

<div class="sm-box">
    <h2 class="sm-h2">Estado de membresías por usuario</h2>
    <p class="sm-sub">Nivel de plan y vencimiento actual de cada cuenta empresa.</p>
    <div style="overflow-x: auto;">
        <table class="sm-table">
            <thead><tr><th class="sm-th">Usuario</th><th class="sm-th">Correo</th><th class="sm-th">Nivel</th><th class="sm-th">Periodo</th><th class="sm-th">Vence</th><th class="sm-th">Estado</th></tr></thead>
            <tbody>
                @forelse ($tenants as $tenant)
                    @php $days = $tenant->membershipDaysLeft(); @endphp
                    <tr>
                        <td class="sm-td"><strong style="color:#f8fafc;">{{ $tenant->name }}</strong></td>
                        <td class="sm-td">{{ $tenant->email }}</td>
                        <td class="sm-td">
                            <span class="sm-badge {{ $tenant->isPremium() ? 'sm-badge-info' : 'sm-badge-warn' }}">
                                Plan {{ $tenant->currentTierLabel() }}
                            </span>
                        </td>
                        <td class="sm-td">{{ $tenant->isOnTrial() ? 'Prueba gratuita' : ($tenant->currentPlanName() ?? '—') }}</td>
                        <td class="sm-td">{{ $tenant->membership_ends_at?->format('d/m/Y') ?? '—' }}</td>
                        <td class="sm-td">
                            @if ($days === 0)
                                <span class="sm-badge sm-badge-bad">Vencida</span>
                            @elseif ($days <= 7)
                                <span class="sm-badge sm-badge-warn">{{ $days }} día(s)</span>
                            @else
                                <span class="sm-badge sm-badge-ok">{{ $days }} días</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="sm-td" style="text-align:center; color: var(--muted);">Sin cuentas empresa.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="sm-box">
    <h2 class="sm-h2">Historial de pagos</h2>
    <p class="sm-sub">Últimos 100 movimientos (Stripe y cortesías).</p>
    <div style="overflow-x: auto;">
        <table class="sm-table">
            <thead><tr><th class="sm-th">Fecha</th><th class="sm-th">Usuario</th><th class="sm-th">Plan</th><th class="sm-th">Origen</th><th class="sm-th">Monto</th><th class="sm-th">Periodo</th><th class="sm-th">Estado</th></tr></thead>
            <tbody>
                @forelse ($payments as $payment)
                    <tr>
                        <td class="sm-td">{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                        <td class="sm-td">{{ $payment->user?->name ?? '—' }}</td>
                        <td class="sm-td">{{ $payment->plan?->fullName() ?? ('Plan '.$payment->tierLabel()) }}</td>
                        <td class="sm-td">{{ $payment->source === 'stripe' ? 'Stripe' : ($payment->notes ?: 'Cortesía') }}</td>
                        <td class="sm-td">${{ number_format($payment->amount_usd, 2) }}</td>
                        <td class="sm-td">{{ $payment->starts_at ? $payment->starts_at->format('d/m/Y').' – '.$payment->ends_at->format('d/m/Y') : '—' }}</td>
                        <td class="sm-td">
                            <span class="sm-badge {{ match($payment->status) { 'paid' => 'sm-badge-ok', 'granted' => 'sm-badge-info', 'failed' => 'sm-badge-bad', default => 'sm-badge-warn' } }}">{{ $payment->statusLabel() }}</span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="sm-td" style="text-align:center; color: var(--muted);">Aún no hay pagos.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
window.switchAdminPlanTab = function switchAdminPlanTab(tier) {
    const isPremium = tier === 'premium';
    document.getElementById('sa-tab-basic')?.classList.toggle('is-active', !isPremium);
    document.getElementById('sa-tab-premium')?.classList.toggle('is-active', isPremium);
    document.getElementById('sa-grid-basic')?.classList.toggle('is-active', !isPremium);
    document.getElementById('sa-grid-premium')?.classList.toggle('is-active', isPremium);
};
</script>
