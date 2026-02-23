<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialesPorComponenteSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['componente_id' => 1, 'material_id' => 1, 'cantidad' => 2],
            ['componente_id' => 1, 'material_id' => 2, 'cantidad' => 3],
            ['componente_id' => 2, 'material_id' => 3, 'cantidad' => 8],
            ['componente_id' => 2, 'material_id' => 4, 'cantidad' => 1],
            ['componente_id' => 3, 'material_id' => 5, 'cantidad' => 5],
            ['componente_id' => 3, 'material_id' => 6, 'cantidad' => 2],
        ];

        foreach ($items as $item) {
            DB::table('materiales_por_componente')->updateOrInsert(
                [
                    'componente_id' => $item['componente_id'],
                    'material_id' => $item['material_id'],
                ],
                ['cantidad' => $item['cantidad']]
            );
        }
    }
}
