<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FuentesDeAlimentacion>
 */
class FuentesDeAlimentacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->unique()->word() . ' FUENTE',
            'precio' => $this->faker->randomFloat(2, 500, 2000),
            'unidades_por_metro' => $this->faker->numberBetween(20, 100),
            'porcentaje_utilizacion' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
