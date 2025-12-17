<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pintura>
 */
class PinturaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'nombre' => $this->faker->word(),
            'tipo' => $this->faker->randomElement(['óleo', 'acrílico', 'acuarela', 'tempera']),
            'descripción' => $this->faker->paragraph(),
            'costo_por_metro_cuadrado' => $this->faker->randomFloat(2, 10, 100),
            'codigo' => $this->faker->word(),
        ];
    }
}
