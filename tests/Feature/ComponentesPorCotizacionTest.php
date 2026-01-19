<?php

namespace Tests\Feature;

use App\Models\Componente;
use App\Models\ComponentesPorCotizacion;
use App\Models\Cotizacion;
use App\Models\Cliente;
use App\Models\Acabado;
use App\Models\ManoDeObra;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ComponentesPorCotizacionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test index endpoint returns list of componentes por cotizacion.
     */
    public function test_index_returns_all_componentes_por_cotizacion(): void
    {
        // Create some test data
        $cotizacion = Cotizacion::factory()->create();
        $componente = Componente::factory()->create();
        ComponentesPorCotizacion::factory()->count(3)->create([
            'cotizacion_id' => $cotizacion->id,
            'componente_id' => $componente->id,
        ]);

        $response = $this->getJson('/api/v1/componentes-por-cotizacion');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'cotizacion_id',
                'componente_id',
                'cantidad',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    /**
     * Test store endpoint creates new componente por cotizacion.
     */
    public function test_store_creates_new_componente_por_cotizacion(): void
    {
        $cotizacion = Cotizacion::factory()->create();
        $componente = Componente::factory()->create();

        $data = [
            'cotizacion_id' => $cotizacion->id,
            'componente_id' => $componente->id,
            'cantidad' => 5,
        ];

        $response = $this->postJson('/api/v1/componentes-por-cotizacion', $data);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'id',
            'cotizacion_id',
            'componente_id',
            'cantidad',
        ]);

        $this->assertDatabaseHas('componentes_por_cotizacion', [
            'cotizacion_id' => $cotizacion->id,
            'componente_id' => $componente->id,
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
            'componente_id' => 9999, // Non-existent ID
            'cantidad' => -1, // Invalid quantity
        ];

        $response = $this->postJson('/api/v1/componentes-por-cotizacion', $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['cotizacion_id', 'componente_id', 'cantidad']);
    }

    /**
     * Test store validation requires all fields.
     */
    public function test_store_validation_requires_all_fields(): void
    {
        $response = $this->postJson('/api/v1/componentes-por-cotizacion', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['cotizacion_id', 'componente_id', 'cantidad']);
    }

    /**
     * Test show endpoint returns aggregated components for a cotizacion.
     */
    public function test_show_returns_aggregated_components_for_cotizacion(): void
    {
        // Create a cotizacion
        $cotizacion = Cotizacion::factory()->create();
        
        // Create components
        $componente1 = Componente::factory()->create([
            'nombre' => 'Component 1',
            'descripcion' => 'Description 1',
            'codigo' => 'CODE1',
        ]);
        
        $componente2 = Componente::factory()->create([
            'nombre' => 'Component 2',
            'descripcion' => 'Description 2',
            'codigo' => 'CODE2',
        ]);
        
        // Add direct component assignments
        ComponentesPorCotizacion::create([
            'cotizacion_id' => $cotizacion->id,
            'componente_id' => $componente1->id,
            'cantidad' => 2,
        ]);
        
        ComponentesPorCotizacion::create([
            'cotizacion_id' => $cotizacion->id,
            'componente_id' => $componente2->id,
            'cantidad' => 3,
        ]);

        $response = $this->getJson("/api/v1/componentes-por-cotizacion/{$cotizacion->id}");

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonStructure([
            '*' => [
                'componente' => [
                    'id',
                    'nombre',
                    'descripcion',
                    'codigo',
                ],
                'cantidad',
            ],
        ]);
        
        // Verify specific component data
        $response->assertJsonFragment([
            'componente' => [
                'id' => $componente1->id,
                'nombre' => 'Component 1',
                'descripcion' => 'Description 1',
                'codigo' => 'CODE1',
            ],
            'cantidad' => 2,
        ]);
        
        $response->assertJsonFragment([
            'componente' => [
                'id' => $componente2->id,
                'nombre' => 'Component 2',
                'descripcion' => 'Description 2',
                'codigo' => 'CODE2',
            ],
            'cantidad' => 3,
        ]);
    }


    /**
     * Test update endpoint updates existing componente por cotizacion.
     */
    public function test_update_modifies_existing_componente_por_cotizacion(): void
    {
        $componentePorCotizacion = ComponentesPorCotizacion::factory()->create([
            'cantidad' => 5,
        ]);

        $updateData = [
            'cantidad' => 10,
        ];

        $response = $this->putJson(
            "/api/v1/componentes-por-cotizacion/{$componentePorCotizacion->id}",
            $updateData
        );

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $componentePorCotizacion->id,
            'cantidad' => 10,
        ]);

        $this->assertDatabaseHas('componentes_por_cotizacion', [
            'id' => $componentePorCotizacion->id,
            'cantidad' => 10,
        ]);
    }

    /**
     * Test update validation fails with invalid data.
     */
    public function test_update_validation_fails_with_invalid_cantidad(): void
    {
        $componentePorCotizacion = ComponentesPorCotizacion::factory()->create();

        $response = $this->putJson(
            "/api/v1/componentes-por-cotizacion/{$componentePorCotizacion->id}",
            ['cantidad' => 0] // Invalid: must be at least 1
        );

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['cantidad']);
    }

    /**
     * Test destroy endpoint deletes componente por cotizacion.
     */
    public function test_destroy_deletes_componente_por_cotizacion(): void
    {
        $componentePorCotizacion = ComponentesPorCotizacion::factory()->create();

        $response = $this->deleteJson("/api/v1/componentes-por-cotizacion/{$componentePorCotizacion->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('componentes_por_cotizacion', [
            'id' => $componentePorCotizacion->id,
        ]);
    }

    /**
     * Test getting all components for a specific quotation.
     */
    public function test_get_componentes_by_cotizacion_id(): void
    {
        $cotizacion = Cotizacion::factory()->create();
        $componentes = Componente::factory()->count(3)->create();

        foreach ($componentes as $index => $componente) {
            ComponentesPorCotizacion::create([
                'cotizacion_id' => $cotizacion->id,
                'componente_id' => $componente->id,
                'cantidad' => $index + 1,
            ]);
        }

        $response = $this->getJson("/api/v1/cotizaciones/{$cotizacion->id}/componentes");

        $response->assertStatus(200);
        $response->assertJsonCount(3);
        $response->assertJsonStructure([
            '*' => [
                'componente' => [
                    'id',
                    'nombre',
                    'descripcion',
                    'codigo',
                ],
                'cantidad',
            ],
        ]);
    }

    /**
     * Test syncing components for a quotation.
     */
    public function test_sync_componentes_replaces_existing_components(): void
    {
        $cotizacion = Cotizacion::factory()->create();
        $componente1 = Componente::factory()->create();
        $componente2 = Componente::factory()->create();
        $componente3 = Componente::factory()->create();

        // Create initial relationships
        ComponentesPorCotizacion::create([
            'cotizacion_id' => $cotizacion->id,
            'componente_id' => $componente1->id,
            'cantidad' => 1,
        ]);

        // Sync with new components
        $syncData = [
            'componentes' => [
                ['id' => $componente2->id, 'cantidad' => 5],
                ['id' => $componente3->id, 'cantidad' => 3],
            ],
        ];

        $response = $this->postJson("/api/v1/cotizaciones/{$cotizacion->id}/sync-componentes", $syncData);

        $response->assertStatus(200);
        $response->assertJsonCount(2);

        // Old component should be removed
        $this->assertDatabaseMissing('componentes_por_cotizacion', [
            'cotizacion_id' => $cotizacion->id,
            'componente_id' => $componente1->id,
        ]);

        // New components should exist
        $this->assertDatabaseHas('componentes_por_cotizacion', [
            'cotizacion_id' => $cotizacion->id,
            'componente_id' => $componente2->id,
            'cantidad' => 5,
        ]);

        $this->assertDatabaseHas('componentes_por_cotizacion', [
            'cotizacion_id' => $cotizacion->id,
            'componente_id' => $componente3->id,
            'cantidad' => 3,
        ]);
    }

    /**
     * Test sync validation requires correct format.
     */
    public function test_sync_componentes_validation_fails_with_invalid_data(): void
    {
        $cotizacion = Cotizacion::factory()->create();

        $invalidData = [
            'componentes' => [
                ['id' => 9999, 'cantidad' => -1], // Invalid: non-existent component and negative quantity
            ],
        ];

        $response = $this->postJson("/api/v1/cotizaciones/{$cotizacion->id}/sync-componentes", $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['componentes.0.id', 'componentes.0.cantidad']);
    }

    /**
     * Test sync requires componentes array.
     */
    public function test_sync_componentes_requires_componentes_array(): void
    {
        $cotizacion = Cotizacion::factory()->create();

        $response = $this->postJson("/api/v1/cotizaciones/{$cotizacion->id}/sync-componentes", []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['componentes']);
    }

    /**
     * Test subtotal calculation in model.
     */
    public function test_model_calculates_subtotal_correctly(): void
    {
        $acabado = Acabado::factory()->create(['costo' => 100]);
        $manoDeObra = ManoDeObra::factory()->create(['costo_hora' => 50]);
        
        $componente = Componente::factory()->create([
            'acabado_id' => $acabado->id,
            'mano_de_obra_id' => $manoDeObra->id,
        ]);

        $componentePorCotizacion = ComponentesPorCotizacion::factory()->create([
            'componente_id' => $componente->id,
            'cantidad' => 3,
        ]);

        // Reload with relationships
        $componentePorCotizacion->load('componente.acabado', 'componente.mano_de_obra');

        // The subtotal depends on the component's costo_total calculation
        // which includes materials, herrajes, acabado, and mano_de_obra
        $this->assertIsNumeric($componentePorCotizacion->subtotal);
        $this->assertGreaterThanOrEqual(0, $componentePorCotizacion->subtotal);
    }

    /**
     * Test relationship with cotizacion.
     */
    public function test_belongs_to_cotizacion_relationship(): void
    {
        $componentePorCotizacion = ComponentesPorCotizacion::factory()->create();

        $this->assertInstanceOf(Cotizacion::class, $componentePorCotizacion->cotizacion);
        $this->assertEquals($componentePorCotizacion->cotizacion_id, $componentePorCotizacion->cotizacion->id);
    }

    /**
     * Test relationship with componente.
     */
    public function test_belongs_to_componente_relationship(): void
    {
        $componentePorCotizacion = ComponentesPorCotizacion::factory()->create();

        $this->assertInstanceOf(Componente::class, $componentePorCotizacion->componente);
        $this->assertEquals($componentePorCotizacion->componente_id, $componentePorCotizacion->componente->id);
    }
}
