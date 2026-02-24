<?php

namespace Database\Seeders;

use App\Models\Puerta;
use Illuminate\Database\Seeder;

class PuertaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $puertas = [
            [
                'nombre' => 'Puerta Cristal Standard',
                'precio_perfil_aluminio' => 793.00,
                'precio_escuadras' => 50.00,
                'precio_silicon' => 80.00,
                'precio_cristal_m2' => 1400.00,
                'precio_final' => 2323.00,
                'alto_maximo' => 2.40,
                'ancho_maximo' => 0.60,
            ],
        ];

        foreach ($puertas as $puerta) {
            Puerta::create($puerta);
        }
    }
}
