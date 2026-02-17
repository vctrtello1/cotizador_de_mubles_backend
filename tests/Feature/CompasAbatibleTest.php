<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompasAbatibleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test index endpoint returns all compases abatibles.
     */
    public function test_compas_abatible_index(): void
    {
        $response = $this->getJson('/api/v1/compases-abatibles');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'nombre',
                    'precio',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }

    /**
     * Test show endpoint returns a specific compas abatible.
     */
    public function test_compas_abatible_show(): void
    {
        $compasAbatible = \App\Models\CompasAbatible::factory()->create();

        $response = $this->getJson("/api/v1/compases-abatibles/{$compasAbatible->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'nombre',
                'precio',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    /**
     * Test store endpoint creates a new compas abatible.
     */
    public function test_compas_abatible_store(): void
    {
        $compasData = [
            'nombre' => 'AVENTOS HK-M',
            'precio' => 2500.00,
        ];

        $response = $this->postJson('/api/v1/compases-abatibles', $compasData);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'nombre' => $compasData['nombre'],
            'precio' => 2500.0,
        ]);
        $this->assertDatabaseHas('compases_abatibles', $compasData);
    }

    /**
     * Test store endpoint validates required fields.
     */
    public function test_compas_abatible_store_validation_required_fields(): void
    {
        $response = $this->postJson('/api/v1/compases-abatibles', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre', 'precio']);
    }

    /**
     * Test store endpoint validates unique nombre.
     */
    public function test_compas_abatible_store_validation_unique_nombre(): void
    {
        $compasAbatible = \App\Models\CompasAbatible::factory()->create();

        $response = $this->postJson('/api/v1/compases-abatibles', [
            'nombre' => $compasAbatible->nombre,
            'precio' => 2500.00,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre']);
    }

    /**
     * Test store endpoint validates numeric precio.
     */
    public function test_compas_abatible_store_validation_numeric_precio(): void
    {
        $response = $this->postJson('/api/v1/compases-abatibles', [
            'nombre' => 'AVENTOS TEST',
            'precio' => 'not-a-number',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['precio']);
    }

    /**
     * Test store endpoint validates minimum precio.
     */
    public function test_compas_abatible_store_validation_min_precio(): void
    {
        $response = $this->postJson('/api/v1/compases-abatibles', [
            'nombre' => 'AVENTOS TEST',
            'precio' => -100,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['precio']);
    }

    /**
     * Test update endpoint updates an existing compas abatible.
     */
    public function test_compas_abatible_update(): void
    {
        $compasAbatible = \App\Models\CompasAbatible::factory()->create();

        $updatedData = [
            'nombre' => 'AVENTOS HK-L UPDATED',
            'precio' => 3000.00,
        ];

        $response = $this->putJson("/api/v1/compases-abatibles/{$compasAbatible->id}", $updatedData);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'nombre' => $updatedData['nombre'],
            'precio' => 3000.0,
        ]);
        $this->assertDatabaseHas('compases_abatibles', array_merge(['id' => $compasAbatible->id], $updatedData));
    }

    /**
     * Test update endpoint with partial data.
     */
    public function test_compas_abatible_update_partial(): void
    {
        $compasAbatible = \App\Models\CompasAbatible::factory()->create();

        $response = $this->putJson("/api/v1/compases-abatibles/{$compasAbatible->id}", [
            'precio' => 4500.00,
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'precio' => 4500.0,
        ]);
    }

    /**
     * Test delete endpoint removes a compas abatible.
     */
    public function test_compas_abatible_destroy(): void
    {
        $compasAbatible = \App\Models\CompasAbatible::factory()->create();

        $response = $this->deleteJson("/api/v1/compases-abatibles/{$compasAbatible->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('compases_abatibles', ['id' => $compasAbatible->id]);
    }

    /**
     * Test show endpoint returns 404 for non-existent compas abatible.
     */
    public function test_compas_abatible_show_not_found(): void
    {
        $response = $this->getJson('/api/v1/compases-abatibles/99999');

        $response->assertStatus(404);
    }

    /**
     * Test update endpoint returns 404 for non-existent compas abatible.
     */
    public function test_compas_abatible_update_not_found(): void
    {
        $response = $this->putJson('/api/v1/compases-abatibles/99999', [
            'nombre' => 'Test',
            'precio' => 1000.00,
        ]);

        $response->assertStatus(404);
    }

    /**
     * Test delete endpoint returns 404 for non-existent compas abatible.
     */
    public function test_compas_abatible_destroy_not_found(): void
    {
        $response = $this->deleteJson('/api/v1/compases-abatibles/99999');

        $response->assertStatus(404);
    }

    /**
     * Test store creates AVENTOS HK-XS product.
     */
    public function test_compas_abatible_store_aventos_hk_xs(): void
    {
        $compasData = [
            'nombre' => 'AVENTOS HK-XS',
            'precio' => 3775.80,
        ];

        $response = $this->postJson('/api/v1/compases-abatibles', $compasData);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'nombre' => 'AVENTOS HK-XS',
            'precio' => 3775.8,
        ]);
    }

    /**
     * Test store creates AVENTOS HK-S product.
     */
    public function test_compas_abatible_store_aventos_hk_s(): void
    {
        $compasData = [
            'nombre' => 'AVENTOS HK-S',
            'precio' => 1087.50,
        ];

        $response = $this->postJson('/api/v1/compases-abatibles', $compasData);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'nombre' => 'AVENTOS HK-S',
            'precio' => 1087.5,
        ]);
    }

    /**
     * Test store creates AVENTOS HF-TOP product.
     */
    public function test_compas_abatible_store_aventos_hf_top(): void
    {
        $compasData = [
            'nombre' => 'AVENTOS HF-TOP',
            'precio' => 3925.30,
        ];

        $response = $this->postJson('/api/v1/compases-abatibles', $compasData);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'nombre' => 'AVENTOS HF-TOP',
            'precio' => 3925.3,
        ]);
    }
}
