<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcabadoTableroSeeder extends Seeder
{
    public function run(): void
    {
        $acabados = [
            ['nombre' => 'ARAUCO 15 MM', 'costo_unitario' => 1200.00],
            ['nombre' => 'FINSA 15 MM', 'costo_unitario' => 1300.00],
            ['nombre' => 'KAINDL (MADERA) 2700mm x 2800mm x 18mm', 'costo_unitario' => 4100.00],
            ['nombre' => 'EGGER (MADERA) 2700mm x 2800mm x 18mm', 'costo_unitario' => 6000.00],
            ['nombre' => 'EGGER (ALTO BRILLO) 2700mm x 2800mm x 18mm', 'costo_unitario' => 9800.00],
            ['nombre' => 'EGGER (ULTRA MATE) 2700mm x 2800mm x 18mm', 'costo_unitario' => 9800.00],
            ['nombre' => 'REHAU (ULTRA MATE) NOIR 2800mm x 1300mm x 19mm', 'costo_unitario' => 9900.00],
            ['nombre' => 'REHAU (ALTO BRILLO) CRYSTAL 2800mm x 1300mm x 19mm', 'costo_unitario' => 10265.00],
            ['nombre' => 'REHAU (ULTRA MATE) NOBLE 2800mm x 1300mm x 19mm', 'costo_unitario' => 6800.00],
            ['nombre' => 'REHAU (ULTRA MATE) ECO FINO 3070mmx1244mmx19.4mm', 'costo_unitario' => 5500.00],
            ['nombre' => 'REHAU (ULTRA MATE) BRILLIANT 2800mm x 1300mm x 19mm', 'costo_unitario' => 5500.00],
            ['nombre' => 'REHAU (ALTO BRILLO) BRILLIANT 2800mm x 1300mm x 19mm', 'costo_unitario' => 5500.00],
            ['nombre' => 'REHAU (ULTRA MATE) RAUVISO FINO BLANCO 2800mm x 1220mm x 18mm', 'costo_unitario' => 5500.00],
            ['nombre' => 'REHAU (ULTRA MATE) RAUVISO FINO NEGRO 2800mm x 1220mm x 18mm', 'costo_unitario' => 5500.00],
            ['nombre' => 'REHAU (ALTO BRILLO) RAUVISO FINO COLOR 2800mm x 1220mm x 18mm', 'costo_unitario' => 5500.00],
            ['nombre' => 'REHAU (ALTO BRILLO) RAUVISO METALLIC 2800mm x 1220mm x 18mm', 'costo_unitario' => 0.00],
        ];

        DB::table('acabado_tableros')->upsert($acabados, ['nombre'], ['costo_unitario']);
    }
}
