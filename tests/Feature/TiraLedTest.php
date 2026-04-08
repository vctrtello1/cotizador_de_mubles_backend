<?php

namespace Tests\Feature;

use App\Models\TiraLed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TiraLedTest extends TestCase
{
    use RefreshDatabase;

    public function test_tira_led_index(): void
    {
        $response = $this->getJson('/api/v1/tira-leds');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'nombre',
                    'codigo',
                    'descripcion',
                    'precio_unitario',
                    'unidades_por_metro',
                    'porcentaje_utilizacion',
                    'cantidad_compra',
                ],
            ],
        ]);
    }

    public function test_tira_led_show(): void
    {
        $tiraLed = TiraLed::factory()->create();

        $response = $this->getJson("/api/v1/tira-leds/{$tiraLed->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'nombre',
                'codigo',
                'descripcion',
                'precio_unitario',
                'unidades_por_metro',
                'porcentaje_utilizacion',
                'cantidad_compra',
            ],
        ]);
    }

    public function test_tira_led_store(): void
    {
        $data = [
            'nombre' => 'Tira LED RGB',
            'codigo' => 'TIRA_LED_TEST_001',
            'descripcion' => 'Tira LED RGB de 5 metros',
            'precio_unitario' => 25.50,
            'unidades_por_metro' => 5,
            'porcentaje_utilizacion' => 3.052,
            'cantidad_compra' => 4,
        ];

        $response = $this->postJson('/api/v1/tira-leds', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('tira_leds', $data);
    }

    public function test_tira_led_update(): void
    {
        $tiraLed = TiraLed::factory()->create();

        $updateData = [
            'nombre' => 'Tira LED RGBW',
            'precio_unitario' => 30.00,
            'unidades_por_metro' => 6,
            'cantidad_compra' => 5,
        ];

        $response = $this->putJson("/api/v1/tira-leds/{$tiraLed->id}", $updateData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('tira_leds', [
            'id' => $tiraLed->id,
            'nombre' => 'Tira LED RGBW',
            'precio_unitario' => 30.00,
            'unidades_por_metro' => 6,
            'cantidad_compra' => 5,
        ]);
    }

    public function test_tira_led_destroy(): void
    {
        $tiraLed = TiraLed::factory()->create();

        $response = $this->deleteJson("/api/v1/tira-leds/{$tiraLed->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('tira_leds', ['id' => $tiraLed->id]);
    }

    public function test_tira_led_validation_on_store(): void
    {
        $data = [
            // 'nombre' is missing
            'codigo' => 'TIRA_LED_VALID_001',
            'descripcion' => 'Tira LED RGB',
            'precio_unitario' => 25.50,
        ];

        $response = $this->postJson('/api/v1/tira-leds', $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre']);
    }

    public function test_tira_led_validation_on_update(): void
    {
        $tiraLed = TiraLed::factory()->create();

        $updateData = [
            'nombre' => '', // Empty nombre
            'precio_unitario' => -10, // Negative price
        ];

        $response = $this->putJson("/api/v1/tira-leds/{$tiraLed->id}", $updateData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre', 'precio_unitario']);
    }

    public function test_tira_led_minimum_price(): void
    {
        $data = [
            'nombre' => 'Tira LED',
            'codigo' => 'TIRA_LED_MIN',
            'descripcion' => 'Con precio mínimo',
            'precio_unitario' => 0.01,
        ];

        $response = $this->postJson('/api/v1/tira-leds', $data);

        $response->assertStatus(201);
    }

    public function test_tira_led_index_with_data(): void
    {
        TiraLed::factory()->count(5)->create();

        $response = $this->getJson('/api/v1/tira-leds');

        $response->assertStatus(200);
        $response->assertJsonCount(5, 'data');
    }

    public function test_tira_led_store_with_all_fields(): void
    {
        $data = [
            'nombre' => 'Tira LED Completa',
            'codigo' => 'TIRA_LED_COMPLETE',
            'descripcion' => 'Tira LED con todos los campos',
            'precio_unitario' => 600.00,
            'unidades_por_metro' => 5,
            'porcentaje_utilizacion' => 3.052,
            'cantidad_compra' => 4,
        ];

        $response = $this->postJson('/api/v1/tira-leds', $data);

        $response->assertStatus(201);
        $response->assertJsonPath('data.nombre', 'Tira LED Completa');
        $response->assertJsonPath('data.precio_unitario', '600.00');
        $response->assertJsonPath('data.unidades_por_metro', 5);
        $response->assertJsonPath('data.porcentaje_utilizacion', '3.052');
        $response->assertJsonPath('data.cantidad_compra', 4);
    }

    public function test_tira_led_validation_unidades_por_metro(): void
    {
        $data = [
            'nombre' => 'Tira LED Test',
            'codigo' => 'TIRA_LED_UPM',
            'precio_unitario' => 25.50,
            'unidades_por_metro' => -1,
        ];

        $response = $this->postJson('/api/v1/tira-leds', $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['unidades_por_metro']);
    }

    public function test_tira_led_validation_cantidad_compra(): void
    {
        $data = [
            'nombre' => 'Tira LED Test',
            'codigo' => 'TIRA_LED_CC',
            'precio_unitario' => 25.50,
            'cantidad_compra' => 0,
        ];

        $response = $this->postJson('/api/v1/tira-leds', $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['cantidad_compra']);
    }

    public function test_tira_led_codigo_unique(): void
    {
        $tiraLed = TiraLed::factory()->create(['codigo' => 'TIRA_LED_UNIQUE']);

        $data = [
            'nombre' => 'Another Tira LED',
            'codigo' => 'TIRA_LED_UNIQUE',
            'precio_unitario' => 25.50,
        ];

        $response = $this->postJson('/api/v1/tira-leds', $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['codigo']);
    }
}
