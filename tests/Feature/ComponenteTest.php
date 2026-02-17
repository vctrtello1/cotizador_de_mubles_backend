<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
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
                    'costo_total',
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
                'costo_total',
                'accesorios',
                'mano_de_obra_id',
            ],
        ]);
    }

    public function test_componente_store(): void
    {
        $material = \App\Models\Material::factory()->create();
        $herraje = \App\Models\Herraje::factory()->create();

        $componenteData = [
            'nombre' => 'Componente Test',
            'descripcion' => 'Descripcion del componente test',
            'codigo' => 'CMP-12345',
            'accesorios' => 'Accesorio1, Accesorio2',
            'mano_de_obra_id' => \App\Models\ManoDeObra::factory()->create()->id,
            'materiales' => [
                ['id' => $material->id, 'cantidad' => 5]
            ],
            'herrajes' => [
                ['id' => $herraje->id, 'cantidad' => 2]
            ]
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
        
        // Check for materials and herrajes in response
        $response->assertJsonFragment(['id' => $material->id, 'cantidad' => 5]);
        $response->assertJsonFragment(['id' => $herraje->id, 'cantidad' => 2]);

        $this->assertDatabaseHas('componentes', [
            'nombre' => 'Componente Test',
            'codigo' => 'CMP-12345',
        ]);
        
        $this->assertDatabaseHas('materiales_por_componente', [
            'material_id' => $material->id,
            'cantidad' => 5
        ]);

        $this->assertDatabaseHas('cantidad_por_herraje', [
            'herraje_id' => $herraje->id,
            'cantidad' => 2
        ]);
    }

    public function test_componente_update(): void
    {
        // First, create a componente to update
        $componente = \App\Models\Componente::factory()->create();
        $material = \App\Models\Material::factory()->create();
        $herraje = \App\Models\Herraje::factory()->create();

        $updateData = [
            'nombre' => 'Componente Actualizado',
            'descripcion' => 'Descripcion actualizada',
            'codigo' => 'CMP-54321',
            'accesorios' => 'Accesorio3, Accesorio4',
            'mano_de_obra_id' => \App\Models\ManoDeObra::factory()->create()->id,
            'materiales' => [
                ['id' => $material->id, 'cantidad' => 10]
            ],
            'herrajes' => [
                ['id' => $herraje->id, 'cantidad' => 4]
            ]
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
        
        $response->assertJsonFragment(['id' => $material->id, 'cantidad' => 10]);
        $response->assertJsonFragment(['id' => $herraje->id, 'cantidad' => 4]);

        $this->assertDatabaseHas('componentes', [
            'id' => $componente->id,
            'nombre' => 'Componente Actualizado',
            'codigo' => 'CMP-54321',
        ]);
        
        $this->assertDatabaseHas('materiales_por_componente', [
            'componente_id' => $componente->id,
            'material_id' => $material->id,
            'cantidad' => 10
        ]);

        $this->assertDatabaseHas('cantidad_por_herraje', [
            'componente_id' => $componente->id,
            'herraje_id' => $herraje->id,
            'cantidad' => 4
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

    public function test_componente_cost_calculation(): void
    {
        $material = \App\Models\Material::factory()->create(['precio_unitario' => 10]);
        $herraje = \App\Models\Herraje::factory()->create(['costo_unitario' => 5]);
        $manoDeObra = \App\Models\ManoDeObra::factory()->create(['costo_hora' => 30]);

        $componente = \App\Models\Componente::factory()->create([
            'mano_de_obra_id' => $manoDeObra->id,
        ]);

        $componente->materiales()->attach($material->id, ['cantidad' => 2]); // 10 * 2 = 20
        $componente->herrajes()->attach($herraje->id, ['cantidad' => 3]); // 5 * 3 = 15

        // Total Cost = 20 (Material) + 15 (Herraje) + 30 (ManoDeObra: 1 hour * 30) = 65

        $response = $this->getJson("/api/v1/componentes/{$componente->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment(['costo_total' => 65]);
    }
}
