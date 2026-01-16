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
        // Asignar estado 'activa' a todas las cotizaciones que tengan estado NULL
        DB::table('cotizaciones')
            ->whereNull('estado')
            ->update(['estado' => 'activa']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Si se revierte, no hacemos nada porque el estado NULL será restaurado
        // por la migración anterior que elimina la columna
    }
};
