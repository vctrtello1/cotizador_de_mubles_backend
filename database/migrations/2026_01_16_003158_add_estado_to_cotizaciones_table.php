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
        Schema::table('cotizaciones', function (Blueprint $table) {
            $table->enum('estado', ['activa', 'cancelada', 'completada'])->default('activa')->after('total');
        });

        // Asignar estados a los registros existentes
        DB::table('cotizaciones')->where('id', 1)->update(['estado' => 'activa']);
        DB::table('cotizaciones')->where('id', 2)->update(['estado' => 'activa']);
        DB::table('cotizaciones')->where('id', 3)->update(['estado' => 'cancelada']);
        DB::table('cotizaciones')->where('id', 4)->update(['estado' => 'cancelada']);
        DB::table('cotizaciones')->where('id', 5)->update(['estado' => 'completada']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cotizaciones', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
};
