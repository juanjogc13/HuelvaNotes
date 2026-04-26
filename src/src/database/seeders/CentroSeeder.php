<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Centro;

class CentroSeeder extends Seeder
{
    public function run(): void
    {
        $centros = [
            // --- HUELVA CAPITAL ---
            ['nombre' => 'IES La Rábida', 'localidad' => 'Huelva'],
            ['nombre' => 'IES Fuentepiña', 'localidad' => 'Huelva'],
            ['nombre' => 'IES Pablo Neruda', 'localidad' => 'Huelva'],
            ['nombre' => 'IES Zurbarán', 'localidad' => 'Huelva'],
            ['nombre' => 'IES Sancti Petri', 'localidad' => 'Huelva'],
            ['nombre' => 'IES Diego de Guzmán y Quesada', 'localidad' => 'Huelva'],
            ['nombre' => 'IES Pérez Comendador', 'localidad' => 'Huelva'],
            ['nombre' => 'IES Tartessos', 'localidad' => 'Huelva'],
            ['nombre' => 'IES Odiel', 'localidad' => 'Huelva'],
            ['nombre' => 'IES Virgen de la Cinta', 'localidad' => 'Huelva'],
            ['nombre' => 'CIFP Concordia', 'localidad' => 'Huelva'],
            ['nombre' => 'CIFP Zafra', 'localidad' => 'Huelva'],
            ['nombre' => 'Colegio Salesiano San Francisco de Sales', 'localidad' => 'Huelva'],
            ['nombre' => 'Colegio La Salle', 'localidad' => 'Huelva'],
            ['nombre' => 'Colegio Santa María del Carmen', 'localidad' => 'Huelva'],
            ['nombre' => 'Colegio Inmaculada Concepción', 'localidad' => 'Huelva'],
            ['nombre' => 'Colegio San José', 'localidad' => 'Huelva'],
            ['nombre' => 'Colegio Divina Pastora', 'localidad' => 'Huelva'],
            ['nombre' => 'Universidad de Huelva', 'localidad' => 'Huelva'],

            // --- COMARCA METROPOLITANA ---
            ['nombre' => 'IES Saltés', 'localidad' => 'Punta Umbría'],
            ['nombre' => 'IES Punta Umbría', 'localidad' => 'Punta Umbría'],
            ['nombre' => 'IES Alonso Sánchez', 'localidad' => 'Palos de la Frontera'],
            ['nombre' => 'IES Doñana', 'localidad' => 'Almonte'],
            ['nombre' => 'IES El Portil', 'localidad' => 'Moguer'],
            ['nombre' => 'IES Padre Marchena', 'localidad' => 'Moguer'],
            ['nombre' => 'IES Juan Ramón Jiménez', 'localidad' => 'Moguer'],
            ['nombre' => 'IES San Jorge', 'localidad' => 'Palos de la Frontera'],

            // --- CONDADO ---
            ['nombre' => 'IES Aroche', 'localidad' => 'Aroche'],
            ['nombre' => 'IES Valdequioto', 'localidad' => 'Bonares'],
            ['nombre' => 'IES La Palma del Condado', 'localidad' => 'La Palma del Condado'],
            ['nombre' => 'IES Matalascañas', 'localidad' => 'Almonte'],
            ['nombre' => 'IES Delgado Hernández', 'localidad' => 'Bollullos Par del Condado'],
            ['nombre' => 'IES San Antonio', 'localidad' => 'Bollullos Par del Condado'],
            ['nombre' => 'IES Écija', 'localidad' => 'Rociana del Condado'],
            ['nombre' => 'IES Cartaya', 'localidad' => 'Cartaya'],
            ['nombre' => 'IES Lepe', 'localidad' => 'Lepe'],
            ['nombre' => 'IES Bahía de Pinos', 'localidad' => 'Lepe'],

            // --- COSTA ---
            ['nombre' => 'IES Isla Cristina', 'localidad' => 'Isla Cristina'],
            ['nombre' => 'IES Saltés', 'localidad' => 'Isla Cristina'],
            ['nombre' => 'IES Ayamonte', 'localidad' => 'Ayamonte'],
            ['nombre' => 'IES Juan de la Cosa', 'localidad' => 'Ayamonte'],
            ['nombre' => 'IES Cinco Villas', 'localidad' => 'Almonte'],

            // --- SIERRA ---
            ['nombre' => 'IES Aracena', 'localidad' => 'Aracena'],
            ['nombre' => 'IES Sierra de Aracena', 'localidad' => 'Aracena'],
            ['nombre' => 'IES Valverde del Camino', 'localidad' => 'Valverde del Camino'],
            ['nombre' => 'IES Nerva', 'localidad' => 'Nerva'],
            ['nombre' => 'IES Riotinto', 'localidad' => 'Minas de Riotinto'],
            ['nombre' => 'IES Zalamea la Real', 'localidad' => 'Zalamea la Real'],
            ['nombre' => 'IES Cortegana', 'localidad' => 'Cortegana'],
            ['nombre' => 'IES Cumbres Mayores', 'localidad' => 'Cumbres Mayores'],
        ];

        foreach ($centros as $centro) {
            Centro::create($centro);
        }
    }
}