<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ComponenteTest extends TestCase
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
                    'codigo',
                    'acabado_id',
                    'mano_de_obra_id',
                ],
            ],
        ]);
    }

    public function test_componente_show(): void
    {
        // First, create a componente to show
        $componente = \App\Models\Componente::factory()->create();

        $response = $this->getJson("/api/v1/componentes/{$componente->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'nombre',
                'descripcion',
                'codigo',
                'accesorios',
                'acabado_id',
                'mano_de_obra_id',
            ],
        ]);
    }

    public function test_componente_store(): void
    {
        $componenteData = [
            'nombre' => 'Componente Test',
            'descripcion' => 'Descripcion del componente test',
            'codigo' => 'CMP-12345',
            'accesorios' => 'Accesorio1, Accesorio2',
            'acabado_id' => \App\Models\Acabado::factory()->create()->id,
            'mano_de_obra_id' => \App\Models\ManoDeObra::factory()->create()->id,
        ];

        $response = $this->postJson('/api/v1/componentes', $componenteData);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'nombre' => 'Componente Test',
            'descripcion' => 'Descripcion del componente test',
            'codigo' => 'CMP-12345',
        ]);
        $response->assertJsonFragment(['accesorio' => 'Accesorio1']);
        $response->assertJsonFragment(['accesorio' => 'Accesorio2']);

        $this->assertDatabaseHas('componentes', [
            'nombre' => 'Componente Test',
            'codigo' => 'CMP-12345',
        ]);
    }

    public function test_componente_update(): void
    {
        // First, create a componente to update
        $componente = \App\Models\Componente::factory()->create();

        $updateData = [
            'nombre' => 'Componente Actualizado',
            'descripcion' => 'Descripcion actualizada',
            'codigo' => 'CMP-54321',
            'accesorios' => 'Accesorio3, Accesorio4',
            'acabado_id' => \App\Models\Acabado::factory()->create()->id,
            'mano_de_obra_id' => \App\Models\ManoDeObra::factory()->create()->id,
        ];

        $response = $this->putJson("/api/v1/componentes/{$componente->id}", $updateData);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'nombre' => 'Componente Actualizado',
            'descripcion' => 'Descripcion actualizada',
            'codigo' => 'CMP-54321',
        ]);
        $response->assertJsonFragment(['accesorio' => 'Accesorio3']);
        $response->assertJsonFragment(['accesorio' => 'Accesorio4']);

        $this->assertDatabaseHas('componentes', [
            'id' => $componente->id,
            'nombre' => 'Componente Actualizado',
            'codigo' => 'CMP-54321',
        ]);
    }

    public function test_componente_destroy(): void
    {
        // First, create a componente to delete
        $componente = \App\Models\Componente::factory()->create();

        $response = $this->deleteJson("/api/v1/componentes/{$componente->id}");

        $response->assertStatus(204); // No Content

        $this->assertDatabaseMissing('componentes', [
            'id' => $componente->id,
        ]);
    }

}
