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
        Schema::create('capacidad_correderas', function (Blueprint $table) {
            $table->id();
            $table->integer('capacidad')->comment('Capacidad en kilogramos');
            $table->foreignId('corredera_id')->constrained('correderas')->onDelete('cascade');
            $table->timestamps();
            
            // Evitar duplicados de capacidad para la misma corredera
            $table->unique(['capacidad', 'corredera_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capacidad_correderas');
    }
};
