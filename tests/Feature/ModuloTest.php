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
            ],
        ]);
    }

    public function test_modulo_store(): void
    {
        $moduloData = [
            'nombre' => 'Modulo Test',
            'descripcion' => 'Descripcion del Modulo Test',
            'codigo' => 'MOD_TEST_001',
        ];

        $response = $this->postJson('/api/v1/modulos', $moduloData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('modulos', $moduloData);
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
}
