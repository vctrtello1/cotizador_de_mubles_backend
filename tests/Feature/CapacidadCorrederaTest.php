<?php

namespace Tests\Feature;

use App\Models\CapacidadCorredera;
use App\Models\Corredera;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CapacidadCorrederaTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test index endpoint returns all capacidades únicas.
     */
    public function test_capacidad_corredera_index(): void
    {
        $corredera = Corredera::factory()->create();
        
        // Crear varias capacidades para la misma corredera
        CapacidadCorredera::factory()->create(['corredera_id' => $corredera->id, 'capacidad' => 30]);
        CapacidadCorredera::factory()->create(['corredera_id' => $corredera->id, 'capacidad' => 40]);
        CapacidadCorredera::factory()->create(['corredera_id' => $corredera->id, 'capacidad' => 70]);

        $response = $this->getJson('/api/v1/capacidad-correderas');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'capacidad',
                ],
            ],
        ]);
        
        // Debe devolver solo las capacidades únicas
        $this->assertCount(3, $response->json('data'));
    }

    /**
     * Test show endpoint returns a specific capacidad corredera.
     */
    public function test_capacidad_corredera_show(): void
    {
        $corredera = Corredera::factory()->create();
        $capacidadCorredera = CapacidadCorredera::factory()->create([
            'corredera_id' => $corredera->id,
        ]);

        $response = $this->getJson("/api/v1/capacidad-correderas/{$capacidadCorredera->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'capacidad',
                'corredera_id',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    /**
     * Test store endpoint creates a new capacidad corredera.
     */
    public function test_capacidad_corredera_store(): void
    {
        $corredera = Corredera::factory()->create();
        
        $capacidadCorrederaData = [
            'capacidad' => 50,
            'corredera_id' => $corredera->id,
        ];

        $response = $this->postJson('/api/v1/capacidad-correderas', $capacidadCorrederaData);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'capacidad' => 50,
            'corredera_id' => $corredera->id,
        ]);
        $this->assertDatabaseHas('capacidad_correderas', $capacidadCorrederaData);
    }

    /**
     * Test store endpoint validates required fields.
     */
    public function test_capacidad_corredera_store_validation_required_fields(): void
    {
        $response = $this->postJson('/api/v1/capacidad-correderas', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['capacidad', 'corredera_id']);
    }

    /**
     * Test store endpoint validates corredera_id exists.
     */
    public function test_capacidad_corredera_store_validation_corredera_exists(): void
    {
        $response = $this->postJson('/api/v1/capacidad-correderas', [
            'capacidad' => 50,
            'corredera_id' => 999999, // ID que no existe
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['corredera_id']);
    }

    /**
     * Test update endpoint updates an existing capacidad corredera.
     */
    public function test_capacidad_corredera_update(): void
    {
        $corredera = Corredera::factory()->create();
        $capacidadCorredera = CapacidadCorredera::factory()->create([
            'corredera_id' => $corredera->id,
        ]);

        $updateData = [
            'capacidad' => 80,
        ];

        $response = $this->putJson("/api/v1/capacidad-correderas/{$capacidadCorredera->id}", $updateData);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'capacidad' => 80,
        ]);
        $this->assertDatabaseHas('capacidad_correderas', [
            'id' => $capacidadCorredera->id,
            'capacidad' => 80,
        ]);
    }

    /**
     * Test destroy endpoint deletes a capacidad corredera.
     */
    public function test_capacidad_corredera_destroy(): void
    {
        $corredera = Corredera::factory()->create();
        $capacidadCorredera = CapacidadCorredera::factory()->create([
            'corredera_id' => $corredera->id,
        ]);

        $response = $this->deleteJson("/api/v1/capacidad-correderas/{$capacidadCorredera->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('capacidad_correderas', [
            'id' => $capacidadCorredera->id,
        ]);
    }
}
