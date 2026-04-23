<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // El orden importa por las relaciones entre tablas
        $this->call([
            CentroSeeder::class,
            NivelSeeder::class,
            CursoSeeder::class,
            AsignaturaSeeder::class,
        ]);
    }
}
