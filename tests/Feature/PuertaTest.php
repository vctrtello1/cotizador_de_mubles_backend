<?php

namespace Tests\Feature;

use App\Models\Puerta;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PuertaTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test index endpoint returns all puertas.
     */
    public function test_puerta_index(): void
    {
        $response = $this->getJson('/api/v1/puertas');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'nombre',
                    'precio_perfil_aluminio',
                    'precio_escuadras',
                    'precio_silicon',
                    'precio_cristal_m2',
                    'precio_final',
                    'alto_maximo',
                    'ancho_maximo',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }

    /**
     * Test show endpoint returns a specific puerta.
     */
    public function test_puerta_show(): void
    {
        $puerta = \App\Models\Puerta::factory()->create();

        $response = $this->getJson("/api/v1/puertas/{$puerta->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'nombre',
                'precio_perfil_aluminio',
                'precio_escuadras',
                'precio_silicon',
                'precio_cristal_m2',
                'precio_final',
                'alto_maximo',
                'ancho_maximo',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    /**
     * Test store endpoint creates a new puerta.
     */
    public function test_puerta_store(): void
    {
        $puertaData = [
            'nombre' => 'Puerta Cristal Premium',
            'precio_perfil_aluminio' => 850.00,
            'precio_escuadras' => 60.00,
            'precio_silicon' => 90.00,
            'precio_cristal_m2' => 1600.00,
            'alto_maximo' => 2.40,
            'ancho_maximo' => 0.60,
        ];

        $response = $this->postJson('/api/v1/puertas', $puertaData);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'nombre' => $puertaData['nombre'],
            'precio_perfil_aluminio' => 850.0,
            'precio_escuadras' => 60.0,
            'precio_silicon' => 90.0,
            'precio_cristal_m2' => 1600.0,
            'precio_final' => 2600.0,
        ]);
        $this->assertDatabaseHas('puertas', $puertaData);
        $this->assertDatabaseHas('puertas', [
            'nombre' => $puertaData['nombre'],
            'precio_final' => 2600.00,
        ]);
    }

    /**
     * Test store endpoint validates required fields.
     */
    public function test_puerta_store_validation_required_fields(): void
    {
        $response = $this->postJson('/api/v1/puertas', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'nombre',
            'precio_perfil_aluminio',
            'precio_escuadras',
            'precio_silicon',
            'precio_cristal_m2',
        ]);
    }

    /**
     * Test store endpoint validates unique nombre.
     */
    public function test_puerta_store_validation_unique_nombre(): void
    {
        $puerta = \App\Models\Puerta::factory()->create();

        $response = $this->postJson('/api/v1/puertas', [
            'nombre' => $puerta->nombre,
            'precio_perfil_aluminio' => 793.00,
            'precio_escuadras' => 50.00,
            'precio_silicon' => 80.00,
            'precio_cristal_m2' => 1400.00,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre']);
    }

    /**
     * Test store endpoint validates numeric prices.
     */
    public function test_puerta_store_validation_numeric_prices(): void
    {
        $response = $this->postJson('/api/v1/puertas', [
            'nombre' => 'Puerta Test',
            'precio_perfil_aluminio' => 'not-a-number',
            'precio_escuadras' => 'not-a-number',
            'precio_silicon' => 'not-a-number',
            'precio_cristal_m2' => 'not-a-number',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'precio_perfil_aluminio',
            'precio_escuadras',
            'precio_silicon',
            'precio_cristal_m2',
        ]);
    }

    /**
     * Test store endpoint validates minimum prices.
     */
    public function test_puerta_store_validation_min_prices(): void
    {
        $response = $this->postJson('/api/v1/puertas', [
            'nombre' => 'Puerta Test',
            'precio_perfil_aluminio' => -100,
            'precio_escuadras' => -50,
            'precio_silicon' => -80,
            'precio_cristal_m2' => -1400,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'precio_perfil_aluminio',
            'precio_escuadras',
            'precio_silicon',
            'precio_cristal_m2',
        ]);
    }

    /**
     * Test update endpoint updates an existing puerta.
     */
    public function test_puerta_update(): void
    {
        $puerta = \App\Models\Puerta::factory()->create();

        $updatedData = [
            'nombre' => 'Puerta Cristal Updated',
            'precio_perfil_aluminio' => 900.00,
            'precio_escuadras' => 70.00,
            'precio_silicon' => 100.00,
            'precio_cristal_m2' => 1800.00,
            'alto_maximo' => 2.50,
            'ancho_maximo' => 0.70,
        ];

        $response = $this->putJson("/api/v1/puertas/{$puerta->id}", $updatedData);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'nombre' => $updatedData['nombre'],
            'precio_perfil_aluminio' => 900.0,
            'precio_escuadras' => 70.0,
            'precio_silicon' => 100.0,
            'precio_cristal_m2' => 1800.0,
            'precio_final' => 2870.0,
        ]);
        $this->assertDatabaseHas('puertas', array_merge(['id' => $puerta->id], $updatedData));
    }

    /**
     * Test update endpoint with partial data.
     */
    public function test_puerta_update_partial(): void
    {
        $puerta = \App\Models\Puerta::factory()->create([
            'precio_perfil_aluminio' => 793.00,
            'precio_escuadras' => 50.00,
            'precio_silicon' => 80.00,
            'precio_cristal_m2' => 1400.00,
        ]);

        $response = $this->putJson("/api/v1/puertas/{$puerta->id}", [
            'precio_cristal_m2' => 1500.00,
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'precio_cristal_m2' => 1500.0,
            'precio_final' => 2423.0,
        ]);
    }

    /**
     * Test delete endpoint removes a puerta.
     */
    public function test_puerta_destroy(): void
    {
        $puerta = \App\Models\Puerta::factory()->create();

        $response = $this->deleteJson("/api/v1/puertas/{$puerta->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('puertas', ['id' => $puerta->id]);
    }

    /**
     * Test show endpoint returns 404 for non-existent puerta.
     */
    public function test_puerta_show_not_found(): void
    {
        $response = $this->getJson('/api/v1/puertas/99999');

        $response->assertStatus(404);
    }

    /**
     * Test update endpoint returns 404 for non-existent puerta.
     */
    public function test_puerta_update_not_found(): void
    {
        $response = $this->putJson('/api/v1/puertas/99999', [
            'nombre' => 'Test',
            'precio_perfil_aluminio' => 793.00,
            'precio_escuadras' => 50.00,
            'precio_silicon' => 80.00,
            'precio_cristal_m2' => 1400.00,
        ]);

        $response->assertStatus(404);
    }

    /**
     * Test delete endpoint returns 404 for non-existent puerta.
     */
    public function test_puerta_destroy_not_found(): void
    {
        $response = $this->deleteJson('/api/v1/puertas/99999');

        $response->assertStatus(404);
    }

    /**
     * Test store creates puerta with standard configuration.
     */
    public function test_puerta_store_standard_config(): void
    {
        $puertaData = [
            'nombre' => 'Puerta Cristal Standard',
            'precio_perfil_aluminio' => 793.00,
            'precio_escuadras' => 50.00,
            'precio_silicon' => 80.00,
            'precio_cristal_m2' => 1400.00,
            'alto_maximo' => 2.40,
            'ancho_maximo' => 0.60,
        ];

        $response = $this->postJson('/api/v1/puertas', $puertaData);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'nombre' => 'Puerta Cristal Standard',
            'precio_perfil_aluminio' => 793.0,
            'precio_final' => 2323.0,
            'alto_maximo' => 2.4,
            'ancho_maximo' => 0.6,
        ]);
    }

    /**
     * Test validates maximum dimensions.
     */
    public function test_puerta_validates_max_dimensions(): void
    {
        $response = $this->postJson('/api/v1/puertas', [
            'nombre' => 'Puerta Test',
            'precio_perfil_aluminio' => 793.00,
            'precio_escuadras' => 50.00,
            'precio_silicon' => 80.00,
            'precio_cristal_m2' => 1400.00,
            'alto_maximo' => 15.00,  // Excede límite
            'ancho_maximo' => 10.00, // Excede límite
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['alto_maximo', 'ancho_maximo']);
    }
}
