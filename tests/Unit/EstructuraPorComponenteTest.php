<?php

namespace Tests\Unit;

use App\Models\EstructuraPorComponente;
use Tests\TestCase;

class EstructuraPorComponenteTest extends TestCase
{
    public function test_estructura_por_componente_uses_expected_table_name(): void
    {
        $model = new EstructuraPorComponente();

        $this->assertEquals('estructura_por_componente', $model->getTable());
    }

    public function test_estructura_por_componente_has_expected_fillable_attributes(): void
    {
        $model = new EstructuraPorComponente();

        $this->assertEquals([
            'componente_id',
            'estructura_id',
            'cantidad',
        ], $model->getFillable());
    }

    public function test_estructura_por_componente_allows_mass_assignment_for_fillable_fields(): void
    {
        $attributes = [
            'componente_id' => 1,
            'estructura_id' => 2,
            'cantidad' => 3,
        ];

        $model = new EstructuraPorComponente($attributes);

        $this->assertEquals(1, $model->componente_id);
        $this->assertEquals(2, $model->estructura_id);
        $this->assertEquals(3, $model->cantidad);
    }
}
