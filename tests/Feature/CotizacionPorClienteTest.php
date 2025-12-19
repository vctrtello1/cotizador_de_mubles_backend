<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CotizacionPorClienteTest extends TestCase
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

    public function test_cotizacion_por_cliente(): void
    {
        // First, create a cliente
        $cliente = \App\Models\Cliente::factory()->create();

        // Create cotizaciones for that cliente
        \App\Models\Cotizacion::factory()->count(3)->create([
            'cliente_id' => $cliente->id,
        ]);

        $response = $this->getJson("/api/v1/clientes/{$cliente->id}/cotizaciones");

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

    public function test_cotizacion_por_cliente_no_existente(): void
    {
        $nonExistentClienteId = 9999; // Assuming this ID does not exist

        $response = $this->getJson("/api/v1/clientes/{$nonExistentClienteId}/cotizaciones");

        $response->assertStatus(404);
    }

    public function test_cotizacion_por_cliente_sin_cotizaciones(): void
    {
        // First, create a cliente without cotizaciones
        $cliente = \App\Models\Cliente::factory()->create();

        $response = $this->getJson("/api/v1/clientes/{$cliente->id}/cotizaciones");

        $response->assertStatus(200);
        $response->assertJsonCount(0, 'data');
    }

    public function test_cotizacion_por_cliente_con_detalles(): void
    {
        // First, create a cliente
        $cliente = \App\Models\Cliente::factory()->create();

        // Create a cotizacion with detalles for that cliente
        $cotizacion = \App\Models\Cotizacion::factory()
            ->for($cliente)
            ->has(\App\Models\DetalleCotizacion::factory()->count(2), 'detalles')
            ->create();

        $response = $this->getJson("/api/v1/clientes/{$cliente->id}/cotizaciones");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
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
            ],
        ]);
    }

    public function test_cotizacion_por_cliente_con_gran_numero_de_cotizaciones(): void
    {
        // First, create a cliente
        $cliente = \App\Models\Cliente::factory()->create();

        // Create a large number of cotizaciones for that cliente
        \App\Models\Cotizacion::factory()->count(50)->create([
            'cliente_id' => $cliente->id,
        ]);

        $response = $this->getJson("/api/v1/clientes/{$cliente->id}/cotizaciones");

        $response->assertStatus(200);
        $response->assertJsonCount(50, 'data');
    }

    public function test_cotizacion_por_cliente_con_fechas_especificas(): void
    {
        // First, create a cliente
        $cliente = \App\Models\Cliente::factory()->create();

        // Create cotizaciones with specific dates for that cliente
        \App\Models\Cotizacion::factory()->create([
            'cliente_id' => $cliente->id,
            'fecha' => '2023-01-15',
        ]);

        \App\Models\Cotizacion::factory()->create([
            'cliente_id' => $cliente->id,
            'fecha' => '2023-02-20',
        ]);

        $response = $this->getJson("/api/v1/clientes/{$cliente->id}/cotizaciones");

        $response->assertStatus(200);
        $response->assertJsonFragment(['fecha' => '2023-01-15']);
        $response->assertJsonFragment(['fecha' => '2023-02-20']);
    }

    public function test_cotizacion_por_cliente_con_totales_correctos(): void
    {
        // First, create a cliente
        $cliente = \App\Models\Cliente::factory()->create();

        // Create a cotizacion with a known total for that cliente
        $cotizacion = \App\Models\Cotizacion::factory()->create([
            'cliente_id' => $cliente->id,
            'total' => 1500.00,
        ]);

        $response = $this->getJson("/api/v1/clientes/{$cliente->id}/cotizaciones");

        $response->assertStatus(200);
        $response->assertJsonFragment(['total' => 1500.00]);
    }

    public function test_cotizacion_por_cliente_con_detalles_vacios(): void
    {
        // First, create a cliente
        $cliente = \App\Models\Cliente::factory()->create();

        // Create a cotizacion without detalles for that cliente
        $cotizacion = \App\Models\Cotizacion::factory()->create([
            'cliente_id' => $cliente->id,
        ]);

        $response = $this->getJson("/api/v1/clientes/{$cliente->id}/cotizaciones");

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

    public function test_cotizacion_por_cliente_con_datos_invalidos(): void
    {
        $invalidClienteId = 'invalid-id';

        $response = $this->getJson("/api/v1/clientes/{$invalidClienteId}/cotizaciones");

        $response->assertStatus(404);
    }

    public function test_cotizacion_por_cliente_con_filtros_adicionales(): void
    {
        // First, create a cliente
        $cliente = \App\Models\Cliente::factory()->create();

        // Create cotizaciones for that cliente
        \App\Models\Cotizacion::factory()->count(5)->create([
            'cliente_id' => $cliente->id,
        ]);

        // Assuming the API supports filtering by date range
        $response = $this->getJson("/api/v1/clientes/{$cliente->id}/cotizaciones?start_date=2023-01-01&end_date=2023-12-31");

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

    public function test_cotizacion_por_cliente_con_paginacion(): void
    {
        // First, create a cliente
        $cliente = \App\Models\Cliente::factory()->create();

        // Create a large number of cotizaciones for that cliente
        \App\Models\Cotizacion::factory()->count(30)->create([
            'cliente_id' => $cliente->id,
        ]);

        // Assuming the API supports pagination
        $response = $this->getJson("/api/v1/clientes/{$cliente->id}/cotizaciones?page=1&per_page=10");

        $response->assertStatus(200);
        $response->assertJsonCount(10, 'data');
    }

    public function test_cotizacion_por_cliente_con_ordenamiento(): void
    {
        // First, create a cliente
        $cliente = \App\Models\Cliente::factory()->create();

        // Create cotizaciones with different dates for that cliente
        \App\Models\Cotizacion::factory()->create([
            'cliente_id' => $cliente->id,
            'fecha' => '2023-03-01',
        ]);

        \App\Models\Cotizacion::factory()->create([
            'cliente_id' => $cliente->id,
            'fecha' => '2023-01-15',
        ]);

        \App\Models\Cotizacion::factory()->create([
            'cliente_id' => $cliente->id,
            'fecha' => '2023-02-20',
        ]);

        // Assuming the API supports ordering by date
        $response = $this->getJson("/api/v1/clientes/{$cliente->id}/cotizaciones?sort_by=fecha&order=asc");

        $response->assertStatus(200);
        $responseData = $response->json('data');

        $this->assertEquals('2023-01-15', $responseData[0]['fecha']);
        $this->assertEquals('2023-02-20', $responseData[1]['fecha']);
        $this->assertEquals('2023-03-01', $responseData[2]['fecha']);
    }

    public function test_cotizacion_por_cliente_con_respuesta_rapida(): void
    {
        // First, create a cliente
        $cliente = \App\Models\Cliente::factory()->create();

        // Create cotizaciones for that cliente
        \App\Models\Cotizacion::factory()->count(10)->create([
            'cliente_id' => $cliente->id,
        ]);

        $startTime = microtime(true);

        $response = $this->getJson("/api/v1/clientes/{$cliente->id}/cotizaciones");

        $endTime = microtime(true);
        $duration = $endTime - $startTime;

        $response->assertStatus(200);

        // Assert that the response time is under 2 seconds
        $this->assertLessThan(2, $duration, "Response time was {$duration} seconds, expected less than 2 seconds.");
    }

    public function test_cotizacion_por_cliente_con_datos_completos(): void
    {
        // First, create a cliente
        $cliente = \App\Models\Cliente::factory()->create();

        // Create a cotizacion with detalles for that cliente
        $cotizacion = \App\Models\Cotizacion::factory()
            ->for($cliente)
            ->has(\App\Models\DetalleCotizacion::factory()->count(2), 'detalles')
            ->create();

        $response = $this->getJson("/api/v1/clientes/{$cliente->id}/cotizaciones");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
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
            ],
        ]);
    }

    public function test_cotizacion_por_cliente_con_respuesta_vacia(): void
    {
        // First, create a cliente
        $cliente = \App\Models\Cliente::factory()->create();

        $response = $this->getJson("/api/v1/clientes/{$cliente->id}/cotizaciones");

        $response->assertStatus(200);
        $response->assertExactJson(['data' => []]);
    }

    public function test_cotizacion_por_cliente_con_datos_malformados(): void
    {
        $malformedClienteId = '!@#$%';
        $response = $this->getJson("/api/v1/clientes/{$malformedClienteId}/cotizaciones");
        $response->assertStatus(404);

    }

    public function test_cotizacion_por_cliente_con_datos_nulos(): void
    {
        $nullClienteId = null;
        $response = $this->getJson("/api/v1/clientes/{$nullClienteId}/cotizaciones");
        $response->assertStatus(404);
    }

    public function test_cotizacion_por_cliente_con_datos_extremos(): void
    {
        // First, create a cliente
        $cliente = \App\Models\Cliente::factory()->create();

        // Create cotizaciones with extreme total values for that cliente
        \App\Models\Cotizacion::factory()->create([
            'cliente_id' => $cliente->id,
            'total' => 0.01,
        ]);

        \App\Models\Cotizacion::factory()->create([
            'cliente_id' => $cliente->id,
            'total' => 1000000.00,
        ]);

        $response = $this->getJson("/api/v1/clientes/{$cliente->id}/cotizaciones");

        $response->assertStatus(200);
        $response->assertJsonFragment(['total' => 0.01]);
        $response->assertJsonFragment(['total' => 1000000.00]);
    }

    public function test_cotizacion_por_cliente_con_datos_duplicados(): void
    {
        // First, create a cliente
        $cliente = \App\Models\Cliente::factory()->create();

        // Create duplicate cotizaciones for that cliente
        $cotizacionData = [
            'cliente_id' => $cliente->id,
            'fecha' => '2023-05-01',
            'total' => 500.00,
        ];

        \App\Models\Cotizacion::factory()->create($cotizacionData);
        \App\Models\Cotizacion::factory()->create($cotizacionData);

        $response = $this->getJson("/api/v1/clientes/{$cliente->id}/cotizaciones");

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
    }

    public function test_cotizacion_por_cliente_con_datos_incompletos(): void
    {
        // First, create a cliente
        $cliente = \App\Models\Cliente::factory()->create();

        // Create a cotizacion with missing total for that cliente
        \App\Models\Cotizacion::factory()->create([
            'cliente_id' => $cliente->id,
            'fecha' => '2023-06-01',
            // 'total' is missing
        ]);

        $response = $this->getJson("/api/v1/clientes/{$cliente->id}/cotizaciones");

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

    public function test_cotizacion_por_cliente_con_datos_muy_grandes(): void
    {
        // First, create a cliente
        $cliente = \App\Models\Cliente::factory()->create();

        // Create a cotizacion with a very large total for that cliente
        \App\Models\Cotizacion::factory()->create([
            'cliente_id' => $cliente->id,
            'fecha' => '2023-07-01',
            'total' => 9999999999.99,
        ]);

        $response = $this->getJson("/api/v1/clientes/{$cliente->id}/cotizaciones");

        $response->assertStatus(200);
        $response->assertJsonFragment(['total' => 9999999999.99]);
    }

    public function test_cotizacion_por_cliente_con_datos_muy_pequenos(): void
    {
        // First, create a cliente
        $cliente = \App\Models\Cliente::factory()->create();

        // Create a cotizacion with a very small total for that cliente
        \App\Models\Cotizacion::factory()->create([
            'cliente_id' => $cliente->id,
            'fecha' => '2023-08-01',
            'total' => 0.0001,
        ]);

        $response = $this->getJson("/api/v1/clientes/{$cliente->id}/cotizaciones");

        $response->assertStatus(200);
        $response->assertJsonFragment(['total' => 0.0001]);
    }

    public function test_cotizacion_por_cliente_con_datos_especiales(): void
    {
        // First, create a cliente
        $cliente = \App\Models\Cliente::factory()->create();

        // Create a cotizacion with special characters in the description of detalles
        $cotizacion = \App\Models\Cotizacion::factory()
            ->for($cliente)
            ->has(\App\Models\DetalleCotizacion::factory()->count(1)->state([
                'descripcion' => 'Descripción con caracteres especiales !@#$%^&*()',
            ]), 'detalles')
            ->create();

        $response = $this->getJson("/api/v1/clientes/{$cliente->id}/cotizaciones");

        $response->assertStatus(200);
        $response->assertJsonFragment(['descripcion' => 'Descripción con caracteres especiales !@#$%^&*()']);
    }

    public function test_cotizacion_por_cliente_con_datos_unicode(): void
    {
        // First, create a cliente
        $cliente = \App\Models\Cliente::factory()->create();

        // Create a cotizacion with unicode characters in the description of detalles
        $cotizacion = \App\Models\Cotizacion::factory()
            ->for($cliente)
            ->has(\App\Models\DetalleCotizacion::factory()->count(1)->state([
                'descripcion' => 'Descripción con caracteres unicode ñáéíóú üÑÁÉÍÓÚ',
            ]), 'detalles')
            ->create();

        $response = $this->getJson("/api/v1/clientes/{$cliente->id}/cotizaciones");

        $response->assertStatus(200);
        $response->assertJsonFragment(['descripcion' => 'Descripción con caracteres unicode ñáéíóú üÑÁÉÍÓÚ']);
    }

    public function test_cotizacion_por_cliente_con_datos_numericos_extremos(): void
    {
        // First, create a cliente
        $cliente = \App\Models\Cliente::factory()->create();

        // Create a cotizacion with extreme numeric values in detalles
        $cotizacion = \App\Models\Cotizacion::factory()
            ->for($cliente)
            ->has(\App\Models\DetalleCotizacion::factory()->count(1)->state([
                'cantidad' => 1000000,
                'precio_unitario' => 9999999.99,
                'subtotal' => 999999999999.99,
            ]), 'detalles')
            ->create();

        $response = $this->getJson("/api/v1/clientes/{$cliente->id}/cotizaciones");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'cantidad' => 1000000,
            'precio_unitario' => 9999999.99,
            'subtotal' => 999999999999.99,
        ]);
    }

    public function test_cotizacion_por_cliente_con_datos_flotantes_extremos(): void
    {
        // First, create a cliente
        $cliente = \App\Models\Cliente::factory()->create();

        // Create a cotizacion with extreme float values in detalles
        $cotizacion = \App\Models\Cotizacion::factory()
            ->for($cliente)
            ->has(\App\Models\DetalleCotizacion::factory()->count(1)->state([
                'cantidad' => 0.0001,
                'precio_unitario' => 0.0001,
                'subtotal' => 0.00000001,
            ]), 'detalles')
            ->create();

        $response = $this->getJson("/api/v1/clientes/{$cliente->id}/cotizaciones");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'cantidad' => 0.0001,
            'precio_unitario' => 0.0001,
            'subtotal' => 0.00000001,
        ]);
    }

    public function test_cotizacion_por_cliente_con_datos_fecha_futura(): void
    {
        // First, create a cliente
        $cliente = \App\Models\Cliente::factory()->create();

        // Create a cotizacion with a future date for that cliente
        \App\Models\Cotizacion::factory()->create([
            'cliente_id' => $cliente->id,
            'fecha' => now()->addYear()->toDateString(),
        ]);

        $response = $this->getJson("/api/v1/clientes/{$cliente->id}/cotizaciones");

        $response->assertStatus(200);
        $response->assertJsonFragment(['fecha' => now()->addYear()->toDateString()]);
    }

    public function test_cotizacion_por_cliente_con_datos_fecha_pasada(): void
    {
        // First, create a cliente
        $cliente = \App\Models\Cliente::factory()->create();

        // Create a cotizacion with a past date for that cliente
        \App\Models\Cotizacion::factory()->create([
            'cliente_id' => $cliente->id,
            'fecha' => now()->subYears(5)->toDateString(),
        ]);

        $response = $this->getJson("/api/v1/clientes/{$cliente->id}/cotizaciones");

        $response->assertStatus(200);
        $response->assertJsonFragment(['fecha' => now()->subYears(5)->toDateString()]);
    }

    public function test_cotizacion_por_cliente_con_datos_fecha_actual(): void
    {
        // First, create a cliente
        $cliente = \App\Models\Cliente::factory()->create();

        // Create a cotizacion with the current date for that cliente
        \App\Models\Cotizacion::factory()->create([
            'cliente_id' => $cliente->id,
            'fecha' => now()->toDateString(),
        ]);

        $response = $this->getJson("/api/v1/clientes/{$cliente->id}/cotizaciones");

        $response->assertStatus(200);
        $response->assertJsonFragment(['fecha' => now()->toDateString()]);
    }

    public function test_cotizacion_por_cliente_con_datos_fecha_invalida(): void
    {
        // First, create a cliente
        $cliente = \App\Models\Cliente::factory()->create();

        // Attempt to create a cotizacion with an invalid date for that cliente
        $response = $this->postJson('/api/v1/cotizaciones', [
            'cliente_id' => $cliente->id,
            'fecha' => 'invalid-date',
            'total' => 100.00,
        ]);

        $response->assertStatus(422); // Unprocessable Entity due to validation error
    }

    public function test_cotizacion_por_cliente_con_datos_fecha_leap_year(): void
    {
        // First, create a cliente
        $cliente = \App\Models\Cliente::factory()->create();

        // Create a cotizacion with a leap year date for that cliente
        \App\Models\Cotizacion::factory()->create([
            'cliente_id' => $cliente->id,
            'fecha' => '2020-02-29',
        ]);

        $response = $this->getJson("/api/v1/clientes/{$cliente->id}/cotizaciones");

        $response->assertStatus(200);
        $response->assertJsonFragment(['fecha' => '2020-02-29']);
    }

    public function test_cotizacion_por_cliente_con_datos_fecha_no_leap_year(): void
    {
        // First, create a cliente
        $cliente = \App\Models\Cliente::factory()->create();

        // Attempt to create a cotizacion with a non-leap year date for that cliente
        $response = $this->postJson('/api/v1/cotizaciones', [
            'cliente_id' => $cliente->id,
            'fecha' => '2019-02-29',
            'total' => 100.00,
        ]);

        $response->assertStatus(422); // Unprocessable Entity due to validation error
    }
}
