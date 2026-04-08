<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PerfilAluminio>
 */
class PerfilAluminioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->unique()->word() . ' PERFIL',
            'precio' => $this->faker->randomFloat(2, 80, 300),
            'porcentaje_utilizacion' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
