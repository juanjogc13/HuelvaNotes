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

        // Usuario administrador principal
        User::create([
            'name'      => 'Juanjo Admin',
            'email'     => 'admin@huelvanotes.com',
            'password'  => Hash::make('Admin1234!'),
            'puntos'    => 500,
            'centro_id' => $centroIds[0] ?? null,
            'rol'       => 'admin',
        ]);

        // Usuario moderador de prueba
        User::create([
            'name'      => 'Moderador HuelvaNotes',
            'email'     => 'moderador@huelvanotes.com',
            'password'  => Hash::make('Mod1234!'),
            'puntos'    => 100,
            'centro_id' => $centroIds[1] ?? null,
            'rol'       => 'moderador',
        ]);

        // Generamos 10 usuarios normales aleatorios
        User::factory(10)->create([
            'centro_id' => function () use ($centroIds) {
                return $centroIds[array_rand($centroIds)];
            },
            'rol' => 'usuario',
        ]);
    }
}