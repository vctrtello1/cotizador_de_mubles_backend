<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AcabadoTest extends TestCase
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

    public function test_acabado_index(): void
    {
        $response = $this->getJson('/api/v1/acabados');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'nombre',
                    'descripcion',
                    'costo',
                ],
            ],
        ]);
    }

    public function test_acabado_show(): void
    {
        // First, create a acabado to show
        $acabado = \App\Models\Acabado::factory()->create();

        $response = $this->getJson("/api/v1/acabados/{$acabado->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'nombre',
                'descripcion',
                'costo',
            ],
        ]);
    }

    public function test_acabado_with_componentes(): void
    {
        // Create an acabado
        $acabado = \App\Models\Acabado::factory()->create();

        // Create componentes associated with this acabado
        $componentes = \App\Models\Componente::factory()
            ->count(3)
            ->withAcabado($acabado->id)
            ->create();

        $response = $this->getJson("/api/v1/acabados/{$acabado->id}?include=componentes");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'nombre',
                'descripcion',
                'costo',
                'componentes' => [
                    '*' => [
                        'id',
                        'nombre',
                        'descripcion',
                    ],
                ],
            ],
        ]);
    }

    public function test_acabado_store(): void
    {
        $acabadoData = [
            'nombre' => 'Acabado Test',
            'descripcion' => 'Descripcion del Acabado Test',
            'costo' => 150.50,
        ];

        $response = $this->postJson('/api/v1/acabados', $acabadoData);

        $response->assertStatus(201);
        $response->assertJsonFragment($acabadoData);
    }

    public function test_acabado_update(): void
    {
        // First, create a acabado to update
        $acabado = \App\Models\Acabado::factory()->create();

        $updatedData = [
            'nombre' => 'Acabado Actualizado',
            'descripcion' => 'Descripcion actualizada del Acabado',
            'costo' => 200.00,
        ];

        $response = $this->putJson("/api/v1/acabados/{$acabado->id}", $updatedData);

        $response->assertStatus(200);
        $response->assertJsonFragment($updatedData);
    }

    public function test_acabado_delete(): void
    {
        // First, create a acabado to delete
        $acabado = \App\Models\Acabado::factory()->create();

        $response = $this->deleteJson("/api/v1/acabados/{$acabado->id}");

        $response->assertStatus(204);

        // Verify that the acabado is deleted
        $this->assertDatabaseMissing('acabados', ['id' => $acabado->id]);
    }

    public function test_acabado_validation_on_store(): void
    {
        // Missing 'nombre' field
        $invalidData = [
            'descripcion' => 'Descripcion sin nombre',
            'costo' => 100,
        ];

        $response = $this->postJson('/api/v1/acabados', $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre']);
    }

    public function test_acabado_validation_on_update(): void
    {
        // First, create a acabado to update
        $acabado = \App\Models\Acabado::factory()->create();

        // Invalid data: 'costo' is not numeric
        $invalidData = [
            'nombre' => 'Acabado Inválido',
            'descripcion' => 'Descripcion inválida',
            'costo' => 'not-a-number',
        ];

        $response = $this->putJson("/api/v1/acabados/{$acabado->id}", $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['costo']);
    }

    public function test_acabado_not_found(): void
    {
        $nonExistentId = 9999;

        $response = $this->getJson("/api/v1/acabados/{$nonExistentId}");

        $response->assertStatus(404);
    }

    public function test_acabado_delete_not_found(): void
    {
        $nonExistentId = 9999;

        $response = $this->deleteJson("/api/v1/acabados/{$nonExistentId}");

        $response->assertStatus(404);
    }
}
