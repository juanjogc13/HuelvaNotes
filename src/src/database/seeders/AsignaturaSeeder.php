<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asignatura;

class AsignaturaSeeder extends Seeder
{
    public function run(): void
    {
        // Asignaturas comunes de ESO (cursos 1 al 4)
        $asignaturasESO = [
            ['nombre' => 'Matemáticas', 'curso_id' => 1],
            ['nombre' => 'Lengua Castellana', 'curso_id' => 1],
            ['nombre' => 'Inglés', 'curso_id' => 1],
            ['nombre' => 'Ciencias Naturales', 'curso_id' => 1],
            ['nombre' => 'Historia', 'curso_id' => 1],
            ['nombre' => 'Matemáticas', 'curso_id' => 2],
            ['nombre' => 'Lengua Castellana', 'curso_id' => 2],
            ['nombre' => 'Inglés', 'curso_id' => 2],
            ['nombre' => 'Física y Química', 'curso_id' => 2],
            ['nombre' => 'Historia', 'curso_id' => 2],
            ['nombre' => 'Matemáticas', 'curso_id' => 3],
            ['nombre' => 'Lengua Castellana', 'curso_id' => 3],
            ['nombre' => 'Inglés', 'curso_id' => 3],
            ['nombre' => 'Física y Química', 'curso_id' => 3],
            ['nombre' => 'Biología', 'curso_id' => 3],
            ['nombre' => 'Matemáticas', 'curso_id' => 4],
            ['nombre' => 'Lengua Castellana', 'curso_id' => 4],
            ['nombre' => 'Inglés', 'curso_id' => 4],
            ['nombre' => 'Física y Química', 'curso_id' => 4],
            ['nombre' => 'Biología', 'curso_id' => 4],
        ];

        // Asignaturas de Bachillerato (cursos 5 y 6)
        $asignaturasBach = [
            ['nombre' => 'Matemáticas I', 'curso_id' => 5],
            ['nombre' => 'Lengua Castellana', 'curso_id' => 5],
            ['nombre' => 'Inglés', 'curso_id' => 5],
            ['nombre' => 'Física', 'curso_id' => 5],
            ['nombre' => 'Historia de España', 'curso_id' => 5],
            ['nombre' => 'Matemáticas II', 'curso_id' => 6],
            ['nombre' => 'Lengua Castellana', 'curso_id' => 6],
            ['nombre' => 'Inglés', 'curso_id' => 6],
            ['nombre' => 'Física', 'curso_id' => 6],
            ['nombre' => 'Historia del Arte', 'curso_id' => 6],
        ];

        // Asignaturas de FP (cursos 7 y 8)
        $asignaturasFP = [
            ['nombre' => 'Programación', 'curso_id' => 7],
            ['nombre' => 'Bases de Datos', 'curso_id' => 7],
            ['nombre' => 'Sistemas Informáticos', 'curso_id' => 7],
            ['nombre' => 'Desarrollo Web', 'curso_id' => 8],
            ['nombre' => 'Empresa e Iniciativa Emprendedora', 'curso_id' => 8],
        ];

        foreach (array_merge($asignaturasESO, $asignaturasBach, $asignaturasFP) as $asignatura) {
            Asignatura::create($asignatura);
        }
    }
}
