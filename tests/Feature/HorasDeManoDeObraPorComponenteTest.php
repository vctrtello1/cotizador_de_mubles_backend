<?php

namespace Tests\Feature;

use App\Models\Componente;
use App\Models\HorasDeManoDeObraPorComponente;
use App\Models\ManoDeObra;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HorasDeManoDeObraPorComponenteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Disable foreign key checks during tests
        \DB::statement('PRAGMA foreign_keys=off');
    }

    protected function tearDown(): void
    {
        \DB::statement('PRAGMA foreign_keys=on');
        parent::tearDown();
    }

    public function test_index(): void
    {
        $horas = HorasDeManoDeObraPorComponente::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/horas-de-mano-de-obra-por-componentes');

        $response->assertStatus(200);
    }

    public function test_store(): void
    {
        $componente = Componente::factory()->create();
        $manoDeObra = ManoDeObra::factory()->create();

        $data = [
            'componente_id' => $componente->id,
            'mano_de_obra_id' => $manoDeObra->id,
            'horas' => 5,
        ];

        $response = $this->postJson('/api/v1/horas-de-mano-de-obra-por-componentes', $data);

        $response->assertStatus(201);
    }

    public function test_show(): void
    {
        $horas = HorasDeManoDeObraPorComponente::factory()->create();

        $response = $this->getJson("/api/v1/horas-de-mano-de-obra-por-componentes/{$horas->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $horas->id]);
    }

    public function test_update(): void
    {
        $horas = HorasDeManoDeObraPorComponente::factory()->create();
        $newManoDeObra = ManoDeObra::factory()->create();

        $data = [
            'mano_de_obra_id' => $newManoDeObra->id,
            'horas' => 8,
        ];

        $response = $this->putJson("/api/v1/horas-de-mano-de-obra-por-componentes/{$horas->id}", $data);

        $response->assertStatus(200);
    }

    public function test_destroy(): void
    {
        $horas = HorasDeManoDeObraPorComponente::factory()->create();

        $response = $this->deleteJson("/api/v1/horas-de-mano-de-obra-por-componentes/{$horas->id}");

        $response->assertStatus(200);
    }

    public function test_validation_errors(): void
    {
        $response = $this->postJson('/api/v1/horas-de-mano-de-obra-por-componentes', [
            'componente_id' => 999,
            'mano_de_obra_id' => 999,
            'horas' => -1,
        ]);

        $response->assertStatus(422);
    }
}
