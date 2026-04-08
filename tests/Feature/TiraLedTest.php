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
            ],
        ]);
    }

    public function test_tira_led_store(): void
    {
        $data = [
            'nombre' => 'Tira LED RGB',
            'codigo' => 'TIRA_LED_001',
            'descripcion' => 'Tira LED RGB de 5 metros',
            'precio_unitario' => 25.50,
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
        ];

        $response = $this->putJson("/api/v1/tira-leds/{$tiraLed->id}", $updateData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('tira_leds', [
            'id' => $tiraLed->id,
            'nombre' => 'Tira LED RGBW',
            'precio_unitario' => 30.00,
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
            'codigo' => 'TIRA_LED_001',
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
}
