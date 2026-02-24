<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private function roleAliasFromRol(string $rol): string
    {
        return match ($rol) {
            'admin' => 'admin',
            'desarrollador' => 'editor',
            default => 'viewer',
        };
    }

    private function rolFromIncomingRole(?string $role, ?string $rol): ?string
    {
        $value = $rol ?? $role;

        if (!$value) {
            return null;
        }

        return match ($value) {
            'admin' => 'admin',
            'editor', 'desarrollador' => 'desarrollador',
            'viewer', 'vendedor' => 'vendedor',
            default => null,
        };
    }

    private function serializeUser(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'rol' => $user->rol,
            'role' => $this->roleAliasFromRol($user->rol),
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ];
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'rol' => 'vendedor',
            'password' => Hash::make($validated['password']),
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::query()->where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales proporcionadas son incorrectas.'],
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
            'permissions' => $request->user()?->permissions() ?? [],
        ]);
    }

    public function users(Request $request)
    {
        if (!$request->user()?->hasPermission('users.read')) {
            return response()->json([
                'message' => 'No tienes permisos para consultar usuarios.',
            ], 403);
        }

        $users = User::query()
            ->select(['id', 'name', 'email', 'rol', 'created_at', 'updated_at'])
            ->orderBy('name')
            ->get();

        return response()->json([
            'data' => $users->map(fn (User $user) => $this->serializeUser($user))->values(),
        ]);
    }

    public function showUser(Request $request, int $userId)
    {
        if (!$request->user()?->hasPermission('users.read')) {
            return response()->json([
                'message' => 'No tienes permisos para consultar usuarios.',
            ], 403);
        }

        $user = User::query()->findOrFail($userId);

        return response()->json([
            'data' => $this->serializeUser($user),
        ]);
    }

    public function updateUser(Request $request, int $userId)
    {
        if (!$request->user()?->hasPermission('users.update-role')) {
            return response()->json([
                'message' => 'No tienes permisos para actualizar usuarios.',
            ], 403);
        }

        $user = User::query()->findOrFail($userId);

        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'rol' => ['sometimes', 'string', 'in:admin,vendedor,desarrollador,viewer,editor'],
            'role' => ['sometimes', 'string', 'in:admin,vendedor,desarrollador,viewer,editor'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $data = [];

        if (array_key_exists('name', $validated)) {
            $data['name'] = $validated['name'];
        }

        if (array_key_exists('email', $validated)) {
            $data['email'] = $validated['email'];
        }

        $normalizedRol = $this->rolFromIncomingRole($validated['role'] ?? null, $validated['rol'] ?? null);
        if ($normalizedRol) {
            if ((int) $request->user()->id === $user->id && $normalizedRol !== 'admin') {
                return response()->json([
                    'message' => 'No puedes quitarte a ti mismo el rol de administrador.',
                ], 422);
            }

            $data['rol'] = $normalizedRol;
        }

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        if (!empty($data)) {
            $user->update($data);
        }

        $user->refresh();

        return response()->json([
            'message' => 'Usuario actualizado correctamente.',
            'data' => $this->serializeUser($user),
        ]);
    }

    public function permissions(Request $request)
    {
        if (!$request->user()?->hasPermission('users.read')) {
            return response()->json([
                'message' => 'No tienes permisos para consultar permisos.',
            ], 403);
        }

        $permissions = collect(config('role_permissions', []))
            ->flatten()
            ->unique()
            ->values();

        return response()->json([
            'data' => $permissions,
        ]);
    }

    public function userPermissions(Request $request, int $userId)
    {
        if (!$request->user()?->hasPermission('users.read')) {
            return response()->json([
                'message' => 'No tienes permisos para consultar permisos de usuarios.',
            ], 403);
        }

        $user = User::query()->findOrFail($userId);

        return response()->json([
            'data' => [
                'role' => $this->roleAliasFromRol($user->rol),
                'rol' => $user->rol,
                'permissions' => $user->permissions(),
            ],
        ]);
    }

    public function updateUserPermissions(Request $request, int $userId)
    {
        if (!$request->user()?->hasPermission('users.update-role')) {
            return response()->json([
                'message' => 'No tienes permisos para actualizar permisos de usuarios.',
            ], 403);
        }

        $user = User::query()->findOrFail($userId);

        $validated = $request->validate([
            'role' => ['sometimes', 'string', 'in:admin,vendedor,desarrollador,viewer,editor'],
            'rol' => ['sometimes', 'string', 'in:admin,vendedor,desarrollador,viewer,editor'],
            'permissions' => ['sometimes', 'array'],
            'permissions.*' => ['string'],
        ]);

        $normalizedRol = $this->rolFromIncomingRole($validated['role'] ?? null, $validated['rol'] ?? null);
        if ($normalizedRol) {
            if ((int) $request->user()->id === $user->id && $normalizedRol !== 'admin') {
                return response()->json([
                    'message' => 'No puedes quitarte a ti mismo el rol de administrador.',
                ], 422);
            }

            $user->update(['rol' => $normalizedRol]);
            $user->refresh();
        }

        return response()->json([
            'message' => 'Permisos del usuario actualizados correctamente.',
            'data' => [
                'role' => $this->roleAliasFromRol($user->rol),
                'rol' => $user->rol,
                'permissions' => $user->permissions(),
            ],
        ]);
    }

    public function destroyUser(Request $request, int $userId)
    {
        if (!$request->user()?->hasPermission('users.delete')) {
            return response()->json([
                'message' => 'No tienes permisos para eliminar usuarios.',
            ], 403);
        }

        if ((int) $request->user()->id === $userId) {
            return response()->json([
                'message' => 'No puedes eliminar tu propio usuario.',
            ], 422);
        }

        User::query()->whereKey($userId)->delete();

        return response()->noContent();
    }

    public function logout(Request $request)
    {
        $token = $request->user()?->currentAccessToken();

        if ($token) {
            $token->delete();
        }

        return response()->json([
            'message' => 'Sesión cerrada correctamente.',
        ]);
    }
}
