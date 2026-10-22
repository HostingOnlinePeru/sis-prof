<?php

use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\ClientCatalogController;
use App\Http\Controllers\DocumentRepositoryController;
use App\Http\Controllers\ProformaController;
use App\Http\Controllers\ProductCatalogController;
use App\Http\Controllers\ProformaEmailController;
use App\Http\Controllers\ProformaPdfController;
use App\Http\Controllers\TermTemplateController;
use App\Http\Controllers\SuperAdminUserController;
use App\Http\Controllers\CompanyOnboardingController;
use App\Http\Middleware\EnsureSuperAdmin;
use App\Http\Middleware\EnsureUserHasCompany;
use App\Http\Middleware\EnsureUserIsActive;
use App\Models\CompanySetting;
use App\Models\Client;
use App\Models\Document;
use App\Models\Product;
use App\Models\Proforma;
use App\Models\User;
use App\Support\AppShell;
use App\Support\CompanyContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->isSuperAdmin()
            ? redirect()->route('superadmin.users.index')
            : redirect()->route('dashboard.local');
    }

    return app()->environment('local')
        ? redirect('/acceso-local')
        : redirect('/admin/login');
});

Route::get('/login', function () {
    if (Auth::check()) {
        return Auth::user()->isSuperAdmin()
            ? redirect()->route('superadmin.users.index')
            : redirect()->route('dashboard.local');
    }
    return redirect('/admin/login');
})->name('login');

// Onboarding for users without companies
Route::middleware(['auth', EnsureUserIsActive::class])->group(function () {
    Route::get('/onboarding/crear-empresa', [CompanyOnboardingController::class, 'create'])->name('onboarding.create');
    Route::post('/onboarding/crear-empresa', [CompanyOnboardingController::class, 'store'])->name('onboarding.store');
});

// Super Admin Routes (Exclusively for managing users & SaaS metrics)
Route::middleware(['auth', EnsureSuperAdmin::class])->group(function () {
    Route::get('/admin/usuarios', [SuperAdminUserController::class, 'index'])->name('superadmin.users.index');
    Route::post('/admin/usuarios', [SuperAdminUserController::class, 'store'])->name('superadmin.users.store');
    Route::put('/admin/usuarios/{user}', [SuperAdminUserController::class, 'update'])->name('superadmin.users.update');
    Route::patch('/admin/usuarios/{user}/estado', [SuperAdminUserController::class, 'toggleStatus'])->name('superadmin.users.toggle-status');
    Route::delete('/admin/usuarios/{user}', [SuperAdminUserController::class, 'destroy'])->name('superadmin.users.destroy');
});

// Main Business Application Routes (Protected by auth and company check, Tenants only)
Route::middleware(['auth', EnsureUserIsActive::class, EnsureUserHasCompany::class])->group(function () {
    Route::get('/admin', function () {
        return redirect()->route('dashboard.local');
    });

    Route::get('/admin/escritorio', function (Request $request) {
        $stats = [
            'proformas' => Proforma::query()->count(),
            'clientes' => Client::query()->count(),
            'productos' => Product::query()->count(),
            'documentos' => Document::query()->count(),
            'total' => Proforma::query()->sum('total'),
        ];

        $recentProformas = Proforma::query()
            ->with('client')
            ->latest()
            ->take(5)
            ->get();

        return AppShell::render($request, [
            'activePage' => 'dashboard',
            'subtitle' => 'Resumen operativo para crear, revisar y enviar cotizaciones.',
            'title' => 'Dashboard de Proformas',
        ], 'dashboard.partial', [
            'stats' => $stats,
            'recentProformas' => $recentProformas,
        ]);
    })->name('dashboard.local');

    Route::get('/admin/empresa', [CompanyProfileController::class, 'edit'])->name('company.edit');
    Route::post('/admin/empresa', [CompanyProfileController::class, 'update'])->name('company.update');
    Route::post('/admin/empresa/nueva', [CompanyProfileController::class, 'store'])->name('company.store');
    Route::post('/admin/empresa/cambiar', [CompanyProfileController::class, 'switch'])->name('company.switch');

    Route::get('/admin/documentos', [DocumentRepositoryController::class, 'index'])->name('documents.index');
    Route::post('/admin/documentos/carpetas', [DocumentRepositoryController::class, 'storeFolder'])->name('documents.folders.store');
    Route::post('/admin/documentos/archivos', [DocumentRepositoryController::class, 'upload'])->name('documents.upload');
    Route::get('/admin/documentos/{document}/descargar', [DocumentRepositoryController::class, 'download'])->name('documents.download');

    Route::get('/admin/productos', [ProductCatalogController::class, 'index'])->name('products.index');
    Route::post('/admin/productos/categorias', [ProductCatalogController::class, 'storeCategory'])->name('products.categories.store');
    Route::post('/admin/productos', [ProductCatalogController::class, 'storeProduct'])->name('products.store');
    Route::put('/admin/productos/{product}', [ProductCatalogController::class, 'updateProduct'])->name('products.update');
    Route::delete('/admin/productos/{product}', [ProductCatalogController::class, 'destroyProduct'])->name('products.destroy');

    Route::get('/admin/terminos', [TermTemplateController::class, 'index'])->name('terms.index');
    Route::post('/admin/terminos', [TermTemplateController::class, 'store'])->name('terms.store');
    Route::put('/admin/terminos/{term}', [TermTemplateController::class, 'update'])->name('terms.update');

    Route::get('/admin/clientes', [ClientCatalogController::class, 'index'])->name('clients.index');
    Route::post('/admin/clientes', [ClientCatalogController::class, 'store'])->name('clients.store');
    Route::put('/admin/clientes/{client}', [ClientCatalogController::class, 'update'])->name('clients.update');
    Route::delete('/admin/clientes/{client}', [ClientCatalogController::class, 'destroy'])->name('clients.destroy');

    Route::get('/admin/proformas', [ProformaController::class, 'index'])->name('proformas.index');
    Route::get('/admin/proformas/create', [ProformaController::class, 'create'])->name('proformas.create');
    Route::post('/admin/proformas', [ProformaController::class, 'store'])->name('proformas.store');
    Route::post('/admin/proformas/clientes', [ProformaController::class, 'storeClient'])->name('proformas.clients.store');
    Route::get('/admin/proformas/{proforma}/edit', [ProformaController::class, 'edit'])->name('proformas.edit');
    Route::get('/admin/proformas/{proforma}/correo', [ProformaEmailController::class, 'create'])->name('proformas.email');
    Route::post('/admin/proformas/{proforma}/correo', [ProformaEmailController::class, 'send'])->name('proformas.email.send');
    Route::put('/admin/proformas/{proforma}', [ProformaController::class, 'update'])->name('proformas.update');
    Route::patch('/admin/proformas/{proforma}/estado', [ProformaController::class, 'updateStatus'])->name('proformas.status.update');
    Route::delete('/admin/proformas/{proforma}', [ProformaController::class, 'destroy'])->name('proformas.destroy');
});

