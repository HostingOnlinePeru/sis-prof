<style>
.tpl-store-grid {display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px; margin-top: 24px;}
.tpl-card {background: linear-gradient(180deg, rgba(255, 255, 255, 0.04), rgba(255, 255, 255, 0.015)); border: 1px solid var(--line); border-radius: 16px; overflow: hidden; display: flex; flex-direction: column; transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;}
.tpl-card:hover {transform: translateY(-3px); border-color: rgba(99, 102, 241, 0.45); box-shadow: 0 16px 36px rgba(0, 0, 0, 0.35);}
.tpl-card-top {position: relative; height: 180px; background: #0c1322; border-bottom: 1px solid var(--line); display: flex; align-items: center; justify-content: center; overflow: hidden; cursor: pointer;}
.tpl-badge-bar {position: absolute; top: 12px; left: 12px; right: 12px; display: flex; justify-content: space-between; align-items: center; z-index: 2;}
.tpl-badge {font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 9999px; text-transform: uppercase; letter-spacing: 0.5px;}
.tpl-badge-free {background: rgba(34, 197, 94, 0.2); color: #86efac; border: 1px solid rgba(34, 197, 94, 0.35);}
.tpl-badge-premium {background: rgba(245, 158, 11, 0.2); color: #fde68a; border: 1px solid rgba(245, 158, 11, 0.4);}
.tpl-badge-cat {background: rgba(15, 23, 42, 0.85); color: #cbd5e1; border: 1px solid var(--line); backdrop-filter: blur(4px);}
.tpl-preview-thumb {width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;}
.tpl-card-top:hover .tpl-preview-thumb {transform: scale(1.04);}
.tpl-mockup-wrap {display: flex; flex-direction: column; align-items: center; justify-content: center; width: 100%; height: 100%; padding: 20px;}
.tpl-mockup-sheet {width: 130px; height: 150px; background: #ffffff; border-radius: 4px; box-shadow: 0 10px 25px rgba(0,0,0,0.4); padding: 8px; display: flex; flex-direction: column; justify-content: space-between;}
.tpl-card-body {padding: 20px; display: flex; flex-direction: column; flex-grow: 1;}
.tpl-card-title {font-size: 17px; font-weight: 700; color: #f8fafc; margin: 0 0 8px 0;}
.tpl-card-desc {font-size: 12.5px; color: #94a3b8; line-height: 1.5; margin-bottom: 16px; flex-grow: 1;}
.tpl-palette-row {display: flex; align-items: center; gap: 8px; margin-bottom: 16px;}
.tpl-palette-label {font-size: 11px; font-weight: 600; color: var(--muted); text-transform: uppercase;}
.tpl-palette-dot {width: 14px; height: 14px; border-radius: 50%; border: 1px solid rgba(255, 255, 255, 0.2);}
.tpl-card-footer {border-top: 1px solid rgba(255, 255, 255, 0.06); padding-top: 16px; display: flex; gap: 10px; align-items: center; flex-wrap: wrap;}
.tpl-btn-preview {background: rgba(255, 255, 255, 0.08); color: #f8fafc; border: 1px solid var(--line); padding: 8px 14px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: background 0.15s ease;}
.tpl-btn-preview:hover {background: rgba(255, 255, 255, 0.14);}
.tpl-btn-buy {background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%); color: #0f172a; border: none; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: transform 0.15s ease, opacity 0.15s ease;}
.tpl-btn-buy:hover {transform: translateY(-1px); opacity: 0.95;}
.tpl-btn-default {background: rgba(99, 102, 241, 0.15); color: #a5b4fc; border: 1px solid rgba(99, 102, 241, 0.35); padding: 7px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer; text-decoration: none;}
.tpl-btn-default:hover {background: rgba(99, 102, 241, 0.25);}
.tpl-status-unlocked {font-size: 12px; font-weight: 700; color: #34d399; display: inline-flex; align-items: center; gap: 4px;}
.tpl-banner-info {background: linear-gradient(135deg, rgba(79, 70, 229, 0.12), rgba(14, 165, 233, 0.08)); border: 1px solid rgba(99, 102, 241, 0.25); border-radius: 14px; padding: 18px 22px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap;}
.tpl-modal-backdrop {display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.75); backdrop-filter: blur(5px); z-index: 99999; align-items: center; justify-content: center; padding: 20px;}
.tpl-modal-backdrop.active {display: flex;}
.tpl-modal-box {background: #0f172a; border: 1px solid var(--line); border-radius: 18px; width: 100%; max-width: 900px; height: 90vh; display: flex; flex-direction: column; overflow: hidden; box-shadow: 0 25px 60px rgba(0, 0, 0, 0.6);}
.tpl-modal-header {padding: 16px 24px; border-bottom: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center; background: rgba(255, 255, 255, 0.02);}
.tpl-modal-body {flex-grow: 1; overflow: hidden; background: #1e293b; display: flex; justify-content: center; padding: 16px;}
.tpl-modal-iframe {width: 100%; max-width: 800px; height: 100%; border: 1px solid #334155; border-radius: 8px; background: #ffffff; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);}
.tpl-modal-close {background: transparent; border: none; color: #94a3b8; font-size: 24px; cursor: pointer; padding: 4px 8px; border-radius: 6px; line-height: 1;}
.tpl-modal-close:hover {color: #ffffff; background: rgba(255, 255, 255, 0.1);}
</style>

@if (session('status'))
    <div class="notice" style="margin-bottom: 20px;">{{ session('status') }}</div>
@endif

@if ($cancelled)
    <div class="errors" style="margin-bottom: 20px;"><div>El proceso de desbloqueo fue cancelado. Puedes retomarlo cuando desees.</div></div>
@endif

<div class="tpl-banner-info">
    <div>
        <h3 style="font-size: 16px; font-weight: 700; color: #f8fafc; margin: 0 0 6px 0;">Catálogo de Modelos para Cotizaciones</h3>
        <p style="font-size: 13px; color: #cbd5e1; margin: 0; line-height: 1.5;">
            Todos los planes (<strong>Básico</strong>, <strong>Stándar</strong> y <strong>Corporativo</strong>) cuentan con los <strong>2 modelos base gratuitos</strong> incluidos sin costo.<br>
            Si deseas un diseño exclusivo con mayor presencia de marca, puedes desbloquear plantillas <strong>Premium</strong> por un pago único de <strong>$5.00 USD</strong> por modelo.
        </p>
    </div>
    <div style="text-align: right;">
        <span class="tpl-badge tpl-badge-free" style="margin-right: 6px;">2 Gratuitas</span>
        <span class="tpl-badge tpl-badge-premium">$5.00 USD c/u</span>
    </div>
</div>

<div class="tpl-store-grid">
    @foreach ($templates as $template)
        @php
            $isUnlocked = $template['is_unlocked'];
            $isDefault = $defaultTemplate === $template['slug'];
            $primaryColor = $template['styles']['primary_color'] ?? '#0f3b57';
            $accentColor = $template['styles']['accent_color'] ?? '#f5a400';
            $bgColor = $template['styles']['background_color'] ?? '#ffffff';
        @endphp
        <div class="tpl-card">
            <div class="tpl-card-top" onclick="openTemplatePreview('{{ $template['slug'] }}', '{{ addslashes($template['name']) }}')">
                <div class="tpl-badge-bar">
                    <span class="tpl-badge tpl-badge-cat">{{ $template['category'] }}</span>
                    @if ($template['is_free'])
                        <span class="tpl-badge tpl-badge-free">Gratuita</span>
                    @else
                        <span class="tpl-badge tpl-badge-premium">$5.00 USD</span>
                    @endif
                </div>

                <div class="tpl-mockup-wrap">
                    <div class="tpl-mockup-sheet" style="background: {{ $bgColor }}; border-top: 4px solid {{ $primaryColor }};">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="width: 32px; height: 10px; background: {{ $primaryColor }}; border-radius: 2px;"></div>
                            <div style="width: 24px; height: 6px; background: {{ $accentColor }}; border-radius: 2px;"></div>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 4px; margin: 6px 0;">
                            <div style="width: 100%; height: 3px; background: #e2e8f0;"></div>
                            <div style="width: 80%; height: 3px; background: #e2e8f0;"></div>
                            <div style="width: 90%; height: 3px; background: #e2e8f0;"></div>
                        </div>
                        <div style="height: 20px; background: {{ $primaryColor }}; border-radius: 2px; display: flex; align-items: center; justify-content: flex-end; padding: 0 4px;">
                            <div style="width: 20px; height: 4px; background: {{ $accentColor }};"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tpl-card-body">
                <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 6px;">
                    <h3 class="tpl-card-title">{{ $template['name'] }}</h3>
                    @if ($isDefault)
                        <span style="font-size: 11px; font-weight: 700; color: #818cf8; background: rgba(99, 102, 241, 0.15); padding: 2px 8px; border-radius: 6px;">Predeterminada</span>
                    @endif
                </div>

                <p class="tpl-card-desc">{{ $template['description'] }}</p>

                <div class="tpl-palette-row">
                    <span class="tpl-palette-label">Paleta:</span>
                    <span class="tpl-palette-dot" style="background: {{ $primaryColor }};" title="Color primario"></span>
                    <span class="tpl-palette-dot" style="background: {{ $accentColor }};" title="Color acento"></span>
                    <span class="tpl-palette-dot" style="background: {{ $bgColor }};" title="Fondo"></span>
                </div>

                <div class="tpl-card-footer">
                    <button type="button" class="tpl-btn-preview" onclick="openTemplatePreview('{{ $template['slug'] }}', '{{ addslashes($template['name']) }}')">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:15px;height:15px;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        Vista Previa
                    </button>

                    @if ($isUnlocked)
                        <span class="tpl-status-unlocked">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:15px;height:15px;"><polyline points="20 6 9 17 4 12"/></svg>
                            Desbloqueada
                        </span>
                        @if (! $isDefault)
                            <form action="{{ route('templates.set-default', $template['slug']) }}" method="POST" style="margin-left: auto;">
                                @csrf
                                <button type="submit" class="tpl-btn-default" title="Usar como modelo por defecto al crear proformas">
                                    Usar por defecto
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('templates.payment', $template['slug']) }}" class="tpl-btn-buy" data-ajax-link data-nav="templates" title="Pagar y desbloquear por $5.00 USD" style="margin-left: auto;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" style="width:14px;height:14px;"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            Desbloquear ($5.00)
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>

<div id="tplModal" class="tpl-modal-backdrop" onclick="if(event.target === this) closeTemplatePreview()">
    <div class="tpl-modal-box">
        <div class="tpl-modal-header">
            <div>
                <h3 id="tplModalTitle" style="margin: 0; font-size: 17px; font-weight: 700; color: #f8fafc;">Vista Previa</h3>
                <span style="font-size: 12px; color: var(--muted);">Renderizado con datos de cotización de muestra</span>
            </div>
            <div style="display: flex; gap: 10px; align-items: center;">
                <a id="tplModalPdfBtn" href="#" target="_blank" class="tpl-btn-preview" style="font-size: 12px; padding: 6px 12px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Abrir en PDF
                </a>
                <button type="button" class="tpl-modal-close" onclick="closeTemplatePreview()">&times;</button>
            </div>
        </div>
        <div class="tpl-modal-body">
            <iframe id="tplModalFrame" class="tpl-modal-iframe" src="about:blank"></iframe>
        </div>
    </div>
</div>

<script>
function openTemplatePreview(slug, name) {
    const modal = document.getElementById('tplModal');
    const frame = document.getElementById('tplModalFrame');
    const title = document.getElementById('tplModalTitle');
    const pdfBtn = document.getElementById('tplModalPdfBtn');

    title.textContent = name;
    frame.src = '/admin/plantillas/' + encodeURIComponent(slug) + '/vista-previa';
    pdfBtn.href = '/admin/plantillas/' + encodeURIComponent(slug) + '/vista-previa?pdf=1';
    modal.classList.add('active');
}

function closeTemplatePreview() {
    const modal = document.getElementById('tplModal');
    const frame = document.getElementById('tplModalFrame');
    frame.src = 'about:blank';
    modal.classList.remove('active');
}
</script>
