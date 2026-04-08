<?php

namespace Tests\Feature;

use App\Models\Apagadores;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApagadoresTest extends TestCase
{
    use RefreshDatabase;

    public function test_apagadores_index(): void
    {
        Apagadores::factory()->create([
            'nombre' => 'Apagador Index A',
            'precio' => 220.00,
            'unidades_por_metro' => 2,
            'porcentaje_utilizacion' => 7.00,
        ]);
        Apagadores::factory()->create([
            'nombre' => 'Apagador Index B',
            'precio' => 240.00,
            'unidades_por_metro' => 3,
            'porcentaje_utilizacion' => 8.00,
        ]);

        $response = $this->getJson('/api/v1/apagadores');

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
        $response->assertJsonFragment(['nombre' => 'Apagador Index A']);
        $response->assertJsonFragment(['nombre' => 'Apagador Index B']);
        $this->assertGreaterThanOrEqual(2, count($response->json('data')));
    }

    public function test_apagadores_seeded_records_exist_after_migration(): void
    {
        $response = $this->getJson('/api/v1/apagadores');

        $response->assertStatus(200);
        $response->assertJsonFragment(['nombre' => 'APAGADOR']);
    }

    public function test_apagadores_show(): void
    {
        $apagador = Apagadores::factory()->create([
            'nombre' => 'Apagador Premium',
            'precio' => 260.00,
            'unidades_por_metro' => 2,
            'porcentaje_utilizacion' => 8.50,
        ]);

        $response = $this->getJson("/api/v1/apagadores/{$apagador->id}");

        $response->assertStatus(200);
        $response->assertJsonPath('data.nombre', 'Apagador Premium');
        $response->assertJsonPath('data.precio', '260.00');
        $response->assertJsonPath('data.unidades_por_metro', 2);
        $response->assertJsonPath('data.porcentaje_utilizacion', '8.50');
    }

    public function test_apagadores_store(): void
    {
        $payload = [
            'nombre' => 'Apagador Novo',
            'precio' => 230.00,
            'unidades_por_metro' => 2,
            'porcentaje_utilizacion' => 7.50,
        ];

        $response = $this->postJson('/api/v1/apagadores', $payload);

        $response->assertStatus(201);
        $response->assertJsonPath('data.nombre', 'Apagador Novo');
        $response->assertJsonPath('data.precio', '230.00');
        $response->assertJsonPath('data.unidades_por_metro', 2);
        $response->assertJsonPath('data.porcentaje_utilizacion', '7.50');

        $this->assertDatabaseHas('apagadores', [
            'nombre' => 'Apagador Novo',
            'precio' => 230.00,
            'unidades_por_metro' => 2,
            'porcentaje_utilizacion' => 7.50,
        ]);
    }

    public function test_apagadores_update(): void
    {
        $apagador = Apagadores::factory()->create();

        $response = $this->putJson("/api/v1/apagadores/{$apagador->id}", [
            'precio' => 270.00,
            'unidades_por_metro' => 3,
            'porcentaje_utilizacion' => 9.00,
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('data.precio', '270.00');
        $response->assertJsonPath('data.unidades_por_metro', 3);
        $response->assertJsonPath('data.porcentaje_utilizacion', '9.00');

        $this->assertDatabaseHas('apagadores', [
            'id' => $apagador->id,
            'precio' => 270.00,
            'unidades_por_metro' => 3,
            'porcentaje_utilizacion' => 9.00,
        ]);
    }

    public function test_apagadores_delete(): void
    {
        $apagador = Apagadores::factory()->create();

        $response = $this->deleteJson("/api/v1/apagadores/{$apagador->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('apagadores', ['id' => $apagador->id]);
    }

    public function test_apagadores_validation_required_fields(): void
    {
        $response = $this->postJson('/api/v1/apagadores', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre', 'precio', 'unidades_por_metro', 'porcentaje_utilizacion']);
    }

    public function test_apagadores_validation_unique_nombre(): void
    {
        $apagador = Apagadores::factory()->create(['nombre' => 'Apagador Único']);

        $response = $this->postJson('/api/v1/apagadores', [
            'nombre' => $apagador->nombre,
            'precio' => 220.00,
            'unidades_por_metro' => 2,
            'porcentaje_utilizacion' => 7.00,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre']);
    }

    public function test_apagadores_validation_precio_non_negative(): void
    {
        $response = $this->postJson('/api/v1/apagadores', [
            'nombre' => 'Apagador Inválido',
            'precio' => -100,
            'unidades_por_metro' => 2,
            'porcentaje_utilizacion' => 7.00,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['precio']);
    }

    public function test_apagadores_validation_unidades_por_metro_positive(): void
    {
        $response = $this->postJson('/api/v1/apagadores', [
            'nombre' => 'Apagador Inválido',
            'precio' => 220.00,
            'unidades_por_metro' => 0,
            'porcentaje_utilizacion' => 7.00,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['unidades_por_metro']);
    }

    public function test_apagadores_validation_porcentaje_utilizacion_range(): void
    {
        $response = $this->postJson('/api/v1/apagadores', [
            'nombre' => 'Apagador Inválido',
            'precio' => 220.00,
            'unidades_por_metro' => 2,
            'porcentaje_utilizacion' => 150.00,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['porcentaje_utilizacion']);
    }

    public function test_non_admin_cannot_create_apagadores(): void
    {
        Sanctum::actingAs(User::factory()->create(['rol' => 'vendedor']));

        $response = $this->postJson('/api/v1/apagadores', [
            'nombre' => 'Apagador Test',
            'precio' => 220.00,
            'unidades_por_metro' => 2,
            'porcentaje_utilizacion' => 7.00,
        ]);

        $response->assertStatus(403);
    }

    public function test_non_admin_cannot_update_apagadores(): void
    {
        $apagador = Apagadores::factory()->create();
        Sanctum::actingAs(User::factory()->create(['rol' => 'vendedor']));

        $response = $this->putJson("/api/v1/apagadores/{$apagador->id}", [
            'precio' => 999.99,
        ]);

        $response->assertStatus(403);
    }

    public function test_non_admin_cannot_delete_apagadores(): void
    {
        $apagador = Apagadores::factory()->create();
        Sanctum::actingAs(User::factory()->create(['rol' => 'vendedor']));

        $response = $this->deleteJson("/api/v1/apagadores/{$apagador->id}");

        $response->assertStatus(403);
    }
}
