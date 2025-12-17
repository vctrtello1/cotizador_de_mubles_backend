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
        Schema::create('acabados', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table ->string('nombre');
            $table ->string('descripcion')->nullable();
            $table ->decimal('costo', 10, 2);
        });

        // Acabados Silla Lucianica
        DB::table('acabados')->insert([
            [
                'nombre' => 'Acabado Premium de Roble',
                'descripcion' => 'Acabado de alta calidad con protección extra',
                'costo' => 150.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Acabados Mesa Lucianica
        DB::table('acabados')->insert([
            [
                'nombre' => 'Acabado Estándar de Roble',
                'descripcion' => 'Acabado estándar con protección básica',
                'costo' => 100.00,
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
        Schema::dropIfExists('acabados');
    }
};
