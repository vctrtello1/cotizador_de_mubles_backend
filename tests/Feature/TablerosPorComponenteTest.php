<?php

namespace Tests\Feature;

use App\Models\Componente;
use App\Models\Material;
use App\Models\TablerosPorComponente;
use Database\Seeders\ComponenteSeeder;
use Database\Seeders\MaterialSeeder;
use Database\Seeders\TablerosPorComponenteSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TablerosPorComponenteTest extends TestCase
{
    use RefreshDatabase;

    public function test_tableros_por_componente_index(): void
    {
        $response = $this->getJson('/api/v1/tableros-por-componente');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'componente_id',
                    'tablero_id',
                    'cantidad',
                ],
            ],
        ]);
    }

    public function test_tableros_por_componente_show(): void
    {
        $tablerosPorComponente = TablerosPorComponente::factory()->create();

        $response = $this->getJson("/api/v1/tableros-por-componente/{$tablerosPorComponente->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'componente_id',
                'tablero_id',
                'cantidad',
            ],
        ]);
    }

    public function test_tableros_por_componente_creation(): void
    {
        $componente = Componente::factory()->create();
        $tablero = Material::factory()->create();

        $response = $this->postJson('/api/v1/tableros-por-componente', [
            'componente_id' => $componente->id,
            'tablero_id' => $tablero->id,
            'cantidad' => 10,
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'componente_id',
                'tablero_id',
                'cantidad',
            ],
        ]);
    }

    public function test_tableros_por_componente_update(): void
    {
        $tablerosPorComponente = TablerosPorComponente::factory()->create();

        $response = $this->putJson("/api/v1/tableros-por-componente/{$tablerosPorComponente->id}", [
            'cantidad' => 20,
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['cantidad' => 20]);
    }

    public function test_tableros_por_componente_deletion(): void
    {
        $tablerosPorComponente = TablerosPorComponente::factory()->create();

        $response = $this->deleteJson("/api/v1/tableros-por-componente/{$tablerosPorComponente->id}");

        $response->assertStatus(204);
    }

    public function test_tableros_por_componente_validation(): void
    {
        $response = $this->postJson('/api/v1/tableros-por-componente', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['componente_id', 'tablero_id', 'cantidad']);
    }

    public function test_tableros_por_componente_unique_constraint(): void
    {
        $componente = Componente::factory()->create();
        $tablero = Material::factory()->create();

        TablerosPorComponente::factory()->create([
            'componente_id' => $componente->id,
            'tablero_id' => $tablero->id,
        ]);

        $response = $this->postJson('/api/v1/tableros-por-componente', [
            'componente_id' => $componente->id,
            'tablero_id' => $tablero->id,
            'cantidad' => 12,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['tablero_id']);
    }

    public function test_tableros_por_componente_list_pagination(): void
    {
        TablerosPorComponente::factory()->count(30)->create();

        $response = $this->getJson('/api/v1/tableros-por-componente?per_page=10');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'componente_id',
                    'tablero_id',
                    'cantidad',
                ],
            ],
            'links',
            'meta',
        ]);
    }

    public function test_tableros_por_componente_index_has_seed_data(): void
    {
        $this->seed([
            MaterialSeeder::class,
            ComponenteSeeder::class,
            TablerosPorComponenteSeeder::class,
        ]);

        $response = $this->getJson('/api/v1/tableros-por-componente');

        $response->assertStatus(200);
        $response->assertJsonCount(4, 'data');
    }

    public function test_tableros_por_componente_index_has_expected_seeded_pairs(): void
    {
        $this->seed([
            MaterialSeeder::class,
            ComponenteSeeder::class,
            TablerosPorComponenteSeeder::class,
        ]);

        $response = $this->getJson('/api/v1/tableros-por-componente');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'componente_id' => 1,
            'tablero_id' => 1,
            'cantidad' => 2,
        ]);
        $response->assertJsonFragment([
            'componente_id' => 1,
            'tablero_id' => 3,
            'cantidad' => 1,
        ]);
        $response->assertJsonFragment([
            'componente_id' => 2,
            'tablero_id' => 2,
            'cantidad' => 4,
        ]);
        $response->assertJsonFragment([
            'componente_id' => 3,
            'tablero_id' => 5,
            'cantidad' => 2,
        ]);
    }

    public function test_tableros_por_componente_show_includes_detailed_componente_and_tablero(): void
    {
        $componente = Componente::factory()->create([
            'nombre' => 'Componente Demo',
            'codigo' => 'CMP-10001',
        ]);
        $tablero = Material::factory()->create([
            'nombre' => 'Tablero Demo',
            'codigo' => 'TBL-10001',
        ]);

        $tablerosPorComponente = TablerosPorComponente::factory()->create([
            'componente_id' => $componente->id,
            'tablero_id' => $tablero->id,
            'cantidad' => 7,
        ]);

        $response = $this->getJson("/api/v1/tableros-por-componente/{$tablerosPorComponente->id}?include=componente,tablero");

        $response->assertStatus(200);
        $response->assertJsonPath('data.componente.id', $componente->id);
        $response->assertJsonPath('data.componente.nombre', 'Componente Demo');
        $response->assertJsonPath('data.tablero.id', $tablero->id);
        $response->assertJsonPath('data.tablero.nombre', 'Tablero Demo');
        $response->assertJsonPath('data.tablero.codigo', 'TBL-10001');
    }

    public function test_tableros_por_componente_show_does_not_include_detailed_relations_by_default(): void
    {
        $tablerosPorComponente = TablerosPorComponente::factory()->create();

        $response = $this->getJson("/api/v1/tableros-por-componente/{$tablerosPorComponente->id}");

        $response->assertStatus(200);
        $response->assertJsonMissingPath('data.componente');
        $response->assertJsonMissingPath('data.tablero');
    }

    public function test_tableros_por_componente_index_allows_partial_include(): void
    {
        $componente = Componente::factory()->create(['nombre' => 'Componente Parcial']);
        $tablero = Material::factory()->create(['nombre' => 'Tablero Parcial']);

        TablerosPorComponente::factory()->create([
            'componente_id' => $componente->id,
            'tablero_id' => $tablero->id,
        ]);

        $response = $this->getJson('/api/v1/tableros-por-componente?include=componente');

        $response->assertStatus(200);
        $response->assertJsonPath('data.0.componente.id', $componente->id);
        $response->assertJsonPath('data.0.componente.nombre', 'Componente Parcial');
        $response->assertJsonMissingPath('data.0.tablero');
    }

    public function test_tableros_por_componente_index_ignores_invalid_include_values(): void
    {
        TablerosPorComponente::factory()->create();

        $response = $this->getJson('/api/v1/tableros-por-componente?include=foo,bar');

        $response->assertStatus(200);
        $response->assertJsonMissingPath('data.0.componente');
        $response->assertJsonMissingPath('data.0.tablero');
    }

    public function test_tableros_por_componente_store_and_update_return_detailed_relations(): void
    {
        $componente = Componente::factory()->create(['nombre' => 'Componente Store']);
        $tablero = Material::factory()->create(['nombre' => 'Tablero Store']);

        $storeResponse = $this->postJson('/api/v1/tableros-por-componente', [
            'componente_id' => $componente->id,
            'tablero_id' => $tablero->id,
            'cantidad' => 9,
        ]);

        $storeResponse->assertStatus(201);
        $storeResponse->assertJsonPath('data.componente.id', $componente->id);
        $storeResponse->assertJsonPath('data.tablero.id', $tablero->id);

        $rowId = $storeResponse->json('data.id');

        $updateResponse = $this->putJson("/api/v1/tableros-por-componente/{$rowId}", [
            'cantidad' => 11,
        ]);

        $updateResponse->assertStatus(200);
        $updateResponse->assertJsonPath('data.cantidad', 11);
        $updateResponse->assertJsonPath('data.componente.id', $componente->id);
        $updateResponse->assertJsonPath('data.tablero.id', $tablero->id);
    }

    public function test_tableros_por_componente_index_includes_detailed_relations_when_requested(): void
    {
        $componente = Componente::factory()->create([
            'nombre' => 'Componente Incluido',
        ]);
        $tablero = Material::factory()->create([
            'nombre' => 'Tablero Incluido',
        ]);

        $tablerosPorComponente = TablerosPorComponente::factory()->create([
            'componente_id' => $componente->id,
            'tablero_id' => $tablero->id,
            'cantidad' => 3,
        ]);

        $response = $this->getJson('/api/v1/tableros-por-componente?include=componente,tablero');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $tablerosPorComponente->id,
            'componente_id' => $componente->id,
            'tablero_id' => $tablero->id,
            'cantidad' => 3,
        ]);
        $response->assertJsonPath('data.0.componente.id', $componente->id);
        $response->assertJsonPath('data.0.componente.nombre', 'Componente Incluido');
        $response->assertJsonPath('data.0.tablero.id', $tablero->id);
        $response->assertJsonPath('data.0.tablero.nombre', 'Tablero Incluido');
    }

    public function test_tableros_por_componente_index_does_not_include_detailed_relations_by_default(): void
    {
        TablerosPorComponente::factory()->create();

        $response = $this->getJson('/api/v1/tableros-por-componente');

        $response->assertStatus(200);
        $response->assertJsonMissingPath('data.0.componente');
        $response->assertJsonMissingPath('data.0.tablero');
    }
}
