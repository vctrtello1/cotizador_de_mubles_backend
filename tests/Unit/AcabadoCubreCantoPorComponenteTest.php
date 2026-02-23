<?php

namespace Tests\Unit;

use App\Models\AcabadoCubreCantoPorComponente;
use Tests\TestCase;

class AcabadoCubreCantoPorComponenteTest extends TestCase
{
    public function test_uses_expected_table_name(): void
    {
        $model = new AcabadoCubreCantoPorComponente();

        $this->assertEquals('acabado_cubre_canto_por_componente', $model->getTable());
    }

    public function test_has_expected_fillable_attributes(): void
    {
        $model = new AcabadoCubreCantoPorComponente();

        $this->assertEquals([
            'componente_id',
            'acabado_cubre_canto_id',
            'cantidad',
        ], $model->getFillable());
    }

    public function test_allows_mass_assignment_for_fillable_fields(): void
    {
        $model = new AcabadoCubreCantoPorComponente([
            'componente_id' => 1,
            'acabado_cubre_canto_id' => 2,
            'cantidad' => 3,
        ]);

        $this->assertEquals(1, $model->componente_id);
        $this->assertEquals(2, $model->acabado_cubre_canto_id);
        $this->assertEquals(3, $model->cantidad);
    }
}
