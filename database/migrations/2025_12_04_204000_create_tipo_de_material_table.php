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
        Schema::create('tipo_de_material', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('codigo')->nullable();
            $table->timestamps();
        });

        // Insert initial data into table_tipo_de_material
        DB::table('tipo_de_material')->insert([
            [
                'nombre' => 'Madera de roble',
                'descripcion' => 'Madera dura y resistente, ideal para muebles de alta calidad.',
                'codigo' => 'MAT-ROB-001',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Acero inoxidable',
                'descripcion' => 'Material duradero y resistente a la corrosión, utilizado en estructuras metálicas.',
                'codigo' => 'MAT-ACR-002',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Plástico ABS',
                'descripcion' => 'Material ligero y resistente, comúnmente usado en componentes moldeados.',
                'codigo' => 'MAT-PLA-003',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Vidrio templado',
                'descripcion' => 'Vidrio tratado térmicamente para mayor resistencia y seguridad.',
                'codigo' => 'MAT-VID-004',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Algodón orgánico ',
                'descripcion' => 'Fibra natural suave y transpirable, utilizada en textiles ecológicos.',
                'codigo' => 'MAT-ALG-005',
                'created_at' => now(),
                'updated_at' => now(),
            ]  
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_de_material');
    }
};
