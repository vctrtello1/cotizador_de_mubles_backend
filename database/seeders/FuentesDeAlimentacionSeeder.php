<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FuentesDeAlimentacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fuentes = [
            ['nombre' => 'F. ALIMENTACION 12V', 'precio' => 650.00, 'unidades_por_metro' => 40, 'porcentaje_utilizacion' => 3.50],
            ['nombre' => 'F. ALIMENTACION 24V', 'precio' => 900.00, 'unidades_por_metro' => 60, 'porcentaje_utilizacion' => 4.75],
        ];

        foreach ($fuentes as $fuente) {
            DB::table('fuentes_de_alimentacion')->updateOrInsert(['nombre' => $fuente['nombre']], $fuente);
        }
    }
}
