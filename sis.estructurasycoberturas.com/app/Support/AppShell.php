<?php

namespace App\Support;

use App\Http\Controllers\CompanyProfileController;
use App\Models\CompanySetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AppShell
{
    public static function render(Request $request, array $meta, string $contentView, array $contentData = []): View|JsonResponse
    {
        $company = app(CompanyContext::class)->active();
        $companies = app(CompanyContext::class)->availableCompanies();
        $dashboardLogoUrl = CompanyProfileController::publicLogoUrl($company?->dashboard_logo_path ?: $company?->proforma_logo_path ?: $company?->logo_path);

        $isPartialRequest = $request->header('X-App-Partial') === '1'
            && $request->header('X-Requested-With') === 'XMLHttpRequest'
            && $request->expectsJson();

        if ($isPartialRequest) {
            return response()->json([
                'activePage' => $meta['activePage'],
                'html' => view($contentView, $contentData)->render(),
                'subtitle' => $meta['subtitle'],
                'title' => $meta['title'],
                'dashboardLogoUrl' => $dashboardLogoUrl,
                'companyName' => $company?->business_name ?: 'Sistema de Proformas',
                'activeCompanyId' => $company?->id,
            ]);
        }

        return view('layouts.app-shell', [
            'activePage' => $meta['activePage'],
            'company' => $company,
            'companies' => $companies,
            'contentData' => $contentData,
            'contentView' => $contentView,
            'dashboardLogoUrl' => $dashboardLogoUrl,
            'pageSubtitle' => $meta['subtitle'],
            'pageTitle' => $meta['title'],
        ]);
    }
}
