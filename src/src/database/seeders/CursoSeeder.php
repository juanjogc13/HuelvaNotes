<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Curso;

class CursoSeeder extends Seeder
{
    public function run(): void
    {
        // Cursos de ESO (nivel_id 1)
        $cursosESO = [
            ['nombre' => '1º ESO', 'nivel_id' => 1],
            ['nombre' => '2º ESO', 'nivel_id' => 1],
            ['nombre' => '3º ESO', 'nivel_id' => 1],
            ['nombre' => '4º ESO', 'nivel_id' => 1],
        ];

        // Cursos de Bachillerato (nivel_id 2)
        $cursosBach = [
            ['nombre' => '1º Bachillerato', 'nivel_id' => 2],
            ['nombre' => '2º Bachillerato', 'nivel_id' => 2],
        ];

        // Cursos de FP (nivel_id 3)
        $cursosFP = [
            ['nombre' => '1º FP', 'nivel_id' => 3],
            ['nombre' => '2º FP', 'nivel_id' => 3],
        ];

        // Cursos de Universidad (nivel_id 4)
        $cursosUni = [
            ['nombre' => '1º Universidad', 'nivel_id' => 4],
            ['nombre' => '2º Universidad', 'nivel_id' => 4],
            ['nombre' => '3º Universidad', 'nivel_id' => 4],
            ['nombre' => '4º Universidad', 'nivel_id' => 4],
        ];

        foreach (array_merge($cursosESO, $cursosBach, $cursosFP, $cursosUni) as $curso) {
            Curso::create($curso);
        }
    }
}
