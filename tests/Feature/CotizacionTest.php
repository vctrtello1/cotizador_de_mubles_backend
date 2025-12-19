<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CotizacionTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_cotizacion_index(): void
    {
        $response = $this->getJson('/api/v1/cotizaciones');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'cliente_id',
                    'fecha',
                    'total',
                    'detalles',
                ],
            ],
        ]);
    }

    public function test_cotizacion_show(): void
    {
        // First, create a cotizacion to show
        $cotizacion = \App\Models\Cotizacion::factory()->create();

        $response = $this->getJson("/api/v1/cotizaciones/{$cotizacion->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'cliente_id',
                'fecha',
                'total',
                'detalles',
            ],
        ]);
    }

    public function test_cotizacion_with_detalles(): void
    {
        // Create a cotizacion with detalles
        $cotizacion = \App\Models\Cotizacion::factory()
            ->has(\App\Models\DetalleCotizacion::factory()->count(3), 'detalles')
            ->create();

        $response = $this->getJson("/api/v1/cotizaciones/{$cotizacion->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'cliente_id',
                'fecha',
                'total',
                'detalles' => [
                    '*' => [
                        'id',
                        'cotizacion_id',
                        'descripcion',
                        'cantidad',
                        'precio_unitario',
                        'subtotal',
                    ],
                ],
            ],
        ]);
    }


    public function test_cotizacion_store(): void
    {
        $cotizacionData = [
            'cliente_id' => 1,
            'fecha' => '2024-01-01',
            'total' => 1000.00,
        ];

        $response = $this->postJson('/api/v1/cotizaciones', $cotizacionData);

        $response->assertStatus(201);
        $response->assertJsonFragment($cotizacionData);
    }


    public function test_cotizacion_store_with_detalles(): void
    {
        $cotizacionData = [
            'cliente_id' => 1,
            'fecha' => '2024-01-01',
            'total' => 1500.00,
            'detalles' => [
                [
                    'descripcion' => 'Detalle 1',
                    'cantidad' => 2,
                    'precio_unitario' => 200.00,
                ],
                [
                    'descripcion' => 'Detalle 2',
                    'cantidad' => 3,
                    'precio_unitario' => 300.00,
                ],
            ],
        ];

        $response = $this->postJson('/api/v1/cotizaciones', $cotizacionData);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'cliente_id' => 1,
            'fecha' => '2024-01-01',
            'total' => 1500.00,
        ]);

        $response->assertJsonCount(2, 'data.detalles');
    }


    public function test_cotizacion_update(): void
    {
        // First, create a cotizacion to update
        $cotizacion = \App\Models\Cotizacion::factory()->create();

        $updateData = [
            'cliente_id' => 2,
            'fecha' => '2024-02-01',
            'total' => 2000.00,
        ];

        $response = $this->putJson("/api/v1/cotizaciones/{$cotizacion->id}", $updateData);

        $response->assertStatus(200);
        $response->assertJsonFragment($updateData);
    }


    public function test_cotizacion_delete(): void
    {
        // First, create a cotizacion to delete
        $cotizacion = \App\Models\Cotizacion::factory()->create();

        $response = $this->deleteJson("/api/v1/cotizaciones/{$cotizacion->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('cotizaciones', ['id' => $cotizacion->id]);
    }


    public function test_cotizacion_total_calculation(): void
    {
        $cotizacion = \App\Models\Cotizacion::factory()
            ->has(
                \App\Models\DetalleCotizacion::factory()->count(2)->state(function (array $attributes) {
                    return [
                        'cantidad' => 2,
                        'precio_unitario' => 250.00,
                    ];
                }),
                'detalles'
            )
            ->create();

        $expectedTotal = 2 * 250.00 * 2; // 2 detalles, each with cantidad 2 and precio_unitario 250.00

        $this->assertEquals($expectedTotal, $cotizacion->total);
    }


    public function test_cotizacion_validation_errors(): void
    {
        $invalidData = [
            'cliente_id' => null, // Required field
            'fecha' => 'invalid-date', // Invalid date format
            'total' => -100.00, // Negative total not allowed
        ];

        $response = $this->postJson('/api/v1/cotizaciones', $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['cliente_id', 'fecha', 'total']);
    }

    public function test_cotizacion_not_found(): void
    {
        $response = $this->getJson('/api/v1/cotizaciones/999999'); // Non-existent ID

        $response->assertStatus(404);
    }

    public function test_cotizacion_delete_not_found(): void
    {
        $response = $this->deleteJson('/api/v1/cotizaciones/999999'); // Non-existent ID

        $response->assertStatus(404);
    }

    public function test_cotizacion_update_not_found(): void
    {
        $updateData = [
            'cliente_id' => 2,
            'fecha' => '2024-02-01',
            'total' => 2000.00,
        ];

        $response = $this->putJson('/api/v1/cotizaciones/999999', $updateData); // Non-existent ID

        $response->assertStatus(404);
    }

    public function test_cotizacion_empty_detalles(): void
    {
        $cotizacionData = [
            'cliente_id' => 1,
            'fecha' => '2024-01-01',
            'total' => 0.00,
            'detalles' => [],
        ];

        $response = $this->postJson('/api/v1/cotizaciones', $cotizacionData);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'cliente_id' => 1,
            'fecha' => '2024-01-01',
            'total' => 0.00,
        ]);

        $response->assertJsonCount(0, 'data.detalles');
    }

    public function test_cotizacion_large_number_of_detalles(): void
    {
        $detalles = [];
        for ($i = 0; $i < 100; $i++) {
            $detalles[] = [
                'descripcion' => "Detalle {$i}",
                'cantidad' => 1,
                'precio_unitario' => 10.00,
            ];
        }

        $cotizacionData = [
            'cliente_id' => 1,
            'fecha' => '2024-01-01',
            'total' => 1000.00,
            'detalles' => $detalles,
        ];

        $response = $this->postJson('/api/v1/cotizaciones', $cotizacionData);

        $response->assertStatus(201);
        $response->assertJsonCount(100, 'data.detalles');
    }


    public function test_cotizacion_date_format(): void
    {
        $cotizacionData = [
            'cliente_id' => 1,
            'fecha' => '2024-12-31', // Valid date format
            'total' => 500.00,
        ];

        $response = $this->postJson('/api/v1/cotizaciones', $cotizacionData);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'fecha' => '2024-12-31',
        ]);
    }
}
