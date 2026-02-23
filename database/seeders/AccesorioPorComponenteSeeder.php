<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccesorioPorComponenteSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['componente_id' => 1, 'accesorio' => 'Mantel antideslizante'],
            ['componente_id' => 2, 'accesorio' => 'Protector de esquinas'],
            ['componente_id' => 3, 'accesorio' => 'Soportes ajustables'],
        ];

        foreach ($items as $item) {
            DB::table('accesorios_por_componente')->updateOrInsert(
                ['componente_id' => $item['componente_id'], 'accesorio' => $item['accesorio']],
                []
            );
        }
    }
}
