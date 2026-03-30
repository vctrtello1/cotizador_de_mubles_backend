<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcabadoTableroSeeder extends Seeder
{
    public function run(): void
    {
        $acabados = [
            ['nombre' => 'ARAUCO 15 MM'],
            ['nombre' => 'FINSA 15 MM'],
            ['nombre' => 'KAINDL (MADERA) 2700mm x 2800mm x 18mm'],
            ['nombre' => 'EGGER (MADERA) 2700mm x 2800mm x 18mm'],
            ['nombre' => 'EGGER (ALTO BRILLO) 2700mm x 2800mm x 18mm'],
            ['nombre' => 'EGGER (ULTRA MATE) 2700mm x 2800mm x 18mm'],
            ['nombre' => 'REHAU (ULTRA MATE) NOIR 2800mm x 1300mm x 19mm'],
            ['nombre' => 'REHAU (ALTO BRILLO) CRYSTAL 2800mm x 1300mm x 19mm'],
            ['nombre' => 'REHAU (ULTRA MATE) NOBLE 2800mm x 1300mm x 19mm'],
            ['nombre' => 'REHAU (ULTRA MATE) ECO FINO 3070mmx1244mmx19.4mm'],
            ['nombre' => 'REHAU (ULTRA MATE) BRILLIANT 2800mm x 1300mm x 19mm'],
            ['nombre' => 'REHAU (ALTO BRILLO) BRILLIANT 2800mm x 1300mm x 19mm'],
            ['nombre' => 'REHAU (ULTRA MATE) RAUVISO FINO BLANCO 2800mm x 1220mm x 18mm'],
            ['nombre' => 'REHAU (ULTRA MATE) RAUVISO FINO NEGRO 2800mm x 1220mm x 18mm'],
            ['nombre' => 'REHAU (ALTO BRILLO) RAUVISO FINO COLOR 2800mm x 1220mm x 18mm'],
            ['nombre' => 'REHAU (ALTO BRILLO) RAUVISO METALLIC 2800mm x 1220mm x 18mm'],
        ];

        foreach ($acabados as $acabado) {
            DB::table('acabado_tableros')->updateOrInsert(['nombre' => $acabado['nombre']], $acabado);
        }
    }
}
