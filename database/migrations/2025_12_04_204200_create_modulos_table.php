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
        Schema::create('modulos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->string('codigo')->unique();
            $table->timestamps();
        });

        DB::table('modulos')->insert([
            [
                'nombre' => 'Comedor Lucianico',
                'descripcion' => 'Comedor de Roble con acabados de alta calidad',
                'codigo' => 'COM_LUCIANICO',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modulos');
    }
};
