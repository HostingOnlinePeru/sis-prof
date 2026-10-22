<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$companies = App\Models\CompanySetting::all();
echo "TOTAL COMPANIES: " . $companies->count() . "\n";

foreach ($companies as $c) {
    echo "ID: {$c->id} | Name: {$c->business_name}\n";
    echo "  Dashboard Logo Path: " . var_export($c->dashboard_logo_path, true) . "\n";
    echo "  Proforma Logo Path:  " . var_export($c->proforma_logo_path, true) . "\n";
    echo "  General Logo Path:   " . var_export($c->logo_path, true) . "\n";
    
    $dUrl = \App\Http\Controllers\CompanyProfileController::publicLogoUrl($c->dashboard_logo_path);
    $pUrl = \App\Http\Controllers\CompanyProfileController::publicLogoUrl($c->proforma_logo_path);
    
    echo "  Dashboard URL: $dUrl\n";
    echo "  Proforma URL:  $pUrl\n";
}
