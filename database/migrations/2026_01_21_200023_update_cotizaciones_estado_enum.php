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
        // SQLite doesn't support modifying enums directly, so we need to recreate the column
        // First, drop the existing column
        Schema::table('cotizaciones', function (Blueprint $table) {
            $table->dropColumn('estado');
        });

        // Then recreate it with the new enum values
        Schema::table('cotizaciones', function (Blueprint $table) {
            $table->enum('estado', ['activa', 'pendiente', 'aprobada', 'rechazada', 'cancelada'])
                ->default('activa')
                ->after('total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cotizaciones', function (Blueprint $table) {
            $table->dropColumn('estado');
        });

        Schema::table('cotizaciones', function (Blueprint $table) {
            $table->enum('estado', ['activa', 'cancelada', 'completada'])
                ->default('activa')
                ->after('total');
        });
    }
};
