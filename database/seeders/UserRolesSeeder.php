<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserRolesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@cotizador.local'],
            [
                'name' => 'Administrador',
                'rol' => 'admin',
                'password' => Hash::make('Admin12345!'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'vendedor@cotizador.local'],
            [
                'name' => 'Vendedor',
                'rol' => 'vendedor',
                'password' => Hash::make('Vendedor123!'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'dev@cotizador.local'],
            [
                'name' => 'Desarrollador',
                'rol' => 'desarrollador',
                'password' => Hash::make('Desarrollador123!'),
            ]
        );
    }
}
