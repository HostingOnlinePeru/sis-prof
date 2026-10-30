<style>
.mb-wrap {display: grid; gap: 26px;}
.mb-alert {border-radius: 12px; padding: 14px 18px; font-size: 14px; font-weight: 600;}
.mb-alert-ok {background: rgba(34, 197, 94, .12); border: 1px solid rgba(34, 197, 94, .35); color: #86efac;}
.mb-alert-err {background: rgba(239, 68, 68, .12); border: 1px solid rgba(239, 68, 68, .35); color: #fca5a5;}
.mb-alert-warn {background: rgba(245, 158, 11, .12); border: 1px solid rgba(245, 158, 11, .35); color: #fcd34d;}
.mb-hero {position: relative; overflow: hidden; text-align: center; padding: 38px 24px 30px; border-radius: 22px; border: 1px solid rgba(255, 255, 255, .08); background: radial-gradient(ellipse at 20% 0%, rgba(245, 158, 11, .22), transparent 55%), radial-gradient(ellipse at 85% 100%, rgba(139, 92, 246, .25), transparent 55%), linear-gradient(180deg, rgba(255, 255, 255, .05), rgba(255, 255, 255, .01));}
.mb-hero-eyebrow {display: inline-flex; align-items: center; gap: 8px; padding: 6px 14px; border-radius: 999px; background: rgba(255, 255, 255, .06); border: 1px solid rgba(255, 255, 255, .12); color: #fde68a; font-size: 12px; font-weight: 800; letter-spacing: .08em; text-transform: uppercase;}
.mb-hero-eyebrow i {width: 8px; height: 8px; border-radius: 50%; background: #34d399; box-shadow: 0 0 0 4px rgba(52, 211, 153, .2); animation: mbPulse 1.8s ease-in-out infinite;}
.mb-hero h2 {margin: 16px auto 10px; max-width: 760px; font-size: clamp(24px, 3.4vw, 36px); line-height: 1.15; font-weight: 900; color: #f8fafc; letter-spacing: -.02em;}
.mb-hero h2 em {font-style: normal; background: linear-gradient(90deg, #fbbf24, #f59e0b 40%, #a78bfa); -webkit-background-clip: text; background-clip: text; color: transparent;}
.mb-hero p {margin: 0 auto; max-width: 620px; color: #cbd5e1; font-size: 15px; line-height: 1.6;}
.mb-hero-stats {display: flex; justify-content: center; flex-wrap: wrap; gap: 12px 28px; margin-top: 22px;}
.mb-hero-stats div {display: flex; align-items: center; gap: 8px; color: #e2e8f0; font-size: 13px; font-weight: 700;}
.mb-hero-stats svg {color: #34d399; flex: none;}
.mb-status {position: relative; overflow: hidden; display: grid; grid-template-columns: minmax(0, 1fr) auto; gap: 20px; align-items: center; padding: 24px 28px; border-radius: 18px; border: 1px solid var(--line); background: radial-gradient(circle at 0% 0%, rgba(245, 158, 11, .16), transparent 55%), linear-gradient(180deg, rgba(255, 255, 255, .06), rgba(255, 255, 255, .02)); box-shadow: 0 22px 50px rgba(0, 0, 0, .28);}
.mb-status.is-expired {background: radial-gradient(circle at 0% 0%, rgba(239, 68, 68, .22), transparent 55%), linear-gradient(180deg, rgba(255, 255, 255, .06), rgba(255, 255, 255, .02));}
.mb-kicker {font-size: 12px; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; color: #fbbf24;}
.mb-status.is-expired .mb-kicker {color: #f87171;}
.mb-status h3 {margin: 6px 0 4px; font-size: 22px; color: #f8fafc;}
.mb-status p {margin: 0; color: var(--muted); font-size: 14px;}
.mb-progress {margin-top: 16px; height: 8px; border-radius: 999px; background: rgba(255, 255, 255, .08); overflow: hidden;}
.mb-progress span {display: block; height: 100%; border-radius: inherit; background: linear-gradient(90deg, #f59e0b, #fbbf24); transition: width .6s ease;}
.mb-days {text-align: center; min-width: 120px;}
.mb-days strong {display: block; font-size: 44px; line-height: 1; font-weight: 900; color: #f8fafc;}
.mb-days small {color: var(--muted); font-size: 12px; font-weight: 700; text-transform: uppercase;}
.mb-tabs-wrap {display: flex; flex-direction: column; align-items: center; gap: 12px;}
.mb-tabs {display: inline-flex; padding: 6px; border-radius: 16px; background: rgba(255, 255, 255, .04); border: 1px solid var(--line); gap: 6px;}
.mb-tab {border: 0; border-radius: 12px; padding: 12px 26px; font: inherit; font-size: 15px; font-weight: 800; color: var(--muted); background: transparent; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all .2s ease;}
.mb-tab:hover {color: #fff;}
.mb-tab.is-active {background: linear-gradient(135deg, #f59e0b, #fbbf24); color: #111827; box-shadow: 0 8px 20px rgba(245, 158, 11, .28);}
.mb-tab-premium.is-active {background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; box-shadow: 0 8px 22px rgba(99, 102, 241, .38);}
.mb-tab-badge {padding: 2px 8px; border-radius: 999px; font-size: 11px; font-weight: 900; text-transform: uppercase; background: rgba(255, 255, 255, .18); color: inherit;}
.mb-tier-desc {font-size: 14px; color: #cbd5e1; margin: 0; text-align: center; max-width: 680px;}
.mb-plans {display: none; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; align-items: stretch;}
.mb-plans.is-active {display: grid; animation: mbFade .35s ease;}
.mb-plan {position: relative; display: flex; flex-direction: column; gap: 14px; padding: 30px 24px 22px; border-radius: 20px; border: 1px solid var(--line); background: linear-gradient(180deg, rgba(255, 255, 255, .055), rgba(255, 255, 255, .02)); transition: transform .25s ease, border-color .25s ease, box-shadow .25s ease;}
.mb-plan:hover {transform: translateY(-6px); border-color: rgba(245, 158, 11, .5); box-shadow: 0 28px 60px rgba(0, 0, 0, .4);}
.mb-plan.is-premium:hover {border-color: rgba(139, 92, 246, .6);}
.mb-plan.is-featured {border: 2px solid rgba(245, 158, 11, .75); background: radial-gradient(circle at 100% 0%, rgba(245, 158, 11, .22), transparent 60%), linear-gradient(180deg, rgba(255, 255, 255, .08), rgba(255, 255, 255, .025)); box-shadow: 0 24px 60px rgba(245, 158, 11, .18);}
.mb-plan.is-premium.is-featured {border-color: rgba(139, 92, 246, .8); background: radial-gradient(circle at 100% 0%, rgba(139, 92, 246, .28), transparent 60%), linear-gradient(180deg, rgba(255, 255, 255, .08), rgba(255, 255, 255, .025)); box-shadow: 0 24px 60px rgba(139, 92, 246, .22);}
.mb-ribbon {position: absolute; top: -13px; left: 50%; transform: translateX(-50%); white-space: nowrap; padding: 6px 14px; border-radius: 999px; background: linear-gradient(135deg, #f59e0b, #fbbf24); color: #111; font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: .06em; box-shadow: 0 8px 18px rgba(245, 158, 11, .35);}
.mb-plan.is-premium .mb-ribbon {background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; box-shadow: 0 8px 18px rgba(139, 92, 246, .4);}
.mb-plan-head {display: flex; align-items: center; justify-content: space-between; gap: 10px;}
.mb-plan-name {font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: .06em; color: #e2e8f0;}
.mb-plan-dur {font-size: 12px; color: var(--muted); font-weight: 700;}
.mb-save {padding: 4px 10px; border-radius: 999px; background: rgba(52, 211, 153, .15); border: 1px solid rgba(52, 211, 153, .35); color: #6ee7b7; font-size: 11px; font-weight: 900; text-transform: uppercase; white-space: nowrap;}
.mb-price-row {display: grid; gap: 4px; padding: 16px 0 14px; border-top: 1px solid rgba(255, 255, 255, .07); border-bottom: 1px solid rgba(255, 255, 255, .07);}
.mb-price {display: flex; align-items: baseline; gap: 6px; color: #f8fafc;}
.mb-price strong {font-size: 52px; font-weight: 900; line-height: 1; letter-spacing: -.03em;}
.mb-price span {font-size: 15px; color: var(--muted); font-weight: 700;}
.mb-monthly {font-size: 14px; color: #fbbf24; font-weight: 800;}
.mb-plan.is-premium .mb-monthly {color: #c4b5fd;}
.mb-daily {font-size: 12px; color: var(--muted);}
.mb-features {list-style: none; margin: 0; padding: 0; display: grid; gap: 10px; color: #e2e8f0; font-size: 14px;}
.mb-features li {display: flex; gap: 10px; align-items: flex-start; line-height: 1.4;}
.mb-features li::before {content: '✓'; flex: none; display: grid; place-items: center; width: 20px; height: 20px; border-radius: 50%; background: rgba(52, 211, 153, .15); color: #34d399; font-size: 12px; font-weight: 900;}
.mb-plan.is-premium .mb-features li::before {background: rgba(139, 92, 246, .2); color: #c4b5fd;}
.mb-features li.is-disabled {color: rgba(154, 168, 183, .5);}
.mb-features li.is-disabled::before {content: '✕'; background: rgba(100, 116, 139, .15); color: #64748b;}
.mb-pay {margin-top: auto; width: 100%; min-height: 50px; border: 0; border-radius: 14px; cursor: pointer; font: inherit; font-size: 15px; font-weight: 800; color: #fff; background: linear-gradient(135deg, #635bff 0%, #7a73ff 100%); box-shadow: 0 12px 26px -8px rgba(99, 91, 255, .6); display: inline-flex; align-items: center; justify-content: center; gap: 8px; transition: transform .18s ease, box-shadow .18s ease, opacity .18s ease;}
.mb-plan.is-featured:not(.is-premium) .mb-pay {background: linear-gradient(135deg, #f59e0b, #fbbf24); color: #111827; box-shadow: 0 12px 28px -8px rgba(245, 158, 11, .6);}
.mb-plan.is-premium.is-featured .mb-pay {background: linear-gradient(135deg, #6366f1, #a855f7); box-shadow: 0 12px 28px -8px rgba(139, 92, 246, .7);}
.mb-pay:hover {transform: translateY(-2px); box-shadow: 0 16px 32px -8px rgba(99, 91, 255, .75);}
.mb-pay:disabled {opacity: .5; cursor: not-allowed; transform: none;}
.mb-secure {display: flex; align-items: center; justify-content: center; gap: 6px; color: var(--muted); font-size: 12px;}
.mb-upsell {display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; padding: 20px 24px; border-radius: 18px; border: 1px dashed rgba(139, 92, 246, .55); background: linear-gradient(90deg, rgba(99, 102, 241, .14), rgba(168, 85, 247, .08));}
.mb-upsell strong {display: block; color: #f8fafc; font-size: 16px; margin-bottom: 4px;}
.mb-upsell span {color: #cbd5e1; font-size: 14px;}
.mb-upsell button {border: 0; border-radius: 12px; padding: 12px 20px; font: inherit; font-weight: 800; font-size: 14px; color: #fff; cursor: pointer; background: linear-gradient(135deg, #6366f1, #a855f7); box-shadow: 0 10px 24px -8px rgba(139, 92, 246, .7); transition: transform .18s ease;}
.mb-upsell button:hover {transform: translateY(-2px);}
.mb-trust {display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px;}
.mb-trust-item {display: flex; gap: 12px; align-items: flex-start; padding: 16px; border-radius: 14px; border: 1px solid var(--line); background: rgba(255, 255, 255, .025);}
.mb-trust-item .ic {flex: none; display: grid; place-items: center; width: 38px; height: 38px; border-radius: 10px; background: rgba(245, 158, 11, .14); color: #fbbf24;}
.mb-trust-item strong {display: block; color: #f8fafc; font-size: 14px; margin-bottom: 2px;}
.mb-trust-item span {color: var(--muted); font-size: 13px; line-height: 1.45;}
.mb-box {border: 1px solid var(--line); border-radius: 18px; padding: 22px 24px; background: linear-gradient(180deg, rgba(255, 255, 255, .045), rgba(255, 255, 255, .015));}
.mb-box h3 {margin: 0 0 14px; font-size: 17px; color: #f8fafc;}
.mb-table {width: 100%; border-collapse: collapse; font-size: 14px;}
.mb-table th {text-align: left; padding: 10px 12px; font-size: 12px; text-transform: uppercase; color: var(--muted); border-bottom: 1px solid var(--line);}
.mb-table td {padding: 12px; border-bottom: 1px solid rgba(255, 255, 255, .06); color: #cbd5e1;}
.mb-compare th:not(:first-child), .mb-compare td:not(:first-child) {text-align: center;}
.mb-compare th.is-pro {color: #c4b5fd;}
.mb-compare td.is-pro {background: rgba(139, 92, 246, .06);}
.mb-yes {color: #34d399; font-weight: 900;}
.mb-no {color: #64748b; font-weight: 900;}
.mb-badge {display: inline-flex; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 700;}
.mb-badge-paid, .mb-badge-granted {background: rgba(34, 197, 94, .15); color: #86efac;}
.mb-badge-pending {background: rgba(245, 158, 11, .15); color: #fcd34d;}
.mb-badge-failed {background: rgba(239, 68, 68, .15); color: #fca5a5;}
.mb-faq {display: grid; gap: 10px;}
.mb-faq details {border: 1px solid rgba(255, 255, 255, .08); border-radius: 12px; padding: 14px 16px; background: rgba(255, 255, 255, .02); transition: border-color .2s ease;}
.mb-faq details[open] {border-color: rgba(245, 158, 11, .4);}
.mb-faq summary {cursor: pointer; list-style: none; display: flex; justify-content: space-between; gap: 12px; color: #f1f5f9; font-weight: 700; font-size: 14px;}
.mb-faq summary::-webkit-details-marker {display: none;}
.mb-faq summary::after {content: '+'; color: #fbbf24; font-weight: 900; font-size: 18px; line-height: 1; transition: transform .2s ease;}
.mb-faq details[open] summary::after {transform: rotate(45deg);}
.mb-faq p {margin: 10px 0 0; color: var(--muted); font-size: 14px; line-height: 1.6;}
.mb-note {margin: -8px 0 0; text-align: center; color: var(--muted); font-size: 13px;}
@keyframes mbFade {from {opacity: 0; transform: translateY(8px);} to {opacity: 1; transform: none;}}
@keyframes mbPulse {0%, 100% {box-shadow: 0 0 0 4px rgba(52, 211, 153, .2);} 50% {box-shadow: 0 0 0 8px rgba(52, 211, 153, 0);}}
@media (max-width: 640px) {.mb-status {grid-template-columns: 1fr;} .mb-days {text-align: left;} .mb-tab {padding: 10px 16px; font-size: 14px;}}
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
    $fmt = fn ($v) => rtrim(rtrim(number_format($v, 2), '0'), '.');
    $months = fn ($p) => max(1, (int) round($p->price_usd / max(0.01, $p->monthlyPrice())));
    $maxMonthly = fn ($set) => $set->max(fn ($p) => $p->monthlyPrice()) ?: 0;
    $basicMax = $maxMonthly($basicPlans);
    $premiumMax = $maxMonthly($premiumPlans);
    $savePct = fn ($p, $max) => $max > 0 ? (int) round((1 - $p->monthlyPrice() / $max) * 100) : 0;
    $lockIcon = '<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>';
    $cardIcon = '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>';
    $checkIcon = '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>';
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

    <section class="mb-hero" id="membership-hero">
        <span class="mb-hero-eyebrow"><i></i> Planes SISPROF</span>
        <h2>Cotiza como un profesional y <em>cierra más ventas</em> desde hoy</h2>
        <p>Proformas impecables en segundos, enviadas por correo o PDF con tu marca. Elige el plan que impulsa tu negocio, por menos de lo que cuesta un café al mes.</p>
        <div class="mb-hero-stats">
            <div>{!! $checkIcon !!} Proformas ilimitadas</div>
            <div>{!! $checkIcon !!} Activación inmediata</div>
            <div>{!! $checkIcon !!} Sin contratos ni renovación automática</div>
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
            {{ $defaultTab === 'premium' ? 'Plan Premium: Hasta 2 empresas, hasta 2 monedas de LATAM/USD, Módulo de Productos (máx. 20) y Galería de Fotos.' : 'Plan Básico: Ideal para 1 empresa con 1 moneda a elección (cualquier país de LATAM) y proformas ilimitadas.' }}
        </p>
    </div>

    <section class="mb-plans {{ $defaultTab === 'basic' ? 'is-active' : '' }}" id="tab-panel-basic" aria-label="Planes Básicos">
        @foreach ($basicPlans as $plan)
            @php $pct = $savePct($plan, $basicMax); $m = $months($plan); @endphp
            <article class="mb-plan {{ $plan->is_featured ? 'is-featured' : '' }}" id="plan-{{ $plan->slug }}">
                @if ($plan->is_featured)
                    <span class="mb-ribbon">★ Mejor precio</span>
                @endif
                <div class="mb-plan-head">
                    <div>
                        <div class="mb-plan-name">Básico · {{ $plan->name }}</div>
                        <div class="mb-plan-dur">{{ $plan->durationLabel() }}</div>
                    </div>
                    @if ($pct > 0)
                        <span class="mb-save">Ahorra {{ $pct }}%</span>
                    @endif
                </div>
                <div class="mb-price-row">
                    <div class="mb-price"><strong>${{ $fmt($plan->price_usd) }}</strong><span>USD</span></div>
                    <div class="mb-monthly">Solo ${{ number_format($plan->monthlyPrice(), 2) }} / mes</div>
                    <div class="mb-daily">Menos de ${{ number_format(ceil($plan->price_usd / ($m * 30) * 100) / 100, 2) }} al día · pago único</div>
                </div>
                <ul class="mb-features">
                    <li>1 Empresa registrada</li>
                    <li>1 Moneda a elección (Todo LATAM / USD)</li>
                    <li>Proformas y clientes ilimitados</li>
                    <li>Envío por correo y exportación PDF</li>
                    <li class="is-disabled">Módulo de Productos</li>
                    <li class="is-disabled">Multimoneda (2da moneda)</li>
                    <li class="is-disabled">Galería de Fotos en Proformas</li>
                    <li class="is-disabled">Multi-empresa (2 empresas)</li>
                </ul>
                <form method="post" action="{{ route('membership.checkout', $plan) }}">
                    @csrf
                    <button class="mb-pay" type="submit" id="pay-{{ $plan->slug }}" @disabled(! $stripeReady)>
                        {!! $cardIcon !!} Elegir Básico {{ $plan->name }}
                    </button>
                </form>
                <div class="mb-secure">{!! $lockIcon !!} Pago seguro con tarjeta vía Stripe</div>
            </article>
        @endforeach
    </section>

    <section class="mb-plans {{ $defaultTab === 'premium' ? 'is-active' : '' }}" id="tab-panel-premium" aria-label="Planes Premium">
        @foreach ($premiumPlans as $plan)
            @php $pct = $savePct($plan, $premiumMax); $m = $months($plan); @endphp
            <article class="mb-plan is-premium {{ $plan->is_featured ? 'is-featured' : '' }}" id="plan-{{ $plan->slug }}">
                @if ($plan->is_featured)
                    <span class="mb-ribbon">★ Más popular</span>
                @endif
                <div class="mb-plan-head">
                    <div>
                        <div class="mb-plan-name">Premium · {{ $plan->name }}</div>
                        <div class="mb-plan-dur">{{ $plan->durationLabel() }}</div>
                    </div>
                    @if ($pct > 0)
                        <span class="mb-save">Ahorra {{ $pct }}%</span>
                    @endif
                </div>
                <div class="mb-price-row">
                    <div class="mb-price"><strong>${{ $fmt($plan->price_usd) }}</strong><span>USD</span></div>
                    <div class="mb-monthly">Solo ${{ number_format($plan->monthlyPrice(), 2) }} / mes</div>
                    <div class="mb-daily">Menos de ${{ number_format(ceil($plan->price_usd / ($m * 30) * 100) / 100, 2) }} al día · pago único</div>
                </div>
                <ul class="mb-features">
                    <li><span><strong>Hasta 2 Empresas</strong> (Multi-empresa)</span></li>
                    <li><span><strong>Multimoneda PRO</strong> (2 monedas LATAM / USD)</span></li>
                    <li><span><strong>Módulo de Productos</strong> (hasta 20)</span></li>
                    <li><span><strong>Galería de Fotos</strong> en tus Proformas</span></li>
                    <li>Proformas y clientes ilimitados</li>
                    <li>Envío por correo y exportación PDF</li>
                </ul>
                <form method="post" action="{{ route('membership.checkout', $plan) }}">
                    @csrf
                    <button class="mb-pay" type="submit" id="pay-{{ $plan->slug }}" @disabled(! $stripeReady)>
                        {!! $cardIcon !!} Elegir Premium {{ $plan->name }}
                    </button>
                </form>
                <div class="mb-secure">{!! $lockIcon !!} Pago seguro con tarjeta vía Stripe</div>
            </article>
        @endforeach
    </section>

    <div class="mb-upsell" id="mb-upsell" @if ($defaultTab === 'premium') hidden @endif>
        <div>
            <strong>🚀 ¿Vendes productos o manejas 2 empresas?</strong>
            <span>Con Premium sumas catálogo de productos, fotos en tus proformas y multimoneda. Impresiona a tus clientes.</span>
        </div>
        <button type="button" id="mb-upsell-btn" onclick="switchMembershipTab('premium')">Ver planes PRO →</button>
    </div>

    <p class="mb-note">Si renuevas antes de que venza tu membresía, los meses se suman a tu fecha de vencimiento actual.</p>

    <section class="mb-trust" aria-label="Garantías">
        <div class="mb-trust-item">
            <div class="ic">{!! $lockIcon !!}</div>
            <div><strong>Pago 100% seguro</strong><span>Procesado por Stripe. Nunca guardamos los datos de tu tarjeta.</span></div>
        </div>
        <div class="mb-trust-item">
            <div class="ic"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M13 2 3 14h9l-1 8 10-12h-9l1-8z"/></svg></div>
            <div><strong>Activación inmediata</strong><span>Tu plan se activa al instante tras confirmar el pago.</span></div>
        </div>
        <div class="mb-trust-item">
            <div class="ic"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
            <div><strong>Tus datos protegidos</strong><span>Aunque venza tu plan, tus proformas y clientes se conservan.</span></div>
        </div>
        <div class="mb-trust-item">
            <div class="ic"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M21 12a9 9 0 1 1-3-6.7L21 8"/><path d="M21 3v5h-5"/></svg></div>
            <div><strong>Sin cobros automáticos</strong><span>Pagas una sola vez por periodo. Tú decides cuándo renovar.</span></div>
        </div>
    </section>

    <section class="mb-box" id="membership-compare">
        <h3>Compara los planes</h3>
        <div style="overflow-x: auto;">
            <table class="mb-table mb-compare">
                <thead>
                    <tr><th>Característica</th><th>Básico</th><th class="is-pro">Premium PRO</th></tr>
                </thead>
                <tbody>
                    <tr><td>Proformas y clientes</td><td>Ilimitados</td><td class="is-pro">Ilimitados</td></tr>
                    <tr><td>Envío por correo y PDF</td><td class="mb-yes">✓</td><td class="is-pro mb-yes">✓</td></tr>
                    <tr><td>Empresas</td><td>1</td><td class="is-pro"><strong>2</strong></td></tr>
                    <tr><td>Monedas simultáneas</td><td>1</td><td class="is-pro"><strong>2</strong></td></tr>
                    <tr><td>Módulo de Productos</td><td class="mb-no">✕</td><td class="is-pro"><strong>Hasta 20</strong></td></tr>
                    <tr><td>Galería de Fotos en Proformas</td><td class="mb-no">✕</td><td class="is-pro mb-yes">✓</td></tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="mb-box" id="membership-faq">
        <h3>Preguntas frecuentes</h3>
        <div class="mb-faq">
            <details><summary>¿Se renueva automáticamente?</summary><p>No. Es un pago único por el periodo elegido. Te avisaremos antes del vencimiento para que renueves si lo deseas.</p></details>
            <details><summary>¿Puedo pasar de Básico a Premium?</summary><p>Sí. Puedes adquirir un plan Premium en cualquier momento y desbloquear al instante productos, galería, multimoneda y multi-empresa.</p></details>
            <details><summary>¿Qué pasa con mis datos si vence mi plan?</summary><p>Tus proformas, clientes y configuración se conservan de forma segura. Al renovar, todo vuelve a estar disponible.</p></details>
            <details><summary>¿Qué medios de pago aceptan?</summary><p>Tarjetas de crédito y débito Visa, Mastercard y American Express a través de Stripe.</p></details>
        </div>
    </section>

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
    const upsell = document.getElementById('mb-upsell');

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
    if (upsell) upsell.hidden = isPremium;
    if (hint) {
        hint.textContent = isPremium
            ? 'Plan Premium: Hasta 2 empresas, hasta 2 monedas de LATAM/USD, Módulo de Productos (máx. 20) y Galería de Fotos.'
            : 'Plan Básico: Ideal para 1 empresa con 1 moneda a elección (cualquier país de LATAM) y proformas ilimitadas.';
    }
    if (isPremium && panelPremium && event && event.currentTarget && event.currentTarget.id === 'mb-upsell-btn') {
        panelPremium.scrollIntoView({behavior: 'smooth', block: 'start'});
    }
};
</script>
