<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerfilAluminioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $perfiles = [
            ['nombre' => 'PERFIL ALUMINIO SUPERFICIE', 'precio' => 120.00, 'porcentaje_utilizacion' => 4.50],
            ['nombre' => 'PERFIL ALUMINIO ESQUINERO', 'precio' => 180.00, 'porcentaje_utilizacion' => 6.00],
        ];

        foreach ($perfiles as $perfil) {
            DB::table('perfil_aluminios')->updateOrInsert(['nombre' => $perfil['nombre']], $perfil);
        }
    }
}
