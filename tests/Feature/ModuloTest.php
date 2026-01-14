<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ModuloTest extends TestCase
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

    public function test_modulo_index(): void
    {
        $response = $this->getJson('/api/v1/modulos');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'nombre',
                    'descripcion',
                    'codigo',
                    'componentes',
                ],
            ],
        ]);
    }

    public function test_modulo_show(): void
    {
        // First, create a modulo to show
        $modulo = \App\Models\modulos::factory()->create();

        $response = $this->getJson("/api/v1/modulos/{$modulo->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'nombre',
                'descripcion',
                'codigo',
                'componentes',
            ],
        ]);
    }

    public function test_modulo_with_componentes_and_quantities(): void
    {
        $modulo = \App\Models\modulos::factory()->create();
        $componente = \App\Models\componente::factory()->create();
        
        $modulo->componentes()->attach($componente->id, ['cantidad' => 5]);

        $response = $this->getJson("/api/v1/modulos/{$modulo->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $componente->id,
            'cantidad' => 5,
        ]);
    }

    public function test_modulo_store(): void
    {
        $moduloData = [
            'nombre' => 'Modulo Test',
            'descripcion' => 'Descripcion del Modulo Test',
            'codigo' => 'MOD_TEST_001',
            'componentes' => [],
        ];

        $response = $this->postJson('/api/v1/modulos', $moduloData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('modulos', [
            'nombre' => 'Modulo Test',
            'codigo' => 'MOD_TEST_001',
        ]);
    }

    public function test_modulo_store_with_componentes(): void
    {
        $componente1 = \App\Models\componente::factory()->create();
        $componente2 = \App\Models\componente::factory()->create();

        $moduloData = [
            'nombre' => 'Modulo Con Componentes',
            'descripcion' => 'Modulo con componentes',
            'codigo' => 'MOD_COMP_001',
            'componentes' => [
                ['id' => $componente1->id, 'cantidad' => 2],
                ['id' => $componente2->id, 'cantidad' => 3],
            ],
        ];

        $response = $this->postJson('/api/v1/modulos', $moduloData);

        $response->assertStatus(201);
        $response->assertJsonFragment(['nombre' => 'Modulo Con Componentes']);
    }

    public function test_modulo_update(): void
    {
        // First, create a modulo to update
        $modulo = \App\Models\modulos::factory()->create();

        $updatedData = [
            'nombre' => 'Modulo Updated',
            'descripcion' => 'Descripcion del Modulo Updated',
            'codigo' => 'MOD_UPDATED_001',
        ];

        $response = $this->putJson("/api/v1/modulos/{$modulo->id}", $updatedData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('modulos', $updatedData);
    }

    public function test_modulo_update_with_componentes(): void
    {
        $modulo = \App\Models\modulos::factory()->create();
        $componente1 = \App\Models\componente::factory()->create();
        $componente2 = \App\Models\componente::factory()->create();

        $updatedData = [
            'nombre' => 'Modulo Updated',
            'descripcion' => 'Modulo actualizado con componentes',
            'codigo' => 'MOD_UPDATE_COMP_001',
            'componentes' => [
                ['id' => $componente1->id, 'cantidad' => 1],
                ['id' => $componente2->id, 'cantidad' => 2],
            ],
        ];

        $response = $this->putJson("/api/v1/modulos/{$modulo->id}", $updatedData);

        $response->assertStatus(200);
        $response->assertJsonFragment(['nombre' => 'Modulo Updated']);
    }

    public function test_modulo_destroy(): void
    {
        // First, create a modulo to delete
        $modulo = \App\Models\modulos::factory()->create();

        $response = $this->deleteJson("/api/v1/modulos/{$modulo->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('modulos', ['id' => $modulo->id]);
    }

    public function test_modulo_validation_on_store(): void
    {
        $moduloData = [
            // 'nombre' is missing to trigger validation error
            'descripcion' => 'Descripcion del Modulo Test',
            'codigo' => 'MOD_TEST_001',
        ];

        $response = $this->postJson('/api/v1/modulos', $moduloData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre']);
    }

    public function test_modulo_validation_on_update(): void
    {
        // First, create a modulo to update
        $modulo = \App\Models\modulos::factory()->create();

        $updatedData = [
            'nombre' => '', // Empty nombre to trigger validation error
            'descripcion' => 'Descripcion del Modulo Updated',
            'codigo' => 'MOD_UPDATED_001',
        ];

        $response = $this->putJson("/api/v1/modulos/{$modulo->id}", $updatedData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre']);
    }

    public function test_modulo_store_with_invalid_componente(): void
    {
        $moduloData = [
            'nombre' => 'Modulo Con Componente Invalido',
            'descripcion' => 'Test con componente que no existe',
            'codigo' => 'MOD_INVALID_001',
            'componentes' => [
                ['id' => 9999, 'cantidad' => 2], // Componente que no existe
            ],
        ];

        $response = $this->postJson('/api/v1/modulos', $moduloData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['componentes.0.id']);
    }

    public function test_modulo_update_removes_componentes(): void
    {
        $modulo = \App\Models\modulos::factory()->create();
        $componente = \App\Models\componente::factory()->create();
        
        // Agregar componente
        $modulo->componentes()->attach($componente->id, ['cantidad' => 5]);

        // Actualizar sin componentes
        $updatedData = [
            'nombre' => 'Modulo Sin Componentes',
            'descripcion' => 'Ahora sin componentes',
            'codigo' => 'MOD_NO_COMP_001',
            'componentes' => [],
        ];

        $response = $this->putJson("/api/v1/modulos/{$modulo->id}", $updatedData);

        $response->assertStatus(200);
        
        // Verificar que los componentes fueron removidos
        $modulo->refresh();
        $this->assertEquals(0, $modulo->componentes()->count());
    }
}
