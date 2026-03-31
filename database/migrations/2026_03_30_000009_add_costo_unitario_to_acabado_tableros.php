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
        Schema::table('acabado_tableros', function (Blueprint $table) {
            $table->decimal('costo_unitario', 10, 2)->after('nombre')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('acabado_tableros', function (Blueprint $table) {
            $table->dropColumn('costo_unitario');
        });
    }
};
