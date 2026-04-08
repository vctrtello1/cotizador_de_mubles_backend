<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WhatsPorMetroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $whatsPorMetro = [
            ['nombre' => 'WATTS LED 5W', 'precio' => 95.00, 'unidades_por_metro' => 5, 'porcentaje_utilizacion' => 4.50],
            ['nombre' => 'WATTS LED 10W', 'precio' => 125.00, 'unidades_por_metro' => 10, 'porcentaje_utilizacion' => 6.00],
        ];

        foreach ($whatsPorMetro as $item) {
            DB::table('whats_por_metro')->updateOrInsert(['nombre' => $item['nombre']], $item);
        }
    }
}
