<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CotizacionTest extends TestCase
{
    use RefreshDatabase;

    private int $clienteId;
    private int $otroClienteId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->clienteId = \App\Models\Cliente::factory()->create()->id;
        $this->otroClienteId = \App\Models\Cliente::factory()->create()->id;
    }

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
                    'estado',
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
                'estado',
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
            ],
        ]);
    }


    public function test_cotizacion_store(): void
    {
        $cotizacionData = [
            'cliente_id' => $this->clienteId,
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
            'cliente_id' => $this->clienteId,
            'fecha' => '2024-01-01',
            'total' => 1300.00,
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
            'cliente_id' => $this->clienteId,
            'fecha' => '2024-01-01',
            'total' => 1300.00,
        ]);
    }


    public function test_cotizacion_update(): void
    {
        // First, create a cotizacion to update
        $cotizacion = \App\Models\Cotizacion::factory()->create();

        $updateData = [
            'cliente_id' => $this->otroClienteId,
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
                }), 'detalles'
            )
            ->create();

        $expectedTotal = 2 * 250.00 * 2; // 2 detalles, each with cantidad 2 and precio_unitario 250.00

        // Usar el método calculateTotal() en lugar del accessor
        $this->assertEquals($expectedTotal, $cotizacion->calculateTotal());
        
        // Actualizar el total en la BD
        $cotizacion->total = $cotizacion->calculateTotal();
        $cotizacion->save();
        
        // Verificar que se guardó correctamente
        $this->assertEquals($expectedTotal, $cotizacion->fresh()->total);
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
            'cliente_id' => $this->otroClienteId,
            'fecha' => '2024-02-01',
            'total' => 2000.00,
        ];

        $response = $this->putJson('/api/v1/cotizaciones/999999', $updateData); // Non-existent ID

        $response->assertStatus(404);
    }

    public function test_cotizacion_empty_detalles(): void
    {
        $cotizacionData = [
            'cliente_id' => $this->clienteId,
            'fecha' => '2024-01-01',
            'total' => 0.00,
            'detalles' => [],
        ];

        $response = $this->postJson('/api/v1/cotizaciones', $cotizacionData);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'cliente_id' => $this->clienteId,
            'fecha' => '2024-01-01',
            'total' => 0.00,
        ]);
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
            'cliente_id' => $this->clienteId,
            'fecha' => '2024-01-01',
            'total' => 1000.00,
            'detalles' => $detalles,
        ];

        $response = $this->postJson('/api/v1/cotizaciones', $cotizacionData);

        $response->assertStatus(201);
    }


    public function test_cotizacion_date_format(): void
    {
        $cotizacionData = [
            'cliente_id' => $this->clienteId,
            'fecha' => '2024-12-31', // Valid date format
            'total' => 500.00,
        ];

        $response = $this->postJson('/api/v1/cotizaciones', $cotizacionData);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'fecha' => '2024-12-31',
        ]);
    }

    public function test_cotizacion_create_with_estado_activa(): void
    {
        $cotizacionData = [
            'cliente_id' => $this->clienteId,
            'fecha' => '2024-01-01',
            'total' => 1000.00,
            'estado' => 'activa',
        ];

        $response = $this->postJson('/api/v1/cotizaciones', $cotizacionData);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'estado' => 'activa',
        ]);
    }

    public function test_cotizacion_create_with_estado_cancelada(): void
    {
        $cotizacionData = [
            'cliente_id' => $this->clienteId,
            'fecha' => '2024-01-01',
            'total' => 1000.00,
            'estado' => 'cancelada',
        ];

        $response = $this->postJson('/api/v1/cotizaciones', $cotizacionData);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'estado' => 'cancelada',
        ]);
    }

    public function test_cotizacion_create_with_estado_completada(): void
    {
        $cotizacionData = [
            'cliente_id' => $this->clienteId,
            'fecha' => '2024-01-01',
            'total' => 1000.00,
            'estado' => 'completada',
        ];

        $response = $this->postJson('/api/v1/cotizaciones', $cotizacionData);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'estado' => 'completada',
        ]);
    }

    public function test_cotizacion_create_default_estado_activa(): void
    {
        $cotizacionData = [
            'cliente_id' => $this->clienteId,
            'fecha' => '2024-01-01',
            'total' => 1000.00,
        ];

        $response = $this->postJson('/api/v1/cotizaciones', $cotizacionData);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'estado' => 'activa',
        ]);
    }

    public function test_cotizacion_update_estado(): void
    {
        $cotizacion = \App\Models\Cotizacion::factory()->activa()->create();

        $updateData = [
            'estado' => 'completada',
        ];

        $response = $this->putJson("/api/v1/cotizaciones/{$cotizacion->id}", $updateData);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'estado' => 'completada',
        ]);
    }

    public function test_cotizacion_invalid_estado(): void
    {
        $cotizacionData = [
            'cliente_id' => $this->clienteId,
            'fecha' => '2024-01-01',
            'total' => 1000.00,
            'estado' => 'invalido',
        ];

        $response = $this->postJson('/api/v1/cotizaciones', $cotizacionData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['estado']);
    }

    public function test_cotizacion_factory_activa(): void
    {
        $cotizacion = \App\Models\Cotizacion::factory()->activa()->create();

        $this->assertEquals('activa', $cotizacion->estado);
        $this->assertDatabaseHas('cotizaciones', [
            'id' => $cotizacion->id,
            'estado' => 'activa',
        ]);
    }

    public function test_cotizacion_factory_cancelada(): void
    {
        $cotizacion = \App\Models\Cotizacion::factory()->cancelada()->create();

        $this->assertEquals('cancelada', $cotizacion->estado);
        $this->assertDatabaseHas('cotizaciones', [
            'id' => $cotizacion->id,
            'estado' => 'cancelada',
        ]);
    }

    public function test_cotizacion_factory_completada(): void
    {
        $cotizacion = \App\Models\Cotizacion::factory()->completada()->create();

        $this->assertEquals('completada', $cotizacion->estado);
        $this->assertDatabaseHas('cotizaciones', [
            'id' => $cotizacion->id,
            'estado' => 'completada',
        ]);
    }

    public function test_cotizacion_show_includes_estado(): void
    {
        $cotizacion = \App\Models\Cotizacion::factory()->activa()->create();

        $response = $this->getJson("/api/v1/cotizaciones/{$cotizacion->id}");

        $response->assertStatus(200);
        $response->assertJsonPath('data.estado', 'activa');
    }

    public function test_cotizacion_update_estado_to_activa(): void
    {
        $cotizacion = \App\Models\Cotizacion::factory()->create(['estado' => 'cancelada']);

        $response = $this->putJson("/api/v1/cotizaciones/{$cotizacion->id}/estado", [
            'estado' => 'activa',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('data.estado', 'activa');
        $this->assertDatabaseHas('cotizaciones', [
            'id' => $cotizacion->id,
            'estado' => 'activa',
        ]);
    }

    public function test_cotizacion_update_estado_to_pendiente(): void
    {
        $cotizacion = \App\Models\Cotizacion::factory()->activa()->create();

        $response = $this->putJson("/api/v1/cotizaciones/{$cotizacion->id}/estado", [
            'estado' => 'pendiente',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('data.estado', 'pendiente');
        $this->assertDatabaseHas('cotizaciones', [
            'id' => $cotizacion->id,
            'estado' => 'pendiente',
        ]);
    }

    public function test_cotizacion_update_estado_to_completada(): void
    {
        $cotizacion = \App\Models\Cotizacion::factory()->create(['estado' => 'pendiente']);

        $response = $this->putJson("/api/v1/cotizaciones/{$cotizacion->id}/estado", [
            'estado' => 'completada',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('data.estado', 'completada');
        $this->assertDatabaseHas('cotizaciones', [
            'id' => $cotizacion->id,
            'estado' => 'completada',
        ]);
    }

    public function test_cotizacion_update_estado_to_rechazada(): void
    {
        $cotizacion = \App\Models\Cotizacion::factory()->create(['estado' => 'pendiente']);

        $response = $this->putJson("/api/v1/cotizaciones/{$cotizacion->id}/estado", [
            'estado' => 'rechazada',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('data.estado', 'rechazada');
        $this->assertDatabaseHas('cotizaciones', [
            'id' => $cotizacion->id,
            'estado' => 'rechazada',
        ]);
    }

    public function test_cotizacion_update_estado_to_cancelada(): void
    {
        $cotizacion = \App\Models\Cotizacion::factory()->activa()->create();

        $response = $this->putJson("/api/v1/cotizaciones/{$cotizacion->id}/estado", [
            'estado' => 'cancelada',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('data.estado', 'cancelada');
        $this->assertDatabaseHas('cotizaciones', [
            'id' => $cotizacion->id,
            'estado' => 'cancelada',
        ]);
    }

    public function test_cotizacion_update_estado_invalid_value(): void
    {
        $cotizacion = \App\Models\Cotizacion::factory()->activa()->create();

        $response = $this->putJson("/api/v1/cotizaciones/{$cotizacion->id}/estado", [
            'estado' => 'estado_invalido',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['estado']);
    }

    public function test_cotizacion_update_estado_missing_parameter(): void
    {
        $cotizacion = \App\Models\Cotizacion::factory()->activa()->create();

        $response = $this->putJson("/api/v1/cotizaciones/{$cotizacion->id}/estado", []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['estado']);
    }

    public function test_cotizacion_update_estado_not_found(): void
    {
        $response = $this->putJson("/api/v1/cotizaciones/99999/estado", [
            'estado' => 'activa',
        ]);

        $response->assertStatus(404);
    }

    public function test_cotizacion_delete_with_related_components(): void
    {
        // Create a cotización with related componentes_por_cotizacion
        $cotizacion = \App\Models\Cotizacion::factory()->create();
        $componente = \App\Models\Componente::factory()->create();
        $modulo = \App\Models\modulos::factory()->create();
        
        // Create related componentes_por_cotizacion
        \DB::table('componentes_por_cotizacion')->insert([
            [
                'cotizacion_id' => $cotizacion->id,
                'componente_id' => $componente->id,
                'modulo_id' => $modulo->id,
                'cantidad' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cotizacion_id' => $cotizacion->id,
                'componente_id' => $componente->id,
                'modulo_id' => $modulo->id,
                'cantidad' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Verify componentes_por_cotizacion exist before deletion
        $this->assertDatabaseHas('componentes_por_cotizacion', [
            'cotizacion_id' => $cotizacion->id,
        ]);

        // Delete the cotización
        $response = $this->deleteJson("/api/v1/cotizaciones/{$cotizacion->id}");

        $response->assertStatus(204);

        // Verify cotización was deleted
        $this->assertDatabaseMissing('cotizaciones', [
            'id' => $cotizacion->id,
        ]);

        // Verify related componentes_por_cotizacion were also deleted (cascade)
        $this->assertDatabaseMissing('componentes_por_cotizacion', [
            'cotizacion_id' => $cotizacion->id,
        ]);
    }
}
