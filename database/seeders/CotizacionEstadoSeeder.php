<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CotizacionEstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asignar estados variados a las cotizaciones existentes
        $cotizaciones = \App\Models\Cotizacion::all();

        if ($cotizaciones->count() > 0) {
            // Primera cotización: activa
            $cotizaciones->first()->update(['estado' => 'activa']);

            // Última cotización: completada
            $cotizaciones->last()->update(['estado' => 'completada']);

            // Cotizaciones intermedias: distribuir entre activa y cancelada
            $cotizacionesIntermediasCount = $cotizaciones->count() - 2;
            if ($cotizacionesIntermediasCount > 0) {
                $intermedias = $cotizaciones->slice(1, $cotizacionesIntermediasCount);
                $mitad = intval($cotizacionesIntermediasCount / 2);

                // Primera mitad: activa
                $intermedias->slice(0, $mitad)->each(function ($cotizacion) {
                    $cotizacion->update(['estado' => 'activa']);
                });

                // Segunda mitad: cancelada
                $intermedias->slice($mitad)->each(function ($cotizacion) {
                    $cotizacion->update(['estado' => 'cancelada']);
                });
            }
        }
    }
}
