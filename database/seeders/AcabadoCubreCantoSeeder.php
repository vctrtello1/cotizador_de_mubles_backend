<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcabadoCubreCantoSeeder extends Seeder
{
    public function run(): void
    {
        $acabados = [
            ['nombre' => 'ARAUCO 15 MM', 'costo_unitario' => 15.00],
            ['nombre' => 'FINSA 15 MM', 'costo_unitario' => 15.00],
            ['nombre' => 'KAINDL (MADERA) 18MM', 'costo_unitario' => 20.00],
            ['nombre' => 'EGGER (MADERA) 18MM', 'costo_unitario' => 40.00],
            ['nombre' => 'EGGER (ALTO BRILLO) 18 MM', 'costo_unitario' => 40.00],
            ['nombre' => 'EGGER (ULTRA MATE) 18 MM', 'costo_unitario' => 40.00],
            ['nombre' => 'REHAU (ULTRA MATE) 19.5mm', 'costo_unitario' => 40.00],
            ['nombre' => 'REHAU (ALTO BRILLO) 19mm', 'costo_unitario' => 40.00],
        ];

        DB::table('acabado_cubre_cantos')->upsert($acabados, ['nombre'], ['costo_unitario']);
    }
}
