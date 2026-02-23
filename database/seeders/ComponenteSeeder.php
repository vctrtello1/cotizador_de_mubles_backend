<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComponenteSeeder extends Seeder
{
    public function run(): void
    {
        $componentes = [
            ['nombre' => 'Silla Lucianica', 'descripcion' => 'Silla Lucianica de Roble', 'codigo' => 'COMP_SILLA_LUCIANICA'],
            ['nombre' => 'Mesa Lucianica', 'descripcion' => 'Mesa Lucianica de Roble', 'codigo' => 'COMP_MESA_LUCIANICA'],
            ['nombre' => 'Estante Moderno', 'descripcion' => 'Estante Moderno de MDF', 'codigo' => 'COMP_ESTANTE_MODERNO'],
            ['nombre' => 'Mesa de Centro Purru', 'descripcion' => 'Mesa de centro minimalista con estructura metálica y superficie de vidrio templado', 'codigo' => 'COMP_MESA_CENTRO_MINIMALISTA'],
        ];

        DB::table('componentes')->upsert($componentes, ['codigo'], ['nombre', 'descripcion']);
    }
}
