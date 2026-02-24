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
        Schema::create('gola_por_componente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('componente_id');
            $table->foreign('componente_id', 'gpc_comp_fk')->references('id')->on('componentes');
            $table->foreignId('gola_id');
            $table->foreign('gola_id', 'gpc_gola_fk')->references('id')->on('table_gola');
            $table->integer('cantidad');
            $table->timestamps();

            $table->unique(['componente_id', 'gola_id'], 'gpc_comp_gola_uq');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gola_por_componente');
    }
};
