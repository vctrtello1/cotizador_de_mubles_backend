<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClienteTest extends TestCase
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


    public function test_cliente_index(): void
    {
        $response = $this->getJson('/api/v1/clientes');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'nombre',
                    'email',
                    'telefono',
                    'direccion',
                    'empresa',
                    'notas',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }

    public function test_cliente_show(): void
    {
        // First, create a cliente to show
        $cliente = \App\Models\Cliente::factory()->create();

        $response = $this->getJson("/api/v1/clientes/{$cliente->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'nombre',
                'email',
                'telefono',
                'direccion',
                'empresa',
                'notas',
                'created_at',
                'updated_at',
            ],
        ]);
    }   

    public function test_cliente_creation(): void
    {
        $data = [
            'nombre' => 'Juan Perez',
            'email' => 'juan.perez@example.com',
            'telefono' => '1234567890',
            'direccion' => '123 Main St',
            'empresa' => 'Empresa XYZ',
            'notas' => 'Cliente importante',
        ];

        $response = $this->postJson('/api/v1/clientes', $data);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'nombre' => 'Juan Perez',
            'email' => 'juan.perez@example.com',
        ]);

        $this->assertDatabaseHas('clientes', [
            'nombre' => 'Juan Perez',
            'email' => 'juan.perez@example.com',
        ]);
    }
    public function test_cliente_update(): void
    {
        // First, create a cliente to update
        $cliente = \App\Models\Cliente::factory()->create();

        $data = [
            'nombre' => 'Juan Perez Actualizado',
            'email' => 'juan.perez.actualizado@example.com',    
            'telefono' => '0987654321',
            'direccion' => '456 Elm St',
            'empresa' => 'Empresa Actualizada',
            'notas' => 'Cliente actualizado',
        ];
        $response = $this->putJson("/api/v1/clientes/{$cliente->id}", $data);
            $response->assertStatus(200);
            $response->assertJsonFragment([
                'nombre' => 'Juan Perez Actualizado',
                'email' => 'juan.perez.actualizado@example.com',    
            ]);
    
        }

        public function test_cliente_delete(): void
        {
            // First, create a cliente to delete
            $cliente = \App\Models\Cliente::factory()->create();
    
            $response = $this->deleteJson("/api/v1/clientes/{$cliente->id}");
    
            $response->assertStatus(204);
            $this->assertDatabaseMissing('clientes', ['id' => $cliente->id]);
        }

        public function test_cliente_validation_on_creation(): void
        {
            $data = [
                // 'nombre' is missing
                'email' => 'invalid-email-format', // Invalid email format
            ];
    
            $response = $this->postJson('/api/v1/clientes', $data);
    
            $response->assertStatus(422); // Unprocessable Entity
            $response->assertJsonValidationErrors(['nombre', 'email']);
        }

        public function test_cliente_validation_on_update(): void
        {
            // First, create a cliente to update
            $cliente = \App\Models\Cliente::factory()->create();
    
            $data = [
                'nombre' => '', // Empty name
                'email' => 'invalid-email-format', // Invalid email format
            ];
    
            $response = $this->putJson("/api/v1/clientes/{$cliente->id}", $data);
    
            $response->assertStatus(422); // Unprocessable Entity
            $response->assertJsonValidationErrors(['nombre', 'email']);
        }

        public function test_cliente_unique_email_validation(): void
        {
            // Create a cliente with a specific email
            $existingCliente = \App\Models\Cliente::factory()->create([
                'email' => 'existing.email@example.com'
            ]);

            $data = [
                'nombre' => 'New Client',
                'email' => 'existing.email@example.com',
                'telefono' => '1234567890',
            ];

            $response = $this->postJson('/api/v1/clientes', $data);

            $response->assertStatus(422);
            $response->assertJsonValidationErrors(['email']);
        }
    public function test_componente_update(): void
    {
        // First, create a componente to update
        $componente = \App\Models\Componente::factory()->create();
        $material = \App\Models\Material::factory()->create();
        $herraje = \App\Models\Herraje::factory()->create();        
        $updateData = [
            'nombre' => 'Componente Actualizado',
            'descripcion' => 'Descripcion actualizada',
            'codigo' => 'CMP-54321',
            'accesorios' => 'Accesorio3, Accesorio4',
            'acabado_id' => \App\Models\Acabado::factory()->create()->id,
            'mano_de_obra_id' => \App\Models\ManoDeObra::factory()->create()->id,
            'materiales' => [
                ['id' => $material->id, 'cantidad' => 10]
            ],
            'herrajes' => [
                ['id' => $herraje->id, 'cantidad' => 4]
            ]
        ];
        $response = $this->putJson("/api/v1/componentes/{$componente->id}", $updateData);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'nombre' => 'Componente Actualizado',
            'descripcion' => 'Descripcion actualizada',     

            'codigo' => 'CMP-54321',
        ]);
        $response->assertJsonFragment(['accesorio' => 'Accesorio3']);
        $response->assertJsonFragment(['accesorio' => 'Accesorio4']);   

        $response->assertJsonFragment(['id' => $material->id, 'cantidad' => 10]);
        $response->assertJsonFragment(['id' => $herraje->id, 'cantidad' => 4]); 

        $this->assertDatabaseHas('componentes', [
            'id' => $componente->id,
            'nombre' => 'Componente Actualizado',
            'codigo' => 'CMP-54321',
        ]);

        $this->assertDatabaseHas('materiales_por_componente', [
            'componente_id' => $componente->id,
            'material_id' => $material->id,
            'cantidad' => 10
        ]);
        $this->assertDatabaseHas('cantidad_por_herraje', [
            'componente_id' => $componente->id,
            'herraje_id' => $herraje->id,
            'cantidad' => 4
        ]);
    }

    public function test_componente_update_alternative(): void
    {
        // First, create a componente to update
        $componente = \App\Models\Componente::factory()->create();
        $material = \App\Models\Material::factory()->create();
        $herraje = \App\Models\Herraje::factory()->create();

        $updateData = [
            'nombre' => 'Componente Actualizado',
            'descripcion' => 'Descripcion actualizada',
            'codigo' => 'CMP-54321',
            'accesorios' => 'Accesorio3, Accesorio4',
            'acabado_id' => \App\Models\Acabado::factory()->create()->id,
            'mano_de_obra_id' => \App\Models\ManoDeObra::factory()->create()->id,
            'materiales' => [
                ['id' => $material->id, 'cantidad' => 10]
            ],
            'herrajes' => [
                ['id' => $herraje->id, 'cantidad' => 4]
            ]
        ];

        $response = $this->putJson("/api/v1/componentes/{$componente->id}", $updateData);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'nombre' => 'Componente Actualizado',
            'descripcion' => 'Descripcion actualizada',
            'codigo' => 'CMP-54321',
        ]);
        $response->assertJsonFragment(['accesorio' => 'Accesorio3']);
        $response->assertJsonFragment(['accesorio' => 'Accesorio4']);
        
        $response->assertJsonFragment(['id' => $material->id, 'cantidad' => 10]);
        $response->assertJsonFragment(['id' => $herraje->id, 'cantidad' => 4]);

        $this->assertDatabaseHas('componentes', [
            'id' => $componente->id,
            'nombre' => 'Componente Actualizado',
            'codigo' => 'CMP-54321',
        ]);
        
        $this->assertDatabaseHas('materiales_por_componente', [
            'componente_id' => $componente->id,
            'material_id' => $material->id,
            'cantidad' => 10
        ]);
        $this->assertDatabaseHas('cantidad_por_herraje', [
            'componente_id' => $componente->id,
            'herraje_id' => $herraje->id,
            'cantidad' => 4
        ]);
    }

    public function test_componente_update_validation(): void
    {
        // First, create a componente to update
        $componente = \App\Models\Componente::factory()->create();

        $updateData = [
            'nombre' => '', // Empty name
            'descripcion' => 'Descripcion actualizada',
            'codigo' => '', // Empty code
        ];

        $response = $this->putJson("/api/v1/componentes/{$componente->id}", $updateData);

        $response->assertStatus(422); // Unprocessable Entity
        $response->assertJsonValidationErrors(['nombre', 'codigo']);
    }

    public function test_componente_update_no_materials_herrajes(): void
    {
        // First, create a componente to update
        $componente = \App\Models\Componente::factory()->create();

        $updateData = [
            'nombre' => 'Componente Actualizado',
            'descripcion' => 'Descripcion actualizada',
            'codigo' => 'CMP-54321',
            'accesorios' => 'Accesorio3, Accesorio4',
            'acabado_id' => \App\Models\Acabado::factory()->create()->id,
            'mano_de_obra_id' => \App\Models\ManoDeObra::factory()->create()->id,
            // No materiales or herrajes provided
        ];

        $response = $this->putJson("/api/v1/componentes/{$componente->id}", $updateData);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'nombre' => 'Componente Actualizado',
            'descripcion' => 'Descripcion actualizada',
            'codigo' => 'CMP-54321',
        ]);
        $response->assertJsonFragment(['accesorio' => 'Accesorio3']);
        $response->assertJsonFragment(['accesorio' => 'Accesorio4']);

        $this->assertDatabaseHas('componentes', [
            'id' => $componente->id,
            'nombre' => 'Componente Actualizado',
            'codigo' => 'CMP-54321',
        ]);
    }

    public function test_componente_update_empty_materials_herrajes(): void
    {
        // First, create a componente to update
        $componente = \App\Models\Componente::factory()->create();

        $updateData = [
            'nombre' => 'Componente Actualizado',
            'descripcion' => 'Descripcion actualizada',
            'codigo' => 'CMP-54321',
            'accesorios' => 'Accesorio3, Accesorio4',
            'acabado_id' => \App\Models\Acabado::factory()->create()->id,
            'mano_de_obra_id' => \App\Models\ManoDeObra::factory()->create()->id,
            'materiales' => [], // Empty materiales
            'herrajes' => [],   // Empty herrajes
        ];

        $response = $this->putJson("/api/v1/componentes/{$componente->id}", $updateData);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'nombre' => 'Componente Actualizado',
            'descripcion' => 'Descripcion actualizada',
            'codigo' => 'CMP-54321',
        ]);
        $response->assertJsonFragment(['accesorio' => 'Accesorio3']);
        $response->assertJsonFragment(['accesorio' => 'Accesorio4']);

        $this->assertDatabaseHas('componentes', [
            'id' => $componente->id,
            'nombre' => 'Componente Actualizado',
            'codigo' => 'CMP-54321',
        ]);
    }

    public function test_componente_update_no_accesorios(): void
    {
        // First, create a componente to update
        $componente = \App\Models\Componente::factory()->create();

        $updateData = [
            'nombre' => 'Componente Actualizado',
            'descripcion' => 'Descripcion actualizada',
            'codigo' => 'CMP-54321',
            'acabado_id' => \App\Models\Acabado::factory()->create()->id,
            'mano_de_obra_id' => \App\Models\ManoDeObra::factory()->create()->id,
            'materiales' => [],
            'herrajes' => [],
            // No accesorios provided
        ];

        $response = $this->putJson("/api/v1/componentes/{$componente->id}", $updateData);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'nombre' => 'Componente Actualizado',
            'descripcion' => 'Descripcion actualizada',
            'codigo' => 'CMP-54321',
        ]);

        $this->assertDatabaseHas('componentes', [
            'id' => $componente->id,
            'nombre' => 'Componente Actualizado',
            'codigo' => 'CMP-54321',
        ]);
    }

    public function test_componente_update_empty_accesorios(): void
    {
        // First, create a componente to update
        $componente = \App\Models\Componente::factory()->create();

        $updateData = [
            'nombre' => 'Componente Actualizado',
            'descripcion' => 'Descripcion actualizada',
            'codigo' => 'CMP-54321',
            'accesorios' => '', // Empty accesorios
            'acabado_id' => \App\Models\Acabado::factory()->create()->id,
            'mano_de_obra_id' => \App\Models\ManoDeObra::factory()->create()->id,
            'materiales' => [],
            'herrajes' => [],
        ];

        $response = $this->putJson("/api/v1/componentes/{$componente->id}", $updateData);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'nombre' => 'Componente Actualizado',
            'descripcion' => 'Descripcion actualizada',
            'codigo' => 'CMP-54321',
        ]);

        $this->assertDatabaseHas('componentes', [
            'id' => $componente->id,
            'nombre' => 'Componente Actualizado',
            'codigo' => 'CMP-54321',
        ]);
    }
}