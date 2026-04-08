<?php

namespace Tests\Feature;

use App\Models\PerfilAluminio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PerfilAluminioTest extends TestCase
{
    use RefreshDatabase;

    public function test_perfil_aluminio_index(): void
    {
        PerfilAluminio::factory()->create([
            'nombre' => 'Perfil Index A',
            'precio' => 130.00,
            'porcentaje_utilizacion' => 4.00,
        ]);
        PerfilAluminio::factory()->create([
            'nombre' => 'Perfil Index B',
            'precio' => 160.00,
            'porcentaje_utilizacion' => 5.50,
        ]);

        $response = $this->getJson('/api/v1/perfiles-aluminio');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'nombre',
                    'precio',
                    'porcentaje_utilizacion',
                ],
            ],
        ]);
        $response->assertJsonFragment(['nombre' => 'Perfil Index A']);
        $response->assertJsonFragment(['nombre' => 'Perfil Index B']);
        $this->assertGreaterThanOrEqual(2, count($response->json('data')));
    }

    public function test_perfil_aluminio_seeded_records_exist_after_migration(): void
    {
        $response = $this->getJson('/api/v1/perfiles-aluminio');

        $response->assertStatus(200);
        $response->assertJsonFragment(['nombre' => 'PERFIL ALUMINIO EMPOTRADO']);
    }

    public function test_perfil_aluminio_show(): void
    {
        $perfil = PerfilAluminio::factory()->create([
            'nombre' => 'Perfil Premium',
            'precio' => 200.00,
            'porcentaje_utilizacion' => 7.50,
        ]);

        $response = $this->getJson("/api/v1/perfiles-aluminio/{$perfil->id}");

        $response->assertStatus(200);
        $response->assertJsonPath('data.nombre', 'Perfil Premium');
        $response->assertJsonPath('data.precio', '200.00');
        $response->assertJsonPath('data.porcentaje_utilizacion', '7.50');
    }

    public function test_perfil_aluminio_store(): void
    {
        $payload = [
            'nombre' => 'Perfil Novo',
            'precio' => 140.00,
            'porcentaje_utilizacion' => 4.25,
        ];

        $response = $this->postJson('/api/v1/perfiles-aluminio', $payload);

        $response->assertStatus(201);
        $response->assertJsonPath('data.nombre', 'Perfil Novo');
        $response->assertJsonPath('data.precio', '140.00');
        $response->assertJsonPath('data.porcentaje_utilizacion', '4.25');

        $this->assertDatabaseHas('perfil_aluminios', [
            'nombre' => 'Perfil Novo',
            'precio' => 140.00,
            'porcentaje_utilizacion' => 4.25,
        ]);
    }

    public function test_perfil_aluminio_update(): void
    {
        $perfil = PerfilAluminio::factory()->create();

        $response = $this->putJson("/api/v1/perfiles-aluminio/{$perfil->id}", [
            'precio' => 190.00,
            'porcentaje_utilizacion' => 6.75,
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('data.precio', '190.00');
        $response->assertJsonPath('data.porcentaje_utilizacion', '6.75');

        $this->assertDatabaseHas('perfil_aluminios', [
            'id' => $perfil->id,
            'precio' => 190.00,
            'porcentaje_utilizacion' => 6.75,
        ]);
    }

    public function test_perfil_aluminio_delete(): void
    {
        $perfil = PerfilAluminio::factory()->create();

        $response = $this->deleteJson("/api/v1/perfiles-aluminio/{$perfil->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('perfil_aluminios', ['id' => $perfil->id]);
    }

    public function test_perfil_aluminio_validation_required_fields(): void
    {
        $response = $this->postJson('/api/v1/perfiles-aluminio', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre', 'precio', 'porcentaje_utilizacion']);
    }

    public function test_perfil_aluminio_validation_unique_nombre(): void
    {
        $perfil = PerfilAluminio::factory()->create(['nombre' => 'Perfil Único']);

        $response = $this->postJson('/api/v1/perfiles-aluminio', [
            'nombre' => $perfil->nombre,
            'precio' => 130.00,
            'porcentaje_utilizacion' => 4.00,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre']);
    }

    public function test_perfil_aluminio_validation_precio_non_negative(): void
    {
        $response = $this->postJson('/api/v1/perfiles-aluminio', [
            'nombre' => 'Perfil Inválido',
            'precio' => -50,
            'porcentaje_utilizacion' => 4.00,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['precio']);
    }

    public function test_perfil_aluminio_validation_porcentaje_utilizacion_range(): void
    {
        $response = $this->postJson('/api/v1/perfiles-aluminio', [
            'nombre' => 'Perfil Inválido',
            'precio' => 130.00,
            'porcentaje_utilizacion' => 150.00,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['porcentaje_utilizacion']);
    }

    public function test_non_admin_cannot_create_perfil_aluminio(): void
    {
        Sanctum::actingAs(User::factory()->create(['rol' => 'vendedor']));

        $response = $this->postJson('/api/v1/perfiles-aluminio', [
            'nombre' => 'Perfil Test',
            'precio' => 130.00,
            'porcentaje_utilizacion' => 4.00,
        ]);

        $response->assertStatus(403);
    }

    public function test_non_admin_cannot_update_perfil_aluminio(): void
    {
        $perfil = PerfilAluminio::factory()->create();
        Sanctum::actingAs(User::factory()->create(['rol' => 'vendedor']));

        $response = $this->putJson("/api/v1/perfiles-aluminio/{$perfil->id}", [
            'precio' => 999.99,
        ]);

        $response->assertStatus(403);
    }

    public function test_non_admin_cannot_delete_perfil_aluminio(): void
    {
        $perfil = PerfilAluminio::factory()->create();
        Sanctum::actingAs(User::factory()->create(['rol' => 'vendedor']));

        $response = $this->deleteJson("/api/v1/perfiles-aluminio/{$perfil->id}");

        $response->assertStatus(403);
    }
}
