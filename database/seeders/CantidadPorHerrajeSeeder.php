<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CantidadPorHerrajeSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['herraje_id' => 1, 'cantidad' => 4, 'componente_id' => 1],
            ['herraje_id' => 2, 'cantidad' => 8, 'componente_id' => 1],
            ['herraje_id' => 3, 'cantidad' => 6, 'componente_id' => 2],
            ['herraje_id' => 4, 'cantidad' => 12, 'componente_id' => 2],
        ];

        foreach ($items as $item) {
            DB::table('cantidad_por_herraje')->updateOrInsert(
                [
                    'componente_id' => $item['componente_id'],
                    'herraje_id' => $item['herraje_id'],
                ],
                ['cantidad' => $item['cantidad']]
            );
        }
    }
}
