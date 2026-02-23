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
}
