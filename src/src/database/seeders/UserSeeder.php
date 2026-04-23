<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Centro;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Obtenemos todos los IDs de los centros para repartir usuarios
        $centroIds = Centro::pluck('id')->toArray();

        // Tu usuario administrador para desarrollo
        User::create([
            'name' => 'Juanjo Admin',
            'email' => 'admin@huelvanotes.com',
            'password' => Hash::make('123'),
            'puntos' => 500, // Te damos margen para descargar cosas
            'centro_id' => $centroIds[0] ?? null, // Te asigna al primer centro de la lista
        ]);

        // Generamos 10 usuarios aleatorios
        User::factory(10)->create([
            // A cada uno le asignamos un centro_id aleatorio de los que existen
            'centro_id' => function () use ($centroIds) {
                return $centroIds[array_rand($centroIds)];
            },
        ]);
    }
}
