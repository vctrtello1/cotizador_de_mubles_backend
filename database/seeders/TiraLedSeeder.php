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
        
        // Seeds específicos
        TiraLed::create([
            'nombre' => 'Tira LED RGB 5m',
            'codigo' => 'TIRA_LED_RGB_5M',
            'descripcion' => 'Tira LED RGB de 5 metros con control remoto',
            'precio_unitario' => 25.99,
        ]);

        TiraLed::create([
            'nombre' => 'Tira LED RGBW 10m',
            'codigo' => 'TIRA_LED_RGBW_10M',
            'descripcion' => 'Tira LED RGBW de 10 metros con control remoto',
            'precio_unitario' => 45.99,
        ]);

        TiraLed::create([
            'nombre' => 'Tira LED Blanca Cálida 5m',
            'codigo' => 'TIRA_LED_CAL_5M',
            'descripcion' => 'Tira LED blanca cálida de 5 metros',
            'precio_unitario' => 15.99,
        ]);
    }
}
