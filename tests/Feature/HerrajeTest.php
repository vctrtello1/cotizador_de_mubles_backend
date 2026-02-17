<?php

namespace Tests\Feature;

use App\Models\Herraje;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HerrajeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test herraje index endpoint returns all herrajes
     */
    public function test_herraje_index(): void
    {
        Herraje::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/herrajes');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'nombre',
                    'descripcion',
                    'medida',
                    'unidad_medida',
                    'costo_unitario',
                    'codigo',
                ],
            ],
        ]);
    }

    /**
     * Test herraje show endpoint returns a specific herraje
     */
    public function test_herraje_show(): void
    {
        $herraje = Herraje::factory()->create([
            'nombre' => 'Bisagra Premium',
            'codigo' => 'BIS-001',
            'costo_unitario' => 125.50,
        ]);

        $response = $this->getJson("/api/v1/herrajes/{$herraje->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'nombre',
                'descripcion',
                'medida',
                'unidad_medida',
                'costo_unitario',
                'codigo',
            ],
        ]);
        $response->assertJsonPath('data.nombre', 'Bisagra Premium');
        $response->assertJsonPath('data.codigo', 'BIS-001');
    }

    /**
     * Test herraje store successfully creates a new herraje
     */
    public function test_herraje_store(): void
    {
        $herrajeData = [
            'nombre' => 'Herraje Test',
            'descripcion' => 'Descripcion del herraje de prueba',
            'medida' => 25.5,
            'unidad_medida' => 'cm',
            'costo_unitario' => 150.75,
            'codigo' => 'HRT-00123',
        ];

        $response = $this->postJson('/api/v1/herrajes', $herrajeData);

        $response->assertStatus(201);
        $response->assertJsonFragment(['nombre' => 'Herraje Test']);
        $this->assertDatabaseHas('herrajes', $herrajeData);
    }

    /**
     * Test herraje update successfully modifies an existing herraje
     */
    public function test_herraje_update(): void
    {
        $herraje = Herraje::factory()->create();

        $updatedData = [
            'nombre' => 'Herraje Actualizado',
            'descripcion' => 'Descripcion actualizada del herraje',
            'medida' => 30.0,
            'unidad_medida' => 'mm',
            'costo_unitario' => 200.00,
            'codigo' => 'HRT-00456',
        ];

        $response = $this->putJson("/api/v1/herrajes/{$herraje->id}", $updatedData);

        $response->assertStatus(200);
        $response->assertJsonFragment(['nombre' => 'Herraje Actualizado']);
        $this->assertDatabaseHas('herrajes', array_merge(['id' => $herraje->id], $updatedData));
    }

    /**
     * Test herraje delete removes the record
     */
    public function test_herraje_delete(): void
    {
        $herraje = Herraje::factory()->create();

        $response = $this->deleteJson("/api/v1/herrajes/{$herraje->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('herrajes', ['id' => $herraje->id]);
    }

    /**
     * Test validation: nombre is required
     */
    public function test_herraje_validation_nombre_required(): void
    {
        $invalidData = [
            'descripcion' => 'Sin nombre',
            'medida' => 10,
            'unidad_medida' => 'cm',
            'costo_unitario' => 100,
            'codigo' => 'TEST-001',
        ];

        $response = $this->postJson('/api/v1/herrajes', $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre']);
    }

    /**
     * Test validation: codigo is required and unique
     */
    public function test_herraje_validation_codigo_required(): void
    {
        $invalidData = [
            'nombre' => 'Test',
            'medida' => 10,
            'unidad_medida' => 'cm',
            'costo_unitario' => 100,
        ];

        $response = $this->postJson('/api/v1/herrajes', $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['codigo']);
    }

    /**
     * Test validation: codigo must be unique
     */
    public function test_herraje_validation_codigo_unique(): void
    {
        Herraje::factory()->create(['codigo' => 'UNIQUE-001']);

        $duplicateData = [
            'nombre' => 'Test Duplicate',
            'medida' => 10,
            'unidad_medida' => 'cm',
            'costo_unitario' => 100,
            'codigo' => 'UNIQUE-001',
        ];

        $response = $this->postJson('/api/v1/herrajes', $duplicateData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['codigo']);
    }

    /**
     * Test validation: costo_unitario must be numeric
     */
    public function test_herraje_validation_costo_numeric(): void
    {
        $invalidData = [
            'nombre' => 'Test',
            'medida' => 10,
            'unidad_medida' => 'cm',
            'costo_unitario' => 'not-a-number',
            'codigo' => 'TEST-001',
        ];

        $response = $this->postJson('/api/v1/herrajes', $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['costo_unitario']);
    }

    /**
     * Test validation: costo_unitario cannot be negative
     */
    public function test_herraje_validation_costo_not_negative(): void
    {
        $invalidData = [
            'nombre' => 'Test',
            'medida' => 10,
            'unidad_medida' => 'cm',
            'costo_unitario' => -100,
            'codigo' => 'TEST-001',
        ];

        $response = $this->postJson('/api/v1/herrajes', $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['costo_unitario']);
    }

    /**
     * Test herraje not found returns 404
     */
    public function test_herraje_not_found(): void
    {
        $nonExistentId = 99999;

        $response = $this->getJson("/api/v1/herrajes/{$nonExistentId}");

        $response->assertStatus(404);
    }

    /**
     * Test update herraje not found returns 404
     */
    public function test_herraje_update_not_found(): void
    {
        $nonExistentId = 99999;

        $response = $this->putJson("/api/v1/herrajes/{$nonExistentId}", [
            'nombre' => 'Test',
            'codigo' => 'TEST-001',
        ]);

        $response->assertStatus(404);
    }

    /**
     * Test delete herraje not found returns 404
     */
    public function test_herraje_delete_not_found(): void
    {
        $nonExistentId = 99999;

        $response = $this->deleteJson("/api/v1/herrajes/{$nonExistentId}");

        $response->assertStatus(404);
    }

    /**
     * Test partial update of herraje
     */
    public function test_herraje_partial_update(): void
    {
        $herraje = Herraje::factory()->create([
            'nombre' => 'Original',
            'codigo' => 'ORIG-001',
            'costo_unitario' => 100.00,
        ]);

        $response = $this->putJson("/api/v1/herrajes/{$herraje->id}", [
            'costo_unitario' => 200.00,
        ]);

        $response->assertStatus(200);
        
        // Original data should be preserved
        $this->assertDatabaseHas('herrajes', [
            'id' => $herraje->id,
            'nombre' => 'Original',
            'codigo' => 'ORIG-001',
            'costo_unitario' => 200.00,
        ]);
    }
}
