<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccesorioPorComponenteSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['componente_id' => 1, 'accesorio' => 'MENSULA REPISA', 'cantidad' => 1],
            ['componente_id' => 2, 'accesorio' => 'ZOCLO', 'cantidad' => 1],
            ['componente_id' => 3, 'accesorio' => 'CLIPS ZOCLO', 'cantidad' => 2],
        ];

        foreach ($items as $item) {
            DB::table('accesorios_por_componente')->updateOrInsert(
                ['componente_id' => $item['componente_id'], 'accesorio' => $item['accesorio']],
                ['cantidad' => $item['cantidad']]
            );
        }
    }
}
