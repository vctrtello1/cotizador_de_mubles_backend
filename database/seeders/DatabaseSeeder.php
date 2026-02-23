<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            MaterialSeeder::class,
            HerrajeSeeder::class,
            ComponenteSeeder::class,
            ModuloSeeder::class,
            EstructuraSeeder::class,
            AcabadoTableroSeeder::class,
            AcabadoCubreCantoSeeder::class,
            GolaSeeder::class,
            CorrederaSeeder::class,
            CompasAbatibleSeeder::class,
            PuertaSeeder::class,
            CantidadPorHerrajeSeeder::class,
            CantidadPorComponenteSeeder::class,
            AccesorioPorComponenteSeeder::class,
            MaterialesPorComponenteSeeder::class,
            CotizacionSeeder::class,
        ]);
    }
}
