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
        Schema::create('tableros_por_componente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('componente_id')->constrained('componentes');
            $table->foreignId('tablero_id')->constrained('materiales');
            $table->integer('cantidad');
            $table->timestamps();

            $table->unique(['componente_id', 'tablero_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tableros_por_componente');
    }
};
