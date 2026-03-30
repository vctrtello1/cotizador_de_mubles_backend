<?php

namespace Database\Factories;

use App\Models\CotizacionesPorUsuario;
use App\Models\Cotizacion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CotizacionesPorUsuario>
 */
class CotizacionesPorUsuarioFactory extends Factory
{
    protected $model = CotizacionesPorUsuario::class;

    public function definition(): array
    {
        return [
            'user_id'       => User::factory(),
            'cotizacion_id' => Cotizacion::factory(),
        ];
    }
}
