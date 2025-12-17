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
        Schema::create('pinturas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nombre');
            $table->string('tipo');
            $table->string('descripcion')->nullable();
            $table->decimal('costo_por_metro_cuadrado', 10, 2); 
            $table->decimal('metros_cuadrados', 10, 2);
            $table->decimal('costo_total', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinturas');
    }
};
