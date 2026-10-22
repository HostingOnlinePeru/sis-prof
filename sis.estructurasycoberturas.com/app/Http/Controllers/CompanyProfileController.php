<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use App\Support\AppShell;
use App\Support\CompanyContext;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CompanyProfileController extends Controller
{
    public function edit(Request $request): View|JsonResponse
    {
        return AppShell::render($request, [
            'activePage' => 'company',
            'subtitle' => 'Esta información se usará en el dashboard y en las proformas generadas.',
            'title' => 'Datos de la Empresa',
        ], 'company.partial', [
            'company' => app(CompanyContext::class)->active() ?? new CompanySetting([
                'default_currency' => 'PEN',
            ]),
        ]);
    }

    public function update(Request $request): RedirectResponse|JsonResponse|View
    {
        $data = $request->validate([
            'business_name' => ['required', 'string', 'max:255'],
            'tax_id' => ['nullable', 'string', 'max:20'],
            'default_currency' => ['required', 'in:PEN,USD'],
            'default_proforma_template' => ['required', 'in:commercial,technical'],
            'address' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
            'mobile_phone' => ['nullable', 'string', 'max:40'],
            'dashboard_logo' => [
                'nullable',
                function ($attribute, $value, $fail) use ($request) {
                    if (! $request->hasFile($attribute)) {
                        return;
                    }
                    $file = $request->file($attribute);
                    if (! $file->isValid()) {
                        $fail('El archivo de logo no se pudo cargar correctamente.');
                        return;
                    }
                    if ($file->getSize() > 4096 * 1024) {
                        $fail('El logo no debe pesar más de 4 MB.');
                        return;
                    }
                    $ext = strtolower($file->getClientOriginalExtension());
                    if (! in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'], true)) {
                        $fail('El logo debe ser un archivo de imagen válido (JPG, PNG, GIF, WEBP o SVG).');
                    }
                },
            ],
            'proforma_logo' => [
                'nullable',
                function ($attribute, $value, $fail) use ($request) {
                    if (! $request->hasFile($attribute)) {
                        return;
                    }
                    $file = $request->file($attribute);
                    if (! $file->isValid()) {
                        $fail('El archivo de logo no se pudo cargar correctamente.');
                        return;
                    }
                    if ($file->getSize() > 4096 * 1024) {
                        $fail('El logo no debe pesar más de 4 MB.');
                        return;
                    }
                    $ext = strtolower($file->getClientOriginalExtension());
                    if (! in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'], true)) {
                        $fail('El logo debe ser un archivo de imagen válido (JPG, PNG, GIF, WEBP o SVG).');
                    }
                },
            ],
        ]);

        unset($data['dashboard_logo'], $data['proforma_logo']);

        $companyId = $request->input('company_id');
        if ($companyId) {
            $company = CompanySetting::query()->find($companyId) ?? app(CompanyContext::class)->active() ?? new CompanySetting();
        } else {
            $company = app(CompanyContext::class)->active() ?? new CompanySetting();
        }

        if ($request->hasFile('dashboard_logo')) {
            $file = $request->file('dashboard_logo');
            if ($file->isValid() && $file->getSize() > 0) {
                if ($company->dashboard_logo_path && Storage::disk('public')->exists($company->dashboard_logo_path)) {
                    Storage::disk('public')->delete($company->dashboard_logo_path);
                }
                $storedPath = $file->store('company/logos', 'public');
                $data['dashboard_logo_path'] = $storedPath;

                if (empty($company->proforma_logo_path) && ! isset($data['proforma_logo_path'])) {
                    $data['proforma_logo_path'] = $storedPath;
                }
            }
        }

        if ($request->hasFile('proforma_logo')) {
            $file = $request->file('proforma_logo');
            if ($file->isValid() && $file->getSize() > 0) {
                if ($company->proforma_logo_path && Storage::disk('public')->exists($company->proforma_logo_path)) {
                    Storage::disk('public')->delete($company->proforma_logo_path);
                }
                $storedPath = $file->store('company/logos', 'public');
                $data['proforma_logo_path'] = $storedPath;

                if (empty($company->dashboard_logo_path) && ! isset($data['dashboard_logo_path'])) {
                    $data['dashboard_logo_path'] = $storedPath;
                }
            }
        }

        $company->fill($data);
        $company->save();

        app(CompanyContext::class)->switchTo($company);

        session()->flash('status', 'Datos de empresa guardados correctamente.');

        if ($request->header('X-App-Partial') === '1' || $request->expectsJson()) {
            return AppShell::render($request, [
                'activePage' => 'company',
                'subtitle' => 'Esta información se usará en el dashboard y en las proformas generadas.',
                'title' => 'Datos de la Empresa',
            ], 'company.partial', [
                'company' => $company,
            ]);
        }

        return redirect()
            ->route('company.edit')
            ->with('status', 'Datos de empresa guardados correctamente.');
    }

    public function store(Request $request, CompanyContext $context): RedirectResponse
    {
        $data = $request->validate([
            'business_name' => ['required', 'string', 'max:255'],
        ]);

        $company = CompanySetting::query()->create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'business_name' => $data['business_name'],
            'default_currency' => 'PEN',
            'default_proforma_template' => 'commercial',
        ]);

        \App\Support\TenantDatabaseManager::ensureDatabaseExists($company);

        $context->switchTo($company);

        return redirect()
            ->route('company.edit')
            ->with('status', 'Nueva empresa creada. Completa sus datos y logos.');
    }

    public function switch(Request $request, CompanyContext $context): RedirectResponse
    {
        $data = $request->validate([
            'company_id' => ['required', 'exists:company_settings,id'],
        ]);

        $context->switchTo(CompanySetting::query()->findOrFail($data['company_id']));

        return redirect()->route('dashboard.local');
    }

    public static function publicLogoUrl(?string $path): ?string
    {
        if (! $path || str_contains($path, '..') || ! Storage::disk('public')->exists($path)) {
            return null;
        }

        $publicPath = str_replace('\\', '/', ltrim($path, '/'));
        $source = storage_path('app/public/'.$publicPath);
        $destination = public_path('storage/'.$publicPath);

        if (! File::exists($source) || filesize($source) === 0) {
            return null;
        }

        if (! File::exists($destination) || filemtime($source) > filemtime($destination) || filesize($destination) === 0) {
            File::ensureDirectoryExists(dirname($destination));
            File::copy($source, $destination);
        }

        $version = filemtime($source);

        return '/storage/'.$publicPath.'?v='.$version;
    }
}
