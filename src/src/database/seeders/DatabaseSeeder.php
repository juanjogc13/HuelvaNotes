<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // El orden importa por las relaciones entre tablas
        $this->call([
            CentroOficialSeeder::class,
            NivelSeeder::class,
            UserSeeder::class,
            CursoSeeder::class,
            AsignaturaSeeder::class,
            CatalogoAcademicoSeeder::class,
        ]);
    }
}