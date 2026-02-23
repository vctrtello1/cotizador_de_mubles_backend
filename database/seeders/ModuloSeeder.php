<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuloSeeder extends Seeder
{
    public function run(): void
    {
        $modulos = [
            ['nombre' => 'Comedor Lucianico', 'descripcion' => 'Comedor de Roble con acabados de alta calidad', 'codigo' => 'COM_LUCIANICO'],
            ['nombre' => 'Centro de Entretenimiento Purru', 'descripcion' => 'Comedor de Roble con acabados de alta calidad', 'codigo' => 'CENT_ENT_PURRU'],
            ['nombre' => 'Comedor Moderno', 'descripcion' => 'Comedor con diseño moderno y elegante', 'codigo' => 'COM_MODERNO'],
            ['nombre' => 'Comedor Rústico', 'descripcion' => 'Comedor con estilo rústico y acogedor', 'codigo' => 'COM_RUSTICO'],
        ];

        DB::table('modulos')->upsert($modulos, ['codigo'], ['nombre', 'descripcion']);
    }
}
