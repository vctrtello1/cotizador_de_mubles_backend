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
        //
        Schema::create('accesorios_por_componente', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('componente_id');
            $table->string('accesorio');
            $table->timestamps();

            $table->foreign('componente_id')->references('id')->on('componentes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('accesorios_por_componente');
    }
};
