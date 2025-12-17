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
        Schema::create('herrajes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->float('medida', 10, 2);
            $table->string('unidad_medida');
            $table->string('codigo')->unique();
            $table->decimal('costo_unitario', 10, 2);
            $table->timestamps();
        });

        DB::table('herrajes')->insert([
            [
                'nombre' => 'Tornillo Estándar de 2.5 cm',
                'descripcion' => 'Tornillo de alta resistencia para muebles',
                'codigo' => 'TOR_ESTANDAR',
                'costo_unitario' => 15.00,
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
        Schema::dropIfExists('herrajes');
    }
};
