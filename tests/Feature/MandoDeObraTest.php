<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MandoDeObraTest extends TestCase
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

    public function test_mando_de_obra_index(): void
    {
        $response = $this->getJson('/api/v1/mano-de-obras');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'nombre',
                    'descripcion',
                    'costo_hora',
                ],
            ],
        ]);
    }

    public function test_mando_de_obra_show(): void
    {
        // First, create a mano de obra to show
        $manoDeObra = \App\Models\ManoDeObra::factory()->create();

        $response = $this->getJson("/api/v1/mano-de-obras/{$manoDeObra->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'nombre',
                'descripcion',
                'costo_hora',
            ],
        ]);
    }

    public function test_mando_de_obra_with_componentes(): void
    {
        // Create a mano de obra
        $manoDeObra = \App\Models\ManoDeObra::factory()->create();

        // Create componentes associated with the mano de obra
        $componentes = \App\Models\Componente::factory()
            ->count(3)
            ->create(['mano_de_obra_id' => $manoDeObra->id]);

        $response = $this->getJson("/api/v1/mano-de-obras/{$manoDeObra->id}?include=componentes");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'nombre',
                'descripcion',
                'costo_hora',
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

    public function test_mando_de_obra_store(): void
    {
        $manoDeObraData = [
            'nombre' => 'Mano de Obra Test',
            'descripcion' => 'Descripcion de Mano de Obra Test',
            'costo_hora' => 50.0,
            'tiempo' => 2.0,
            'costo_total' => 100.0,
        ];

        $response = $this->postJson('/api/v1/mano-de-obras', $manoDeObraData);

        $response->assertStatus(201);
        $response->assertJsonFragment($manoDeObraData);
    }

    public function test_mando_de_obra_update(): void
    {
        $manoDeObra = \App\Models\ManoDeObra::factory()->create();

        $updateData = [
            'nombre' => 'Mano de Obra Actualizada',
            'descripcion' => 'Descripcion Actualizada',
            'costo_hora' => 75.0,
        ];

        $response = $this->putJson("/api/v1/mano-de-obras/{$manoDeObra->id}", $updateData);

        $response->assertStatus(200);
        $response->assertJsonFragment($updateData);
    }

    public function test_mando_de_obra_delete(): void
    {
        $manoDeObra = \App\Models\ManoDeObra::factory()->create();

        $response = $this->deleteJson("/api/v1/mano-de-obras/{$manoDeObra->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('mano_de_obras', ['id' => $manoDeObra->id]);
    }

    public function test_mando_de_obra_validation_on_store(): void
    {
        $invalidData = [
            'nombre' => '', // Nombre is required
            'descripcion' => 'Descripcion invalida',
            'costo_hora' => -10, // Costo por hora must be non-negative
        ];

        $response = $this->postJson('/api/v1/mano-de-obras', $invalidData);

        $response->assertStatus(422); // Unprocessable Entity
        $response->assertJsonValidationErrors(['nombre', 'costo_hora']);
    }

    public function test_mando_de_obra_validation_on_update(): void
    {
        $manoDeObra = \App\Models\ManoDeObra::factory()->create();
        $invalidData = [
            'nombre' => '', // Nombre is required
            'descripcion' => 'Descripcion invalida',
            'costo_hora' => -20, // Costo por hora must be non-negative
        ];

        $response = $this->putJson("/api/v1/mano-de-obras/{$manoDeObra->id}", $invalidData);

        $response->assertStatus(422); // Unprocessable Entity
        $response->assertJsonValidationErrors(['nombre', 'costo_hora']);
    }
}
