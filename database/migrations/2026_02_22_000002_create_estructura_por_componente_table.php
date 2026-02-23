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
        Schema::create('estructura_por_componente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('componente_id')->constrained('componentes');
            $table->foreignId('estructura_id')->constrained('estructura');
            $table->integer('cantidad');
            $table->timestamps();

            $table->unique(['componente_id', 'estructura_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estructura_por_componente');
    }
};
