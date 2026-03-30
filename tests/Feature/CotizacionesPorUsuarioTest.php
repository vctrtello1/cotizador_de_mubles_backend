<?php

namespace Tests\Feature;

use App\Models\CotizacionesPorUsuario;
use App\Models\Cotizacion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CotizacionesPorUsuarioTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user, 'sanctum');
    }

    public function test_index_returns_paginated_list(): void
    {
        CotizacionesPorUsuario::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/cotizaciones-por-usuario');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'user_id', 'cotizacion_id'],
            ],
        ]);
    }

    public function test_store_creates_registro(): void
    {
        $cotizacion = Cotizacion::factory()->create();

        $response = $this->postJson('/api/v1/cotizaciones-por-usuario', [
            'user_id'       => $this->user->id,
            'cotizacion_id' => $cotizacion->id,
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'user_id'       => $this->user->id,
            'cotizacion_id' => $cotizacion->id,
        ]);
        $this->assertDatabaseHas('cotizaciones_por_usuario', [
            'user_id'       => $this->user->id,
            'cotizacion_id' => $cotizacion->id,
        ]);
    }

    public function test_store_fails_with_invalid_user(): void
    {
        $cotizacion = Cotizacion::factory()->create();

        $response = $this->postJson('/api/v1/cotizaciones-por-usuario', [
            'user_id'       => 99999,
            'cotizacion_id' => $cotizacion->id,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['user_id']);
    }

    public function test_store_fails_with_invalid_cotizacion(): void
    {
        $response = $this->postJson('/api/v1/cotizaciones-por-usuario', [
            'user_id'       => $this->user->id,
            'cotizacion_id' => 99999,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['cotizacion_id']);
    }

    public function test_show_returns_registro(): void
    {
        $registro = CotizacionesPorUsuario::factory()->create();

        $response = $this->getJson("/api/v1/cotizaciones-por-usuario/{$registro->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id'            => $registro->id,
            'user_id'       => $registro->user_id,
            'cotizacion_id' => $registro->cotizacion_id,
        ]);
    }

    public function test_update_modifies_registro(): void
    {
        $registro   = CotizacionesPorUsuario::factory()->create();
        $nuevaCotizacion = Cotizacion::factory()->create();

        $response = $this->putJson("/api/v1/cotizaciones-por-usuario/{$registro->id}", [
            'user_id'       => $registro->user_id,
            'cotizacion_id' => $nuevaCotizacion->id,
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['cotizacion_id' => $nuevaCotizacion->id]);
    }

    public function test_destroy_deletes_registro(): void
    {
        $registro = CotizacionesPorUsuario::factory()->create();

        $response = $this->deleteJson("/api/v1/cotizaciones-por-usuario/{$registro->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('cotizaciones_por_usuario', ['id' => $registro->id]);
    }

    public function test_no_se_puede_duplicar_asignacion(): void
    {
        $cotizacion = Cotizacion::factory()->create();

        CotizacionesPorUsuario::factory()->create([
            'user_id'       => $this->user->id,
            'cotizacion_id' => $cotizacion->id,
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        CotizacionesPorUsuario::factory()->create([
            'user_id'       => $this->user->id,
            'cotizacion_id' => $cotizacion->id,
        ]);
    }

    public function test_index_incluye_relaciones_cargadas(): void
    {
        CotizacionesPorUsuario::factory()->create([
            'user_id'       => $this->user->id,
        ]);

        $response = $this->getJson('/api/v1/cotizaciones-por-usuario');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'user_id',
                    'cotizacion_id',
                    'user',
                    'cotizacion',
                ],
            ],
        ]);
    }

    public function test_show_incluye_relaciones(): void
    {
        $registro = CotizacionesPorUsuario::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->getJson("/api/v1/cotizaciones-por-usuario/{$registro->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'user_id',
                'cotizacion_id',
                'user',
                'cotizacion',
            ],
        ]);
    }

    public function test_show_not_found(): void
    {
        $response = $this->getJson('/api/v1/cotizaciones-por-usuario/99999');

        $response->assertStatus(404);
    }
}
