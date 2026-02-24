<?php

namespace Tests\Feature;

use App\Models\Componente;
use App\Models\Puerta;
use App\Models\PuertasPorComponente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PuertasPorComponenteTest extends TestCase
{
    use RefreshDatabase;

    public function test_index(): void
    {
        $componente = Componente::factory()->create(['nombre' => 'Componente Index']);
        $puerta = Puerta::factory()->create(['nombre' => 'Puerta Index']);

        PuertasPorComponente::factory()->create([
            'componente_id' => $componente->id,
            'puerta_id' => $puerta->id,
        ]);

        $response = $this->getJson('/api/v1/puertas-por-componente');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'componente_id',
                    'componente_nombre',
                    'puerta_id',
                    'puerta_nombre',
                    'cantidad',
                ],
            ],
        ]);
        $response->assertJsonPath('data.0.componente_nombre', 'Componente Index');
        $response->assertJsonPath('data.0.puerta_nombre', 'Puerta Index');
    }

    public function test_show(): void
    {
        $componente = Componente::factory()->create(['nombre' => 'Componente Show']);
        $puerta = Puerta::factory()->create(['nombre' => 'Puerta Show']);

        $row = PuertasPorComponente::factory()->create([
            'componente_id' => $componente->id,
            'puerta_id' => $puerta->id,
        ]);

        $response = $this->getJson("/api/v1/puertas-por-componente/{$row->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'componente_id',
                'componente_nombre',
                'puerta_id',
                'puerta_nombre',
                'cantidad',
            ],
        ]);
        $response->assertJsonPath('data.componente_nombre', 'Componente Show');
        $response->assertJsonPath('data.puerta_nombre', 'Puerta Show');
    }

    public function test_creation(): void
    {
        $componente = Componente::factory()->create();
        $puerta = Puerta::factory()->create();

        $response = $this->postJson('/api/v1/puertas-por-componente', [
            'componente_id' => $componente->id,
            'puerta_id' => $puerta->id,
            'cantidad' => 4,
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'componente_id',
                'puerta_id',
                'cantidad',
            ],
        ]);
    }

    public function test_update(): void
    {
        $row = PuertasPorComponente::factory()->create();

        $response = $this->putJson("/api/v1/puertas-por-componente/{$row->id}", [
            'cantidad' => 7,
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['cantidad' => 7]);
    }

    public function test_deletion(): void
    {
        $row = PuertasPorComponente::factory()->create();

        $response = $this->deleteJson("/api/v1/puertas-por-componente/{$row->id}");

        $response->assertStatus(204);
    }

    public function test_deletion_is_idempotent_when_resource_does_not_exist(): void
    {
        $response = $this->deleteJson('/api/v1/puertas-por-componente/999999');

        $response->assertStatus(204);
    }

    public function test_validation(): void
    {
        $response = $this->postJson('/api/v1/puertas-por-componente', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['componente_id', 'puerta_id', 'cantidad']);
    }

    public function test_unique_constraint(): void
    {
        $componente = Componente::factory()->create();
        $puerta = Puerta::factory()->create();

        PuertasPorComponente::factory()->create([
            'componente_id' => $componente->id,
            'puerta_id' => $puerta->id,
        ]);

        $response = $this->postJson('/api/v1/puertas-por-componente', [
            'componente_id' => $componente->id,
            'puerta_id' => $puerta->id,
            'cantidad' => 9,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['puerta_id']);
    }

    public function test_filtering_by_componente(): void
    {
        $componenteA = Componente::factory()->create();
        $componenteB = Componente::factory()->create();

        PuertasPorComponente::factory()->create([
            'componente_id' => $componenteA->id,
            'puerta_id' => Puerta::factory()->create()->id,
        ]);

        PuertasPorComponente::factory()->create([
            'componente_id' => $componenteB->id,
            'puerta_id' => Puerta::factory()->create()->id,
        ]);

        $response = $this->getJson("/api/v1/puertas-por-componente?componente_id={$componenteA->id}");

        $response->assertStatus(200);
        foreach ($response->json('data') as $item) {
            $this->assertEquals($componenteA->id, $item['componente_id']);
        }
    }
}
