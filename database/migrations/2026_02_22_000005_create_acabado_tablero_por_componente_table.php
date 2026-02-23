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
        Schema::create('acabado_tablero_por_componente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('componente_id');
            $table->foreign('componente_id', 'atpc_comp_fk')->references('id')->on('componentes');
            $table->foreignId('acabado_tablero_id');
            $table->foreign('acabado_tablero_id', 'atpc_at_fk')->references('id')->on('acabado_tableros');
            $table->integer('cantidad');
            $table->timestamps();

            $table->unique(['componente_id', 'acabado_tablero_id'], 'atpc_comp_at_uq');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acabado_tablero_por_componente');
    }
};
