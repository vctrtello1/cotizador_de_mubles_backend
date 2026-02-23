<?php

namespace Database\Factories;

use App\Models\Componente;
use App\Models\Material;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TablerosPorComponente>
 */
class TablerosPorComponenteFactory extends Factory
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
            'tablero_id' => Material::factory(),
            'cantidad' => $this->faker->numberBetween(1, 100),
        ];
    }
}
