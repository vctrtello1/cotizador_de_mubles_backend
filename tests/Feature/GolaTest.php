<?php

namespace Tests\Feature;

use App\Models\Gola;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GolaTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test gola index endpoint returns all golas
     */
    public function test_gola_index(): void
    {
        // Create some golas
        Gola::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/golas');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'nombre',
                    'descripcion',
                    'precio',
                ],
            ],
        ]);
        $response->assertJsonCount(6, 'data'); // 3 from seed + 3 created
    }

    /**
     * Test gola show endpoint returns a specific gola
     */
    public function test_gola_show(): void
    {
        $gola = Gola::factory()->create([
            'nombre' => 'Gola Test',
            'descripcion' => 'Descripción de prueba',
            'precio' => 500.00,
        ]);

        $response = $this->getJson("/api/v1/golas/{$gola->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'nombre',
                'descripcion',
                'precio',
            ],
        ]);
        $response->assertJsonPath('data.nombre', 'Gola Test');
        $response->assertJsonPath('data.precio', '500.00');
    }

    /**
     * Test gola store successfully creates a new gola
     */
    public function test_gola_store(): void
    {
        $golaData = [
            'nombre' => 'LATERAL',
            'descripcion' => 'Gola lateral',
            'precio' => 550.00,
        ];

        $response = $this->postJson('/api/v1/golas', $golaData);

        $response->assertStatus(201);
        $response->assertJsonPath('data.nombre', 'LATERAL');
        $response->assertJsonPath('data.descripcion', 'Gola lateral');
        $response->assertJsonPath('data.precio', '550.00');

        // Verify database
        $this->assertDatabaseHas('table_gola', [
            'nombre' => 'LATERAL',
            'descripcion' => 'Gola lateral',
            'precio' => 550.00,
        ]);
    }

    /**
     * Test gola store with nullable description
     */
    public function test_gola_store_without_description(): void
    {
        $golaData = [
            'nombre' => 'PREMIUM',
            'precio' => 1200.00,
        ];

        $response = $this->postJson('/api/v1/golas', $golaData);

        $response->assertStatus(201);
        $response->assertJsonPath('data.nombre', 'PREMIUM');
        $response->assertJsonPath('data.precio', '1200.00');
        
        $this->assertDatabaseHas('table_gola', [
            'nombre' => 'PREMIUM',
            'precio' => 1200.00,
        ]);
    }

    /**
     * Test gola update successfully modifies an existing gola
     */
    public function test_gola_update(): void
    {
        $gola = Gola::factory()->create();

        $updatedData = [
            'nombre' => 'INFERIOR ACTUALIZADA',
            'descripcion' => 'Gola inferior actualizada',
            'precio' => 850.00,
        ];

        $response = $this->putJson("/api/v1/golas/{$gola->id}", $updatedData);

        $response->assertStatus(200);
        $response->assertJsonPath('data.nombre', 'INFERIOR ACTUALIZADA');
        $response->assertJsonPath('data.descripcion', 'Gola inferior actualizada');
        $response->assertJsonPath('data.precio', '850.00');

        // Verify database
        $this->assertDatabaseHas('table_gola', [
            'id' => $gola->id,
            'nombre' => 'INFERIOR ACTUALIZADA',
            'precio' => 850.00,
        ]);
    }

    /**
     * Test partial update of gola
     */
    public function test_gola_partial_update(): void
    {
        $gola = Gola::factory()->create([
            'nombre' => 'Original',
            'precio' => 100.00,
        ]);

        $response = $this->putJson("/api/v1/golas/{$gola->id}", [
            'precio' => 200.00,
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('data.precio', '200.00');
        
        // Original nombre should remain
        $this->assertDatabaseHas('table_gola', [
            'id' => $gola->id,
            'nombre' => 'Original',
            'precio' => 200.00,
        ]);
    }

    /**
     * Test gola delete removes the record
     */
    public function test_gola_delete(): void
    {
        $gola = Gola::factory()->create();

        $response = $this->deleteJson("/api/v1/golas/{$gola->id}");

        $response->assertStatus(204);

        // Verify that the gola is deleted
        $this->assertDatabaseMissing('table_gola', ['id' => $gola->id]);
    }

    /**
     * Test validation: nombre is required
     */
    public function test_gola_validation_nombre_required(): void
    {
        $invalidData = [
            'descripcion' => 'Descripcion sin nombre',
            'precio' => 100,
        ];

        $response = $this->postJson('/api/v1/golas', $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre']);
    }

    /**
     * Test validation: precio is required
     */
    public function test_gola_validation_precio_required(): void
    {
        $invalidData = [
            'nombre' => 'Test Gola',
            'descripcion' => 'Descripcion sin precio',
        ];

        $response = $this->postJson('/api/v1/golas', $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['precio']);
    }

    /**
     * Test validation: precio must be numeric
     */
    public function test_gola_validation_precio_numeric(): void
    {
        $gola = Gola::factory()->create();

        $invalidData = [
            'nombre' => 'Test',
            'precio' => 'not-a-number',
        ];

        $response = $this->putJson("/api/v1/golas/{$gola->id}", $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['precio']);
    }

    /**
     * Test validation: precio cannot be negative
     */
    public function test_gola_validation_precio_not_negative(): void
    {
        $invalidData = [
            'nombre' => 'Test',
            'precio' => -100,
        ];

        $response = $this->postJson('/api/v1/golas', $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['precio']);
    }

    /**
     * Test validation: nombre max length
     */
    public function test_gola_validation_nombre_max_length(): void
    {
        $invalidData = [
            'nombre' => str_repeat('a', 256), // 256 characters, max is 255
            'precio' => 100,
        ];

        $response = $this->postJson('/api/v1/golas', $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre']);
    }

    /**
     * Test gola not found returns 404
     */
    public function test_gola_not_found(): void
    {
        $nonExistentId = 99999;

        $response = $this->getJson("/api/v1/golas/{$nonExistentId}");

        $response->assertStatus(404);
    }

    /**
     * Test update gola not found returns 404
     */
    public function test_gola_update_not_found(): void
    {
        $nonExistentId = 99999;

        $response = $this->putJson("/api/v1/golas/{$nonExistentId}", [
            'nombre' => 'Test',
            'precio' => 100,
        ]);

        $response->assertStatus(404);
    }

    /**
     * Test delete gola not found returns 404
     */
    public function test_gola_delete_not_found(): void
    {
        $nonExistentId = 99999;

        $response = $this->deleteJson("/api/v1/golas/{$nonExistentId}");

        $response->assertStatus(404);
    }

    /**
     * Test seeded gola data exists in database
     */
    public function test_gola_seed_data_exists(): void
    {
        // Verify seed data in database
        $this->assertDatabaseHas('table_gola', [
            'nombre' => 'SUPERIOR',
            'precio' => 701.00,
        ]);

        $this->assertDatabaseHas('table_gola', [
            'nombre' => 'INFERIOR',
            'precio' => 795.00,
        ]);

        $this->assertDatabaseHas('table_gola', [
            'nombre' => 'ESCUADRA',
            'precio' => 30.00,
        ]);
    }

    /**
     * Test gola index returns seeded data
     */
    public function test_gola_index_includes_seed_data(): void
    {
        $response = $this->getJson('/api/v1/golas');

        $response->assertStatus(200);
        
        // Check that the three default golas exist
        $data = $response->json('data');
        $this->assertGreaterThanOrEqual(3, count($data));
        
        $nombres = array_column($data, 'nombre');
        $this->assertContains('SUPERIOR', $nombres);
        $this->assertContains('INFERIOR', $nombres);
        $this->assertContains('ESCUADRA', $nombres);
    }
}
