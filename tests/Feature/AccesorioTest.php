<?php

namespace Tests\Feature;

use App\Models\Accesorio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AccesorioTest extends TestCase
{
    use RefreshDatabase;

    public function test_accesorio_index(): void
    {
        Accesorio::factory()->create([
            'nombre' => 'Accesorio Index A',
            'precio' => 10.00,
        ]);
        Accesorio::factory()->create([
            'nombre' => 'Accesorio Index B',
            'precio' => 20.00,
        ]);

        $response = $this->getJson('/api/v1/accesorios');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'nombre',
                    'precio',
                ],
            ],
        ]);
        $response->assertJsonFragment(['nombre' => 'Accesorio Index A']);
        $response->assertJsonFragment(['nombre' => 'Accesorio Index B']);
        $this->assertGreaterThanOrEqual(2, count($response->json('data')));
    }

    public function test_accesorio_seeded_records_exist_after_migration(): void
    {
        $response = $this->getJson('/api/v1/accesorios');

        $response->assertStatus(200);
        $response->assertJsonFragment(['nombre' => 'MENSULA REPISA']);
        $response->assertJsonFragment(['nombre' => 'ZOCLO']);
        $response->assertJsonFragment(['nombre' => 'CLIPS ZOCLO']);
        $response->assertJsonFragment(['nombre' => 'PATAS NIVELADORAS']);
    }

    public function test_accesorio_show(): void
    {
        $accesorio = Accesorio::factory()->create([
            'nombre' => 'Bisagra Premium',
            'precio' => 45.90,
        ]);

        $response = $this->getJson("/api/v1/accesorios/{$accesorio->id}");

        $response->assertStatus(200);
        $response->assertJsonPath('data.nombre', 'Bisagra Premium');
        $response->assertJsonPath('data.precio', '45.90');
    }

    public function test_accesorio_store(): void
    {
        $payload = [
            'nombre' => 'Jaladera Nova',
            'precio' => 39.00,
        ];

        $response = $this->postJson('/api/v1/accesorios', $payload);

        $response->assertStatus(201);
        $response->assertJsonPath('data.nombre', 'Jaladera Nova');
        $response->assertJsonPath('data.precio', '39.00');

        $this->assertDatabaseHas('accesorios', [
            'nombre' => 'Jaladera Nova',
            'precio' => 39.00,
        ]);
    }

    public function test_accesorio_update(): void
    {
        $accesorio = Accesorio::factory()->create();

        $response = $this->putJson("/api/v1/accesorios/{$accesorio->id}", [
            'precio' => 55.50,
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('data.precio', '55.50');

        $this->assertDatabaseHas('accesorios', [
            'id' => $accesorio->id,
            'precio' => 55.50,
        ]);
    }

    public function test_accesorio_delete(): void
    {
        $accesorio = Accesorio::factory()->create();

        $response = $this->deleteJson("/api/v1/accesorios/{$accesorio->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('accesorios', ['id' => $accesorio->id]);
    }

    public function test_accesorio_validation_required_fields(): void
    {
        $response = $this->postJson('/api/v1/accesorios', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre', 'precio']);
    }

    public function test_accesorio_validation_unique_nombre(): void
    {
        $accesorio = Accesorio::factory()->create(['nombre' => 'Bisagra Unica']);

        $response = $this->postJson('/api/v1/accesorios', [
            'nombre' => $accesorio->nombre,
            'precio' => 12.00,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre']);
    }

    public function test_accesorio_validation_precio_non_negative(): void
    {
        $response = $this->postJson('/api/v1/accesorios', [
            'nombre' => 'Accesorio Inválido',
            'precio' => -10,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['precio']);
    }

    public function test_non_admin_cannot_create_accesorio(): void
    {
        Sanctum::actingAs(User::factory()->create(['rol' => 'vendedor']));

        $response = $this->postJson('/api/v1/accesorios', [
            'nombre' => 'Accesorio Restringido',
            'precio' => 50.00,
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('accesorios', [
            'nombre' => 'Accesorio Restringido',
        ]);
    }
}
