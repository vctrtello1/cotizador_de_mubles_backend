<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Asigna todas las cotizaciones sin created_by_user_id al único vendedor existente.
        // Si hay más de un vendedor, esta migración no realiza cambios para evitar asignaciones incorrectas.
        $vendedores = DB::table('users')->where('rol', 'vendedor')->get();

        if ($vendedores->count() !== 1) {
            return;
        }

        $vendedor = $vendedores->first();

        DB::table('cotizaciones')
            ->whereNull('created_by_user_id')
            ->update(['created_by_user_id' => $vendedor->id]);
    }

    public function down(): void
    {
        DB::table('cotizaciones')->update(['created_by_user_id' => null]);
    }
};
