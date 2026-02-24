<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccesorioPorComponenteSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['componente_id' => 1, 'accesorio' => 'MENSULA REPISA'],
            ['componente_id' => 2, 'accesorio' => 'ZOCLO'],
            ['componente_id' => 3, 'accesorio' => 'CLIPS ZOCLO'],
        ];

        foreach ($items as $item) {
            DB::table('accesorios_por_componente')->updateOrInsert(
                ['componente_id' => $item['componente_id'], 'accesorio' => $item['accesorio']],
                []
            );
        }
    }
}
