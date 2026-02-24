<?php

namespace Tests\Feature;

use App\Models\GolaPorComponente;
use Tests\TestCase;

class GolaPorComponenteModelTest extends TestCase
{
    public function test_model_has_expected_table_name(): void
    {
        $model = new GolaPorComponente();

        $this->assertEquals('gola_por_componente', $model->getTable());
    }

    public function test_model_has_expected_fillable_attributes(): void
    {
        $model = new GolaPorComponente();

        $this->assertEquals([
            'componente_id',
            'gola_id',
            'cantidad',
        ], $model->getFillable());
    }

    public function test_model_supports_mass_assignment(): void
    {
        $model = new GolaPorComponente([
            'componente_id' => 1,
            'gola_id' => 2,
            'cantidad' => 4,
        ]);

        $this->assertEquals(1, $model->componente_id);
        $this->assertEquals(2, $model->gola_id);
        $this->assertEquals(4, $model->cantidad);
    }
}
