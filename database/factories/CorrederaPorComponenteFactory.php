<?php

namespace Database\Factories;

use App\Models\Componente;
use App\Models\Corredera;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CorrederaPorComponente>
 */
class CorrederaPorComponenteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'componente_id' => Componente::factory(),
            'corredera_id' => Corredera::factory(),
            'cantidad' => $this->faker->numberBetween(1, 10),
        ];
    }
}
