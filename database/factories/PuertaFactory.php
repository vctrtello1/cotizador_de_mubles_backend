<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Puerta>
 */
class PuertaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => 'Puerta Cristal ' . fake()->unique()->word() . ' ' . fake()->unique()->numberBetween(100, 999),
            'precio_perfil_aluminio' => fake()->randomFloat(2, 500, 1000),
            'precio_escuadras' => fake()->randomFloat(2, 30, 80),
            'precio_silicon' => fake()->randomFloat(2, 50, 120),
            'precio_cristal_m2' => fake()->randomFloat(2, 1000, 2000),
            'alto_maximo' => 2.40,
            'ancho_maximo' => 0.60,
        ];
    }
}
