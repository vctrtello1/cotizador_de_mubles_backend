<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRoleRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserRoleController extends Controller
{
    public function update(UpdateUserRoleRequest $request, User $user): JsonResponse
    {
        if (!$request->user()?->hasPermission('users.update-role')) {
            return response()->json([
                'message' => 'No tienes permisos para cambiar roles.',
            ], 403);
        }

        if ((int) $request->user()->id === $user->id && $request->validated('rol') !== 'admin') {
            return response()->json([
                'message' => 'No puedes quitarte a ti mismo el rol de administrador.',
            ], 422);
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
