<style>
.mb-wrap {display: grid; gap: 22px;}
.mb-alert {border-radius: 12px; padding: 14px 18px; font-size: 14px; font-weight: 600;}
.mb-alert-ok {background: rgba(34, 197, 94, .12); border: 1px solid rgba(34, 197, 94, .35); color: #86efac;}
.mb-alert-err {background: rgba(239, 68, 68, .12); border: 1px solid rgba(239, 68, 68, .35); color: #fca5a5;}
.mb-alert-warn {background: rgba(245, 158, 11, .12); border: 1px solid rgba(245, 158, 11, .35); color: #fcd34d;}
.mb-status {position: relative; overflow: hidden; display: grid; grid-template-columns: minmax(0, 1fr) auto; gap: 20px; align-items: center; padding: 26px 28px; border-radius: 18px; border: 1px solid var(--line); background: radial-gradient(circle at 0% 0%, rgba(245, 158, 11, .18), transparent 55%), linear-gradient(180deg, rgba(255, 255, 255, .06), rgba(255, 255, 255, .02)); box-shadow: 0 22px 50px rgba(0, 0, 0, .28);}
.mb-status.is-expired {background: radial-gradient(circle at 0% 0%, rgba(239, 68, 68, .22), transparent 55%), linear-gradient(180deg, rgba(255, 255, 255, .06), rgba(255, 255, 255, .02));}
.mb-kicker {font-size: 12px; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; color: #fbbf24;}
.mb-status.is-expired .mb-kicker {color: #f87171;}
.mb-status h3 {margin: 6px 0 4px; font-size: 24px; color: #f8fafc;}
.mb-status p {margin: 0; color: var(--muted); font-size: 14px;}
.mb-progress {margin-top: 16px; height: 8px; border-radius: 999px; background: rgba(255, 255, 255, .08); overflow: hidden;}
.mb-progress span {display: block; height: 100%; border-radius: inherit; background: linear-gradient(90deg, #f59e0b, #fbbf24); transition: width .6s ease;}
.mb-days {text-align: center; min-width: 120px;}
.mb-days strong {display: block; font-size: 44px; line-height: 1; font-weight: 900; color: #f8fafc;}
.mb-days small {color: var(--muted); font-size: 12px; font-weight: 700; text-transform: uppercase;}
.mb-tabs-wrap {display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px;}
.mb-tabs {display: inline-flex; padding: 5px; border-radius: 14px; background: rgba(255, 255, 255, .04); border: 1px solid var(--line); gap: 6px;}
.mb-tab {border: 0; border-radius: 10px; padding: 10px 20px; font: inherit; font-size: 14px; font-weight: 800; color: var(--muted); background: transparent; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all .2s ease;}
.mb-tab:hover {color: #fff;}
.mb-tab.is-active {background: linear-gradient(135deg, #f59e0b, #fbbf24); color: #111827; box-shadow: 0 8px 20px rgba(245, 158, 11, .28);}
.mb-tab-premium.is-active {background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; box-shadow: 0 8px 22px rgba(99, 102, 241, .38);}
.mb-tab-badge {padding: 2px 8px; border-radius: 999px; font-size: 11px; font-weight: 900; text-transform: uppercase; background: rgba(255, 255, 255, .15); color: inherit;}
.mb-tier-desc {font-size: 13px; color: var(--muted); margin: 0;}
.mb-plans {display: none; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 18px;}
.mb-plans.is-active {display: grid;}
.mb-plan {position: relative; display: flex; flex-direction: column; gap: 14px; padding: 26px 24px; border-radius: 18px; border: 1px solid var(--line); background: linear-gradient(180deg, rgba(255, 255, 255, .055), rgba(255, 255, 255, .02)); transition: transform .22s ease, border-color .22s ease, box-shadow .22s ease;}
.mb-plan:hover {transform: translateY(-4px); border-color: rgba(245, 158, 11, .5); box-shadow: 0 24px 50px rgba(0, 0, 0, .35);}
.mb-plan.is-featured {border-color: rgba(245, 158, 11, .65); background: radial-gradient(circle at 100% 0%, rgba(245, 158, 11, .2), transparent 60%), linear-gradient(180deg, rgba(255, 255, 255, .07), rgba(255, 255, 255, .025)); box-shadow: 0 20px 50px rgba(245, 158, 11, .12);}
.mb-plan.is-premium.is-featured {border-color: rgba(139, 92, 246, .7); background: radial-gradient(circle at 100% 0%, rgba(139, 92, 246, .24), transparent 60%), linear-gradient(180deg, rgba(255, 255, 255, .07), rgba(255, 255, 255, .025)); box-shadow: 0 20px 50px rgba(139, 92, 246, .16);}
.mb-ribbon {position: absolute; top: 16px; right: 16px; padding: 5px 10px; border-radius: 999px; background: linear-gradient(135deg, #f59e0b, #fbbf24); color: #111; font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: .04em;}
.mb-plan.is-premium .mb-ribbon {background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff;}
.mb-plan-name {font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: .06em; color: var(--muted);}
.mb-price {display: flex; align-items: baseline; gap: 6px; color: #f8fafc;}
.mb-price strong {font-size: 46px; font-weight: 900; line-height: 1;}
.mb-price span {font-size: 15px; color: var(--muted); font-weight: 700;}
.mb-monthly {font-size: 13px; color: #fbbf24; font-weight: 700;}
.mb-plan.is-premium .mb-monthly {color: #a5b4fc;}
.mb-features {list-style: none; margin: 0; padding: 0; display: grid; gap: 8px; color: #cbd5e1; font-size: 14px;}
.mb-features li {display: flex; gap: 8px; align-items: center;}
.mb-features li::before {content: '✓'; color: #34d399; font-weight: 900;}
.mb-features li.is-disabled {color: rgba(154, 168, 183, .55);}
.mb-features li.is-disabled::before {content: '✕'; color: #64748b;}
.mb-pay {margin-top: auto; width: 100%; min-height: 46px; border: 0; border-radius: 12px; cursor: pointer; font: inherit; font-size: 15px; font-weight: 800; color: #fff; background: linear-gradient(135deg, #635bff 0%, #7a73ff 100%); box-shadow: 0 12px 26px -8px rgba(99, 91, 255, .6); display: inline-flex; align-items: center; justify-content: center; gap: 8px; transition: transform .18s ease, box-shadow .18s ease, opacity .18s ease;}
.mb-pay:hover {transform: translateY(-1px); box-shadow: 0 16px 32px -8px rgba(99, 91, 255, .75);}
.mb-pay:disabled {opacity: .5; cursor: not-allowed; transform: none;}
.mb-secure {display: flex; align-items: center; justify-content: center; gap: 6px; color: var(--muted); font-size: 12px;}
.mb-box {border: 1px solid var(--line); border-radius: 18px; padding: 22px 24px; background: linear-gradient(180deg, rgba(255, 255, 255, .045), rgba(255, 255, 255, .015));}
.mb-box h3 {margin: 0 0 14px; font-size: 17px; color: #f8fafc;}
.mb-table {width: 100%; border-collapse: collapse; font-size: 14px;}
.mb-table th {text-align: left; padding: 10px 12px; font-size: 12px; text-transform: uppercase; color: var(--muted); border-bottom: 1px solid var(--line);}
.mb-table td {padding: 12px; border-bottom: 1px solid rgba(255, 255, 255, .06); color: #cbd5e1;}
.mb-badge {display: inline-flex; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 700;}
.mb-badge-paid, .mb-badge-granted {background: rgba(34, 197, 94, .15); color: #86efac;}
.mb-badge-pending {background: rgba(245, 158, 11, .15); color: #fcd34d;}
.mb-badge-failed {background: rgba(239, 68, 68, .15); color: #fca5a5;}
@media (max-width: 640px) {.mb-status {grid-template-columns: 1fr;} .mb-days {text-align: left;}}
</style>

@php
    $active = $user->hasActiveMembership();
    $daysLeft = $user->membershipDaysLeft();
    $onTrial = $user->isOnTrial();
    $planName = $user->currentPlanName();
    $defaultTab = $user->isPremium() ? 'premium' : 'basic';
    $totalDays = $onTrial ? \App\Models\User::TRIAL_DAYS : 365;
    $percent = $active ? min(100, max(4, round($daysLeft / max(1, $totalDays) * 100))) : 0;
    $basicPlans = $plans->where('tier', 'basic');
    $premiumPlans = $plans->where('tier', 'premium');
@endphp

<div class="mb-wrap">
    @if (session('status'))
        <div class="mb-alert mb-alert-ok">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
        <div class="mb-alert mb-alert-err">{{ $errors->first() }}</div>
    @endif
    @if ($cancelled)
        <div class="mb-alert mb-alert-warn">El pago fue cancelado. Puedes intentarlo nuevamente cuando quieras.</div>
    @endif
    @unless ($stripeReady)
        <div class="mb-alert mb-alert-warn">Los pagos en línea con Stripe se están configurando. Muy pronto podrás pagar tu plan desde aquí.</div>
    @endunless

    <section class="mb-status {{ $active ? '' : 'is-expired' }}" id="membership-status">
        <div>
            <div class="mb-kicker">
                @if (! $active) Membresía vencida @elseif ($onTrial) Prueba gratuita ({{ $user->currentTierLabel() }}) @else Membresía activa · Plan {{ $user->currentTierLabel() }} @endif
            </div>
            <h3>
                @if (! $active)
                    Renueva para seguir usando SISPROF
                @elseif ($onTrial)
                    Estás disfrutando {{ \App\Models\User::TRIAL_DAYS }} días gratis
                @else
                    Plan {{ $planName }}
                @endif
            </h3>
            <p>
                @if ($user->membership_ends_at)
                    {{ $active ? 'Vence el' : 'Venció el' }} {{ $user->membership_ends_at->format('d/m/Y H:i') }}. Tus datos están seguros y se conservan.
                @else
                    Elige un plan para activar tu cuenta.
                @endif
            </p>
            <div class="mb-progress"><span style="width: {{ $percent }}%"></span></div>
        </div>
        <div class="mb-days">
            <strong>{{ $daysLeft }}</strong>
            <small>{{ $daysLeft === 1 ? 'día restante' : 'días restantes' }}</small>
        </div>
    </section>

    <div class="mb-tabs-wrap">
        <div class="mb-tabs" role="tablist" aria-label="Tipo de plan">
            <button type="button" class="mb-tab {{ $defaultTab === 'basic' ? 'is-active' : '' }}" id="tab-btn-basic" onclick="switchMembershipTab('basic')" role="tab" aria-selected="{{ $defaultTab === 'basic' ? 'true' : 'false' }}">
                <span>Plan Básico</span>
            </button>
            <button type="button" class="mb-tab mb-tab-premium {{ $defaultTab === 'premium' ? 'is-active' : '' }}" id="tab-btn-premium" onclick="switchMembershipTab('premium')" role="tab" aria-selected="{{ $defaultTab === 'premium' ? 'true' : 'false' }}">
                <span>Plan Premium</span>
                <span class="mb-tab-badge">PRO</span>
            </button>
        </div>
        <p class="mb-tier-desc" id="mb-tier-hint">
            {{ $defaultTab === 'premium' ? 'Plan Premium: Hasta 2 empresas, hasta 2 monedas de LATAM/USD y Galería de Fotos para Proformas.' : 'Plan Básico: Ideal para 1 empresa con 1 moneda a elección (cualquier país de LATAM) y proformas ilimitadas.' }}
        </p>
    </div>

    <section class="mb-plans {{ $defaultTab === 'basic' ? 'is-active' : '' }}" id="tab-panel-basic" aria-label="Planes Básicos">
        @foreach ($basicPlans as $plan)
            <article class="mb-plan {{ $plan->is_featured ? 'is-featured' : '' }}" id="plan-{{ $plan->slug }}">
                @if ($plan->is_featured)
                    <span class="mb-ribbon">Mejor precio</span>
                @endif
                <div class="mb-plan-name">Plan Básico · {{ $plan->name }} ({{ $plan->durationLabel() }})</div>
                <div class="mb-price"><strong>${{ rtrim(rtrim(number_format($plan->price_usd, 2), '0'), '.') }}</strong><span>USD</span></div>
                <div class="mb-monthly">Equivale a ${{ number_format($plan->monthlyPrice(), 2) }} / mes</div>
                <ul class="mb-features">
                    <li>1 Empresa registrada</li>
                    <li>1 Moneda a elección (Todo LATAM / USD)</li>
                    <li>Proformas, clientes y productos ilimitados</li>
                    <li>Envío por correo y exportación PDF</li>
                    <li class="is-disabled">Sin 2da moneda simultánea (Multimoneda)</li>
                    <li class="is-disabled">Sin Galería de Fotos para Proformas</li>
                    <li class="is-disabled">Sin Multi-empresa (2 empresas)</li>
                </ul>
                <form method="post" action="{{ route('membership.checkout', $plan) }}">
                    @csrf
                    <button class="mb-pay" type="submit" id="pay-{{ $plan->slug }}" @disabled(! $stripeReady)>
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
                        Elegir Básico {{ $plan->name }}
                    </button>
                </form>
                <div class="mb-secure">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
                    Pago seguro con tarjeta vía Stripe
                </div>
            </article>
        @endforeach
    </section>

    <section class="mb-plans {{ $defaultTab === 'premium' ? 'is-active' : '' }}" id="tab-panel-premium" aria-label="Planes Premium">
        @foreach ($premiumPlans as $plan)
            <article class="mb-plan is-premium {{ $plan->is_featured ? 'is-featured' : '' }}" id="plan-{{ $plan->slug }}">
                @if ($plan->is_featured)
                    <span class="mb-ribbon">Más popular</span>
                @endif
                <div class="mb-plan-name">Plan Premium · {{ $plan->name }} ({{ $plan->durationLabel() }})</div>
                <div class="mb-price"><strong>${{ rtrim(rtrim(number_format($plan->price_usd, 2), '0'), '.') }}</strong><span>USD</span></div>
                <div class="mb-monthly">Equivale a ${{ number_format($plan->monthlyPrice(), 2) }} / mes</div>
                <ul class="mb-features">
                    <li><strong>Hasta 2 Empresas</strong> (Multi-empresa)</li>
                    <li><strong>Multimoneda PRO</strong> (Hasta 2 monedas de LATAM / USD)</li>
                    <li><strong>Galería de Fotos</strong> para incrustar en Proformas</li>
                    <li>Proformas, clientes y productos ilimitados</li>
                    <li>Envío por correo y exportación PDF</li>
                </ul>
                <form method="post" action="{{ route('membership.checkout', $plan) }}">
                    @csrf
                    <button class="mb-pay" type="submit" id="pay-{{ $plan->slug }}" @disabled(! $stripeReady)>
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
                        Elegir Premium {{ $plan->name }}
                    </button>
                </form>
                <div class="mb-secure">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
                    Pago seguro con tarjeta vía Stripe
                </div>
            </article>
        @endforeach
    </section>

    <p style="margin: -6px 0 0; color: var(--muted); font-size: 13px;">Si renuevas antes de que venza tu membresía, los meses se suman a tu fecha de vencimiento actual.</p>

    <section class="mb-box">
        <h3>Historial de pagos</h3>
        <div style="overflow-x: auto;">
            <table class="mb-table">
                <thead>
                    <tr><th>Fecha</th><th>Plan</th><th>Nivel</th><th>Monto</th><th>Periodo</th><th>Estado</th></tr>
                </thead>
                <tbody>
                    @forelse ($payments as $payment)
                        <tr>
                            <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $payment->plan?->name ?? '—' }}</td>
                            <td>{{ $payment->tierLabel() }}</td>
                            <td>${{ number_format($payment->amount_usd, 2) }}</td>
                            <td>{{ $payment->starts_at ? $payment->starts_at->format('d/m/Y').' – '.$payment->ends_at->format('d/m/Y') : '—' }}</td>
                            <td><span class="mb-badge mb-badge-{{ $payment->status }}">{{ $payment->statusLabel() }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="text-align: center; color: var(--muted); padding: 24px;">Aún no tienes pagos registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>

<script>
window.switchMembershipTab = function switchMembershipTab(tier) {
    const isPremium = tier === 'premium';
    const btnBasic = document.getElementById('tab-btn-basic');
    const btnPremium = document.getElementById('tab-btn-premium');
    const panelBasic = document.getElementById('tab-panel-basic');
    const panelPremium = document.getElementById('tab-panel-premium');
    const hint = document.getElementById('mb-tier-hint');

    if (btnBasic) {
        btnBasic.classList.toggle('is-active', !isPremium);
        btnBasic.setAttribute('aria-selected', String(!isPremium));
    }
    if (btnPremium) {
        btnPremium.classList.toggle('is-active', isPremium);
        btnPremium.setAttribute('aria-selected', String(isPremium));
    }
    if (panelBasic) panelBasic.classList.toggle('is-active', !isPremium);
    if (panelPremium) panelPremium.classList.toggle('is-active', isPremium);
    if (hint) {
        hint.textContent = isPremium
            ? 'Plan Premium: Hasta 2 empresas, Multimoneda (Soles/Dólares) y Galería de Fotos para Proformas.'
            : 'Plan Básico: Ideal para 1 empresa en Soles con proformas, clientes y productos ilimitados.';
    }
};
</script>
