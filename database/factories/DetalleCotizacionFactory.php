<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetalleCotizacion>
 */
class DetalleCotizacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cotizacion_id' => \App\Models\Cotizacion::factory(),
            'modulo_id' => \App\Models\Modulos::inRandomOrder()->first()->id ?? \App\Models\Modulos::factory(),
            'descripcion' => $this->faker->sentence(),
            'cantidad' => $this->faker->numberBetween(1, 10),
            'precio_unitario' => $this->faker->randomFloat(2, 10, 100),
            'subtotal' => $this->faker->randomFloat(2, 10, 1000),
        ];
    }
}
