<?php

namespace Database\Factories;

use App\Models\AcabadoTablero;
use App\Models\Componente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AcabadoTableroPorComponente>
 */
class AcabadoTableroPorComponenteFactory extends Factory
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
            'acabado_tablero_id' => AcabadoTablero::factory(),
            'cantidad' => $this->faker->numberBetween(1, 100),
        ];
    }
}
