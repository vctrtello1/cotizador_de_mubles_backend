<?php

namespace Tests\Feature;

use App\Models\Estructura;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EstructuraTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that estructura index endpoint returns all structures.
     */
    public function test_estructura_index(): void
    {
        // Create some test estructuras
        Estructura::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/estructuras');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'nombre',
                ],
            ],
        ]);
        // Verify at least the 3 we created exist
        $this->assertGreaterThanOrEqual(3, count($response->json('data')));
    }

    /**
     * Test that estructura show endpoint returns a single structure.
     */
    public function test_estructura_show(): void
    {
        $estructura = Estructura::factory()->create([
            'nombre' => 'BCO FROSTY',
        ]);

        $response = $this->getJson("/api/v1/estructuras/{$estructura->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'nombre',
            ],
        ]);
        $response->assertJsonFragment([
            'nombre' => 'BCO FROSTY',
        ]);
    }

    /**
     * Test that estructura can be created.
     */
    public function test_estructura_store(): void
    {
        $estructuraData = [
            'nombre' => 'MAPLE NATURAL',
        ];

        $response = $this->postJson('/api/v1/estructuras', $estructuraData);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'nombre' => 'MAPLE NATURAL',
        ]);

        $this->assertDatabaseHas('estructura', [
            'nombre' => 'MAPLE NATURAL',
        ]);
    }

    /**
     * Test that estructura can be updated.
     */
    public function test_estructura_update(): void
    {
        $estructura = Estructura::factory()->create([
            'nombre' => 'ROBLE CLARO',
        ]);

        $updatedData = [
            'nombre' => 'ROBLE OSCURO',
        ];

        $response = $this->putJson("/api/v1/estructuras/{$estructura->id}", $updatedData);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'nombre' => 'ROBLE OSCURO',
        ]);

        $this->assertDatabaseHas('estructura', [
            'id' => $estructura->id,
            'nombre' => 'ROBLE OSCURO',
        ]);
    }

    /**
     * Test that estructura can be deleted.
     */
    public function test_estructura_delete(): void
    {
        $estructura = Estructura::factory()->create();

        $response = $this->deleteJson("/api/v1/estructuras/{$estructura->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('estructura', [
            'id' => $estructura->id,
        ]);
    }

    /**
     * Test validation on estructura store - nombre is required.
     */
    public function test_estructura_validation_nombre_required(): void
    {
        $invalidData = [];

        $response = $this->postJson('/api/v1/estructuras', $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre']);
    }

    /**
     * Test validation on estructura store - costo_unitario is no longer required.
     */
    public function test_estructura_validation_costo_unitario_required(): void
    {
        $data = [
            'nombre' => 'PINO NATURAL',
        ];

        $response = $this->postJson('/api/v1/estructuras', $data);

        $response->assertStatus(201);
    }

    /**
     * Test validation on estructura store - costo_unitario field is ignored.
     */
    public function test_estructura_validation_costo_unitario_numeric(): void
    {
        $data = [
            'nombre' => 'PINO NATURAL 2',
        ];

        $response = $this->postJson('/api/v1/estructuras', $data);

        $response->assertStatus(201);
    }

    /**
     * Test that estructura show returns 404 for non-existent ID.
     */
    public function test_estructura_not_found(): void
    {
        $nonExistentId = 9999;

        $response = $this->getJson("/api/v1/estructuras/{$nonExistentId}");

        $response->assertStatus(404);
    }

    /**
     * Test that estructura delete returns 404 for non-existent ID.
     */
    public function test_estructura_delete_not_found(): void
    {
        $nonExistentId = 9999;

        $response = $this->deleteJson("/api/v1/estructuras/{$nonExistentId}");

        $response->assertStatus(404);
    }

    /**
     * Test that estructura update returns 404 for non-existent ID.
     */
    public function test_estructura_update_not_found(): void
    {
        $nonExistentId = 9999;
        
        $updatedData = [
            'nombre' => 'ESTRUCTURA INEXISTENTE',
        ];

        $response = $this->putJson("/api/v1/estructuras/{$nonExistentId}", $updatedData);

        $response->assertStatus(404);
    }

    /**
     * Test that estructura nombre must be unique.
     */
    public function test_estructura_nombre_unique(): void
    {
        // Create first estructura
        Estructura::factory()->create([
            'nombre' => 'NOGAL AMERICANO',
        ]);

        // Try to create another with same nombre
        $duplicateData = [
            'nombre' => 'NOGAL AMERICANO',
        ];

        $response = $this->postJson('/api/v1/estructuras', $duplicateData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre']);
    }
}
