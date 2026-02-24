<?php

namespace Tests\Feature;

use App\Models\Accesorio;
use Tests\TestCase;

class AccesorioModelTest extends TestCase
{
    public function test_model_has_expected_default_table_name(): void
    {
        $model = new Accesorio();

        $this->assertEquals('accesorios', $model->getTable());
    }

    public function test_model_has_expected_fillable_attributes(): void
    {
        $model = new Accesorio();

        $this->assertEquals([
            'nombre',
            'descripcion',
            'precio',
        ], $model->getFillable());
    }

    public function test_model_supports_mass_assignment(): void
    {
        $model = new Accesorio([
            'nombre' => 'Accesorio de prueba',
            'descripcion' => 'Descripción de prueba',
            'precio' => 15.50,
        ]);

        $this->assertEquals('Accesorio de prueba', $model->getAttribute('nombre'));
        $this->assertEquals('Descripción de prueba', $model->getAttribute('descripcion'));
        $this->assertEquals(15.50, (float) $model->getAttribute('precio'));
    }
}
