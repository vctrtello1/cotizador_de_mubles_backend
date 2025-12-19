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
            'codigo' => $this->faker->unique()->bothify('???-#####'),
            'accesorios' => $this->faker->word(),
            'acabado_id' => \App\Models\Acabado::factory(),
            'mano_de_obra_id' => \App\Models\ManoDeObra::factory(),
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
