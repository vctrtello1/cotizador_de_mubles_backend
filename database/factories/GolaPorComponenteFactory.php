<?php

namespace Database\Factories;

use App\Models\Componente;
use App\Models\Gola;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GolaPorComponente>
 */
class GolaPorComponenteFactory extends Factory
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
            'gola_id' => Gola::factory(),
            'cantidad' => $this->faker->numberBetween(1, 100),
        ];
    }
}
