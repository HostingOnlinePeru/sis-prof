<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Proforma;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_home_redirects_to_admin(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/admin/login');
    }

    public function test_proforma_pdf_is_rendered(): void
    {
        $client = Client::query()->create([
            'name' => 'Cliente Test',
            'document_type' => 'RUC',
        ]);

        $proforma = Proforma::query()->create([
            'client_id' => $client->id,
            'issue_date' => now()->toDateString(),
            'template' => 'commercial',
            'currency' => 'PEN',
            'terms' => 'Terminos de prueba',
        ]);

        $proforma->items()->create([
            'description' => 'Producto de prueba',
            'unit' => 'UND',
            'quantity' => 2,
            'unit_price' => 100,
            'discount_rate' => 0,
            'tax_rate' => 18,
        ]);

        $response = $this->get(route('proformas.pdf', $proforma));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
    }
}