Route::get('/proformas/{proforma}/pdf', ProformaPdfController::class)
    ->name('proformas.pdf');

// Acceso local rapido y pruebas de perfiles
Route::get('/acceso-local', function (Request $request) {
    $targetRole = $request->query('as', 'superadmin');

    if ($targetRole === 'superadmin') {
        $user = User::query()->where('role', 'super_admin')->first();

        if (! $user) {
            $user = User::query()->create([
                'name' => 'SISPROF Admin',
                'email' => 'superadmin@sistema.com',
                'password' => bcrypt('admin123'),
                'role' => 'super_admin',
                'is_active' => true,
            ]);
        } else {
            $user->update(['name' => 'SISPROF Admin']);
        }

        Auth::login($user, true);
        request()->session()->regenerate();

        return redirect()->route('superadmin.users.index');
    } elseif ($targetRole === 'tenant') {
        $user = User::query()->where('email', 'tenant@sistema.com')->first()
            ?? User::query()->create([
                'name' => 'Usuario Empresa Demostracion',
                'email' => 'tenant@sistema.com',
                'password' => bcrypt('tenant123'),
                'role' => 'tenant',
                'is_active' => true,
            ]);

        if ($user->companies()->count() === 0) {
            $company = CompanySetting::query()->create([
                'user_id' => $user->id,
                'business_name' => 'Mi Empresa S.A.C.',
                'default_currency' => 'PEN',
                'default_proforma_template' => 'commercial',
            ]);
            \App\Support\TenantDatabaseManager::ensureDatabaseExists($company);
        }

        Auth::login($user, true);
        request()->session()->regenerate();

        return redirect()->route('dashboard.local');
    } else { // nuevo -> Onboarding test
        $user = User::query()->where('email', 'nuevo@sistema.com')->first()
            ?? User::query()->create([
                'name' => 'Nuevo Usuario Sin Empresa',
                'email' => 'nuevo@sistema.com',
                'password' => bcrypt('nuevo123'),
                'role' => 'tenant',
                'is_active' => true,
            ]);

        Auth::login($user, true);
        request()->session()->regenerate();

        return redirect()->route('dashboard.local');
    }
});

Route::post('/ingresar-local', function () {
    $credentials = request()->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
    ]);

    if (! Auth::attempt($credentials, request()->boolean('remember'))) {
        return back()
            ->withInput(request()->only('email'))
            ->withErrors(['email' => 'El correo o la contraseña no son correctos.']);
    }

    if (! Auth::user()->is_active) {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return back()
            ->withInput(request()->only('email'))
            ->withErrors(['email' => 'Tu usuario ha sido suspendido. Comunícate con tu administrador para activar tu cuenta.']);
    }

    request()->session()->regenerate();

    if (Auth::user()->isSuperAdmin()) {
        return redirect()->route('superadmin.users.index');
    }

    return redirect()->route('dashboard.local');
})->name('login.local');

Route::get('/storage/{path}', function ($path) {
    $fullPath = storage_path('app/public/'.ltrim($path, '/'));
    if (! file_exists($fullPath)) {
        abort(404);
    }
    $mime = mime_content_type($fullPath);
    if (str_ends_with(strtolower($path), '.svg')) {
        $mime = 'image/svg+xml';
    }

    return response()->file($fullPath, ['Content-Type' => $mime]);
})->where('path', '.*')->name('storage.local');
