<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccesorioPorComponenteTest extends TestCase
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

    public function test_accesorio_por_componente_index(): void
    {
        $response = $this->getJson('/api/v1/accesorios-por-componente');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'componente_id',
                    'accesorio',
                ],
            ],
        ]);
    }

    public function test_accesorio_por_componente_show(): void
    {
        // First, create an accesorio por componente to show
        $accesorioPorComponente = \App\Models\AccesoriosPorComponente::factory()->create();

        $response = $this->getJson("/api/v1/accesorios-por-componente/{$accesorioPorComponente->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'componente_id',
                'accesorio',
            ],
        ]);
    }

    public function test_accesorio_por_componente_creation(): void
    {
        $componente = \App\Models\Componente::factory()->create();
        $data = [
            'componente_id' => $componente->id,
            'accesorio' => 'Tornillo de 1/2 pulgada',
        ];

        $response = $this->postJson('/api/v1/accesorios-por-componente', $data);

        $response->assertStatus(201);
        $response->assertJsonFragment($data);
    }

    public function test_accesorio_por_componente_update(): void
    {
        // First, create an accesorio por componente to update
        $accesorioPorComponente = \App\Models\AccesoriosPorComponente::factory()->create();

        $updateData = [
            'accesorio' => 'Tornillo de 1 pulgada',
        ];

        $response = $this->putJson("/api/v1/accesorios-por-componente/{$accesorioPorComponente->id}", $updateData);

        $response->assertStatus(200);
        $response->assertJsonFragment($updateData);
    }

    public function test_accesorio_por_componente_deletion(): void
    {
        // First, create an accesorio por componente to delete
        $accesorioPorComponente = \App\Models\AccesoriosPorComponente::factory()->create();

        $response = $this->deleteJson("/api/v1/accesorios-por-componente/{$accesorioPorComponente->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('accesorios_por_componente', ['id' => $accesorioPorComponente->id]);
    }
}
