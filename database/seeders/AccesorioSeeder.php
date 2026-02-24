<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccesorioSeeder extends Seeder
{
    public function run(): void
    {
        $accesorios = [
            ['nombre' => 'Tornillo 1/2"', 'descripcion' => 'Tornillo galvanizado de media pulgada', 'precio' => 1.50],
            ['nombre' => 'Bisagra Cazoleta', 'descripcion' => 'Bisagra estándar para puerta de mueble', 'precio' => 24.90],
            ['nombre' => 'Jaladera Aluminio', 'descripcion' => 'Jaladera lineal de aluminio', 'precio' => 39.00],
        ];

        foreach ($accesorios as $accesorio) {
            DB::table('accesorios')->updateOrInsert(['nombre' => $accesorio['nombre']], $accesorio);
        }
    }
}
