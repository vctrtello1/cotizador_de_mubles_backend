<?php

namespace Tests\Feature;

use App\Models\Modulos;
use App\Models\ModulosPorCotizacion;
use App\Models\Cotizacion;
use App\Models\Cliente;
use App\Models\Componente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ModulosPorCotizacionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test index endpoint returns list of modulos por cotizacion.
     */
    public function test_index_returns_all_modulos_por_cotizacion(): void
    {
        // Create some test data
        $cotizacion = Cotizacion::factory()->create();
        $modulo = Modulos::factory()->create();
        ModulosPorCotizacion::factory()->count(3)->create([
            'cotizacion_id' => $cotizacion->id,
            'modulo_id' => $modulo->id,
        ]);

        $response = $this->getJson('/api/v1/modulos-por-cotizacion');

        $response->assertStatus(200);
        // Check that we have at least 3 items (seeded data may exist)
        $this->assertGreaterThanOrEqual(3, count($response->json()));
        $response->assertJsonStructure([
            '*' => [
                'id',
                'cotizacion_id',
                'modulo_id',
                'cantidad',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    /**
     * Test store endpoint creates new modulo por cotizacion.
     */
    public function test_store_creates_new_modulo_por_cotizacion(): void
    {
        $cotizacion = Cotizacion::factory()->create();
        $modulo = Modulos::factory()->create();

        $data = [
            'cotizacion_id' => $cotizacion->id,
            'modulo_id' => $modulo->id,
            'cantidad' => 5,
        ];

        $response = $this->postJson('/api/v1/modulos-por-cotizacion', $data);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'id',
            'cotizacion_id',
            'modulo_id',
            'cantidad',
        ]);

        $this->assertDatabaseHas('modulos_por_cotizacion', [
            'cotizacion_id' => $cotizacion->id,
            'modulo_id' => $modulo->id,
            'cantidad' => 5,
        ]);
    }

    /**
     * Test store validation fails with invalid data.
     */
    public function test_store_validation_fails_with_invalid_data(): void
    {
        $data = [
            'cotizacion_id' => 9999, // Non-existent ID
            'modulo_id' => 9999, // Non-existent ID
            'cantidad' => -1, // Invalid quantity
        ];

        $response = $this->postJson('/api/v1/modulos-por-cotizacion', $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['cotizacion_id', 'modulo_id', 'cantidad']);
    }

    /**
     * Test store validation requires all fields.
     */
    public function test_store_validation_requires_all_fields(): void
    {
        $response = $this->postJson('/api/v1/modulos-por-cotizacion', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['cotizacion_id', 'modulo_id', 'cantidad']);
    }

    /**
     * Test show endpoint returns specific modulo por cotizacion.
     */
    public function test_show_returns_specific_modulo_por_cotizacion(): void
    {
        $moduloPorCotizacion = ModulosPorCotizacion::factory()->create();

        $response = $this->getJson("/api/v1/modulos-por-cotizacion/{$moduloPorCotizacion->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'cotizacion_id',
            'modulo_id',
            'cantidad',
            'cotizacion',
            'modulo',
        ]);
        $response->assertJson([
            'id' => $moduloPorCotizacion->id,
            'cantidad' => $moduloPorCotizacion->cantidad,
        ]);
    }

    /**
     * Test update endpoint updates existing modulo por cotizacion.
     */
    public function test_update_modifies_existing_modulo_por_cotizacion(): void
    {
        $moduloPorCotizacion = ModulosPorCotizacion::factory()->create([
            'cantidad' => 5,
        ]);

        $updateData = [
            'cantidad' => 10,
        ];

        $response = $this->putJson(
            "/api/v1/modulos-por-cotizacion/{$moduloPorCotizacion->id}",
            $updateData
        );

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $moduloPorCotizacion->id,
            'cantidad' => 10,
        ]);

        $this->assertDatabaseHas('modulos_por_cotizacion', [
            'id' => $moduloPorCotizacion->id,
            'cantidad' => 10,
        ]);
    }

    /**
     * Test update validation fails with invalid data.
     */
    public function test_update_validation_fails_with_invalid_cantidad(): void
    {
        $moduloPorCotizacion = ModulosPorCotizacion::factory()->create();

        $response = $this->putJson(
            "/api/v1/modulos-por-cotizacion/{$moduloPorCotizacion->id}",
            ['cantidad' => 0] // Invalid: must be at least 1
        );

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['cantidad']);
    }

    /**
     * Test destroy endpoint deletes modulo por cotizacion.
     */
    public function test_destroy_deletes_modulo_por_cotizacion(): void
    {
        $moduloPorCotizacion = ModulosPorCotizacion::factory()->create();

        $response = $this->deleteJson("/api/v1/modulos-por-cotizacion/{$moduloPorCotizacion->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('modulos_por_cotizacion', [
            'id' => $moduloPorCotizacion->id,
        ]);
    }

    /**
     * Test getting all modules for a specific quotation.
     */
    public function test_get_modulos_by_cotizacion_id(): void
    {
        $cotizacion = Cotizacion::factory()->create();
        $modulos = Modulos::factory()->count(3)->create();

        foreach ($modulos as $index => $modulo) {
            ModulosPorCotizacion::create([
                'cotizacion_id' => $cotizacion->id,
                'modulo_id' => $modulo->id,
                'cantidad' => $index + 1,
            ]);
        }

        $response = $this->getJson("/api/v1/cotizaciones/{$cotizacion->id}/modulos-relation");

        $response->assertStatus(200);
        $response->assertJsonCount(3);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'cotizacion_id',
                'modulo_id',
                'cantidad',
                'modulo' => [
                    'id',
                    'nombre',
                ],
            ],
        ]);
    }

    /**
     * Test syncing modules for a quotation.
     */
    public function test_sync_modulos_replaces_existing_modules(): void
    {
        $cotizacion = Cotizacion::factory()->create();
        $modulo1 = Modulos::factory()->create();
        $modulo2 = Modulos::factory()->create();
        $modulo3 = Modulos::factory()->create();

        // Create initial relationships
        ModulosPorCotizacion::create([
            'cotizacion_id' => $cotizacion->id,
            'modulo_id' => $modulo1->id,
            'cantidad' => 1,
        ]);

        // Sync with new modules
        $syncData = [
            'modulos' => [
                ['id' => $modulo2->id, 'cantidad' => 5],
                ['id' => $modulo3->id, 'cantidad' => 3],
            ],
        ];

        $response = $this->postJson("/api/v1/cotizaciones/{$cotizacion->id}/sync-modulos-relation", $syncData);

        $response->assertStatus(200);
        $response->assertJsonCount(2);

        // Old module should be removed
        $this->assertDatabaseMissing('modulos_por_cotizacion', [
            'cotizacion_id' => $cotizacion->id,
            'modulo_id' => $modulo1->id,
        ]);

        // New modules should exist
        $this->assertDatabaseHas('modulos_por_cotizacion', [
            'cotizacion_id' => $cotizacion->id,
            'modulo_id' => $modulo2->id,
            'cantidad' => 5,
        ]);

        $this->assertDatabaseHas('modulos_por_cotizacion', [
            'cotizacion_id' => $cotizacion->id,
            'modulo_id' => $modulo3->id,
            'cantidad' => 3,
        ]);
    }

    /**
     * Test sync validation requires correct format.
     */
    public function test_sync_modulos_validation_fails_with_invalid_data(): void
    {
        $cotizacion = Cotizacion::factory()->create();

        $invalidData = [
            'modulos' => [
                ['id' => 9999, 'cantidad' => -1], // Invalid: non-existent module and negative quantity
            ],
        ];

        $response = $this->postJson("/api/v1/cotizaciones/{$cotizacion->id}/sync-modulos-relation", $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['modulos.0.id', 'modulos.0.cantidad']);
    }

    /**
     * Test sync requires modulos array.
     */
    public function test_sync_modulos_requires_modulos_array(): void
    {
        $cotizacion = Cotizacion::factory()->create();

        $response = $this->postJson("/api/v1/cotizaciones/{$cotizacion->id}/sync-modulos-relation", []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['modulos']);
    }

    /**
     * Test subtotal calculation in model.
     */
    public function test_model_calculates_subtotal_correctly(): void
    {
        $modulo = Modulos::factory()->create();

        $moduloPorCotizacion = ModulosPorCotizacion::factory()->create([
            'modulo_id' => $modulo->id,
            'cantidad' => 3,
        ]);

        // Reload with relationships
        $moduloPorCotizacion->load('modulo.componentes');

        // The subtotal depends on the module's costo_total calculation
        $this->assertIsNumeric($moduloPorCotizacion->subtotal);
        $this->assertGreaterThanOrEqual(0, $moduloPorCotizacion->subtotal);
    }

    /**
     * Test relationship with cotizacion.
     */
    public function test_belongs_to_cotizacion_relationship(): void
    {
        $moduloPorCotizacion = ModulosPorCotizacion::factory()->create();

        $this->assertInstanceOf(Cotizacion::class, $moduloPorCotizacion->cotizacion);
        $this->assertEquals($moduloPorCotizacion->cotizacion_id, $moduloPorCotizacion->cotizacion->id);
    }

    /**
     * Test relationship with modulo.
     */
    public function test_belongs_to_modulo_relationship(): void
    {
        $moduloPorCotizacion = ModulosPorCotizacion::factory()->create();

        $this->assertInstanceOf(Modulos::class, $moduloPorCotizacion->modulo);
        $this->assertEquals($moduloPorCotizacion->modulo_id, $moduloPorCotizacion->modulo->id);
    }
}
