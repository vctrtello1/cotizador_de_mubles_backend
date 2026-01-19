<?php

namespace Database\Factories;

use App\Models\ComponentesPorCotizacion;
use App\Models\Cotizacion;
use App\Models\Componente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ComponentesPorCotizacion>
 */
class ComponentesPorCotizionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ComponentesPorCotizacion::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cotizacion_id' => Cotizacion::factory(),
            'componente_id' => Componente::factory(),
            'cantidad' => $this->faker->numberBetween(1, 20),
        ];
    }
}
