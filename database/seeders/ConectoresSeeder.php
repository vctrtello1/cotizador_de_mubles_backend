<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConectoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conectores = [
            ['nombre' => 'CONECTORES MINIFIX', 'precio' => 45.00, 'unidades_por_metro' => 2, 'porcentaje_utilizacion' => 5.50],
            ['nombre' => 'CONECTORES EXCÉNTRICOS', 'precio' => 75.00, 'unidades_por_metro' => 3, 'porcentaje_utilizacion' => 8.75],
        ];

        foreach ($conectores as $conector) {
            DB::table('conectores')->updateOrInsert(['nombre' => $conector['nombre']], $conector);
        }
    }
}
