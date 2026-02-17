<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CantidadPorHerrajeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_cantidad_por_herraje_index(): void
    {
        $response = $this->getJson('/api/v1/cantidad-por-herrajes');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'herraje_id',
                    'cantidad',
                ],
            ],
        ]);
    }


    public function test_cantidad_por_herraje_show(): void
    {
        // First, create a cantidad por herraje to show
        $cantidadPorHerraje = \App\Models\CantidadPorHerraje::factory()->create();

        $response = $this->getJson("/api/v1/cantidad-por-herrajes/{$cantidadPorHerraje->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'herraje_id',
                'cantidad',
            ],
        ]);
    }

    public function test_cantidad_por_herraje_with_herraje(): void
    {
        // Create a cantidad por herraje
        $cantidadPorHerraje = \App\Models\CantidadPorHerraje::factory()->create();

        // Create a herraje associated with this cantidad por herraje
        $herraje = \App\Models\Herraje::factory()->create();
        $cantidadPorHerraje->herraje()->associate($herraje);
        $cantidadPorHerraje->save();

        $response = $this->getJson("/api/v1/cantidad-por-herrajes/{$cantidadPorHerraje->id}?include=herraje");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'herraje_id',
                'cantidad',
                'herraje' => [
                    'id',
                    'nombre',
                    'descripcion',
                    'codigo',
                ],
            ],
        ]);
    }

    public function test_cantidad_por_herraje_creation(): void
    {
        $herraje = \App\Models\Herraje::factory()->create();
        $componente = \App\Models\Componente::factory()->create();
        $data = [
            'herraje_id' => $herraje->id,
            'componente_id' => $componente->id,
            'cantidad' => 15,
        ];

        $response = $this->postJson('/api/v1/cantidad-por-herrajes', $data);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'herraje_id',
                'cantidad',
            ],
        ]);
    }

    public function test_cantidad_por_herraje_creation_validation_error(): void
    {
        // Missing 'cantidad' field
        $herraje = \App\Models\Herraje::factory()->create();
        $componente = \App\Models\Componente::factory()->create();
        $data = [
            'herraje_id' => $herraje->id,
            'componente_id' => $componente->id,
        ];

        $response = $this->postJson('/api/v1/cantidad-por-herrajes', $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['cantidad']);
    }

    public function test_cantidad_por_herraje_creation_invalid_herraje(): void
    {
        $componente = \App\Models\Componente::factory()->create();
        // Non-existing herraje_id
        $data = [
            'herraje_id' => 9999, // Assuming this ID does not exist
            'componente_id' => $componente->id,
            'cantidad' => 10,
        ];

        $response = $this->postJson('/api/v1/cantidad-por-herrajes', $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['herraje_id']);
    }

    public function test_cantidad_por_herraje_deletion(): void
    {
        // First, create a cantidad por herraje to delete
        $cantidadPorHerraje = \App\Models\CantidadPorHerraje::factory()->create();

        $response = $this->deleteJson("/api/v1/cantidad-por-herrajes/{$cantidadPorHerraje->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('cantidad_por_herraje', ['id' => $cantidadPorHerraje->id]);
    }

    public function test_cantidad_por_herraje_update(): void
    {
        // First, create a cantidad por herraje to update
        $cantidadPorHerraje = \App\Models\CantidadPorHerraje::factory()->create();

        $updateData = [
            'cantidad' => 25,
        ];

        $response = $this->putJson("/api/v1/cantidad-por-herrajes/{$cantidadPorHerraje->id}", $updateData);

        $response->assertStatus(200);
        $response->assertJsonFragment($updateData);
    }   

    public function test_cantidad_por_herraje_update_validation_error(): void
    {
        // First, create a cantidad por herraje to update
        $cantidadPorHerraje = \App\Models\CantidadPorHerraje::factory()->create();

        // Invalid 'cantidad' field (negative number)
        $updateData = [
            'cantidad' => -5,
        ];

        $response = $this->putJson("/api/v1/cantidad-por-herrajes/{$cantidadPorHerraje->id}", $updateData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['cantidad']);
    }

    public function test_cantidad_por_herraje_update_invalid_herraje(): void
    {
        // First, create a cantidad por herraje to update
        $cantidadPorHerraje = \App\Models\CantidadPorHerraje::factory()->create();

        // Non-existing herraje_id
        $updateData = [
            'herraje_id' => 9999, // Assuming this ID does not exist
            'cantidad' => 10,
        ];

        $response = $this->putJson("/api/v1/cantidad-por-herrajes/{$cantidadPorHerraje->id}", $updateData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['herraje_id']);
    }

    public function test_cantidad_por_herraje_unique_constraint(): void
    {
        $herraje = \App\Models\Herraje::factory()->create();
        $componente = \App\Models\Componente::factory()->create();

        // Create the first cantidad por herraje
        \App\Models\CantidadPorHerraje::factory()->create([
            'herraje_id' => $herraje->id,
            'componente_id' => $componente->id,
            'cantidad' => 10,
        ]);

        // Attempt to create a second cantidad por herraje with the same herraje_id
        $data = [
            'herraje_id' => $herraje->id,
            'componente_id' => $componente->id,
            'cantidad' => 20,
        ];

        $response = $this->postJson('/api/v1/cantidad-por-herrajes', $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['herraje_id']);
    }   

    public function test_cantidad_por_herraje_index_with_data(): void
    {
        // Clear existing data
        \App\Models\CantidadPorHerraje::query()->delete();

        // Create multiple cantidad por herraje entries
        \App\Models\CantidadPorHerraje::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/cantidad-por-herrajes');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    public function test_cantidad_por_herraje_minimum_quantity(): void
    {
        $herraje = \App\Models\Herraje::factory()->create();
        $componente = \App\Models\Componente::factory()->create();
        
        $data = [
            'herraje_id' => $herraje->id,
            'componente_id' => $componente->id,
            'cantidad' => 1, // Minimum allowed
        ];

        $response = $this->postJson('/api/v1/cantidad-por-herrajes', $data);

        $response->assertStatus(201);
    }

    public function test_cantidad_por_herraje_zero_quantity_fails(): void
    {
        $herraje = \App\Models\Herraje::factory()->create();
        $componente = \App\Models\Componente::factory()->create();
        
        $data = [
            'herraje_id' => $herraje->id,
            'componente_id' => $componente->id,
            'cantidad' => 0, // Below minimum
        ];

        $response = $this->postJson('/api/v1/cantidad-por-herrajes', $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['cantidad']);
    }

    public function test_cantidad_por_herraje_update_minimum_quantity(): void
    {
        $cantidadPorHerraje = \App\Models\CantidadPorHerraje::factory()->create(['cantidad' => 10]);

        $updateData = [
            'cantidad' => 1, // Minimum allowed
        ];

        $response = $this->putJson("/api/v1/cantidad-por-herrajes/{$cantidadPorHerraje->id}", $updateData);

        $response->assertStatus(200);
        $response->assertJsonFragment(['cantidad' => 1]);
    }
}
