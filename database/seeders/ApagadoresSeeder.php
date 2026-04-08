<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApagadoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apagadores = [
            ['nombre' => 'APAGADOR TOUCH', 'precio' => 250.00, 'unidades_por_metro' => 2, 'porcentaje_utilizacion' => 8.50],
            ['nombre' => 'APAGADOR DIMMER', 'precio' => 280.00, 'unidades_por_metro' => 1, 'porcentaje_utilizacion' => 9.25],
        ];

        foreach ($apagadores as $apagador) {
            DB::table('apagadores')->updateOrInsert(['nombre' => $apagador['nombre']], $apagador);
        }
    }
}
