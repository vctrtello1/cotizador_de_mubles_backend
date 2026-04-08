<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Apagadores>
 */
class ApagadoresFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->unique()->word() . ' APAGADOR',
            'precio' => $this->faker->randomFloat(2, 150, 400),
            'unidades_por_metro' => $this->faker->numberBetween(1, 5),
            'porcentaje_utilizacion' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
