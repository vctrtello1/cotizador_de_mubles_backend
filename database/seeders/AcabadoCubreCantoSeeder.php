<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcabadoCubreCantoSeeder extends Seeder
{
    public function run(): void
    {
        $acabados = [
            ['nombre' => 'ARAUCO 15 MM'],
            ['nombre' => 'FINSA 15 MM'],
            ['nombre' => 'KAINDL (MADERA) 18MM'],
            ['nombre' => 'EGGER (MADERA) 18MM'],
            ['nombre' => 'EGGER (ALTO BRILLO) 18 MM'],
            ['nombre' => 'EGGER (ULTRA MATE) 18 MM'],
            ['nombre' => 'REHAU (ULTRA MATE) 19.5mm'],
            ['nombre' => 'REHAU (ALTO BRILLO) 19mm'],
        ];

        foreach ($acabados as $acabado) {
            DB::table('acabado_cubre_cantos')->updateOrInsert(['nombre' => $acabado['nombre']], $acabado);
        }
    }
}
