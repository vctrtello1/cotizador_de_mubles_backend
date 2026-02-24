<?php

namespace Database\Factories;

use App\Models\Componente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AccesoriosPorComponente>
 */
class AccesoriosPorComponenteFactory extends Factory
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
            'accesorio' => $this->faker->word(),
            'cantidad' => $this->faker->numberBetween(1, 10),
        ];
    }
}
