<?php

namespace Tests\Feature;

use App\Models\Componente;
use App\Models\Gola;
use App\Models\GolaPorComponente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GolaPorComponenteTest extends TestCase
{
    use RefreshDatabase;

    public function test_index(): void
    {
        $componente = Componente::factory()->create(['nombre' => 'Componente Index']);
        $gola = Gola::factory()->create(['nombre' => 'Gola Index']);

        GolaPorComponente::factory()->create([
            'componente_id' => $componente->id,
            'gola_id' => $gola->id,
        ]);

        $response = $this->getJson('/api/v1/gola-por-componente');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'componente_id',
                    'componente_nombre',
                    'gola_id',
                    'gola_nombre',
                    'cantidad',
                ],
            ],
        ]);
        $response->assertJsonPath('data.0.componente_nombre', 'Componente Index');
        $response->assertJsonPath('data.0.gola_nombre', 'Gola Index');
    }

    public function test_show(): void
    {
        $componente = Componente::factory()->create(['nombre' => 'Componente Show']);
        $gola = Gola::factory()->create(['nombre' => 'Gola Show']);

        $row = GolaPorComponente::factory()->create([
            'componente_id' => $componente->id,
            'gola_id' => $gola->id,
        ]);

        $response = $this->getJson("/api/v1/gola-por-componente/{$row->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'componente_id',
                'componente_nombre',
                'gola_id',
                'gola_nombre',
                'cantidad',
            ],
        ]);
        $response->assertJsonPath('data.componente_nombre', 'Componente Show');
        $response->assertJsonPath('data.gola_nombre', 'Gola Show');
    }

    public function test_creation(): void
    {
        $componente = Componente::factory()->create();
        $gola = Gola::factory()->create();

        $response = $this->postJson('/api/v1/gola-por-componente', [
            'componente_id' => $componente->id,
            'gola_id' => $gola->id,
            'cantidad' => 4,
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'componente_id',
                'gola_id',
                'cantidad',
            ],
        ]);
    }

    public function test_update(): void
    {
        $row = GolaPorComponente::factory()->create();

        $response = $this->putJson("/api/v1/gola-por-componente/{$row->id}", [
            'cantidad' => 7,
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['cantidad' => 7]);
    }

    public function test_deletion(): void
    {
        $row = GolaPorComponente::factory()->create();

        $response = $this->deleteJson("/api/v1/gola-por-componente/{$row->id}");

        $response->assertStatus(204);
    }

    public function test_validation(): void
    {
        $response = $this->postJson('/api/v1/gola-por-componente', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['componente_id', 'gola_id', 'cantidad']);
    }

    public function test_unique_constraint(): void
    {
        $componente = Componente::factory()->create();
        $gola = Gola::factory()->create();

        GolaPorComponente::factory()->create([
            'componente_id' => $componente->id,
            'gola_id' => $gola->id,
        ]);

        $response = $this->postJson('/api/v1/gola-por-componente', [
            'componente_id' => $componente->id,
            'gola_id' => $gola->id,
            'cantidad' => 9,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['gola_id']);
    }

    public function test_filtering_by_componente(): void
    {
        $componenteA = Componente::factory()->create();
        $componenteB = Componente::factory()->create();

        GolaPorComponente::factory()->create([
            'componente_id' => $componenteA->id,
            'gola_id' => Gola::factory()->create()->id,
        ]);

        GolaPorComponente::factory()->create([
            'componente_id' => $componenteB->id,
            'gola_id' => Gola::factory()->create()->id,
        ]);

        $response = $this->getJson("/api/v1/gola-por-componente?componente_id={$componenteA->id}");

        $response->assertStatus(200);
        foreach ($response->json('data') as $item) {
            $this->assertEquals($componenteA->id, $item['componente_id']);
        }
    }

    public function test_pagination(): void
    {
        $componente = Componente::factory()->create();

        GolaPorComponente::factory()->count(3)->create([
            'componente_id' => $componente->id,
        ]);

        $response = $this->getJson('/api/v1/gola-por-componente?per_page=2');

        $response->assertStatus(200);
        $response->assertJsonPath('data.per_page', 2);
        $this->assertCount(2, $response->json('data.data'));
    }

    public function test_sorting_by_cantidad_desc(): void
    {
        $componente = Componente::factory()->create();
        $golaA = Gola::factory()->create();
        $golaB = Gola::factory()->create();
        $golaC = Gola::factory()->create();

        GolaPorComponente::factory()->create([
            'componente_id' => $componente->id,
            'gola_id' => $golaA->id,
            'cantidad' => 1,
        ]);

        GolaPorComponente::factory()->create([
            'componente_id' => $componente->id,
            'gola_id' => $golaB->id,
            'cantidad' => 3,
        ]);

        GolaPorComponente::factory()->create([
            'componente_id' => $componente->id,
            'gola_id' => $golaC->id,
            'cantidad' => 2,
        ]);

        $response = $this->getJson('/api/v1/gola-por-componente?sort_by=cantidad&sort_order=desc');

        $response->assertStatus(200);
        $cantidades = array_column($response->json('data'), 'cantidad');

        $this->assertSame([3, 2, 1], $cantidades);
    }

    public function test_sorting_by_cantidad_asc(): void
    {
        $componente = Componente::factory()->create();
        $golaA = Gola::factory()->create();
        $golaB = Gola::factory()->create();
        $golaC = Gola::factory()->create();

        GolaPorComponente::factory()->create([
            'componente_id' => $componente->id,
            'gola_id' => $golaA->id,
            'cantidad' => 3,
        ]);

        GolaPorComponente::factory()->create([
            'componente_id' => $componente->id,
            'gola_id' => $golaB->id,
            'cantidad' => 1,
        ]);

        GolaPorComponente::factory()->create([
            'componente_id' => $componente->id,
            'gola_id' => $golaC->id,
            'cantidad' => 2,
        ]);

        $response = $this->getJson('/api/v1/gola-por-componente?sort_by=cantidad&sort_order=asc');

        $response->assertStatus(200);
        $cantidades = array_column($response->json('data'), 'cantidad');

        $this->assertSame([1, 2, 3], $cantidades);
    }

    public function test_invalid_sort_by_returns_server_error(): void
    {
        GolaPorComponente::factory()->create();

        $response = $this->getJson('/api/v1/gola-por-componente?sort_by=campo_invalido&sort_order=asc');

        $response->assertStatus(500);
    }
}
