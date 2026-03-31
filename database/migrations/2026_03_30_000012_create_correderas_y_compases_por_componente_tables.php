<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('correderas_por_componente', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('componente_id');
            $table->unsignedBigInteger('corredera_id');
            $table->integer('cantidad')->default(1);
            $table->timestamps();

            $table->foreign('componente_id')->references('id')->on('componentes');
            $table->foreign('corredera_id')->references('id')->on('correderas');
        });

        Schema::create('compases_abatibles_por_componente', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('componente_id');
            $table->unsignedBigInteger('compas_abatible_id');
            $table->integer('cantidad')->default(1);
            $table->timestamps();

            $table->foreign('componente_id')->references('id')->on('componentes');
            $table->foreign('compas_abatible_id')->references('id')->on('compases_abatibles');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compases_abatibles_por_componente');
        Schema::dropIfExists('correderas_por_componente');
    }
};
