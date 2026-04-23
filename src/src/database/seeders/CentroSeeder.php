<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Centro;

class CentroSeeder extends Seeder
{
    public function run(): void
    {
        // Centros educativos reales de la provincia de Huelva
        $centros = [
            ['nombre' => 'IES La Rábida', 'localidad' => 'Huelva'],
            ['nombre' => 'IES Fuentepiña', 'localidad' => 'Huelva'],
            ['nombre' => 'IES Pablo Neruda', 'localidad' => 'Huelva'],
            ['nombre' => 'IES Zurbarán', 'localidad' => 'Huelva'],
            ['nombre' => 'IES Padre Marchena', 'localidad' => 'Moguer'],
            ['nombre' => 'IES Juan Ramón Jiménez', 'localidad' => 'Moguer'],
            ['nombre' => 'IES Saltés', 'localidad' => 'Isla Cristina'],
            ['nombre' => 'Universidad de Huelva', 'localidad' => 'Huelva'],
        ];

        foreach ($centros as $centro) {
            Centro::create($centro);
        }
    }
}