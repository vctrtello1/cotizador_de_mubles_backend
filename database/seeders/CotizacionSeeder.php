<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cliente;
use App\Models\Cotizacion;
use App\Models\DetalleCotizacion;

class CotizacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 5 clients
        Cliente::factory(5)->create()->each(function ($cliente) {
            // For each client, create 3 cotizaciones
            Cotizacion::factory(3)->create([
                'cliente_id' => $cliente->id,
            ])->each(function ($cotizacion) {
                // For each cotizacion, create 2-5 detalles
                DetalleCotizacion::factory(rand(2, 5))->create([
                    'cotizacion_id' => $cotizacion->id,
                ]);
            });
        });
    }
}
