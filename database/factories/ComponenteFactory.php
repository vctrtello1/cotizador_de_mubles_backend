<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Componente>
 */
class ComponenteFactory extends Factory
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
            'costo' => $this->faker->randomFloat(2, 20, 200),
            'codigo' => $this->faker->unique()->bothify('???-#####'),
            'materiales' => $this->faker->word(),
            'herrajes' => $this->faker->word(),
            'mano_obra_id' => $this->faker->randomFloat(2, 5, 50),
            'acabado_id' => $this->faker->randomFloat(2, 5, 50),

        ];
    }

    public function withAcabado($acabadoId)
    {
        return $this->state(function (array $attributes) use ($acabadoId) {
            return [
                'acabado_id' => $acabadoId,
            ];
        });
    }

}
