<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\CompanySetting;
use App\Models\Product;
use App\Models\Proforma;
use App\Models\TermTemplate;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@proformas.local'],
            ['name' => 'Administrador', 'password' => 'password']
        );

        CompanySetting::query()->updateOrCreate(
            ['id' => 1],
            [
                'business_name' => 'Mi Empresa S.A.C.',
                'commercial_name' => 'Mi Empresa',
                'tax_id' => '20600000000',
                'email' => 'ventas@miempresa.com',
                'phone' => '+51 999 999 999',
                'whatsapp' => '+51 999 999 999',
                'address' => 'Lima, Peru',
                'website' => 'https://miempresa.com',
                'default_terms' => "Validez de oferta: 7 días.\nForma de pago: 50% adelanto y 50% contra entrega.\nPrecios sujetos a disponibilidad.",
            ]
        );

        $terms = TermTemplate::query()->updateOrCreate(
            ['name' => 'Condiciones comerciales'],
            [
                'content' => "Validez de oferta: 7 días.\nTiempo de entrega: según disponibilidad.\nForma de pago: transferencia bancaria.\nGarantía: según ficha técnica del producto.",
                'active' => true,
            ]
        );

        $client = Client::query()->updateOrCreate(
            ['document_number' => '20123456789'],
            [
                'name' => 'Cliente de Ejemplo S.A.C.',
                'document_type' => 'RUC',
                'contact_name' => 'Compras',
                'email' => 'compras@cliente.com',
                'phone' => '+51 988 888 888',
                'whatsapp' => '+51988888888',
                'address' => 'Av. Principal 123, Lima',
            ]
        );

        $product = Product::query()->updateOrCreate(
            ['sku' => 'SERV-001'],
            [
                'name' => 'Servicio de instalacion',
                'description' => 'Servicio de instalacion, configuracion y pruebas operativas segun requerimiento del cliente.',
                'unit' => 'SERV',
                'price' => 850,
                'tax_rate' => 18,
                'active' => true,
            ]
        );

        Product::query()->updateOrCreate(
            ['sku' => 'PROD-001'],
            [
                'name' => 'Equipo industrial base',
                'description' => 'Equipo industrial con accesorios estandar, manual de operacion y soporte inicial.',
                'unit' => 'UND',
                'price' => 1250,
                'tax_rate' => 18,
                'active' => true,
            ]
        );

        $proforma = Proforma::query()->firstOrCreate(
            ['number' => 'PF-2026-0001'],
            [
                'client_id' => $client->id,
                'issue_date' => now()->toDateString(),
                'valid_until' => now()->addDays(7)->toDateString(),
                'status' => 'draft',
                'template' => 'commercial',
                'currency' => 'PEN',
                'subject' => 'Proforma de ejemplo',
                'terms' => $terms->content,
            ]
        );

        if ($proforma->items()->doesntExist()) {
            $proforma->items()->create([
                'product_id' => $product->id,
                'description' => $product->description,
                'unit' => $product->unit,
                'quantity' => 1,
                'unit_price' => $product->price,
                'discount_rate' => 0,
                'tax_rate' => $product->tax_rate,
            ]);
        }

        $proforma->recalculateTotals();
    }
}
