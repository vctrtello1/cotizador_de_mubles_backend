<?php

namespace Database\Factories;

use App\Models\Componente;
use App\Models\Puerta;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PuertasPorComponente>
 */
class PuertasPorComponenteFactory extends Factory
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
            'puerta_id' => Puerta::factory(),
            'cantidad' => $this->faker->numberBetween(1, 100),
        ];
    }
}
