<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TiraLed>
 */
class TiraLedFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tipos = ['RGB', 'RGBW', 'Blanca', 'Cálida'];
        $largo = fake()->randomElement(['5m', '10m', '15m']);
        
        return [
            'nombre' => 'Tira LED ' . fake()->randomElement($tipos) . ' ' . $largo,
            'codigo' => 'TIRA_LED_' . fake()->unique()->numerify('###'),
            'descripcion' => fake()->sentence(),
            'precio_unitario' => fake()->randomFloat(2, 10, 100),
        ];
    }
}
