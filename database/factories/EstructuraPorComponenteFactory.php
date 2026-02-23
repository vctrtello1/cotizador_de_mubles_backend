<?php

namespace Database\Factories;

use App\Models\Componente;
use App\Models\Estructura;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EstructuraPorComponente>
 */
class EstructuraPorComponenteFactory extends Factory
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
            'estructura_id' => Estructura::factory(),
            'cantidad' => $this->faker->numberBetween(1, 100),
        ];
    }
}
