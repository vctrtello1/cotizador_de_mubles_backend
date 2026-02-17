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
            $table->integer('capacidad_carga')->after('nombre')->comment('Capacidad de carga en kilogramos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('correderas', function (Blueprint $table) {
            $table->dropColumn('capacidad_carga');
        });
    }
};
