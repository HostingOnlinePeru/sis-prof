@php
    $dashboardLogo = \App\Http\Controllers\CompanyProfileController::publicLogoUrl($company->dashboard_logo_path ?: $company->proforma_logo_path ?: $company->logo_path);
    $proformaLogo = \App\Http\Controllers\CompanyProfileController::publicLogoUrl($company->proforma_logo_path ?: $company->dashboard_logo_path ?: $company->logo_path);
@endphp

@if (session('status'))
    <div class="notice">{{ session('status') }}</div>
@endif

<section class="panel" style="margin-bottom: 18px;">
    <div class="sp-section-title">
        <div>
            <h3>Empresa activa: {{ $company->business_name ?: 'Nueva empresa' }}</h3>
            <p class="muted" style="margin: 6px 0 0;">Los clientes, productos, términos, documentos y proformas se guardan por separado para cada empresa.</p>
        </div>
        <button class="button secondary" type="button" data-open-modal="newCompanyModal">Nueva empresa</button>
    </div>
</section>

<form class="panel" method="post" action="{{ route('company.update') }}" enctype="multipart/form-data">
    @csrf
    @if ($company->id)
        <input type="hidden" name="company_id" value="{{ $company->id }}">
    @endif

    <div class="company-grid">
        <div class="field">
            <label for="business_name">Nombre de la Empresa</label>
            <input id="business_name" name="business_name" value="{{ old('business_name', $company->business_name) }}" required>
            @error('business_name') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="tax_id">RUC</label>
            <input id="tax_id" name="tax_id" value="{{ old('tax_id', $company->tax_id) }}">
            @error('tax_id') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="default_currency">Moneda</label>
            <select id="default_currency" name="default_currency" required>
                <option value="PEN" @selected(old('default_currency', $company->default_currency ?: 'PEN') === 'PEN')>Soles (PEN)</option>
                <option value="USD" @selected(old('default_currency', $company->default_currency) === 'USD')>Dólares (USD)</option>
            </select>
            @error('default_currency') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="default_proforma_template">Modelo predeterminado de proforma</label>
            <select id="default_proforma_template" name="default_proforma_template" required>
                <option value="commercial" @selected(old('default_proforma_template', $company->default_proforma_template ?: 'commercial') === 'commercial')>Modelo 1</option>
                <option value="technical" @selected(old('default_proforma_template', $company->default_proforma_template) === 'technical')>Modelo 2</option>
            </select>
            @error('default_proforma_template') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="phone">Teléfono Móvil 1</label>
            <input id="phone" name="phone" value="{{ old('phone', $company->phone) }}">
            @error('phone') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="mobile_phone">Teléfono Móvil 2</label>
            <input id="mobile_phone" name="mobile_phone" value="{{ old('mobile_phone', $company->mobile_phone) }}">
            @error('mobile_phone') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field full">
            <label for="address">Dirección de la Empresa</label>
            <input id="address" name="address" value="{{ old('address', $company->address) }}">
            @error('address') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field full">
            <label for="website">Sitio web</label>
            <input id="website" name="website" value="{{ old('website', $company->website) }}" placeholder="www.toldosyestructurasperu.com">
            @error('website') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field full">
            <label for="dashboard_logo">Subir logo de la empresa</label>
            <div class="logo-row">
                <div class="preview" data-logo-preview="dashboard_logo">
                    @if ($dashboardLogo)
                        <img src="{{ $dashboardLogo }}" alt="Logo de dashboard">
                    @else
                        Sin logo
                    @endif
                </div>
                <input id="dashboard_logo" name="dashboard_logo" type="file" accept="image/*,.svg,image/svg+xml" data-logo-input="dashboard_logo">
            </div>
            @error('dashboard_logo') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field full">
            <label for="proforma_logo">Logo de proforma</label>
            <div class="logo-row">
                <div class="preview" data-logo-preview="proforma_logo">
                    @if ($proformaLogo)
                        <img src="{{ $proformaLogo }}" alt="Logo de proforma">
                    @else
                        Sin logo
                    @endif
                </div>
                <input id="proforma_logo" name="proforma_logo" type="file" accept="image/*,.svg,image/svg+xml" data-logo-input="proforma_logo">
            </div>
            @error('proforma_logo') <div class="error">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="actions">
        <button class="button" type="submit">Guardar</button>
    </div>
</form>

<div id="newCompanyModal" class="modal-backdrop" aria-hidden="true">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Crear nueva empresa</h3>
            <button class="icon-button" type="button" data-close-modal aria-label="Cerrar">×</button>
        </div>
        <form method="post" action="{{ route('company.store') }}">
            @csrf
            <label for="new_company_name">Nombre o razón social</label>
            <input id="new_company_name" name="business_name" required placeholder="Ej. Mi nueva empresa">
            <div class="actions">
                <button class="button secondary" type="button" data-close-modal>Cancelar</button>
                <button class="button" type="submit">Crear empresa</button>
            </div>
        </form>
    </div>
</div>
