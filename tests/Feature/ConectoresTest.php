<?php

namespace Tests\Feature;

use App\Models\Conectores;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ConectoresTest extends TestCase
{
    use RefreshDatabase;

    public function test_conectores_index(): void
    {
        Conectores::factory()->create([
            'nombre' => 'Conector Index A',
            'precio' => 50.00,
            'unidades_por_metro' => 2,
            'porcentaje_utilizacion' => 5.00,
        ]);
        Conectores::factory()->create([
            'nombre' => 'Conector Index B',
            'precio' => 75.00,
            'unidades_por_metro' => 3,
            'porcentaje_utilizacion' => 8.00,
        ]);

        $response = $this->getJson('/api/v1/conectores');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'nombre',
                    'precio',
                    'unidades_por_metro',
                    'porcentaje_utilizacion',
                ],
            ],
        ]);
        $response->assertJsonFragment(['nombre' => 'Conector Index A']);
        $response->assertJsonFragment(['nombre' => 'Conector Index B']);
        $this->assertGreaterThanOrEqual(2, count($response->json('data')));
    }

    public function test_conectores_seeded_records_exist_after_migration(): void
    {
        $response = $this->getJson('/api/v1/conectores');

        $response->assertStatus(200);
        $response->assertJsonFragment(['nombre' => 'CONECTORES']);
    }

    public function test_conectores_show(): void
    {
        $conector = Conectores::factory()->create([
            'nombre' => 'Conector Premium',
            'precio' => 85.90,
            'unidades_por_metro' => 4,
            'porcentaje_utilizacion' => 10.50,
        ]);

        $response = $this->getJson("/api/v1/conectores/{$conector->id}");

        $response->assertStatus(200);
        $response->assertJsonPath('data.nombre', 'Conector Premium');
        $response->assertJsonPath('data.precio', '85.90');
        $response->assertJsonPath('data.unidades_por_metro', 4);
        $response->assertJsonPath('data.porcentaje_utilizacion', '10.50');
    }

    public function test_conectores_store(): void
    {
        $payload = [
            'nombre' => 'Conector Nova',
            'precio' => 65.00,
            'unidades_por_metro' => 2,
            'porcentaje_utilizacion' => 7.50,
        ];

        $response = $this->postJson('/api/v1/conectores', $payload);

        $response->assertStatus(201);
        $response->assertJsonPath('data.nombre', 'Conector Nova');
        $response->assertJsonPath('data.precio', '65.00');
        $response->assertJsonPath('data.unidades_por_metro', 2);
        $response->assertJsonPath('data.porcentaje_utilizacion', '7.50');

        $this->assertDatabaseHas('conectores', [
            'nombre' => 'Conector Nova',
            'precio' => 65.00,
            'unidades_por_metro' => 2,
            'porcentaje_utilizacion' => 7.50,
        ]);
    }

    public function test_conectores_update(): void
    {
        $conector = Conectores::factory()->create();

        $response = $this->putJson("/api/v1/conectores/{$conector->id}", [
            'precio' => 95.50,
            'unidades_por_metro' => 5,
            'porcentaje_utilizacion' => 12.75,
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('data.precio', '95.50');
        $response->assertJsonPath('data.unidades_por_metro', 5);
        $response->assertJsonPath('data.porcentaje_utilizacion', '12.75');

        $this->assertDatabaseHas('conectores', [
            'id' => $conector->id,
            'precio' => 95.50,
            'unidades_por_metro' => 5,
            'porcentaje_utilizacion' => 12.75,
        ]);
    }

    public function test_conectores_delete(): void
    {
        $conector = Conectores::factory()->create();

        $response = $this->deleteJson("/api/v1/conectores/{$conector->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('conectores', ['id' => $conector->id]);
    }

    public function test_conectores_validation_required_fields(): void
    {
        $response = $this->postJson('/api/v1/conectores', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre', 'precio', 'unidades_por_metro', 'porcentaje_utilizacion']);
    }

    public function test_conectores_validation_unique_nombre(): void
    {
        $conector = Conectores::factory()->create(['nombre' => 'Conector Único']);

        $response = $this->postJson('/api/v1/conectores', [
            'nombre' => $conector->nombre,
            'precio' => 50.00,
            'unidades_por_metro' => 2,
            'porcentaje_utilizacion' => 5.00,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre']);
    }

    public function test_conectores_validation_precio_non_negative(): void
    {
        $response = $this->postJson('/api/v1/conectores', [
            'nombre' => 'Conector Inválido',
            'precio' => -10,
            'unidades_por_metro' => 2,
            'porcentaje_utilizacion' => 5.00,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['precio']);
    }

    public function test_conectores_validation_unidades_por_metro_positive(): void
    {
        $response = $this->postJson('/api/v1/conectores', [
            'nombre' => 'Conector Inválido',
            'precio' => 50.00,
            'unidades_por_metro' => 0,
            'porcentaje_utilizacion' => 5.00,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['unidades_por_metro']);
    }

    public function test_non_admin_cannot_create_conectores(): void
    {
        Sanctum::actingAs(User::factory()->create(['rol' => 'vendedor']));

        $response = $this->postJson('/api/v1/conectores', [
            'nombre' => 'Conector Test',
            'precio' => 50.00,
            'unidades_por_metro' => 2,
            'porcentaje_utilizacion' => 5.00,
        ]);

        $response->assertStatus(403);
    }

    public function test_non_admin_cannot_update_conectores(): void
    {
        $conector = Conectores::factory()->create();
        Sanctum::actingAs(User::factory()->create(['rol' => 'vendedor']));

        $response = $this->putJson("/api/v1/conectores/{$conector->id}", [
            'precio' => 99.99,
        ]);

        $response->assertStatus(403);
    }

    public function test_non_admin_cannot_delete_conectores(): void
    {
        $conector = Conectores::factory()->create();
        Sanctum::actingAs(User::factory()->create(['rol' => 'vendedor']));

        $response = $this->deleteJson("/api/v1/conectores/{$conector->id}");

        $response->assertStatus(403);
    }

    public function test_conectores_validation_porcentaje_utilizacion_range(): void
    {
        $response = $this->postJson('/api/v1/conectores', [
            'nombre' => 'Conector Inválido',
            'precio' => 50.00,
            'unidades_por_metro' => 2,
            'porcentaje_utilizacion' => 150.00,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['porcentaje_utilizacion']);
    }
}
