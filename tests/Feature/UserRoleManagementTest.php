<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserRoleManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_list_users(): void
    {
        $admin = User::factory()->create(['rol' => 'admin', 'name' => 'Admin A']);
        User::factory()->create(['rol' => 'vendedor', 'name' => 'Vendedor B']);
        Sanctum::actingAs($admin);

        $response = $this->getJson('/api/v1/auth/users');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'email', 'rol', 'created_at', 'updated_at'],
            ],
        ]);
        $response->assertJsonFragment(['rol' => 'admin']);
        $response->assertJsonFragment(['rol' => 'vendedor']);
    }

    public function test_non_admin_cannot_list_users(): void
    {
        $vendedor = User::factory()->create(['rol' => 'vendedor']);
        Sanctum::actingAs($vendedor);

        $response = $this->getJson('/api/v1/auth/users');

        $response->assertStatus(403);
    }

    public function test_admin_can_update_user_role(): void
    {
        $admin = User::factory()->create(['rol' => 'admin']);
        Sanctum::actingAs($admin);

        $targetUser = User::factory()->create(['rol' => 'vendedor']);

        $response = $this->patchJson("/api/v1/auth/users/{$targetUser->id}/rol", [
            'rol' => 'desarrollador',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('user.id', $targetUser->id);
        $response->assertJsonPath('user.rol', 'desarrollador');

        $this->assertDatabaseHas('users', [
            'id' => $targetUser->id,
            'rol' => 'desarrollador',
        ]);
    }

    public function test_non_admin_cannot_update_user_role(): void
    {
        $vendedor = User::factory()->create(['rol' => 'vendedor']);
        Sanctum::actingAs($vendedor);

        $targetUser = User::factory()->create(['rol' => 'vendedor']);

        $response = $this->patchJson("/api/v1/auth/users/{$targetUser->id}/rol", [
            'rol' => 'admin',
        ]);

        $response->assertStatus(403);

        $this->assertDatabaseHas('users', [
            'id' => $targetUser->id,
            'rol' => 'vendedor',
        ]);
    }

    public function test_update_user_role_validates_allowed_values(): void
    {
        $admin = User::factory()->create(['rol' => 'admin']);
        Sanctum::actingAs($admin);

        $targetUser = User::factory()->create(['rol' => 'vendedor']);

        $response = $this->patchJson("/api/v1/auth/users/{$targetUser->id}/rol", [
            'rol' => 'super-admin',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['rol']);
    }
}
