<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\CompanySetting;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

$companies = CompanySetting::all();
foreach ($companies as $c) {
    $fields = ['dashboard_logo_path', 'proforma_logo_path', 'logo_path'];
    foreach ($fields as $field) {
        $path = $c->{$field};
        if ($path) {
            $fullPath = storage_path('app/public/' . $path);
            if (!File::exists($fullPath) || filesize($fullPath) === 0) {
                echo "Cleaning 0-byte or missing logo for Company {$c->id} ({$c->business_name}): field {$field} ($path)\n";
                if (File::exists($fullPath)) {
                    @unlink($fullPath);
                }
                $pubPath = public_path('storage/' . $path);
                if (File::exists($pubPath)) {
                    @unlink($pubPath);
                }
                $c->update([$field => null]);
            }
        }
    }
}

echo "Cleanup complete!\n";
