<?php

namespace Database\Seeders;

use App\Models\Centro;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CentroOficialSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Seeder oficial de centros de Huelva
        |--------------------------------------------------------------------------
        |
        | Este seeder está pensado para leer un CSV oficial de la Junta de Andalucía
        | con el directorio de centros docentes no universitarios.
        |
        | Ruta esperada:
        | database/seeders/data/centros_docentes_andalucia.csv
        |
        | El seeder filtra automáticamente los centros de la provincia de Huelva.
        |
        */

        $csvPath = database_path('seeders/data/centros_docentes_andalucia.csv');

        if (!File::exists($csvPath)) {
            $this->command?->warn('No se ha encontrado el CSV oficial en: ' . $csvPath);
            $this->command?->warn('Se cargarán solo centros base de Huelva como respaldo.');

            $this->cargarCentrosBaseHuelva();
            $this->cargarUniversidadHuelva();

            return;
        }

        $handle = fopen($csvPath, 'r');

        if ($handle === false) {
            $this->command?->error('No se pudo abrir el CSV: ' . $csvPath);
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Detectar separador
        |--------------------------------------------------------------------------
        |
        | Algunos CSV oficiales vienen separados por ; y otros por ,
        |
        */

        $primeraLinea = fgets($handle);
        rewind($handle);

        $delimiter = substr_count($primeraLinea, ';') > substr_count($primeraLinea, ',') ? ';' : ',';

        /*
        |--------------------------------------------------------------------------
        | Leer cabecera
        |--------------------------------------------------------------------------
        */

        $headers = fgetcsv($handle, 0, $delimiter);

        if (!$headers) {
            fclose($handle);
            $this->command?->error('El CSV no tiene cabecera válida.');
            return;
        }

        $headers = array_map(fn ($h) => $this->normalizarClave($h), $headers);

        $insertados = 0;
        $saltados = 0;

        while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
            if (count($row) !== count($headers)) {
                $saltados++;
                continue;
            }

            $data = array_combine($headers, $row);

            if (!$data) {
                $saltados++;
                continue;
            }

            $provincia = $this->obtenerCampo($data, [
                'provincia',
                'nombre_provincia',
                'denominacion_provincia',
            ]);

            if (!$this->esHuelva($provincia)) {
                continue;
            }

            $nombre = $this->obtenerCampo($data, [
                'nombre',
                'nombre_centro',
                'denominacion',
                'denominacion_centro',
                'centro',
            ]);

            $localidad = $this->obtenerCampo($data, [
                'localidad',
                'nombre_localidad',
                'denominacion_localidad',
                'municipio',
                'nombre_municipio',
                'denominacion_municipio',
            ]);

            if (!$nombre || !$localidad) {
                $saltados++;
                continue;
            }

            $nombre = $this->limpiarTexto($nombre);
            $localidad = $this->limpiarTexto($localidad);

            Centro::firstOrCreate([
                'nombre' => $nombre,
                'localidad' => $localidad,
            ]);

            $insertados++;
        }

        fclose($handle);

        /*
        |--------------------------------------------------------------------------
        | Universidad de Huelva
        |--------------------------------------------------------------------------
        |
        | El directorio oficial de la Junta usado aquí es no universitario.
        | Por eso añadimos la UHU manualmente.
        |
        */

        $this->cargarUniversidadHuelva();

        $this->command?->info("Centros procesados de Huelva: {$insertados}");
        $this->command?->info("Filas saltadas por formato incompleto: {$saltados}");
    }

    private function cargarCentrosBaseHuelva(): void
    {
        $centros = [
            ['nombre' => 'IES La Rábida', 'localidad' => 'Huelva'],
            ['nombre' => 'IES Fuentepiña', 'localidad' => 'Huelva'],
            ['nombre' => 'IES Pablo Neruda', 'localidad' => 'Huelva'],
            ['nombre' => 'IES Zurbarán', 'localidad' => 'Huelva'],
            ['nombre' => 'IES Diego de Guzmán y Quesada', 'localidad' => 'Huelva'],
            ['nombre' => 'IES Pérez Comendador', 'localidad' => 'Huelva'],
            ['nombre' => 'IES Tartessos', 'localidad' => 'Huelva'],
            ['nombre' => 'IES Odiel', 'localidad' => 'Huelva'],
            ['nombre' => 'IES Virgen de la Cinta', 'localidad' => 'Huelva'],
            ['nombre' => 'CIFP Zafra', 'localidad' => 'Huelva'],
            ['nombre' => 'CIFP Profesor Rodríguez Casado', 'localidad' => 'La Rábida'],
            ['nombre' => 'CIFP Marítimo Zaporito', 'localidad' => 'Huelva'],
            ['nombre' => 'Colegio Salesiano Cristo Sacerdote', 'localidad' => 'Huelva'],
            ['nombre' => 'Colegio La Salle', 'localidad' => 'Huelva'],
            ['nombre' => 'Colegio Montessori', 'localidad' => 'Huelva'],

            ['nombre' => 'IES Saltés', 'localidad' => 'Punta Umbría'],
            ['nombre' => 'IES Bitácora', 'localidad' => 'Punta Umbría'],
            ['nombre' => 'IES Padre José Miravent', 'localidad' => 'Isla Cristina'],
            ['nombre' => 'IES Galeón', 'localidad' => 'Isla Cristina'],
            ['nombre' => 'IES Guadiana', 'localidad' => 'Ayamonte'],
            ['nombre' => 'IES González de Aguilar', 'localidad' => 'Ayamonte'],
            ['nombre' => 'IES La Arboleda', 'localidad' => 'Lepe'],
            ['nombre' => 'IES El Sur', 'localidad' => 'Lepe'],
            ['nombre' => 'IES Rafael Reyes', 'localidad' => 'Cartaya'],
            ['nombre' => 'IES Sebastián Fernández', 'localidad' => 'Cartaya'],
            ['nombre' => 'IES Juan Ramón Jiménez', 'localidad' => 'Moguer'],
            ['nombre' => 'IES Francisco Garfias', 'localidad' => 'Moguer'],
            ['nombre' => 'IES Carabelas', 'localidad' => 'Palos de la Frontera'],
            ['nombre' => 'IES San Jorge', 'localidad' => 'Palos de la Frontera'],
            ['nombre' => 'IES Doñana', 'localidad' => 'Almonte'],
            ['nombre' => 'IES La Ribera', 'localidad' => 'Almonte'],
            ['nombre' => 'IES Matalascañas', 'localidad' => 'Matalascañas'],
            ['nombre' => 'IES Delgado Hernández', 'localidad' => 'Bollullos Par del Condado'],
            ['nombre' => 'IES San Antonio', 'localidad' => 'Bollullos Par del Condado'],
            ['nombre' => 'IES Catedrático Pulido Rubio', 'localidad' => 'Bonares'],
            ['nombre' => 'IES La Palma', 'localidad' => 'La Palma del Condado'],
            ['nombre' => 'IES Virgen del Socorro', 'localidad' => 'Rociana del Condado'],
            ['nombre' => 'IES Campo de Tejada', 'localidad' => 'Paterna del Campo'],
            ['nombre' => 'IES Cuenca Minera', 'localidad' => 'Minas de Riotinto'],
            ['nombre' => 'IES Vázquez Díaz', 'localidad' => 'Nerva'],
            ['nombre' => 'IES Don Bosco', 'localidad' => 'Valverde del Camino'],
            ['nombre' => 'IES Diego Angulo', 'localidad' => 'Valverde del Camino'],
            ['nombre' => 'IES Silos', 'localidad' => 'Zalamea la Real'],
            ['nombre' => 'IES San Blas', 'localidad' => 'Aracena'],
            ['nombre' => 'IES Sierra de Aracena', 'localidad' => 'Aracena'],
            ['nombre' => 'IES San José', 'localidad' => 'Cortegana'],
            ['nombre' => 'IES Catedrático Francisco Javier de Uriarte', 'localidad' => 'Cumbres Mayores'],
            ['nombre' => 'IES Puerta de Andalucía', 'localidad' => 'Santa Olalla del Cala'],
            ['nombre' => 'IES Odón Betanzos Palacios', 'localidad' => 'Mazagón'],
        ];

        foreach ($centros as $centro) {
            Centro::firstOrCreate([
                'nombre' => $centro['nombre'],
                'localidad' => $centro['localidad'],
            ]);
        }
    }

    private function cargarUniversidadHuelva(): void
    {
        Centro::firstOrCreate([
            'nombre' => 'Universidad de Huelva',
            'localidad' => 'Huelva',
        ]);
    }

    private function obtenerCampo(array $data, array $posiblesClaves): ?string
    {
        foreach ($posiblesClaves as $clave) {
            $claveNormalizada = $this->normalizarClave($clave);

            if (array_key_exists($claveNormalizada, $data)) {
                $valor = trim((string) $data[$claveNormalizada]);

                if ($valor !== '') {
                    return $valor;
                }
            }
        }

        return null;
    }

    private function esHuelva(?string $provincia): bool
    {
        if (!$provincia) {
            return false;
        }

        $provincia = mb_strtolower(trim($provincia));

        return str_contains($provincia, 'huelva');
    }

    private function limpiarTexto(string $texto): string
    {
        $texto = trim($texto);
        $texto = preg_replace('/\s+/', ' ', $texto);

        return $texto;
    }

    private function normalizarClave(string $clave): string
    {
        $clave = trim($clave);
        $clave = mb_strtolower($clave);

        $buscar = ['á', 'é', 'í', 'ó', 'ú', 'ü', 'ñ'];
        $reemplazar = ['a', 'e', 'i', 'o', 'u', 'u', 'n'];

        $clave = str_replace($buscar, $reemplazar, $clave);
        $clave = preg_replace('/[^a-z0-9]+/', '_', $clave);
        $clave = trim($clave, '_');

        return $clave;
    }
}