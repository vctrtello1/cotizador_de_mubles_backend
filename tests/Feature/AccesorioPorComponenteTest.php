<?php

namespace Tests\Feature;

use App\Models\Accesorio;
use App\Models\Componente;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
                    'costo',
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
                'costo',
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

    public function test_accesorio_por_componente_creation_with_accesorio_id(): void
    {
        $componente = Componente::factory()->create();
        $accesorio = Accesorio::factory()->create([
            'nombre' => 'PATAS NIVELADORAS',
            'precio' => 20.00,
        ]);

        $response = $this->postJson('/api/v1/accesorios-por-componente', [
            'componente_id' => $componente->id,
            'accesorio_id' => $accesorio->id,
        ]);

        $response->assertStatus(201);
        $response->assertJsonPath('data.accesorio', 'PATAS NIVELADORAS');
        $response->assertJsonPath('data.costo', '20.00');
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

    public function test_accesorio_por_componente_shows_costo_when_catalog_match_exists(): void
    {
        $componente = Componente::factory()->create();
        Accesorio::factory()->create([
            'nombre' => 'CLIPS ZOCLO',
            'precio' => 2.00,
        ]);

        $accesorioPorComponente = \App\Models\AccesoriosPorComponente::factory()->create([
            'componente_id' => $componente->id,
            'accesorio' => 'CLIPS ZOCLO',
        ]);

        $response = $this->getJson("/api/v1/accesorios-por-componente/{$accesorioPorComponente->id}");

        $response->assertStatus(200);
        $response->assertJsonPath('data.costo', '2.00');
    }

    public function test_seeded_accesorios_por_componente_include_non_null_costo(): void
    {
        $response = $this->getJson('/api/v1/accesorios-por-componente');

        $response->assertStatus(200);
        foreach ($response->json('data') as $item) {
            $this->assertNotNull($item['costo']);
        }
    }
}
