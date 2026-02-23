<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MaterialesTest extends TestCase
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

    public function test_materiales_index(): void
    {
        $response = $this->getJson('/api/v1/materiales');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'nombre',
                    'descripcion',
                    'codigo',
                    'precio_unitario',
                ],
            ],
        ]);
    }

    public function test_materiales_show(): void
    {
        // First, create a material to show
        $material = \App\Models\Material::factory()->create();

        $response = $this->getJson("/api/v1/materiales/{$material->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'nombre',
                'descripcion',
                'codigo',
                'precio_unitario',
            ],
        ]);
    }

    public function test_materiales_store(): void
    {
        $materialData = [
            'nombre' => 'Material de prueba',
            'descripcion' => 'Descripción del material de prueba',
            'codigo' => 'MAT-001',
            'precio_unitario' => 50.75,
            'unidad_medida' => 'cm',
            'alto' => 10.5,
            'ancho' => 5.0,
            'largo' => 2.0,
        ];

        $response = $this->postJson('/api/v1/materiales', $materialData);

        $response->assertStatus(201);
        $response->assertJsonFragment($materialData);

        $this->assertDatabaseHas('materiales', $materialData);
    }

    public function test_materiales_update(): void
    {
        // First, create a material to update
        $material = \App\Models\Material::factory()->create();

        $updatedData = [
            'nombre' => 'Material actualizado',
            'descripcion' => 'Descripción actualizada',
            'codigo' => 'MAT-002',
            'precio_unitario' => 75.50,
            'unidad_medida' => 'm',
            'alto' => 12.0,
            'ancho' => 6.0,
            'largo' => 3.0,
        ];

        $response = $this->putJson("/api/v1/materiales/{$material->id}", $updatedData);

        $response->assertStatus(200);
        $response->assertJsonFragment($updatedData);

        $this->assertDatabaseHas('materiales', array_merge(['id' => $material->id], $updatedData));
    }

    public function test_materiales_destroy(): void
    {
        // First, create a material to delete
        $material = \App\Models\Material::factory()->create();

        $response = $this->deleteJson("/api/v1/materiales/{$material->id}");

        $response->assertStatus(204); // No Content

        $this->assertDatabaseMissing('materiales', [
            'id' => $material->id,
        ]);
    }
}