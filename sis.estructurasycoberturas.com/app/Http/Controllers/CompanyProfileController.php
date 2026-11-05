<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use App\Support\AppShell;
use App\Support\CompanyContext;
use App\Support\LatamCurrencies;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
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
        $validCurrencies = LatamCurrencies::codes();

        $data = $request->validate([
            'business_name' => ['required', 'string', 'max:255'],
            'tax_id' => ['nullable', 'string', 'max:20'],
            'default_currency' => ['required', Rule::in($validCurrencies)],
            'secondary_currency' => ['nullable', Rule::in($validCurrencies)],
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

        $data['default_currency'] = $data['default_currency'] ?? 'PEN';

        if ($request->user()?->canUseMultiCurrency()) {
            $secondary = $data['secondary_currency'] ?? null;
            $data['secondary_currency'] = ($secondary && $secondary !== $data['default_currency']) ? $secondary : null;
        } else {
            $data['secondary_currency'] = null;
        }

        $companyId = $request->input('company_id');
        if ($companyId) {
            $company = CompanySetting::query()->find($companyId) ?? app(CompanyContext::class)->active() ?? new CompanySetting();
        } else {
            $company = app(CompanyContext::class)->active() ?? new CompanySetting();
        }

        if (! $company->user_id && $request->user()) {
            $company->user_id = $request->user()->id;
        }

        $oldDashboardLogo = $company->dashboard_logo_path;
        $oldProformaLogo = $company->proforma_logo_path;

        if ($request->hasFile('dashboard_logo')) {
            $file = $request->file('dashboard_logo');
            if ($file->isValid() && $file->getSize() > 0) {
                $storedPath = $file->store('company/logos', 'public');
                $data['dashboard_logo_path'] = $storedPath;

                if (empty($oldProformaLogo) || ($oldProformaLogo === $oldDashboardLogo && ! $request->hasFile('proforma_logo'))) {
                    $data['proforma_logo_path'] = $storedPath;
                }

                if ($oldDashboardLogo && $oldDashboardLogo !== ($data['proforma_logo_path'] ?? $oldProformaLogo)) {
                    try {
                        if (Storage::disk('public')->exists($oldDashboardLogo)) {
                            Storage::disk('public')->delete($oldDashboardLogo);
                        }
                    } catch (\Throwable) {
                    }
                }
            }
        }

        if ($request->hasFile('proforma_logo')) {
            $file = $request->file('proforma_logo');
            if ($file->isValid() && $file->getSize() > 0) {
                $storedPath = $file->store('company/logos', 'public');
                $data['proforma_logo_path'] = $storedPath;

                if (empty($oldDashboardLogo) && ! isset($data['dashboard_logo_path'])) {
                    $data['dashboard_logo_path'] = $storedPath;
                }

                $currentDashboardLogo = $data['dashboard_logo_path'] ?? $oldDashboardLogo;
                if ($oldProformaLogo && $oldProformaLogo !== $currentDashboardLogo) {
                    try {
                        if (Storage::disk('public')->exists($oldProformaLogo)) {
                            Storage::disk('public')->delete($oldProformaLogo);
                        }
                    } catch (\Throwable) {
                    }
                }
            }
        }

        $company->fill($data);
        $company->save();

        \App\Support\TenantDatabaseManager::ensureDatabaseExists($company);
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
        $user = $request->user();

        if (! $user?->canCreateCompany()) {
            return redirect()
                ->route('company.edit')
                ->withErrors([
                    'business_name' => $user?->maxCompanies() > 1
                        ? "Tu Plan {$user->currentTierLabel()} permite registrar hasta un máximo de {$user->maxCompanies()} empresas."
                        : 'El Plan Básico solo permite 1 empresa. Mejora al Plan Stándar o Plan Corporativo para gestionar hasta 2 empresas.',
                ]);
        }

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
        if (! $path || str_contains($path, '..')) {
            return null;
        }

        try {
            $publicPath = str_replace('\\', '/', ltrim($path, '/'));
            $source = storage_path('app/public/'.$publicPath);

            if (! is_file($source) || @filesize($source) === 0) {
                return null;
            }

            $destination = public_path('storage/'.$publicPath);

            try {
                if (@realpath($source) !== @realpath($destination)) {
                    if (! is_file($destination) || @filemtime($source) > @filemtime($destination) || @filesize($destination) === 0) {
                        $destDir = dirname($destination);
                        if (is_dir($destDir) ? is_writable($destDir) : is_writable(public_path())) {
                            File::ensureDirectoryExists($destDir);
                            @copy($source, $destination);
                        }
                    }
                }
            } catch (\Throwable) {
                // Ignore if public/storage is read-only in production; served via /media-publica
            }

            $version = @filemtime($source) ?: time();

            return '/media-publica?path='.rawurlencode($publicPath).'&v='.$version;
        } catch (\Throwable) {
            return null;
        }
    }

    public static function pdfImageDataUri(?string $path): ?string
    {
        if (! $path || str_contains($path, '..')) {
            return null;
        }

        try {
            $publicPath = str_replace('\\', '/', ltrim($path, '/'));
            $fullPath = storage_path('app/public/'.$publicPath);

            if (! is_file($fullPath) || @filesize($fullPath) === 0) {
                return null;
            }

            $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
            if ($ext === 'svg') {
                return 'data:image/svg+xml;base64,'.base64_encode((string) file_get_contents($fullPath));
            }

            $imageInfo = @getimagesize($fullPath);
            $imageType = $imageInfo[2] ?? null;

            $needsPngConversion = $ext === 'webp'
                || $imageType === IMAGETYPE_WEBP
                || $ext === 'gif'
                || $imageType === IMAGETYPE_GIF
                || $ext === 'bmp'
                || $imageType === IMAGETYPE_BMP;

            if ($needsPngConversion) {
                $im = false;
                if (($ext === 'webp' || $imageType === IMAGETYPE_WEBP) && function_exists('imagecreatefromwebp')) {
                    $im = @imagecreatefromwebp($fullPath);
                } elseif (function_exists('imagecreatefromstring')) {
                    $im = @imagecreatefromstring((string) @file_get_contents($fullPath));
                }

                if ($im !== false && function_exists('imagepng')) {
                    if (function_exists('imagepalettetotruecolor')) {
                        @imagepalettetotruecolor($im);
                    }
                    @imagealphablending($im, true);
                    @imagesavealpha($im, true);
                    ob_start();
                    @imagepng($im);
                    $pngData = ob_get_clean();
                    if ($pngData) {
                        return 'data:image/png;base64,'.base64_encode($pngData);
                    }
                }

                if (class_exists(\Imagick::class)) {
                    $imagick = new \Imagick($fullPath);
                    $imagick->setImageFormat('png');
                    $pngData = $imagick->getImageBlob();
                    $imagick->clear();
                    if ($pngData) {
                        return 'data:image/png;base64,'.base64_encode($pngData);
                    }
                }

                return null;
            }

            $mime = $imageInfo['mime'] ?? (function_exists('mime_content_type') ? @mime_content_type($fullPath) : null);
            if (! $mime) {
                $mime = match ($ext) {
                    'png' => 'image/png',
                    'jpg', 'jpeg' => 'image/jpeg',
                    default => 'image/png',
                };
            }

            return 'data:'.$mime.';base64,'.base64_encode((string) file_get_contents($fullPath));
        } catch (\Throwable) {
            return null;
        }
    }
}
