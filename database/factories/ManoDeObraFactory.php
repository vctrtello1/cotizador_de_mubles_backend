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
            'costo_hora' => $this->faker->randomFloat(2, 10, 100),
            'tiempo' => $this->faker->randomFloat(2, 1, 10),
            'costo_total' => $this->faker->randomFloat(2, 10, 1000),
        ];
    }
}
