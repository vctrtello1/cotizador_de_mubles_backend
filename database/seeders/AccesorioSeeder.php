<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccesorioSeeder extends Seeder
{
    public function run(): void
    {
        $accesorios = [
            ['nombre' => 'Tornillo 1/2"', 'precio' => 1.50],
            ['nombre' => 'Bisagra Cazoleta', 'precio' => 24.90],
            ['nombre' => 'Jaladera Aluminio', 'precio' => 39.00],
        ];

        foreach ($accesorios as $accesorio) {
            DB::table('accesorios')->updateOrInsert(['nombre' => $accesorio['nombre']], $accesorio);
        }
    }
}
