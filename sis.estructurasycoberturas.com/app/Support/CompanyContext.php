<?php

namespace App\Support;

use App\Models\CompanySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CompanyContext
{
    public function availableCompanies(): Collection
    {
        $user = Auth::user();

        if (! $user) {
            return collect();
        }

        if ($user->isSuperAdmin()) {
            return CompanySetting::query()->orderBy('business_name')->get();
        }

        return CompanySetting::query()
            ->where('user_id', $user->id)
            ->orderBy('business_name')
            ->get();
    }

    public function active(): ?CompanySetting
    {
        $request = app()->bound('request') ? app(Request::class) : null;
        $companyId = $request?->hasSession() ? $request->session()->get('active_company_id') : null;

        $available = $this->availableCompanies();
        $company = $companyId ? $available->firstWhere('id', $companyId) : null;

        if (! $company) {
            $company = $available->first();

            if ($company && $request?->hasSession()) {
                $request->session()->put('active_company_id', $company->id);
            }
        }

        if ($company) {
            TenantDatabaseManager::connect($company);
        }

        return $company;
    }

    public function id(): ?int
    {
        return $this->active()?->id;
    }

    public function switchTo(CompanySetting $company): void
    {
        $user = Auth::user();

        if ($user && ! $user->isSuperAdmin() && $company->user_id !== $user->id) {
            abort(403, 'No tiene permiso para acceder a esta empresa.');
        }

        $request = app(Request::class);

        if ($request->hasSession()) {
            $request->session()->put('active_company_id', $company->id);
        }

        TenantDatabaseManager::connect($company);
    }
}
