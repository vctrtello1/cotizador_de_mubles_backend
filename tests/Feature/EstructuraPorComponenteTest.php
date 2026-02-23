<?php

namespace Tests\Feature;

use App\Models\Componente;
use App\Models\Estructura;
use App\Models\EstructuraPorComponente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EstructuraPorComponenteTest extends TestCase
{
    use RefreshDatabase;

    public function test_estructura_por_componente_index(): void
    {
        $estructura = Estructura::factory()->create(['nombre' => 'Estructura Index']);
        EstructuraPorComponente::factory()->create([
            'estructura_id' => $estructura->id,
        ]);

        $response = $this->getJson('/api/v1/estructura-por-componente');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'componente_id',
                    'estructura_id',
                    'estructura_nombre',
                    'cantidad',
                ],
            ],
        ]);
        $response->assertJsonPath('data.0.estructura_nombre', 'Estructura Index');
    }

    public function test_estructura_por_componente_show(): void
    {
        $estructura = Estructura::factory()->create(['nombre' => 'Estructura Show']);
        $estructuraPorComponente = EstructuraPorComponente::factory()->create([
            'estructura_id' => $estructura->id,
        ]);

        $response = $this->getJson("/api/v1/estructura-por-componente/{$estructuraPorComponente->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'componente_id',
                'estructura_id',
                'estructura_nombre',
                'cantidad',
            ],
        ]);
        $response->assertJsonPath('data.estructura_nombre', 'Estructura Show');
    }

    public function test_estructura_por_componente_creation(): void
    {
        $componente = Componente::factory()->create();
        $estructura = Estructura::factory()->create();

        $response = $this->postJson('/api/v1/estructura-por-componente', [
            'componente_id' => $componente->id,
            'estructura_id' => $estructura->id,
            'cantidad' => 6,
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'componente_id',
                'estructura_id',
                'cantidad',
            ],
        ]);
    }

    public function test_estructura_por_componente_update(): void
    {
        $estructuraPorComponente = EstructuraPorComponente::factory()->create();

        $response = $this->putJson("/api/v1/estructura-por-componente/{$estructuraPorComponente->id}", [
            'cantidad' => 10,
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['cantidad' => 10]);
    }

    public function test_estructura_por_componente_deletion(): void
    {
        $estructuraPorComponente = EstructuraPorComponente::factory()->create();

        $response = $this->deleteJson("/api/v1/estructura-por-componente/{$estructuraPorComponente->id}");

        $response->assertStatus(204);
    }

    public function test_estructura_por_componente_validation(): void
    {
        $response = $this->postJson('/api/v1/estructura-por-componente', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['componente_id', 'estructura_id', 'cantidad']);
    }

    public function test_estructura_por_componente_unique_constraint(): void
    {
        $componente = Componente::factory()->create();
        $estructura = Estructura::factory()->create();

        EstructuraPorComponente::factory()->create([
            'componente_id' => $componente->id,
            'estructura_id' => $estructura->id,
        ]);

        $response = $this->postJson('/api/v1/estructura-por-componente', [
            'componente_id' => $componente->id,
            'estructura_id' => $estructura->id,
            'cantidad' => 8,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['estructura_id']);
    }

    public function test_estructura_por_componente_filtering(): void
    {
        $componenteA = Componente::factory()->create();
        $componenteB = Componente::factory()->create();
        $estructura = Estructura::factory()->create();

        EstructuraPorComponente::factory()->create([
            'componente_id' => $componenteA->id,
            'estructura_id' => $estructura->id,
        ]);

        EstructuraPorComponente::factory()->create([
            'componente_id' => $componenteB->id,
            'estructura_id' => Estructura::factory()->create()->id,
        ]);

        $response = $this->getJson("/api/v1/estructura-por-componente?componente_id={$componenteA->id}");

        $response->assertStatus(200);
        foreach ($response->json('data') as $item) {
            $this->assertEquals($componenteA->id, $item['componente_id']);
        }
    }
}
