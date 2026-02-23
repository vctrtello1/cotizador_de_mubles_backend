<?php

namespace Tests\Feature;

use App\Models\AcabadoCubreCanto;
use App\Models\AcabadoCubreCantoPorComponente;
use App\Models\Componente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AcabadoCubreCantoPorComponenteTest extends TestCase
{
    use RefreshDatabase;

    public function test_index(): void
    {
        $componente = Componente::factory()->create(['nombre' => 'Componente Index']);
        $acabado = AcabadoCubreCanto::factory()->create(['nombre' => 'Acabado Index']);
        AcabadoCubreCantoPorComponente::factory()->create([
            'componente_id' => $componente->id,
            'acabado_cubre_canto_id' => $acabado->id,
        ]);

        $response = $this->getJson('/api/v1/acabado-cubre-canto-por-componente');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'componente_id',
                    'componente_nombre',
                    'acabado_cubre_canto_id',
                    'acabado_cubre_canto_nombre',
                    'cantidad',
                ],
            ],
        ]);
        $response->assertJsonPath('data.0.componente_nombre', 'Componente Index');
        $response->assertJsonPath('data.0.acabado_cubre_canto_nombre', 'Acabado Index');
    }

    public function test_show(): void
    {
        $componente = Componente::factory()->create(['nombre' => 'Componente Show']);
        $acabado = AcabadoCubreCanto::factory()->create(['nombre' => 'Acabado Show']);
        $row = AcabadoCubreCantoPorComponente::factory()->create([
            'componente_id' => $componente->id,
            'acabado_cubre_canto_id' => $acabado->id,
        ]);

        $response = $this->getJson("/api/v1/acabado-cubre-canto-por-componente/{$row->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'componente_id',
                'componente_nombre',
                'acabado_cubre_canto_id',
                'acabado_cubre_canto_nombre',
                'cantidad',
            ],
        ]);
        $response->assertJsonPath('data.componente_nombre', 'Componente Show');
        $response->assertJsonPath('data.acabado_cubre_canto_nombre', 'Acabado Show');
    }

    public function test_creation(): void
    {
        $componente = Componente::factory()->create();
        $acabado = AcabadoCubreCanto::factory()->create();

        $response = $this->postJson('/api/v1/acabado-cubre-canto-por-componente', [
            'componente_id' => $componente->id,
            'acabado_cubre_canto_id' => $acabado->id,
            'cantidad' => 5,
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'componente_id',
                'acabado_cubre_canto_id',
                'cantidad',
            ],
        ]);
    }

    public function test_update(): void
    {
        $row = AcabadoCubreCantoPorComponente::factory()->create();

        $response = $this->putJson("/api/v1/acabado-cubre-canto-por-componente/{$row->id}", [
            'cantidad' => 8,
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['cantidad' => 8]);
    }

    public function test_deletion(): void
    {
        $row = AcabadoCubreCantoPorComponente::factory()->create();

        $response = $this->deleteJson("/api/v1/acabado-cubre-canto-por-componente/{$row->id}");

        $response->assertStatus(204);
    }

    public function test_validation(): void
    {
        $response = $this->postJson('/api/v1/acabado-cubre-canto-por-componente', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['componente_id', 'acabado_cubre_canto_id', 'cantidad']);
    }

    public function test_unique_constraint(): void
    {
        $componente = Componente::factory()->create();
        $acabado = AcabadoCubreCanto::factory()->create();

        AcabadoCubreCantoPorComponente::factory()->create([
            'componente_id' => $componente->id,
            'acabado_cubre_canto_id' => $acabado->id,
        ]);

        $response = $this->postJson('/api/v1/acabado-cubre-canto-por-componente', [
            'componente_id' => $componente->id,
            'acabado_cubre_canto_id' => $acabado->id,
            'cantidad' => 10,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['acabado_cubre_canto_id']);
    }

    public function test_filtering_by_componente(): void
    {
        $componenteA = Componente::factory()->create();
        $componenteB = Componente::factory()->create();

        AcabadoCubreCantoPorComponente::factory()->create([
            'componente_id' => $componenteA->id,
            'acabado_cubre_canto_id' => AcabadoCubreCanto::factory()->create()->id,
        ]);

        AcabadoCubreCantoPorComponente::factory()->create([
            'componente_id' => $componenteB->id,
            'acabado_cubre_canto_id' => AcabadoCubreCanto::factory()->create()->id,
        ]);

        $response = $this->getJson("/api/v1/acabado-cubre-canto-por-componente?componente_id={$componenteA->id}");

        $response->assertStatus(200);
        foreach ($response->json('data') as $item) {
            $this->assertEquals($componenteA->id, $item['componente_id']);
        }
    }
}
