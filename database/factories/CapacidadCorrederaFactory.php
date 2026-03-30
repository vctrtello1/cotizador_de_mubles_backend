<?php

namespace Database\Factories;

use App\Models\Corredera;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CapacidadCorredera>
 */
class CapacidadCorrederaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $capacidades = [20, 30, 40, 50, 70, 80, 100];
        
        return [
            'capacidad' => $this->faker->randomElement($capacidades),
            'corredera_id' => Corredera::factory(),
        ];
    }
}
