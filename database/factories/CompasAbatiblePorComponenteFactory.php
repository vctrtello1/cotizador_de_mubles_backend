<?php

namespace Database\Factories;

use App\Models\CompasAbatible;
use App\Models\Componente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CompasAbatiblePorComponente>
 */
class CompasAbatiblePorComponenteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'componente_id' => Componente::factory(),
            'compas_abatible_id' => CompasAbatible::factory(),
            'cantidad' => $this->faker->numberBetween(1, 10),
        ];
    }
}
