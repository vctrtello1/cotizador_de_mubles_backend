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
        // Assign modulo_id = 1 to all existing details that have null modulo_id
        // Assuming modulo with id 1 exists (created in previous migrations)
        DB::table('detalle_cotizacions')
            ->whereNull('modulo_id')
            ->update(['modulo_id' => 1]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We don't necessarily want to set them back to null on rollback, 
        // but strictly speaking, we could.
        // For now, we'll leave it as is or set them to null if we wanted to revert exactly.
        // DB::table('detalle_cotizacions')->update(['modulo_id' => null]);
    }
};
