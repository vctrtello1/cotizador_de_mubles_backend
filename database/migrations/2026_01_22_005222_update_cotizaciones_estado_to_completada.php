<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Simplemente cambiar 'aprobada' a 'completada' en registros existentes
        DB::table('cotizaciones')
            ->where('estado', 'aprobada')
            ->update(['estado' => 'completada']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir: cambiar 'completada' a 'aprobada'
        DB::table('cotizaciones')
            ->where('estado', 'completada')
            ->update(['estado' => 'aprobada']);
    }
};
