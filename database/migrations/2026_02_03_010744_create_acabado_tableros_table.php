<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('acabado_tableros', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->decimal('costo_unitario', 10, 2);
            $table->timestamps();
        });

        DB::table('acabado_tableros')->insert([
            [
                'nombre' => 'ARAUCO 15 MM',
                'costo_unitario' => 1200.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'FINSA 15 MM',
                'costo_unitario' => 1300.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'KAINDL (MADERA) 2700mm x 2800mm x 18mm',
                'costo_unitario' => 4100.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'EGGER (MADERA) 2700mm x 2800mm x 18mm',
                'costo_unitario' => 6000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'EGGER (ALTO BRILLO) 2700mm x 2800mm x 18mm',
                'costo_unitario' => 9800.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'EGGER (ULTRA MATE) 2700mm x 2800mm x 18mm',
                'costo_unitario' => 9800.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'REHAU (ULTRA MATE) NOIR 2800mm x 1300mm x 19mm',
                'costo_unitario' => 9900.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'REHAU (ALTO BRILLO) CRYSTAL 2800mm x 1300mm x 19mm',
                'costo_unitario' => 10265.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'REHAU (ULTRA MATE) NOBLE 2800mm x 1300mm x 19mm',
                'costo_unitario' => 6800.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'REHAU (ULTRA MATE) ECO FINO 3070mmx1244mmx19.4mm',
                'costo_unitario' => 5500.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'REHAU (ULTRA MATE) BRILLIANT 2800mm x 1300mm x 19mm',
                'costo_unitario' => 5500.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'REHAU (ALTO BRILLO) BRILLIANT 2800mm x 1300mm x 19mm',
                'costo_unitario' => 5500.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'REHAU (ULTRA MATE) RAUVISO FINO BLANCO 2800mm x 1220mm x 18mm',
                'costo_unitario' => 5500.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'REHAU (ULTRA MATE) RAUVISO FINO NEGRO 2800mm x 1220mm x 18mm',
                'costo_unitario' => 5500.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'REHAU (ALTO BRILLO) RAUVISO FINO COLOR 2800mm x 1220mm x 18mm',
                'costo_unitario' => 5500.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'REHAU (ALTO BRILLO) RAUVISO METALLIC 2800mm x 1220mm x 18mm',
                'costo_unitario' => 0.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acabado_tableros');
    }
};
