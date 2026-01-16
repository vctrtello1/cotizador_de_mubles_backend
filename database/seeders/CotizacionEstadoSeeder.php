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
        // Los estados ya están incluidos en la migración original
        // Esta seeder solo actualiza estados si es necesario
        
        $cotizaciones = \App\Models\Cotizacion::all();

        if ($cotizaciones->count() > 0) {
            // Garantizar que todas las cotizaciones tengan un estado válido
            foreach ($cotizaciones as $cotizacion) {
                if (empty($cotizacion->estado) || !in_array($cotizacion->estado, ['activa', 'cancelada', 'completada'])) {
                    $cotizacion->update(['estado' => 'activa']);
                }
            }
        }
    }
}
