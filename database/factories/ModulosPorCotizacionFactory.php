<?php

namespace Database\Factories;

use App\Models\ModulosPorCotizacion;
use App\Models\Cotizacion;
use App\Models\Modulos;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ModulosPorCotizacion>
 */
class ModulosPorCotizacionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ModulosPorCotizacion::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cotizacion_id' => Cotizacion::factory(),
            'modulo_id' => Modulos::factory(),
            'cantidad' => $this->faker->numberBetween(1, 20),
        ];
    }
}
