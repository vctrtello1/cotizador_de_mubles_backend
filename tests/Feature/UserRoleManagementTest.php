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

    public function test_admin_can_get_user_by_id(): void
    {
        $admin = User::factory()->create(['rol' => 'admin']);
        $targetUser = User::factory()->create(['rol' => 'desarrollador']);
        Sanctum::actingAs($admin);

        $response = $this->getJson("/api/v1/auth/users/{$targetUser->id}");

        $response->assertStatus(200);
        $response->assertJsonPath('data.id', $targetUser->id);
        $response->assertJsonPath('data.role', 'editor');
        $response->assertJsonPath('data.rol', 'desarrollador');
    }

    public function test_admin_can_update_user_with_put_role_alias(): void
    {
        $admin = User::factory()->create(['rol' => 'admin']);
        $targetUser = User::factory()->create(['rol' => 'vendedor']);
        Sanctum::actingAs($admin);

        $response = $this->putJson("/api/v1/auth/users/{$targetUser->id}", [
            'name' => 'Usuario Editado',
            'role' => 'desarrollador',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('data.name', 'Usuario Editado');
        $response->assertJsonPath('data.role', 'editor');
        $response->assertJsonPath('data.rol', 'desarrollador');

        $this->assertDatabaseHas('users', [
            'id' => $targetUser->id,
            'name' => 'Usuario Editado',
            'rol' => 'desarrollador',
        ]);
    }

    public function test_admin_cannot_self_demote_with_put_user_update(): void
    {
        $admin = User::factory()->create(['rol' => 'admin']);
        Sanctum::actingAs($admin);

        $response = $this->putJson("/api/v1/auth/users/{$admin->id}", [
            'role' => 'viewer',
        ]);

        $response->assertStatus(422);
        $response->assertJsonPath('message', 'No puedes quitarte a ti mismo el rol de administrador.');

        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'rol' => 'admin',
        ]);
    }

    public function test_non_admin_cannot_update_user_with_put(): void
    {
        $vendedor = User::factory()->create(['rol' => 'vendedor']);
        $targetUser = User::factory()->create(['rol' => 'desarrollador']);
        Sanctum::actingAs($vendedor);

        $response = $this->putJson("/api/v1/auth/users/{$targetUser->id}", [
            'name' => 'Sin permiso',
        ]);

        $response->assertStatus(403);
    }

    public function test_admin_can_get_user_permissions_endpoint(): void
    {
        $admin = User::factory()->create(['rol' => 'admin']);
        $targetUser = User::factory()->create(['rol' => 'vendedor']);
        Sanctum::actingAs($admin);

        $response = $this->getJson("/api/v1/auth/users/{$targetUser->id}/permissions");

        $response->assertStatus(200);
        $response->assertJsonPath('data.role', 'viewer');
        $response->assertJsonPath('data.rol', 'vendedor');
        $response->assertJsonStructure([
            'data' => ['role', 'rol', 'permissions'],
        ]);
    }

    public function test_admin_can_update_user_permissions_with_role_alias(): void
    {
        $admin = User::factory()->create(['rol' => 'admin']);
        $targetUser = User::factory()->create(['rol' => 'vendedor']);
        Sanctum::actingAs($admin);

        $response = $this->putJson("/api/v1/auth/users/{$targetUser->id}/permissions", [
            'role' => 'editor',
            'permissions' => ['usuarios.ver', 'usuarios.editar'],
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('data.role', 'editor');
        $response->assertJsonPath('data.rol', 'desarrollador');

        $this->assertDatabaseHas('users', [
            'id' => $targetUser->id,
            'rol' => 'desarrollador',
        ]);
    }

    public function test_admin_cannot_self_demote_with_permissions_endpoint(): void
    {
        $admin = User::factory()->create(['rol' => 'admin']);
        Sanctum::actingAs($admin);

        $response = $this->putJson("/api/v1/auth/users/{$admin->id}/permissions", [
            'role' => 'viewer',
        ]);

        $response->assertStatus(422);
        $response->assertJsonPath('message', 'No puedes quitarte a ti mismo el rol de administrador.');

        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'rol' => 'admin',
        ]);
    }

    public function test_admin_can_list_available_permissions(): void
    {
        $admin = User::factory()->create(['rol' => 'admin']);
        Sanctum::actingAs($admin);

        $response = $this->getJson('/api/v1/auth/permissions');

        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
        $this->assertContains('users.read', $response->json('data'));
    }

    public function test_admin_can_delete_user(): void
    {
        $admin = User::factory()->create(['rol' => 'admin']);
        $targetUser = User::factory()->create(['rol' => 'vendedor']);
        Sanctum::actingAs($admin);

        $response = $this->deleteJson("/api/v1/auth/users/{$targetUser->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('users', ['id' => $targetUser->id]);
    }

    public function test_non_admin_cannot_delete_user(): void
    {
        $vendedor = User::factory()->create(['rol' => 'vendedor']);
        $targetUser = User::factory()->create(['rol' => 'desarrollador']);
        Sanctum::actingAs($vendedor);

        $response = $this->deleteJson("/api/v1/auth/users/{$targetUser->id}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('users', ['id' => $targetUser->id]);
    }

    public function test_admin_cannot_delete_himself(): void
    {
        $admin = User::factory()->create(['rol' => 'admin']);
        Sanctum::actingAs($admin);

        $response = $this->deleteJson("/api/v1/auth/users/{$admin->id}");

        $response->assertStatus(422);
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_admin_delete_is_idempotent_when_user_does_not_exist(): void
    {
        $admin = User::factory()->create(['rol' => 'admin']);
        Sanctum::actingAs($admin);

        $response = $this->deleteJson('/api/v1/auth/users/999999');

        $response->assertStatus(204);
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

    public function test_admin_cannot_self_demote_with_patch_role_endpoint(): void
    {
        $admin = User::factory()->create(['rol' => 'admin']);
        Sanctum::actingAs($admin);

        $response = $this->patchJson("/api/v1/auth/users/{$admin->id}/rol", [
            'rol' => 'vendedor',
        ]);

        $response->assertStatus(422);
        $response->assertJsonPath('message', 'No puedes quitarte a ti mismo el rol de administrador.');

        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'rol' => 'admin',
        ]);
    }
}
