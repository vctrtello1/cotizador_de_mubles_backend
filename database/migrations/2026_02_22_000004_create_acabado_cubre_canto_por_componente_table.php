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
        Schema::create('acabado_cubre_canto_por_componente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('componente_id');
            $table->foreign('componente_id', 'accpc_comp_fk')->references('id')->on('componentes');
            $table->foreignId('acabado_cubre_canto_id');
            $table->foreign('acabado_cubre_canto_id', 'accpc_acc_fk')->references('id')->on('acabado_cubre_cantos');
            $table->integer('cantidad');
            $table->timestamps();

            $table->unique(['componente_id', 'acabado_cubre_canto_id'], 'accpc_comp_acabado_uq');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acabado_cubre_canto_por_componente');
    }
};
