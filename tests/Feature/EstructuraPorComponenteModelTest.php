<?php

namespace Tests\Feature;

use App\Models\EstructuraPorComponente;
use Tests\TestCase;

class EstructuraPorComponenteModelTest extends TestCase
{
    public function test_model_has_expected_table_name(): void
    {
        $model = new EstructuraPorComponente();

        $this->assertEquals('estructura_por_componente', $model->getTable());
    }

    public function test_model_has_expected_fillable_attributes(): void
    {
        $model = new EstructuraPorComponente();

        $this->assertEquals([
            'componente_id',
            'estructura_id',
            'cantidad',
        ], $model->getFillable());
    }

    public function test_model_supports_mass_assignment(): void
    {
        $model = new EstructuraPorComponente([
            'componente_id' => 1,
            'estructura_id' => 2,
            'cantidad' => 4,
        ]);

        $this->assertEquals(1, $model->componente_id);
        $this->assertEquals(2, $model->estructura_id);
        $this->assertEquals(4, $model->cantidad);
    }
}
