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
        Schema::create('correderas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->integer('capacidad_carga')->comment('Capacidad de carga en kilogramos');
            $table->enum('tipo', ['PARCIAL', 'TOTAL', 'TOTAL_TIP_ON'])->comment('Tipo de corredera');
            $table->boolean('incluye_varilla')->default(false)->comment('Indica si incluye varilla de sincronización');
            $table->decimal('precio_base', 10, 2);
            $table->decimal('precio_con_acoplamiento', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('correderas');
    }
};
