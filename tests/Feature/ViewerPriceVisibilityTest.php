<?php

namespace Tests\Feature;

use App\Models\AcabadoCubreCanto;
use App\Models\AcabadoTablero;
use App\Models\Accesorio;
use App\Models\AccesoriosPorComponente;
use App\Models\Componente;
use App\Models\Estructura;
use App\Models\Puerta;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ViewerPriceVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_viewer_cannot_see_detailed_prices_but_can_see_componente_precio_unitario(): void
    {
        Sanctum::actingAs(User::factory()->create(['rol' => 'vendedor']));

        $estructura = Estructura::factory()->create(['costo_unitario' => 123.45]);
        $acabadoCubreCanto = AcabadoCubreCanto::factory()->create(['costo_unitario' => 67.89]);
        $acabadoTablero = AcabadoTablero::factory()->create(['costo_unitario' => 89.01]);
        $puerta = Puerta::factory()->create();
        $accesorio = Accesorio::factory()->create(['nombre' => 'Bisagra Viewer', 'precio' => 45.50]);
        $componente = Componente::factory()->create(['precio_unitario' => 250.75]);
        AccesoriosPorComponente::factory()->create([
            'componente_id' => $componente->id,
            'accesorio' => $accesorio->nombre,
            'cantidad' => 2,
        ]);

        $estructuraResponse = $this->getJson("/api/v1/estructuras/{$estructura->id}");
        $estructuraResponse->assertOk();
        $this->assertArrayNotHasKey('costo_unitario', $estructuraResponse->json('data'));

        $cubreCantoResponse = $this->getJson("/api/v1/acabado-cubre-cantos/{$acabadoCubreCanto->id}");
        $cubreCantoResponse->assertOk();
        $this->assertArrayNotHasKey('costo_unitario', $cubreCantoResponse->json('data'));

        $tableroResponse = $this->getJson("/api/v1/acabado-tableros/{$acabadoTablero->id}");
        $tableroResponse->assertOk();
        $this->assertArrayNotHasKey('costo_unitario', $tableroResponse->json('data'));

        $puertaResponse = $this->getJson("/api/v1/puertas/{$puerta->id}");
        $puertaResponse->assertOk();
        $puertaData = $puertaResponse->json('data');
        $this->assertArrayNotHasKey('precio_perfil_aluminio', $puertaData);
        $this->assertArrayNotHasKey('precio_escuadras', $puertaData);
        $this->assertArrayNotHasKey('precio_silicon', $puertaData);
        $this->assertArrayNotHasKey('precio_cristal_m2', $puertaData);
        $this->assertArrayNotHasKey('precio_final', $puertaData);

        $accesorioResponse = $this->getJson("/api/v1/accesorios/{$accesorio->id}");
        $accesorioResponse->assertOk();
        $this->assertArrayNotHasKey('precio', $accesorioResponse->json('data'));

        $componenteResponse = $this->getJson("/api/v1/componentes/{$componente->id}");
        $componenteResponse->assertOk();
        $componenteData = $componenteResponse->json('data');
        $this->assertArrayHasKey('precio_unitario', $componenteData);
        $this->assertArrayNotHasKey('costo_total', $componenteData);
        $this->assertArrayNotHasKey('costo', $componenteData['accesorios'][0]);
    }

    public function test_desarrollador_can_still_see_detailed_prices(): void
    {
        Sanctum::actingAs(User::factory()->create(['rol' => 'desarrollador']));

        $estructura = Estructura::factory()->create(['costo_unitario' => 123.45]);
        $puerta = Puerta::factory()->create();
        $accesorio = Accesorio::factory()->create(['nombre' => 'Bisagra Dev', 'precio' => 45.50]);
        $componente = Componente::factory()->create(['precio_unitario' => 250.75]);
        AccesoriosPorComponente::factory()->create([
            'componente_id' => $componente->id,
            'accesorio' => $accesorio->nombre,
            'cantidad' => 2,
        ]);

        $estructuraResponse = $this->getJson("/api/v1/estructuras/{$estructura->id}");
        $estructuraResponse->assertOk();
        $this->assertArrayHasKey('costo_unitario', $estructuraResponse->json('data'));

        $puertaResponse = $this->getJson("/api/v1/puertas/{$puerta->id}");
        $puertaResponse->assertOk();
        $this->assertArrayHasKey('precio_final', $puertaResponse->json('data'));

        $accesorioResponse = $this->getJson("/api/v1/accesorios/{$accesorio->id}");
        $accesorioResponse->assertOk();
        $this->assertArrayHasKey('precio', $accesorioResponse->json('data'));

        $componenteResponse = $this->getJson("/api/v1/componentes/{$componente->id}");
        $componenteResponse->assertOk();
        $componenteData = $componenteResponse->json('data');
        $this->assertArrayHasKey('precio_unitario', $componenteData);
        $this->assertArrayHasKey('costo_total', $componenteData);
        $this->assertArrayHasKey('costo', $componenteData['accesorios'][0]);
    }
}
