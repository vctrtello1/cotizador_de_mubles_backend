<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CantidadPorMaterialTest extends TestCase
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

    public function test_cantidad_por_material_index(): void
    {
        $response = $this->getJson('/api/v1/cantidad-por-materiales');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'material_id',
                    'cantidad',
                ],
            ],
        ]);
    }

    public function test_cantidad_por_material_show(): void
    {
        // First, create a cantidad por material to show
        $cantidadPorMaterial = \App\Models\CantidadPorMaterial::factory()->create();

        $response = $this->getJson("/api/v1/cantidad-por-materiales/{$cantidadPorMaterial->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'material_id',
                'cantidad',
            ],
        ]);
    }

    public function test_cantidad_por_material_with_material(): void
    {
        // Create a cantidad por material
        $cantidadPorMaterial = \App\Models\CantidadPorMaterial::factory()->create();

        // Create a material associated with this cantidad por material
        $material = \App\Models\Material::factory()->create();
        $cantidadPorMaterial->material()->associate($material);
        $cantidadPorMaterial->save();

        $response = $this->getJson("/api/v1/cantidad-por-materiales/{$cantidadPorMaterial->id}?include=material");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'material_id',
                'cantidad',
                'material' => [
                    'id',
                    'nombre',
                    'descripcion',
                    'precio_unitario',
                    'tipo_de_material_id',
                ],
            ],
        ]);
    }

    public function test_cantidad_por_material_creation(): void
    {
        $material = \App\Models\Material::factory()->create();
        $componente = \App\Models\Componente::factory()->create();

        $payload = [
            'material_id' => $material->id,
            'componente_id' => $componente->id,
            'cantidad' => 10,
        ];

        $response = $this->postJson('/api/v1/cantidad-por-materiales', $payload);

        $response->assertStatus(201);
        $response->assertJsonFragment($payload);
    }

    public function test_cantidad_por_material_update(): void
    {
        $cantidadPorMaterial = \App\Models\CantidadPorMaterial::factory()->create();

        $payload = [
            'cantidad' => 20,
        ];

        $response = $this->putJson("/api/v1/cantidad-por-materiales/{$cantidadPorMaterial->id}", $payload);

        $response->assertStatus(200);
        $response->assertJsonFragment($payload);
    }

    public function test_cantidad_por_material_delete(): void
    {
        $cantidadPorMaterial = \App\Models\CantidadPorMaterial::factory()->create();

        $response = $this->deleteJson("/api/v1/cantidad-por-materiales/{$cantidadPorMaterial->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('cantidad_por_material', ['id' => $cantidadPorMaterial->id]);
    }


}