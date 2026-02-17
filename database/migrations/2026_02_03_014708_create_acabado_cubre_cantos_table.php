<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('acabado_cubre_cantos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->decimal('costo_unitario', 10, 2);
            $table->timestamps();
        });

        DB::table('acabado_cubre_cantos')->insert([
            [
                'nombre' => 'ARAUCO 15 MM',
                'costo_unitario' => 15.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'FINSA 15 MM',
                'costo_unitario' => 15.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'KAINDL (MADERA) 18MM',
                'costo_unitario' => 20.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'EGGER (MADERA) 18MM',
                'costo_unitario' => 40.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'EGGER (ALTO BRILLO) 18 MM',
                'costo_unitario' => 40.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'EGGER (ULTRA MATE) 18 MM',
                'costo_unitario' => 40.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'REHAU (ULTRA MATE) 19.5mm',
                'costo_unitario' => 40.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'REHAU (ALTO BRILLO) 19mm',
                'costo_unitario' => 40.00,
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
        Schema::dropIfExists('acabado_cubre_cantos');
    }
};
