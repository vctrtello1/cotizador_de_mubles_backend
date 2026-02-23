<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GolaSeeder extends Seeder
{
    public function run(): void
    {
        $golas = [
            ['nombre' => 'SUPERIOR', 'descripcion' => 'Gola superior', 'precio' => 701.00],
            ['nombre' => 'INFERIOR', 'descripcion' => 'Gola inferior', 'precio' => 795.00],
            ['nombre' => 'ESCUADRA', 'descripcion' => 'Escuadra para gola', 'precio' => 30.00],
        ];

        foreach ($golas as $gola) {
            DB::table('table_gola')->updateOrInsert(['nombre' => $gola['nombre']], $gola);
        }
    }
}
