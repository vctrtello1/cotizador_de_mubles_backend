<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HerrajeTest extends TestCase
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

    public function test_herraje_index(): void
    {
        $response = $this->getJson('/api/v1/herrajes');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'nombre',
                    'descripcion',
                    'medida',
                    'unidad_medida',
                    'costo_unitario',
                    'codigo',
                ],
            ],
        ]);
    }

    public function test_herraje_show(): void
    {
        // First, create a herraje to show
        $herraje = \App\Models\Herraje::factory()->create();

        $response = $this->getJson("/api/v1/herrajes/{$herraje->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'nombre',
                'descripcion',
                'medida',
                'unidad_medida',
                'costo_unitario',
                'codigo',
            ],
        ]);
    }

    public function test_herraje_store(): void
    {
        $herrajeData = [
            'nombre' => 'Herraje Test',
            'descripcion' => 'Descripcion del herraje de prueba',
            'medida' => 25.5,
            'unidad_medida' => 'cm',
            'costo_unitario' => 150.75,
            'codigo' => 'HRT-00123',
        ];

        $response = $this->postJson('/api/v1/herrajes', $herrajeData);

        $response->assertStatus(201);
        $response->assertJsonFragment($herrajeData);
        $this->assertDatabaseHas('herrajes', $herrajeData);
    }

    public function test_herraje_update(): void
    {
        // First, create a herraje to update
        $herraje = \App\Models\Herraje::factory()->create();

        $updatedData = [
            'nombre' => 'Herraje Actualizado',
            'descripcion' => 'Descripcion actualizada del herraje',
            'medida' => 30.0,
            'unidad_medida' => 'mm',
            'costo_unitario' => 200.00,
            'codigo' => 'HRT-00456',
        ];

        $response = $this->putJson("/api/v1/herrajes/{$herraje->id}", $updatedData);

        $response->assertStatus(200);
        $response->assertJsonFragment($updatedData);
        $this->assertDatabaseHas('herrajes', array_merge(['id' => $herraje->id], $updatedData));
    }
}
