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
                    'costo_unitario',
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
            'costo_unitario' => 800.00,
        ]);

        $response = $this->getJson("/api/v1/estructuras/{$estructura->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'nombre',
                'costo_unitario',
            ],
        ]);
        $response->assertJsonFragment([
            'nombre' => 'BCO FROSTY',
            'costo_unitario' => '800.00',
        ]);
    }

    /**
     * Test that estructura can be created.
     */
    public function test_estructura_store(): void
    {
        $estructuraData = [
            'nombre' => 'MAPLE NATURAL',
            'costo_unitario' => 950.00,
        ];

        $response = $this->postJson('/api/v1/estructuras', $estructuraData);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'nombre' => 'MAPLE NATURAL',
        ]);

        $this->assertDatabaseHas('estructura', [
            'nombre' => 'MAPLE NATURAL',
            'costo_unitario' => 950.00,
        ]);
    }

    /**
     * Test that estructura can be updated.
     */
    public function test_estructura_update(): void
    {
        $estructura = Estructura::factory()->create([
            'nombre' => 'ROBLE CLARO',
            'costo_unitario' => 700.00,
        ]);

        $updatedData = [
            'nombre' => 'ROBLE OSCURO',
            'costo_unitario' => 850.00,
        ];

        $response = $this->putJson("/api/v1/estructuras/{$estructura->id}", $updatedData);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'nombre' => 'ROBLE OSCURO',
            'costo_unitario' => '850.00',
        ]);

        $this->assertDatabaseHas('estructura', [
            'id' => $estructura->id,
            'nombre' => 'ROBLE OSCURO',
            'costo_unitario' => 850.00,
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
        $invalidData = [
            'costo_unitario' => 500.00,
        ];

        $response = $this->postJson('/api/v1/estructuras', $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre']);
    }

    /**
     * Test validation on estructura store - costo_unitario is required.
     */
    public function test_estructura_validation_costo_unitario_required(): void
    {
        $invalidData = [
            'nombre' => 'PINO NATURAL',
        ];

        $response = $this->postJson('/api/v1/estructuras', $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['costo_unitario']);
    }

    /**
     * Test validation on estructura store - costo_unitario must be numeric.
     */
    public function test_estructura_validation_costo_unitario_numeric(): void
    {
        $invalidData = [
            'nombre' => 'PINO NATURAL',
            'costo_unitario' => 'not-a-number',
        ];

        $response = $this->postJson('/api/v1/estructuras', $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['costo_unitario']);
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
            'costo_unitario' => 999.00,
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
            'costo_unitario' => 1100.00,
        ]);

        // Try to create another with same nombre
        $duplicateData = [
            'nombre' => 'NOGAL AMERICANO',
            'costo_unitario' => 1200.00,
        ];

        $response = $this->postJson('/api/v1/estructuras', $duplicateData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre']);
    }
}
