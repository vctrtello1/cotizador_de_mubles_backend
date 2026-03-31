<?php

namespace Tests\Feature;

use App\Models\AcabadoCubreCanto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AcabadoCubreCantoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that acabado_cubre_canto index endpoint returns all items.
     */
    public function test_acabado_cubre_canto_index(): void
    {
        AcabadoCubreCanto::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/acabado-cubre-cantos');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'nombre',
                ],
            ],
        ]);
    }

    /**
     * Test that acabado_cubre_canto show endpoint returns a single item.
     */
    public function test_acabado_cubre_canto_show(): void
    {
        $acabadoCubreCanto = AcabadoCubreCanto::factory()->create([
            'nombre' => 'Canto PVC Blanco',
        ]);

        $response = $this->getJson("/api/v1/acabado-cubre-cantos/{$acabadoCubreCanto->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'nombre',
            ],
        ]);
        $response->assertJsonFragment([
            'nombre' => 'Canto PVC Blanco',
        ]);
    }

    /**
     * Test that acabado_cubre_canto can be created.
     */
    public function test_acabado_cubre_canto_store(): void
    {
        $acabadoCubreCantoData = [
            'nombre' => 'Canto ABS Negro',
        ];

        $response = $this->postJson('/api/v1/acabado-cubre-cantos', $acabadoCubreCantoData);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'nombre' => 'Canto ABS Negro',
        ]);

        $this->assertDatabaseHas('acabado_cubre_cantos', [
            'nombre' => 'Canto ABS Negro',
        ]);
    }

    /**
     * Test that acabado_cubre_canto can be updated.
     */
    public function test_acabado_cubre_canto_update(): void
    {
        $acabadoCubreCanto = AcabadoCubreCanto::factory()->create([
            'nombre' => 'Canto Melamina',
        ]);

        $updatedData = [
            'nombre' => 'Canto Melamina Premium',
        ];

        $response = $this->putJson("/api/v1/acabado-cubre-cantos/{$acabadoCubreCanto->id}", $updatedData);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'nombre' => 'Canto Melamina Premium',
        ]);

        $this->assertDatabaseHas('acabado_cubre_cantos', [
            'id' => $acabadoCubreCanto->id,
            'nombre' => 'Canto Melamina Premium',
        ]);
    }

    /**
     * Test that acabado_cubre_canto can be deleted.
     */
    public function test_acabado_cubre_canto_delete(): void
    {
        $acabadoCubreCanto = AcabadoCubreCanto::factory()->create();

        $response = $this->deleteJson("/api/v1/acabado-cubre-cantos/{$acabadoCubreCanto->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('acabado_cubre_cantos', [
            'id' => $acabadoCubreCanto->id,
        ]);
    }

    /**
     * Test validation on acabado_cubre_canto store - nombre is required.
     */
    public function test_acabado_cubre_canto_validation_nombre_required(): void
    {
        $invalidData = [];

        $response = $this->postJson('/api/v1/acabado-cubre-cantos', $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre']);
    }

    /**
     * Test validation on acabado_cubre_canto store - costo_unitario is required.
     */
    public function test_acabado_cubre_canto_validation_costo_unitario_required(): void
    {
        $data = [
            'nombre' => 'Canto Aluminio',
        ];

        $response = $this->postJson('/api/v1/acabado-cubre-cantos', $data);

        $response->assertStatus(201);
    }

    /**
     * Test validation on acabado_cubre_canto store - costo_unitario must be numeric.
     */
    public function test_acabado_cubre_canto_validation_costo_unitario_numeric(): void
    {
        $data = [
            'nombre' => 'Canto Aluminio 2',
        ];

        $response = $this->postJson('/api/v1/acabado-cubre-cantos', $data);

        $response->assertStatus(201);
    }

    /**
     * Test that acabado_cubre_canto show returns 404 for non-existent ID.
     */
    public function test_acabado_cubre_canto_not_found(): void
    {
        $nonExistentId = 9999;

        $response = $this->getJson("/api/v1/acabado-cubre-cantos/{$nonExistentId}");

        $response->assertStatus(404);
    }

    /**
     * Test that acabado_cubre_canto delete returns 404 for non-existent ID.
     */
    public function test_acabado_cubre_canto_delete_not_found(): void
    {
        $nonExistentId = 9999;

        $response = $this->deleteJson("/api/v1/acabado-cubre-cantos/{$nonExistentId}");

        $response->assertStatus(404);
    }

    /**
     * Test that acabado_cubre_canto update returns 404 for non-existent ID.
     */
    public function test_acabado_cubre_canto_update_not_found(): void
    {
        $nonExistentId = 9999;
        
        $updatedData = [
            'nombre' => 'Canto Inexistente',
        ];

        $response = $this->putJson("/api/v1/acabado-cubre-cantos/{$nonExistentId}", $updatedData);

        $response->assertStatus(404);
    }

    /**
     * Test that acabado_cubre_canto nombre must be unique.
     */
    public function test_acabado_cubre_canto_nombre_unique(): void
    {
        AcabadoCubreCanto::factory()->create([
            'nombre' => 'Canto Roble',
        ]);

        $duplicateData = [
            'nombre' => 'Canto Roble',
        ];

        $response = $this->postJson('/api/v1/acabado-cubre-cantos', $duplicateData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre']);
    }
}
