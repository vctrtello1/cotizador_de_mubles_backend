<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MaterialesPorComponenteTest extends TestCase
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

    public function test_materiales_por_componente_index(): void
    {
        $response = $this->getJson('/api/v1/materiales-por-componente');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'componente_id',
                    'material_id',
                    'cantidad',
                ],
            ],
        ]);
    }

    public function test_materiales_por_componente_show(): void
    {
        // First, create a materiales por componente to show
        $materialesPorComponente = \App\Models\MaterialesPorComponente::factory()->create();

        $response = $this->getJson("/api/v1/materiales-por-componente/{$materialesPorComponente->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'componente_id',
                'material_id',
                'cantidad',
            ],
        ]);
    }

    public function test_materiales_por_componente_creation(): void
    {
        $componente = \App\Models\Componente::factory()->create();
        $material = \App\Models\Material::factory()->create();
        $data = [
            'componente_id' => $componente->id,
            'material_id' => $material->id,
            'cantidad' => 10,
        ];

        $response = $this->postJson('/api/v1/materiales-por-componente', $data);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'componente_id',
                'material_id',
                'cantidad',
            ],
        ]);
    }

    public function test_materiales_por_componente_update(): void
    {
        // First, create a materiales por componente to update
        $materialesPorComponente = \App\Models\MaterialesPorComponente::factory()->create();

        $updateData = [
            'cantidad' => 20,
        ];

        $response = $this->putJson("/api/v1/materiales-por-componente/{$materialesPorComponente->id}", $updateData);

        $response->assertStatus(200);
        $response->assertJsonFragment($updateData);
    }

    public function test_materiales_por_componente_deletion(): void
    {
        // First, create a materiales por componente to delete
        $materialesPorComponente = \App\Models\MaterialesPorComponente::factory()->create();

        $response = $this->deleteJson("/api/v1/materiales-por-componente/{$materialesPorComponente->id}");

        $response->assertStatus(204);
    }

    public function test_materiales_por_componente_validation(): void
    {
        $response = $this->postJson('/api/v1/materiales-por-componente', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['componente_id', 'material_id', 'cantidad']);
    }

    public function test_materiales_por_componente_validation_on_update(): void
    {
        // First, create a materiales por componente to update
        $materialesPorComponente = \App\Models\MaterialesPorComponente::factory()->create();

        $response = $this->putJson("/api/v1/materiales-por-componente/{$materialesPorComponente->id}", [
            'cantidad' => -5,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['cantidad']);
    }

    public function test_materiales_por_componente_unique_constraint(): void
    {
        $componente = \App\Models\Componente::factory()->create();
        $material = \App\Models\Material::factory()->create();

        // Create the first entry
        \App\Models\MaterialesPorComponente::factory()->create([
            'componente_id' => $componente->id,
            'material_id' => $material->id,
        ]);

        // Attempt to create a duplicate entry
        $response = $this->postJson('/api/v1/materiales-por-componente', [
            'componente_id' => $componente->id,
            'material_id' => $material->id,
            'cantidad' => 15,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['material_id']);
    }

    public function test_materiales_por_componente_response_structure(): void
    {
        // First, create a materiales por componente to show
        $materialesPorComponente = \App\Models\MaterialesPorComponente::factory()->create();

        $response = $this->getJson("/api/v1/materiales-por-componente/{$materialesPorComponente->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'componente_id',
                'material_id',
                'cantidad',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function test_materiales_por_componente_list_pagination(): void
    {
        // Create multiple materiales por componente entries
        \App\Models\MaterialesPorComponente::factory()->count(30)->create();

        $response = $this->getJson('/api/v1/materiales-por-componente?per_page=10');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'componente_id',
                    'material_id',
                    'cantidad',
                ],
            ],
            'links',
            'meta',
        ]);
    }


    public function test_materiales_por_componente_filtering(): void
    {
        $componenteA = \App\Models\Componente::factory()->create();
        $componenteB = \App\Models\Componente::factory()->create();
        $material = \App\Models\Material::factory()->create();

        // Create materiales por componente for different componentes
        \App\Models\MaterialesPorComponente::factory()->create([
            'componente_id' => $componenteA->id,
            'material_id' => $material->id,
        ]);

        \App\Models\MaterialesPorComponente::factory()->create([
            'componente_id' => $componenteB->id,
            'material_id' => $material->id,
        ]);

        $response = $this->getJson("/api/v1/materiales-por-componente?componente_id={$componenteA->id}");

        $response->assertStatus(200);
        $responseData = $response->json('data');

        foreach ($responseData as $item) {
            $this->assertEquals($componenteA->id, $item['componente_id']);
        }
    }


    public function test_materiales_por_componente_sorting(): void
    {
        // Create materiales por componente with different cantidades
        \App\Models\MaterialesPorComponente::factory()->create(['cantidad' => 5]);
        \App\Models\MaterialesPorComponente::factory()->create(['cantidad' => 15]);
        \App\Models\MaterialesPorComponente::factory()->create(['cantidad' => 10]);

        $response = $this->getJson('/api/v1/materiales-por-componente?sort_by=cantidad&sort_order=asc');

        $response->assertStatus(200);
        $responseData = $response->json('data');

        $cantidades = array_column($responseData, 'cantidad');
        $sortedCantidades = $cantidades;
        sort($sortedCantidades);

        $this->assertEquals($sortedCantidades, $cantidades);
    }
}
