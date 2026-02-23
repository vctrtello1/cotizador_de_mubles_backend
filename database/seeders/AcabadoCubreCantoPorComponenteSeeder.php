<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcabadoCubreCantoPorComponenteSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['componente_id' => 1, 'acabado_cubre_canto_id' => 1, 'cantidad' => 2],
            ['componente_id' => 1, 'acabado_cubre_canto_id' => 2, 'cantidad' => 1],
            ['componente_id' => 2, 'acabado_cubre_canto_id' => 3, 'cantidad' => 2],
            ['componente_id' => 3, 'acabado_cubre_canto_id' => 4, 'cantidad' => 1],
        ];

        foreach ($items as $item) {
            DB::table('acabado_cubre_canto_por_componente')->updateOrInsert(
                [
                    'componente_id' => $item['componente_id'],
                    'acabado_cubre_canto_id' => $item['acabado_cubre_canto_id'],
                ],
                ['cantidad' => $item['cantidad']]
            );
        }
    }
}
