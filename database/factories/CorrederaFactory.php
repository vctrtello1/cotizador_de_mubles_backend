<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Corredera>
 */
class CorrederaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sizes = [350, 400, 450, 500, 550];
        $size = $this->faker->randomElement($sizes);
        $precioBase = $this->faker->randomFloat(2, 300, 450);
        $precioConAcoplamiento = $precioBase + 50.20;

        return [
            'nombre' => "CORREDERA TANDEM PARCIAL BLUMOTION 30kgs {$size}mm 550H{$size}0B",
            'precio_base' => $precioBase,
            'precio_con_acoplamiento' => $precioConAcoplamiento,
        ];
    }
}
