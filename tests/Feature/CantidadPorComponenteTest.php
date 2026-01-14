<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CantidadPorComponenteTest extends TestCase
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

    public function test_cantidad_por_componente_index(): void
    {
        $response = $this->getJson('/api/v1/cantidad-por-componentes');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'componente_id',
                    'cantidad',
                ],
            ],
        ]);
    }

    public function test_cantidad_por_componente_show(): void
    {
        // First, create a cantidad por componente to show
        $cantidadPorComponente = \App\Models\CantidadPorComponente::factory()->create();

        $response = $this->getJson("/api/v1/cantidad-por-componentes/{$cantidadPorComponente->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'componente_id',
                'cantidad',
            ],
        ]);
    }


    public function test_cantidad_por_componente_with_componente(): void
    {
        // Create a cantidad por componente
        $cantidadPorComponente = \App\Models\CantidadPorComponente::factory()->create();

        $response = $this->getJson("/api/v1/cantidad-por-componentes/{$cantidadPorComponente->id}?include=componente");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'componente_id',
                'cantidad',
                'componente' => [
                    'id',
                    'nombre',
                    'descripcion',
                    // Add other componente fields as necessary
                ],
            ],
        ]);
    }


    public function test_example_componente(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_componente_index(): void
    {
        $response = $this->getJson('/api/v1/componentes');

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
}
