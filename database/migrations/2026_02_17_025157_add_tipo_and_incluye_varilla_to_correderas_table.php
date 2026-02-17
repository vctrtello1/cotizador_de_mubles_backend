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
        Schema::table('correderas', function (Blueprint $table) {
            $table->enum('tipo', ['PARCIAL', 'TOTAL', 'TOTAL_TIP_ON'])->after('capacidad_carga')->comment('Tipo de corredera');
            $table->boolean('incluye_varilla')->default(false)->after('tipo')->comment('Indica si incluye varilla de sincronización');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('correderas', function (Blueprint $table) {
            $table->dropColumn(['tipo', 'incluye_varilla']);
        });
    }
};
