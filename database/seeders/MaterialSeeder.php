<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materiales = [
            [
                'nombre' => 'Pata de silla Lucianica',
                'descripcion' => 'Patas de silla de madera de roble maciza con acabado natural',
                'codigo' => 'PAT-LUC-001',
                'precio_unitario' => 15.75,
                'unidad_medida' => 'cm',
                'alto' => 47,
                'ancho' => 2.7,
                'largo' => 2.7,
            ],
            [
                'nombre' => 'Base de silla Lucianica',
                'descripcion' => 'Base de silla de madera de roble maciza con acabado natural',
                'codigo' => 'TAB-LUC-001',
                'precio_unitario' => 500,
                'unidad_medida' => 'cm',
                'alto' => 2.7,
                'ancho' => 42,
                'largo' => 42,
            ],
            [
                'nombre' => 'Respaldo de silla Lucianica',
                'descripcion' => 'Respaldo de silla de madera de roble maciza con acabado natural',
                'codigo' => 'BCK-LUC-001',
                'precio_unitario' => 200,
                'unidad_medida' => 'cm',
                'alto' => 42,
                'ancho' => 42,
                'largo' => 2.7,
            ],
            [
                'nombre' => 'Asiento de silla Lucianica',
                'descripcion' => 'Asiento de silla algodon de 500 hilos con espuma de alta densidad',
                'codigo' => 'SEA-LUC-001',
                'precio_unitario' => 250,
                'unidad_medida' => 'cm',
                'alto' => 2.7,
                'ancho' => 42,
                'largo' => 42,
            ],
            [
                'nombre' => 'Pata de mesa Lucianica',
                'descripcion' => 'Patas de mesa de madera de roble maciza con acabado natural',
                'codigo' => 'PAT-MES-001',
                'precio_unitario' => 25.50,
                'unidad_medida' => 'cm',
                'alto' => 75,
                'ancho' => 5,
                'largo' => 5,
            ],
            [
                'nombre' => 'Tabla de mesa Lucianica',
                'descripcion' => 'Tabla de mesa de madera de roble maciza con acabado natural',
                'codigo' => 'TAB-MES-001',
                'precio_unitario' => 800,
                'unidad_medida' => 'cm',
                'alto' => 4,
                'ancho' => 120,
                'largo' => 80,
            ],
            [
                'nombre' => 'Estructura de centro de entretenimiento Purru',
                'descripcion' => 'Estructura de centro de entretenimiento de madera de pino con acabado barnizado',
                'codigo' => 'EST-PUR-001',
                'precio_unitario' => 1200,
                'unidad_medida' => 'cm',
                'alto' => 60,
                'ancho' => 150,
                'largo' => 40,
            ],
            [
                'nombre' => 'Pata de centro de entretenimiento Purru',
                'descripcion' => 'Pata de centro de entretenimiento de madera de pino con acabado barnizado',
                'codigo' => 'PAT-PUR-001',
                'precio_unitario' => 300,
                'unidad_medida' => 'cm',
                'alto' => 50,
                'ancho' => 2,
                'largo' => 2,
            ],
            [
                'nombre' => 'Vidrio de centro de entretenimiento Purru',
                'descripcion' => 'Vidrio templado para centro de entretenimiento',
                'codigo' => 'GLA-PUR-001',
                'precio_unitario' => 400,
                'unidad_medida' => 'cm',
                'alto' => 55,
                'ancho' => 45,
                'largo' => 1,
            ],
            [
                'nombre' => 'Repisa de centro de entretenimiento Purru',
                'descripcion' => 'Repisa de centro de entretenimiento de madera de pino con acabado barnizado',
                'codigo' => 'SHE-PUR-001',
                'precio_unitario' => 250,
                'unidad_medida' => 'cm',
                'alto' => 2,
                'ancho' => 140,
                'largo' => 35,
            ],
        ];

        Material::upsert($materiales, ['codigo'], ['nombre', 'descripcion', 'precio_unitario', 'unidad_medida', 'alto', 'ancho', 'largo']);
    }
}
