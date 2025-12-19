<?php

namespace Database\Factories;

use App\Models\Componente;
use App\Models\Herraje;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CantidadPorHerraje>
 */
class CantidadPorHerrajeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'componente_id' => Componente::factory(),
            'herraje_id' => Herraje::factory(),
            'cantidad' => $this->faker->numberBetween(1, 100),
        ];
    }
}
