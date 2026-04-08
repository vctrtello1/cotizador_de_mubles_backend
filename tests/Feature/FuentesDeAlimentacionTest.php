<?php

namespace Tests\Feature;

use App\Models\FuentesDeAlimentacion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class FuentesDeAlimentacionTest extends TestCase
{
    use RefreshDatabase;

    public function test_fuentes_de_alimentacion_index(): void
    {
        FuentesDeAlimentacion::factory()->create([
            'nombre' => 'Fuente Index A',
            'precio' => 700.00,
            'unidades_por_metro' => 45,
            'porcentaje_utilizacion' => 3.00,
        ]);
        FuentesDeAlimentacion::factory()->create([
            'nombre' => 'Fuente Index B',
            'precio' => 850.00,
            'unidades_por_metro' => 55,
            'porcentaje_utilizacion' => 4.00,
        ]);

        $response = $this->getJson('/api/v1/fuentes-de-alimentacion');

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
        $response->assertJsonFragment(['nombre' => 'Fuente Index A']);
        $response->assertJsonFragment(['nombre' => 'Fuente Index B']);
        $this->assertGreaterThanOrEqual(2, count($response->json('data')));
    }

    public function test_fuentes_de_alimentacion_seeded_records_exist_after_migration(): void
    {
        $response = $this->getJson('/api/v1/fuentes-de-alimentacion');

        $response->assertStatus(200);
        $response->assertJsonFragment(['nombre' => 'F. ALIMENTACION']);
    }

    public function test_fuentes_de_alimentacion_show(): void
    {
        $fuente = FuentesDeAlimentacion::factory()->create([
            'nombre' => 'Fuente Premium',
            'precio' => 950.00,
            'unidades_por_metro' => 60,
            'porcentaje_utilizacion' => 5.50,
        ]);

        $response = $this->getJson("/api/v1/fuentes-de-alimentacion/{$fuente->id}");

        $response->assertStatus(200);
        $response->assertJsonPath('data.nombre', 'Fuente Premium');
        $response->assertJsonPath('data.precio', '950.00');
        $response->assertJsonPath('data.unidades_por_metro', 60);
        $response->assertJsonPath('data.porcentaje_utilizacion', '5.50');
    }

    public function test_fuentes_de_alimentacion_store(): void
    {
        $payload = [
            'nombre' => 'Fuente Nova',
            'precio' => 750.00,
            'unidades_por_metro' => 50,
            'porcentaje_utilizacion' => 3.25,
        ];

        $response = $this->postJson('/api/v1/fuentes-de-alimentacion', $payload);

        $response->assertStatus(201);
        $response->assertJsonPath('data.nombre', 'Fuente Nova');
        $response->assertJsonPath('data.precio', '750.00');
        $response->assertJsonPath('data.unidades_por_metro', 50);
        $response->assertJsonPath('data.porcentaje_utilizacion', '3.25');

        $this->assertDatabaseHas('fuentes_de_alimentacion', [
            'nombre' => 'Fuente Nova',
            'precio' => 750.00,
            'unidades_por_metro' => 50,
            'porcentaje_utilizacion' => 3.25,
        ]);
    }

    public function test_fuentes_de_alimentacion_update(): void
    {
        $fuente = FuentesDeAlimentacion::factory()->create();

        $response = $this->putJson("/api/v1/fuentes-de-alimentacion/{$fuente->id}", [
            'precio' => 1050.00,
            'unidades_por_metro' => 70,
            'porcentaje_utilizacion' => 6.50,
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('data.precio', '1050.00');
        $response->assertJsonPath('data.unidades_por_metro', 70);
        $response->assertJsonPath('data.porcentaje_utilizacion', '6.50');

        $this->assertDatabaseHas('fuentes_de_alimentacion', [
            'id' => $fuente->id,
            'precio' => 1050.00,
            'unidades_por_metro' => 70,
            'porcentaje_utilizacion' => 6.50,
        ]);
    }

    public function test_fuentes_de_alimentacion_delete(): void
    {
        $fuente = FuentesDeAlimentacion::factory()->create();

        $response = $this->deleteJson("/api/v1/fuentes-de-alimentacion/{$fuente->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('fuentes_de_alimentacion', ['id' => $fuente->id]);
    }

    public function test_fuentes_de_alimentacion_validation_required_fields(): void
    {
        $response = $this->postJson('/api/v1/fuentes-de-alimentacion', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre', 'precio', 'unidades_por_metro', 'porcentaje_utilizacion']);
    }

    public function test_fuentes_de_alimentacion_validation_unique_nombre(): void
    {
        $fuente = FuentesDeAlimentacion::factory()->create(['nombre' => 'Fuente Única']);

        $response = $this->postJson('/api/v1/fuentes-de-alimentacion', [
            'nombre' => $fuente->nombre,
            'precio' => 700.00,
            'unidades_por_metro' => 50,
            'porcentaje_utilizacion' => 3.00,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre']);
    }

    public function test_fuentes_de_alimentacion_validation_precio_non_negative(): void
    {
        $response = $this->postJson('/api/v1/fuentes-de-alimentacion', [
            'nombre' => 'Fuente Inválida',
            'precio' => -100,
            'unidades_por_metro' => 50,
            'porcentaje_utilizacion' => 3.00,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['precio']);
    }

    public function test_fuentes_de_alimentacion_validation_unidades_por_metro_positive(): void
    {
        $response = $this->postJson('/api/v1/fuentes-de-alimentacion', [
            'nombre' => 'Fuente Inválida',
            'precio' => 700.00,
            'unidades_por_metro' => 0,
            'porcentaje_utilizacion' => 3.00,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['unidades_por_metro']);
    }

    public function test_fuentes_de_alimentacion_validation_porcentaje_utilizacion_range(): void
    {
        $response = $this->postJson('/api/v1/fuentes-de-alimentacion', [
            'nombre' => 'Fuente Inválida',
            'precio' => 700.00,
            'unidades_por_metro' => 50,
            'porcentaje_utilizacion' => 150.00,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['porcentaje_utilizacion']);
    }

    public function test_non_admin_cannot_create_fuentes_de_alimentacion(): void
    {
        Sanctum::actingAs(User::factory()->create(['rol' => 'vendedor']));

        $response = $this->postJson('/api/v1/fuentes-de-alimentacion', [
            'nombre' => 'Fuente Test',
            'precio' => 700.00,
            'unidades_por_metro' => 50,
            'porcentaje_utilizacion' => 3.00,
        ]);

        $response->assertStatus(403);
    }

    public function test_non_admin_cannot_update_fuentes_de_alimentacion(): void
    {
        $fuente = FuentesDeAlimentacion::factory()->create();
        Sanctum::actingAs(User::factory()->create(['rol' => 'vendedor']));

        $response = $this->putJson("/api/v1/fuentes-de-alimentacion/{$fuente->id}", [
            'precio' => 999.99,
        ]);

        $response->assertStatus(403);
    }

    public function test_non_admin_cannot_delete_fuentes_de_alimentacion(): void
    {
        $fuente = FuentesDeAlimentacion::factory()->create();
        Sanctum::actingAs(User::factory()->create(['rol' => 'vendedor']));

        $response = $this->deleteJson("/api/v1/fuentes-de-alimentacion/{$fuente->id}");

        $response->assertStatus(403);
    }
}
