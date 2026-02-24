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
        Schema::create('puertas_por_componente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('componente_id');
            $table->foreign('componente_id', 'ppc_comp_fk')->references('id')->on('componentes');
            $table->foreignId('puerta_id');
            $table->foreign('puerta_id', 'ppc_puerta_fk')->references('id')->on('puertas');
            $table->integer('cantidad');
            $table->timestamps();

            $table->unique(['componente_id', 'puerta_id'], 'ppc_comp_puerta_uq');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puertas_por_componente');
    }
};
