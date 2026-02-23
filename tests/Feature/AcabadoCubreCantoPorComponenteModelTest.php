<?php

namespace Tests\Feature;

use App\Models\AcabadoCubreCantoPorComponente;
use Tests\TestCase;

class AcabadoCubreCantoPorComponenteModelTest extends TestCase
{
    public function test_model_has_expected_table_name(): void
    {
        $model = new AcabadoCubreCantoPorComponente();

        $this->assertEquals('acabado_cubre_canto_por_componente', $model->getTable());
    }

    public function test_model_has_expected_fillable_attributes(): void
    {
        $model = new AcabadoCubreCantoPorComponente();

        $this->assertEquals([
            'componente_id',
            'acabado_cubre_canto_id',
            'cantidad',
        ], $model->getFillable());
    }

    public function test_model_supports_mass_assignment(): void
    {
        $model = new AcabadoCubreCantoPorComponente([
            'componente_id' => 1,
            'acabado_cubre_canto_id' => 2,
            'cantidad' => 4,
        ]);

        $this->assertEquals(1, $model->componente_id);
        $this->assertEquals(2, $model->acabado_cubre_canto_id);
        $this->assertEquals(4, $model->cantidad);
    }
}
