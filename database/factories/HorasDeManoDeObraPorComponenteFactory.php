<?php

namespace Database\Factories;

use App\Models\Componente;
use App\Models\ManoDeObra;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HorasDeManoDeObraPorComponente>
 */
class HorasDeManoDeObraPorComponenteFactory extends Factory
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
            'mano_de_obra_id' => ManoDeObra::factory(),
            'horas' => $this->faker->numberBetween(1, 10),
        ];
    }
}
