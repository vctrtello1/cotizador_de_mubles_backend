<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Herraje>
 */
class HerrajeFactory extends Factory
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
            'medida' => $this->faker->randomFloat(2, 1, 100),
            'unidad_medida' => $this->faker->randomElement(['cm', 'mm', 'in']),
            'costo_unitario' => $this->faker->randomFloat(2, 1, 1000),
            'codigo' => $this->faker->unique()->bothify('???-#####'),
        ];
    }
}
