<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRoleRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserRoleController extends Controller
{
    public function update(UpdateUserRoleRequest $request, User $user): JsonResponse
    {
        if ($request->user()?->rol !== 'admin') {
            return response()->json([
                'message' => 'No tienes permisos para cambiar roles.',
            ], 403);
        }

        $user->update([
            'rol' => $request->validated('rol'),
        ]);

        return response()->json([
            'message' => 'Rol actualizado correctamente.',
            'user' => $user,
        ]);
    }
}
