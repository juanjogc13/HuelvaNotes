<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Nivel;

class NivelSeeder extends Seeder
{
    public function run(): void
    {
        // Niveles educativos disponibles en la plataforma
        $niveles = [
            ['nombre' => 'ESO'],
            ['nombre' => 'Bachillerato'],
            ['nombre' => 'Formación Profesional'],
            ['nombre' => 'Universidad'],
        ];

        foreach ($niveles as $nivel) {
            Nivel::create($nivel);
        }
    }
}
