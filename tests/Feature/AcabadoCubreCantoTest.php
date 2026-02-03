<?php

namespace Tests\Feature;

use App\Models\AcabadoCubreCanto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
                    'costo_unitario',
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
            'costo_unitario' => 120.00,
        ]);

        $response = $this->getJson("/api/v1/acabado-cubre-cantos/{$acabadoCubreCanto->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'nombre',
                'costo_unitario',
            ],
        ]);
        $response->assertJsonFragment([
            'nombre' => 'Canto PVC Blanco',
            'costo_unitario' => '120.00',
        ]);
    }

    /**
     * Test that acabado_cubre_canto can be created.
     */
    public function test_acabado_cubre_canto_store(): void
    {
        $acabadoCubreCantoData = [
            'nombre' => 'Canto ABS Negro',
            'costo_unitario' => 150.00,
        ];

        $response = $this->postJson('/api/v1/acabado-cubre-cantos', $acabadoCubreCantoData);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'nombre' => 'Canto ABS Negro',
        ]);

        $this->assertDatabaseHas('acabado_cubre_cantos', [
            'nombre' => 'Canto ABS Negro',
            'costo_unitario' => 150.00,
        ]);
    }

    /**
     * Test that acabado_cubre_canto can be updated.
     */
    public function test_acabado_cubre_canto_update(): void
    {
        $acabadoCubreCanto = AcabadoCubreCanto::factory()->create([
            'nombre' => 'Canto Melamina',
            'costo_unitario' => 80.00,
        ]);

        $updatedData = [
            'nombre' => 'Canto Melamina Premium',
            'costo_unitario' => 100.00,
        ];

        $response = $this->putJson("/api/v1/acabado-cubre-cantos/{$acabadoCubreCanto->id}", $updatedData);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'nombre' => 'Canto Melamina Premium',
            'costo_unitario' => '100.00',
        ]);

        $this->assertDatabaseHas('acabado_cubre_cantos', [
            'id' => $acabadoCubreCanto->id,
            'nombre' => 'Canto Melamina Premium',
            'costo_unitario' => 100.00,
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
        $invalidData = [
            'costo_unitario' => 100.00,
        ];

        $response = $this->postJson('/api/v1/acabado-cubre-cantos', $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre']);
    }

    /**
     * Test validation on acabado_cubre_canto store - costo_unitario is required.
     */
    public function test_acabado_cubre_canto_validation_costo_unitario_required(): void
    {
        $invalidData = [
            'nombre' => 'Canto Aluminio',
        ];

        $response = $this->postJson('/api/v1/acabado-cubre-cantos', $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['costo_unitario']);
    }

    /**
     * Test validation on acabado_cubre_canto store - costo_unitario must be numeric.
     */
    public function test_acabado_cubre_canto_validation_costo_unitario_numeric(): void
    {
        $invalidData = [
            'nombre' => 'Canto Aluminio',
            'costo_unitario' => 'not-a-number',
        ];

        $response = $this->postJson('/api/v1/acabado-cubre-cantos', $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['costo_unitario']);
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
            'costo_unitario' => 999.00,
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
            'costo_unitario' => 180.00,
        ]);

        $duplicateData = [
            'nombre' => 'Canto Roble',
            'costo_unitario' => 190.00,
        ];

        $response = $this->postJson('/api/v1/acabado-cubre-cantos', $duplicateData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre']);
    }
}
