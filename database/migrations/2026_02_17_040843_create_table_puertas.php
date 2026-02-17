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
        Schema::create('puertas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->decimal('precio_perfil_aluminio', 10, 2);
            $table->decimal('precio_escuadras', 10, 2);
            $table->decimal('precio_silicon', 10, 2);
            $table->decimal('precio_cristal_m2', 10, 2);
            $table->decimal('alto_maximo', 8, 2)->default(2.40);
            $table->decimal('ancho_maximo', 8, 2)->default(0.60);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puertas');
    }
};
