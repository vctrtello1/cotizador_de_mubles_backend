<?php

namespace Tests\Feature;

use App\Models\AcabadoTablero;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AcabadoTableroTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that acabado_tablero index endpoint returns all items.
     */
    public function test_acabado_tablero_index(): void
    {
        AcabadoTablero::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/acabado-tableros');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'nombre',
                    'costo_unitario',
                ],
            ],
        ]);
    }

    /**
     * Test that acabado_tablero show endpoint returns a single item.
     */
    public function test_acabado_tablero_show(): void
    {
        $acabadoTablero = AcabadoTablero::factory()->create([
            'nombre' => 'Laminado Brillante',
            'costo_unitario' => 450.00,
        ]);

        $response = $this->getJson("/api/v1/acabado-tableros/{$acabadoTablero->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'nombre',
                'costo_unitario',
            ],
        ]);
        $response->assertJsonFragment([
            'nombre' => 'Laminado Brillante',
            'costo_unitario' => '450.00',
        ]);
    }

    /**
     * Test that acabado_tablero can be created.
     */
    public function test_acabado_tablero_store(): void
    {
        $acabadoTableroData = [
            'nombre' => 'Melamina Blanca',
            'costo_unitario' => 350.00,
        ];

        $response = $this->postJson('/api/v1/acabado-tableros', $acabadoTableroData);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'nombre' => 'Melamina Blanca',
        ]);

        $this->assertDatabaseHas('acabado_tableros', [
            'nombre' => 'Melamina Blanca',
            'costo_unitario' => 350.00,
        ]);
    }

    /**
     * Test that acabado_tablero can be updated.
     */
    public function test_acabado_tablero_update(): void
    {
        $acabadoTablero = AcabadoTablero::factory()->create([
            'nombre' => 'Laca Mate',
            'costo_unitario' => 600.00,
        ]);

        $updatedData = [
            'nombre' => 'Laca Brillante',
            'costo_unitario' => 650.00,
        ];

        $response = $this->putJson("/api/v1/acabado-tableros/{$acabadoTablero->id}", $updatedData);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'nombre' => 'Laca Brillante',
            'costo_unitario' => '650.00',
        ]);

        $this->assertDatabaseHas('acabado_tableros', [
            'id' => $acabadoTablero->id,
            'nombre' => 'Laca Brillante',
            'costo_unitario' => 650.00,
        ]);
    }

    /**
     * Test that acabado_tablero can be deleted.
     */
    public function test_acabado_tablero_delete(): void
    {
        $acabadoTablero = AcabadoTablero::factory()->create();

        $response = $this->deleteJson("/api/v1/acabado-tableros/{$acabadoTablero->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('acabado_tableros', [
            'id' => $acabadoTablero->id,
        ]);
    }

    /**
     * Test validation on acabado_tablero store - nombre is required.
     */
    public function test_acabado_tablero_validation_nombre_required(): void
    {
        $invalidData = [
            'costo_unitario' => 500.00,
        ];

        $response = $this->postJson('/api/v1/acabado-tableros', $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre']);
    }

    /**
     * Test validation on acabado_tablero store - costo_unitario is required.
     */
    public function test_acabado_tablero_validation_costo_unitario_required(): void
    {
        $invalidData = [
            'nombre' => 'Vinilo Texturizado',
        ];

        $response = $this->postJson('/api/v1/acabado-tableros', $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['costo_unitario']);
    }

    /**
     * Test validation on acabado_tablero store - costo_unitario must be numeric.
     */
    public function test_acabado_tablero_validation_costo_unitario_numeric(): void
    {
        $invalidData = [
            'nombre' => 'Vinilo Texturizado',
            'costo_unitario' => 'not-a-number',
        ];

        $response = $this->postJson('/api/v1/acabado-tableros', $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['costo_unitario']);
    }

    /**
     * Test that acabado_tablero show returns 404 for non-existent ID.
     */
    public function test_acabado_tablero_not_found(): void
    {
        $nonExistentId = 9999;

        $response = $this->getJson("/api/v1/acabado-tableros/{$nonExistentId}");

        $response->assertStatus(404);
    }

    /**
     * Test that acabado_tablero delete returns 404 for non-existent ID.
     */
    public function test_acabado_tablero_delete_not_found(): void
    {
        $nonExistentId = 9999;

        $response = $this->deleteJson("/api/v1/acabado-tableros/{$nonExistentId}");

        $response->assertStatus(404);
    }

    /**
     * Test that acabado_tablero update returns 404 for non-existent ID.
     */
    public function test_acabado_tablero_update_not_found(): void
    {
        $nonExistentId = 9999;
        
        $updatedData = [
            'nombre' => 'Acabado Inexistente',
            'costo_unitario' => 999.00,
        ];

        $response = $this->putJson("/api/v1/acabado-tableros/{$nonExistentId}", $updatedData);

        $response->assertStatus(404);
    }

    /**
     * Test that acabado_tablero nombre must be unique.
     */
    public function test_acabado_tablero_nombre_unique(): void
    {
        AcabadoTablero::factory()->create([
            'nombre' => 'Formica Negra',
            'costo_unitario' => 500.00,
        ]);

        $duplicateData = [
            'nombre' => 'Formica Negra',
            'costo_unitario' => 550.00,
        ];

        $response = $this->postJson('/api/v1/acabado-tableros', $duplicateData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nombre']);
    }
}
