<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ManoDeObra>
 */
class ManoDeObraFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'nombre' => $this->faker->word(),
            'descripcion' => $this->faker->sentence(),
            'horas_trabajadas' => $this->faker->numberBetween(1, 100),
            'costo_por_hora' => $this->faker->randomFloat(2, 10, 100),
            'codigo' => $this->faker->unique()->bothify('???-#####'),
        ];
    }
}
