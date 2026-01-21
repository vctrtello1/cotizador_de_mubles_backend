<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cotizacion>
 */
class CotizacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cliente_id' => \App\Models\Cliente::factory(),
            'fecha' => $this->faker->date(),
            'total' => $this->faker->randomFloat(2, 100, 10000),
            'estado' => $this->faker->randomElement(['activa', 'pendiente', 'aprobada', 'rechazada', 'cancelada']),
        ];
    }

    public function activa(): self
    {
        return $this->state(fn (array $attributes) => [
            'estado' => 'activa',
        ]);
    }

    public function cancelada(): self
    {
        return $this->state(fn (array $attributes) => [
            'estado' => 'cancelada',
        ]);
    }

    public function aprobada(): self
    {
        return $this->state(fn (array $attributes) => [
            'estado' => 'aprobada',
        ]);
    }
}
