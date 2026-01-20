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
        Schema::create('componentes_por_cotizacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cotizacion_id')->constrained('cotizaciones');
            $table->foreignId('componente_id')->constrained('componentes');
            $table->foreignId('modulo_id')->nullable()->constrained('modulos');
            $table->integer('cantidad');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('componentes_por_cotizacion');
    }
};
