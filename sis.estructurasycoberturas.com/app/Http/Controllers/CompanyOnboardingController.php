<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use App\Support\CompanyContext;
use App\Support\TenantDatabaseManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CompanyOnboardingController extends Controller
{
    public function create(): View|RedirectResponse
    {
        $user = Auth::user();

        if ($user->companies()->count() > 0) {
            return redirect()->route('dashboard.local');
        }

        return view('onboarding.create-company', [
            'user' => $user,
        ]);
    }

    public function store(Request $request, CompanyContext $context): RedirectResponse
    {
        $user = Auth::user();

        $data = $request->validate([
            'business_name' => ['required', 'string', 'max:255'],
            'tax_id' => ['nullable', 'string', 'max:20'],
            'default_currency' => ['required', 'in:PEN,USD'],
            'phone' => ['nullable', 'string', 'max:40'],
        ]);

        $company = CompanySetting::query()->create([
            'user_id' => $user->id,
            'business_name' => $data['business_name'],
            'tax_id' => $data['tax_id'] ?? null,
            'default_currency' => $data['default_currency'],
            'phone' => $data['phone'] ?? null,
            'default_proforma_template' => 'commercial',
        ]);

        TenantDatabaseManager::ensureDatabaseExists($company);

        $context->switchTo($company);

        return redirect()
            ->route('dashboard.local')
            ->with('status', '¡Bienvenido! Tu empresa y su base de datos independiente han sido configuradas correctamente.');
    }
}
