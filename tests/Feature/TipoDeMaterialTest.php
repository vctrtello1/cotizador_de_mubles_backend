<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TipoDeMaterialTest extends TestCase
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

    public function test_tipo_de_material_index(): void
    {
        $response = $this->getJson('/api/v1/tipo-de-materiales');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'nombre',
                    'descripcion',
                ],
            ],
        ]);
    }

    public function test_tipo_de_material_show(): void
    {
        // First, create a tipo de material to show
        $tipoDeMaterial = \App\Models\TipoDeMaterial::factory()->create();

        $response = $this->getJson("/api/v1/tipo-de-materiales/{$tipoDeMaterial->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'nombre',
                'descripcion',
            ],
        ]);
    }

    public function test_tipo_de_material_with_materiales(): void
    {
        // Create a tipo de material
        $tipoDeMaterial = \App\Models\TipoDeMaterial::factory()->create();

        // Create some materiales associated with this tipo de material
        $materiales = \App\Models\Material::factory()->count(3)->create([
            'tipo_de_material_id' => $tipoDeMaterial->id,
        ]);

        $response = $this->getJson("/api/v1/tipo-de-materiales/{$tipoDeMaterial->id}?include=materiales");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'nombre',
                'descripcion',
                'materiales' => [
                    '*' => [
                        'id',
                        'nombre',
                        'descripcion',
                        'codigo',
                        'tipo_de_material_id',
                        'precio_unitario',
                        'unidad_medida',
                    ],
                ],
            ],
        ]);
    }

    public function test_tipo_de_material_store(): void
    {
        $tipoDeMaterialData = [
            'nombre' => 'Tipo de Material Test',
            'descripcion' => 'Descripción del Tipo de Material Test',
        ];

        $response = $this->postJson('/api/v1/tipo-de-materiales', $tipoDeMaterialData);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'nombre',
                'descripcion',
            ],
        ]);

        $this->assertDatabaseHas('tipo_de_material', $tipoDeMaterialData);
    }


    public function test_tipo_de_material_validation_errors(): void
    {
        // Test missing 'nombre' field
        $response = $this->postJson('/api/v1/tipo-de-materiales', [
            'descripcion' => 'Descripción sin nombre',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre']);

        // Test 'nombre' field exceeding max length
        $response = $this->postJson('/api/v1/tipo-de-materiales', [
            'nombre' => str_repeat('A', 256), // 256 characters
            'descripcion' => 'Descripción con nombre largo',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre']);
    }


    public function test_tipo_de_material_update(): void
    {
        // First, create a tipo de material to update
        $tipoDeMaterial = \App\Models\TipoDeMaterial::factory()->create();

        $updateData = [
            'nombre' => 'Tipo de Material Actualizado',
            'descripcion' => 'Descripción actualizada del Tipo de Material',
        ];

        $response = $this->putJson("/api/v1/tipo-de-materiales/{$tipoDeMaterial->id}", $updateData);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'nombre',
                'descripcion',
            ],
        ]);

        $this->assertDatabaseHas('tipo_de_material', array_merge(['id' => $tipoDeMaterial->id], $updateData));
    }   
    public function test_tipo_de_material_delete(): void
    {
        // First, create a tipo de material to delete
        $tipoDeMaterial = \App\Models\TipoDeMaterial::factory()->create();

        $response = $this->deleteJson("/api/v1/tipo-de-materiales/{$tipoDeMaterial->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('tipo_de_material', ['id' => $tipoDeMaterial->id]);
    }
}