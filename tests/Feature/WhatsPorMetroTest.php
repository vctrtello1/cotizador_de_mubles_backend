<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\WhatsPorMetro;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class WhatsPorMetroTest extends TestCase
{
    use RefreshDatabase;

    public function test_whats_por_metro_index(): void
    {
        WhatsPorMetro::factory()->create([
            'nombre' => 'Watts Index A',
            'precio' => 100.00,
            'unidades_por_metro' => 6,
            'porcentaje_utilizacion' => 5.00,
        ]);
        WhatsPorMetro::factory()->create([
            'nombre' => 'Watts Index B',
            'precio' => 120.00,
            'unidades_por_metro' => 8,
            'porcentaje_utilizacion' => 6.00,
        ]);

        $response = $this->getJson('/api/v1/whats-por-metro');

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
        $response->assertJsonFragment(['nombre' => 'Watts Index A']);
        $response->assertJsonFragment(['nombre' => 'Watts Index B']);
        $this->assertGreaterThanOrEqual(2, count($response->json('data')));
    }

    public function test_whats_por_metro_seeded_records_exist_after_migration(): void
    {
        $response = $this->getJson('/api/v1/whats-por-metro');

        $response->assertStatus(200);
        $response->assertJsonFragment(['nombre' => 'W X METRO']);
    }

    public function test_whats_por_metro_show(): void
    {
        $whatsPorMetro = WhatsPorMetro::factory()->create([
            'nombre' => 'Watts Premium',
            'precio' => 130.00,
            'unidades_por_metro' => 7,
            'porcentaje_utilizacion' => 5.50,
        ]);

        $response = $this->getJson("/api/v1/whats-por-metro/{$whatsPorMetro->id}");

        $response->assertStatus(200);
        $response->assertJsonPath('data.nombre', 'Watts Premium');
        $response->assertJsonPath('data.precio', '130.00');
        $response->assertJsonPath('data.unidades_por_metro', 7);
        $response->assertJsonPath('data.porcentaje_utilizacion', '5.50');
    }

    public function test_whats_por_metro_store(): void
    {
        $payload = [
            'nombre' => 'Watts Novo',
            'precio' => 110.00,
            'unidades_por_metro' => 7,
            'porcentaje_utilizacion' => 5.00,
        ];

        $response = $this->postJson('/api/v1/whats-por-metro', $payload);

        $response->assertStatus(201);
        $response->assertJsonPath('data.nombre', 'Watts Novo');
        $response->assertJsonPath('data.precio', '110.00');
        $response->assertJsonPath('data.unidades_por_metro', 7);
        $response->assertJsonPath('data.porcentaje_utilizacion', '5.00');

        $this->assertDatabaseHas('whats_por_metro', [
            'nombre' => 'Watts Novo',
            'precio' => 110.00,
            'unidades_por_metro' => 7,
            'porcentaje_utilizacion' => 5.00,
        ]);
    }

    public function test_whats_por_metro_update(): void
    {
        $whatsPorMetro = WhatsPorMetro::factory()->create();

        $response = $this->putJson("/api/v1/whats-por-metro/{$whatsPorMetro->id}", [
            'precio' => 150.00,
            'unidades_por_metro' => 9,
            'porcentaje_utilizacion' => 7.00,
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('data.precio', '150.00');
        $response->assertJsonPath('data.unidades_por_metro', 9);
        $response->assertJsonPath('data.porcentaje_utilizacion', '7.00');

        $this->assertDatabaseHas('whats_por_metro', [
            'id' => $whatsPorMetro->id,
            'precio' => 150.00,
            'unidades_por_metro' => 9,
            'porcentaje_utilizacion' => 7.00,
        ]);
    }

    public function test_whats_por_metro_delete(): void
    {
        $whatsPorMetro = WhatsPorMetro::factory()->create();

        $response = $this->deleteJson("/api/v1/whats-por-metro/{$whatsPorMetro->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('whats_por_metro', ['id' => $whatsPorMetro->id]);
    }

    public function test_whats_por_metro_validation_required_fields(): void
    {
        $response = $this->postJson('/api/v1/whats-por-metro', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre', 'precio', 'unidades_por_metro', 'porcentaje_utilizacion']);
    }

    public function test_whats_por_metro_validation_unique_nombre(): void
    {
        $whatsPorMetro = WhatsPorMetro::factory()->create(['nombre' => 'Watts Único']);

        $response = $this->postJson('/api/v1/whats-por-metro', [
            'nombre' => $whatsPorMetro->nombre,
            'precio' => 100.00,
            'unidades_por_metro' => 7,
            'porcentaje_utilizacion' => 5.00,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre']);
    }

    public function test_whats_por_metro_validation_precio_non_negative(): void
    {
        $response = $this->postJson('/api/v1/whats-por-metro', [
            'nombre' => 'Watts Inválido',
            'precio' => -100,
            'unidades_por_metro' => 7,
            'porcentaje_utilizacion' => 5.00,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['precio']);
    }

    public function test_whats_por_metro_validation_unidades_por_metro_positive(): void
    {
        $response = $this->postJson('/api/v1/whats-por-metro', [
            'nombre' => 'Watts Inválido',
            'precio' => 100.00,
            'unidades_por_metro' => 0,
            'porcentaje_utilizacion' => 5.00,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['unidades_por_metro']);
    }

    public function test_whats_por_metro_validation_porcentaje_utilizacion_range(): void
    {
        $response = $this->postJson('/api/v1/whats-por-metro', [
            'nombre' => 'Watts Inválido',
            'precio' => 100.00,
            'unidades_por_metro' => 7,
            'porcentaje_utilizacion' => 150.00,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['porcentaje_utilizacion']);
    }

    public function test_non_admin_cannot_create_whats_por_metro(): void
    {
        Sanctum::actingAs(User::factory()->create(['rol' => 'vendedor']));

        $response = $this->postJson('/api/v1/whats-por-metro', [
            'nombre' => 'Watts Test',
            'precio' => 100.00,
            'unidades_por_metro' => 7,
            'porcentaje_utilizacion' => 5.00,
        ]);

        $response->assertStatus(403);
    }

    public function test_non_admin_cannot_update_whats_por_metro(): void
    {
        $whatsPorMetro = WhatsPorMetro::factory()->create();
        Sanctum::actingAs(User::factory()->create(['rol' => 'vendedor']));

        $response = $this->putJson("/api/v1/whats-por-metro/{$whatsPorMetro->id}", [
            'precio' => 999.99,
        ]);

        $response->assertStatus(403);
    }

    public function test_non_admin_cannot_delete_whats_por_metro(): void
    {
        $whatsPorMetro = WhatsPorMetro::factory()->create();
        Sanctum::actingAs(User::factory()->create(['rol' => 'vendedor']));

        $response = $this->deleteJson("/api/v1/whats-por-metro/{$whatsPorMetro->id}");

        $response->assertStatus(403);
    }
}
