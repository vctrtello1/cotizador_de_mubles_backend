<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Material>
 */
class MaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word(),
            'descripcion' => $this->faker->sentence(),
            'precio_unitario' => $this->faker->randomFloat(2, 1, 1000),
            'codigo' => $this->faker->unique()->bothify('???-#####'),
            'unidad_medida' => $this->faker->randomElement(['kg', 'm', 'cm', 'mm']),
            'alto' => $this->faker->randomFloat(2, 0.1, 10),
            'ancho' => $this->faker->randomFloat(2, 0.1, 10),
            'largo' => $this->faker->randomFloat(2, 0.1, 10),
        ];
    }
}
