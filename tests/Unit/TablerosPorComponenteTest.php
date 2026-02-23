<?php

namespace Tests\Unit;

use App\Models\TablerosPorComponente;
use PHPUnit\Framework\TestCase;

class TablerosPorComponenteTest extends TestCase
{
    public function test_uses_expected_table_name(): void
    {
        $model = new TablerosPorComponente();

        $this->assertSame('tableros_por_componente', $model->getTable());
    }

    public function test_has_expected_fillable_attributes(): void
    {
        $model = new TablerosPorComponente();

        $this->assertSame([
            'componente_id',
            'tablero_id',
            'cantidad',
        ], $model->getFillable());
    }

    public function test_allows_mass_assignment_for_fillable_fields(): void
    {
        $attributes = [
            'componente_id' => 10,
            'tablero_id' => 20,
            'cantidad' => 3,
        ];

        $model = new TablerosPorComponente($attributes);

        $this->assertSame(10, $model->componente_id);
        $this->assertSame(20, $model->tablero_id);
        $this->assertSame(3, $model->cantidad);
    }
}
