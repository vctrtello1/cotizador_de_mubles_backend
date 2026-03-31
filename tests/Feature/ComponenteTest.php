<?php

namespace Tests\Feature;

use App\Models\AcabadoCubreCanto;
use App\Models\AcabadoCubreCantoPorComponente;
use App\Models\AcabadoTablero;
use App\Models\AcabadoTableroPorComponente;
use App\Models\AccesoriosPorComponente;
use App\Models\CompasAbatible;
use App\Models\CompasAbatiblePorComponente;
use App\Models\Componente;
use App\Models\Corredera;
use App\Models\CorrederaPorComponente;
use App\Models\Estructura;
use App\Models\EstructuraPorComponente;
use App\Models\GolaPorComponente;
use App\Models\Gola;
use App\Models\Puerta;
use App\Models\PuertasPorComponente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ComponenteTest extends TestCase
{
    use RefreshDatabase;

    public function test_componente_index(): void
    {
        $response = $this->getJson('/api/v1/componentes');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'nombre',
                    'descripcion',
                    'codigo',
                    'precio_unitario',
                    'costo_total',
                ],
            ],
        ]);
    }

    public function test_componente_show(): void
    {
        $componente = Componente::factory()->create();

        $response = $this->getJson("/api/v1/componentes/{$componente->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'nombre',
                'descripcion',
                'codigo',
                'precio_unitario',
                'costo_total',
                'accesorios',
            ],
        ]);
    }

    public function test_componente_store(): void
    {
        $componenteData = [
            'nombre' => 'Componente Test',
            'descripcion' => 'Descripcion del componente test',
            'codigo' => 'CMP-12345',
            'precio_unitario' => 350.50,
            'accesorios' => 'Accesorio1, Accesorio2',
        ];

        $response = $this->postJson('/api/v1/componentes', $componenteData);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'nombre' => 'Componente Test',
            'descripcion' => 'Descripcion del componente test',
            'codigo' => 'CMP-12345',
            'precio_unitario' => '350.50',
        ]);
        $response->assertJsonFragment(['accesorio' => 'Accesorio1']);
        $response->assertJsonFragment(['accesorio' => 'Accesorio2']);

        $this->assertDatabaseHas('componentes', [
            'nombre' => 'Componente Test',
            'codigo' => 'CMP-12345',
            'precio_unitario' => 350.50,
        ]);
    }

    public function test_componente_update(): void
    {
        $componente = Componente::factory()->create();

        $updateData = [
            'nombre' => 'Componente Actualizado',
            'descripcion' => 'Descripcion actualizada',
            'codigo' => 'CMP-54321',
            'precio_unitario' => 899.99,
            'accesorios' => 'Accesorio3, Accesorio4',
        ];

        $response = $this->putJson("/api/v1/componentes/{$componente->id}", $updateData);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'nombre' => 'Componente Actualizado',
            'descripcion' => 'Descripcion actualizada',
            'codigo' => 'CMP-54321',
            'precio_unitario' => '899.99',
        ]);
        $response->assertJsonFragment(['accesorio' => 'Accesorio3']);
        $response->assertJsonFragment(['accesorio' => 'Accesorio4']);

        $this->assertDatabaseHas('componentes', [
            'id' => $componente->id,
            'nombre' => 'Componente Actualizado',
            'codigo' => 'CMP-54321',
            'precio_unitario' => 899.99,
        ]);
    }

    public function test_componente_destroy(): void
    {
        $componente = Componente::factory()->create();

        $response = $this->deleteJson("/api/v1/componentes/{$componente->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('componentes', [
            'id' => $componente->id,
        ]);
    }

    public function test_componente_destroy_elimina_todas_las_relaciones(): void
    {
        $componente = Componente::factory()->create();

        EstructuraPorComponente::factory()->create(['componente_id' => $componente->id]);
        AcabadoTableroPorComponente::factory()->create(['componente_id' => $componente->id]);
        AcabadoCubreCantoPorComponente::factory()->create(['componente_id' => $componente->id]);
        PuertasPorComponente::factory()->create(['componente_id' => $componente->id]);
        GolaPorComponente::factory()->create(['componente_id' => $componente->id]);
        CorrederaPorComponente::factory()->create(['componente_id' => $componente->id]);
        CompasAbatiblePorComponente::factory()->create(['componente_id' => $componente->id]);
        AccesoriosPorComponente::factory()->create(['componente_id' => $componente->id]);

        $response = $this->deleteJson("/api/v1/componentes/{$componente->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('componentes', ['id' => $componente->id]);
        $this->assertDatabaseMissing('estructura_por_componente', ['componente_id' => $componente->id]);
        $this->assertDatabaseMissing('acabado_tablero_por_componente', ['componente_id' => $componente->id]);
        $this->assertDatabaseMissing('acabado_cubre_canto_por_componente', ['componente_id' => $componente->id]);
        $this->assertDatabaseMissing('puertas_por_componente', ['componente_id' => $componente->id]);
        $this->assertDatabaseMissing('gola_por_componente', ['componente_id' => $componente->id]);
        $this->assertDatabaseMissing('correderas_por_componente', ['componente_id' => $componente->id]);
        $this->assertDatabaseMissing('compases_abatibles_por_componente', ['componente_id' => $componente->id]);
        $this->assertDatabaseMissing('accesorios_por_componente', ['componente_id' => $componente->id]);
    }

    public function test_componente_cost_calculation(): void
    {
        $componente = Componente::factory()->create([
            'precio_unitario' => 420.00,
        ]);

        $response = $this->getJson("/api/v1/componentes/{$componente->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment(['costo_total' => 420.0]);
    }

    // ─── Duplicate ───────────────────────────────────────────────────────────

    public function test_duplicate_crea_nuevo_componente(): void
    {
        $componente = Componente::factory()->create(['nombre' => 'Original']);

        $response = $this->postJson("/api/v1/componentes/{$componente->id}/duplicate");

        $response->assertStatus(201);
        $response->assertJsonPath('data.nombre', 'Copia de Original');
        $this->assertDatabaseCount('componentes', 2);
    }

    public function test_duplicate_copia_estructuras(): void
    {
        $componente = Componente::factory()->create();
        $estructura = Estructura::factory()->create();
        EstructuraPorComponente::factory()->create([
            'componente_id' => $componente->id,
            'estructura_id' => $estructura->id,
            'cantidad'      => 3,
        ]);

        $response = $this->postJson("/api/v1/componentes/{$componente->id}/duplicate");

        $response->assertStatus(201);
        $nuevoId = $response->json('data.id');
        $this->assertDatabaseHas('estructura_por_componente', [
            'componente_id' => $nuevoId,
            'estructura_id' => $estructura->id,
            'cantidad'      => 3,
        ]);
    }

    public function test_duplicate_copia_acabado_tablero(): void
    {
        $componente = Componente::factory()->create();
        $acabado    = AcabadoTablero::factory()->create();
        AcabadoTableroPorComponente::factory()->create([
            'componente_id'      => $componente->id,
            'acabado_tablero_id' => $acabado->id,
            'cantidad'           => 2,
        ]);

        $response = $this->postJson("/api/v1/componentes/{$componente->id}/duplicate");

        $response->assertStatus(201);
        $nuevoId = $response->json('data.id');
        $this->assertDatabaseHas('acabado_tablero_por_componente', [
            'componente_id'      => $nuevoId,
            'acabado_tablero_id' => $acabado->id,
            'cantidad'           => 2,
        ]);
    }

    public function test_duplicate_copia_acabado_cubre_canto(): void
    {
        $componente = Componente::factory()->create();
        $acabado    = AcabadoCubreCanto::factory()->create();
        AcabadoCubreCantoPorComponente::factory()->create([
            'componente_id'          => $componente->id,
            'acabado_cubre_canto_id' => $acabado->id,
            'cantidad'               => 4,
        ]);

        $response = $this->postJson("/api/v1/componentes/{$componente->id}/duplicate");

        $response->assertStatus(201);
        $nuevoId = $response->json('data.id');
        $this->assertDatabaseHas('acabado_cubre_canto_por_componente', [
            'componente_id'          => $nuevoId,
            'acabado_cubre_canto_id' => $acabado->id,
            'cantidad'               => 4,
        ]);
    }

    public function test_duplicate_copia_puertas(): void
    {
        $componente = Componente::factory()->create();
        $puerta     = Puerta::factory()->create();
        PuertasPorComponente::factory()->create([
            'componente_id' => $componente->id,
            'puerta_id'     => $puerta->id,
            'cantidad'      => 1,
        ]);

        $response = $this->postJson("/api/v1/componentes/{$componente->id}/duplicate");

        $response->assertStatus(201);
        $nuevoId = $response->json('data.id');
        $this->assertDatabaseHas('puertas_por_componente', [
            'componente_id' => $nuevoId,
            'puerta_id'     => $puerta->id,
            'cantidad'      => 1,
        ]);
    }

    public function test_duplicate_copia_gola(): void
    {
        $componente = Componente::factory()->create();
        $gola       = Gola::factory()->create();
        GolaPorComponente::factory()->create([
            'componente_id' => $componente->id,
            'gola_id'       => $gola->id,
            'cantidad'      => 5,
        ]);

        $response = $this->postJson("/api/v1/componentes/{$componente->id}/duplicate");

        $response->assertStatus(201);
        $nuevoId = $response->json('data.id');
        $this->assertDatabaseHas('gola_por_componente', [
            'componente_id' => $nuevoId,
            'gola_id'       => $gola->id,
            'cantidad'      => 5,
        ]);
    }

    public function test_duplicate_copia_accesorios(): void
    {
        $componente = Componente::factory()->create();
        AccesoriosPorComponente::factory()->create([
            'componente_id' => $componente->id,
            'accesorio'     => 'Bisagra',
        ]);

        $response = $this->postJson("/api/v1/componentes/{$componente->id}/duplicate");

        $response->assertStatus(201);
        $nuevoId = $response->json('data.id');
        $this->assertDatabaseHas('accesorios_por_componente', [
            'componente_id' => $nuevoId,
            'accesorio'     => 'Bisagra',
        ]);
    }

    public function test_duplicate_copia_correderas(): void
    {
        $componente = Componente::factory()->create();
        $corredera  = Corredera::factory()->create();
        CorrederaPorComponente::factory()->create([
            'componente_id' => $componente->id,
            'corredera_id'  => $corredera->id,
            'cantidad'      => 3,
        ]);

        $response = $this->postJson("/api/v1/componentes/{$componente->id}/duplicate");

        $response->assertStatus(201);
        $nuevoId = $response->json('data.id');
        $this->assertDatabaseHas('correderas_por_componente', [
            'componente_id' => $nuevoId,
            'corredera_id'  => $corredera->id,
            'cantidad'      => 3,
        ]);
    }

    public function test_duplicate_copia_compases_abatibles(): void
    {
        $componente     = Componente::factory()->create();
        $compasAbatible = CompasAbatible::factory()->create();
        CompasAbatiblePorComponente::factory()->create([
            'componente_id'     => $componente->id,
            'compas_abatible_id' => $compasAbatible->id,
            'cantidad'          => 2,
        ]);

        $response = $this->postJson("/api/v1/componentes/{$componente->id}/duplicate");

        $response->assertStatus(201);
        $nuevoId = $response->json('data.id');
        $this->assertDatabaseHas('compases_abatibles_por_componente', [
            'componente_id'     => $nuevoId,
            'compas_abatible_id' => $compasAbatible->id,
            'cantidad'          => 2,
        ]);
    }

    public function test_duplicate_no_modifica_original(): void
    {
        $componente = Componente::factory()->create(['nombre' => 'Original', 'precio_unitario' => 100.00]);
        EstructuraPorComponente::factory()->create(['componente_id' => $componente->id]);

        $this->postJson("/api/v1/componentes/{$componente->id}/duplicate");

        $this->assertDatabaseHas('componentes', [
            'id'     => $componente->id,
            'nombre' => 'Original',
        ]);
        $this->assertEquals(1, EstructuraPorComponente::where('componente_id', $componente->id)->count());
    }

    public function test_duplicate_retorna_404_si_no_existe(): void
    {
        $response = $this->postJson('/api/v1/componentes/9999/duplicate');

        $response->assertStatus(404);
    }
}
