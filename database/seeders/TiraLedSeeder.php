<?php

namespace Database\Seeders;

use App\Models\TiraLed;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TiraLedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TiraLed::factory()->count(5)->create();
        
        // Seed específico: TIRA LED con datos del proyecto
        TiraLed::create([
            'nombre' => 'Tira LED',
            'codigo' => 'TIRA_LED_001',
            'descripcion' => 'Tira LED para componentes de muebles',
            'precio_unitario' => 600,
            'unidades_por_metro' => 5,
            'porcentaje_utilizacion' => 3.052,
            'cantidad_compra' => 4,
        ]);

        // Seeds adicionales
        TiraLed::create([
            'nombre' => 'Tira LED RGB 5m',
            'codigo' => 'TIRA_LED_RGB_5M',
            'descripcion' => 'Tira LED RGB de 5 metros con control remoto',
            'precio_unitario' => 25.99,
            'unidades_por_metro' => 3,
            'porcentaje_utilizacion' => 2.5,
            'cantidad_compra' => 2,
        ]);

        TiraLed::create([
            'nombre' => 'Tira LED RGBW 10m',
            'codigo' => 'TIRA_LED_RGBW_10M',
            'descripcion' => 'Tira LED RGBW de 10 metros con control remoto',
            'precio_unitario' => 45.99,
            'unidades_por_metro' => 4,
            'porcentaje_utilizacion' => 3.5,
            'cantidad_compra' => 3,
        ]);

        TiraLed::create([
            'nombre' => 'Tira LED Blanca Cálida 5m',
            'codigo' => 'TIRA_LED_CAL_5M',
            'descripcion' => 'Tira LED blanca cálida de 5 metros',
            'precio_unitario' => 15.99,
            'unidades_por_metro' => 5,
            'porcentaje_utilizacion' => 2.0,
            'cantidad_compra' => 1,
        ]);
    }
}
