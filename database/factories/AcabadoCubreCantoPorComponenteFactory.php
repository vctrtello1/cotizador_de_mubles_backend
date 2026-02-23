<?php

namespace Database\Factories;

use App\Models\AcabadoCubreCanto;
use App\Models\Componente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AcabadoCubreCantoPorComponente>
 */
class AcabadoCubreCantoPorComponenteFactory extends Factory
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
            'acabado_cubre_canto_id' => AcabadoCubreCanto::factory(),
            'cantidad' => $this->faker->numberBetween(1, 100),
        ];
    }
}
