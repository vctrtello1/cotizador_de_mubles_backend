<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CorrederaTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test index endpoint returns all correderas.
     */
    public function test_corredera_index(): void
    {
        $response = $this->getJson('/api/v1/correderas');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'nombre',
                    'capacidad_carga',
                    'precio_base',
                    'precio_con_acoplamiento',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }

    /**
     * Test show endpoint returns a specific corredera.
     */
    public function test_corredera_show(): void
    {
        // First, create a corredera to show
        $corredera = \App\Models\Corredera::factory()->create();

        $response = $this->getJson("/api/v1/correderas/{$corredera->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'nombre',
                'capacidad_carga',
                'precio_base',
                'precio_con_acoplamiento',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    /**
     * Test store endpoint creates a new corredera.
     */
    public function test_corredera_store(): void
    {
        $correderaData = [
            'nombre' => 'CORREDERA TANDEM PARCIAL BLUMOTION 30kgs 600mm 550H6000B',
            'capacidad_carga' => 30,
            'precio_base' => 420.50,
            'precio_con_acoplamiento' => 470.70,
        ];

        $response = $this->postJson('/api/v1/correderas', $correderaData);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'nombre' => $correderaData['nombre'],
            'capacidad_carga' => 30,
            'precio_base' => 420.5,
            'precio_con_acoplamiento' => 470.7,
        ]);
        $this->assertDatabaseHas('correderas', $correderaData);
    }

    /**
     * Test store endpoint validates required fields.
     */
    public function test_corredera_store_validation_required_fields(): void
    {
        $response = $this->postJson('/api/v1/correderas', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre', 'capacidad_carga', 'precio_base', 'precio_con_acoplamiento']);
    }

    /**
     * Test store endpoint validates unique nombre.
     */
    public function test_corredera_store_validation_unique_nombre(): void
    {
        $corredera = \App\Models\Corredera::factory()->create();

        $response = $this->postJson('/api/v1/correderas', [
            'nombre' => $corredera->nombre,
            'capacidad_carga' => 30,
            'precio_base' => 420.50,
            'precio_con_acoplamiento' => 470.70,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre']);
    }

    /**
     * Test store endpoint validates numeric prices.
     */
    public function test_corredera_store_validation_numeric_prices(): void
    {
        $response = $this->postJson('/api/v1/correderas', [
            'nombre' => 'CORREDERA TEST',
            'capacidad_carga' => 30,
            'precio_base' => 'not-a-number',
            'precio_con_acoplamiento' => 'not-a-number',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['precio_base', 'precio_con_acoplamiento']);
    }

    /**
     * Test update endpoint updates an existing corredera.
     */
    public function test_corredera_update(): void
    {
        // First, create a corredera to update
        $corredera = \App\Models\Corredera::factory()->create();

        $updatedData = [
            'nombre' => 'CORREDERA TANDEM PARCIAL BLUMOTION 30kgs 700mm 550H7000B',
            'capacidad_carga' => 40,
            'precio_base' => 450.00,
            'precio_con_acoplamiento' => 500.20,
        ];

        $response = $this->putJson("/api/v1/correderas/{$corredera->id}", $updatedData);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'nombre' => $updatedData['nombre'],
            'capacidad_carga' => 40,
            'precio_base' => 450.0,
            'precio_con_acoplamiento' => 500.2,
        ]);
        $this->assertDatabaseHas('correderas', array_merge(['id' => $corredera->id], $updatedData));
    }

    /**
     * Test update endpoint with partial data.
     */
    public function test_corredera_update_partial(): void
    {
        $corredera = \App\Models\Corredera::factory()->create();

        $response = $this->putJson("/api/v1/correderas/{$corredera->id}", [
            'capacidad_carga' => 70,
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'capacidad_carga' => 70,
        ]);
    }

    /**
     * Test delete endpoint removes a corredera.
     */
    public function test_corredera_destroy(): void
    {
        // First, create a corredera to delete
        $corredera = \App\Models\Corredera::factory()->create();

        $response = $this->deleteJson("/api/v1/correderas/{$corredera->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('correderas', ['id' => $corredera->id]);
    }

    /**
     * Test show endpoint returns 404 for non-existent corredera.
     */
    public function test_corredera_show_not_found(): void
    {
        $response = $this->getJson('/api/v1/correderas/99999');

        $response->assertStatus(404);
    }

    /**
     * Test update endpoint returns 404 for non-existent corredera.
     */
    public function test_corredera_update_not_found(): void
    {
        $response = $this->putJson('/api/v1/correderas/99999', [
            'nombre' => 'Test',
            'capacidad_carga' => 30,
            'precio_base' => 100.00,
            'precio_con_acoplamiento' => 150.00,
        ]);

        $response->assertStatus(404);
    }

    /**
     * Test delete endpoint returns 404 for non-existent corredera.
     */
    public function test_corredera_destroy_not_found(): void
    {
        $response = $this->deleteJson('/api/v1/correderas/99999');

        $response->assertStatus(404);
    }
}
