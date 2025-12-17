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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('cantidad'); 
            $table->string('descripcion')->nullable();
            $table->string('codigo')->unique();
            $table->float('precio_unitario');
            $table->string('unidad_medida');
            $table->string('tipo_de_material');
            $table->float('alto');
            $table->float('ancho');
            $table->float('largo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
