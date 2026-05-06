<?php

namespace Database\Seeders;

use App\Models\Asignatura;
use App\Models\Centro;
use App\Models\Curso;
use App\Models\Nivel;
use App\Models\Titulacion;
use Illuminate\Database\Seeder;

class CatalogoAcademicoSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | NIVELES
        |--------------------------------------------------------------------------
        */

        $eso = Nivel::firstOrCreate(['nombre' => 'ESO']);
        $bachillerato = Nivel::firstOrCreate(['nombre' => 'Bachillerato']);
        $fp = Nivel::firstOrCreate(['nombre' => 'Formación Profesional']);
        $universidad = Nivel::firstOrCreate(['nombre' => 'Universidad']);

        /*
        |--------------------------------------------------------------------------
        | CENTROS
        |--------------------------------------------------------------------------
        */

        $centros = [
            // Huelva capital
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
            ['nombre' => 'Colegio La Hispanidad', 'localidad' => 'Huelva'],
            ['nombre' => 'Colegio Montessori', 'localidad' => 'Huelva'],
            ['nombre' => 'Colegio La Salle', 'localidad' => 'Huelva'],
            ['nombre' => 'Colegio Santa María de Gracia', 'localidad' => 'Huelva'],
            ['nombre' => 'Colegio Cardenal Spínola', 'localidad' => 'Huelva'],
            ['nombre' => 'Universidad de Huelva', 'localidad' => 'Huelva'],

            // Provincia
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
            ['nombre' => 'IES San Sebastián', 'localidad' => 'Huelva'],
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
            ['nombre' => 'IES Juan Ramón Jiménez', 'localidad' => 'La Palma del Condado'],
            ['nombre' => 'IES Virgen del Socorro', 'localidad' => 'Rociana del Condado'],
            ['nombre' => 'IES Campo de Tejada', 'localidad' => 'Paterna del Campo'],
            ['nombre' => 'IES Cuenca Minera', 'localidad' => 'Minas de Riotinto'],
            ['nombre' => 'IES Vázquez Díaz', 'localidad' => 'Nerva'],
            ['nombre' => 'IES Don Bosco', 'localidad' => 'Valverde del Camino'],
            ['nombre' => 'IES Diego Angulo', 'localidad' => 'Valverde del Camino'],
            ['nombre' => 'IES Silos', 'localidad' => 'Zalamea la Real'],
            ['nombre' => 'IES San Blas', 'localidad' => 'Aracena'],
            ['nombre' => 'IES Sierra de Aracena', 'localidad' => 'Aracena'],
            ['nombre' => 'IES José Caballero', 'localidad' => 'Huelva'],
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

        $uhu = Centro::firstOrCreate([
            'nombre' => 'Universidad de Huelva',
            'localidad' => 'Huelva',
        ]);

        /*
        |--------------------------------------------------------------------------
        | UNIVERSIDAD DE HUELVA - GRADOS Y DOBLES GRADOS
        |--------------------------------------------------------------------------
        */

        $gradosUhu = [
            // Humanidades
            'Grado en Estudios Ingleses',
            'Grado en Filología Hispánica',
            'Grado en Gestión Cultural',
            'Grado en Historia',
            'Grado en Humanidades',
            'Doble Grado en Estudios Ingleses y Filología Hispánica',

            // Ciencias y Ciencias de la Salud
            'Grado en Ciencias Ambientales',
            'Grado en Enfermería',
            'Grado en Física',
            'Grado en Geología',
            'Grado en Medicina',
            'Grado en Psicología',
            'Grado en Química',
            'Doble Grado en Geología y Ciencias Ambientales',
            'Doble Grado en Ciencias Ambientales e Ingeniería en Explotación Forestal del Medio Natural',

            // Ciencias Sociales y Jurídicas
            'Grado en Administración y Dirección de Empresas',
            'Grado en Ciencias de la Actividad Física y del Deporte',
            'Grado en Derecho',
            'Grado en Educación Infantil',
            'Grado en Educación Primaria',
            'Grado en Educación Social',
            'Grado en Finanzas y Contabilidad',
            'Grado en Relaciones Laborales y Recursos Humanos',
            'Grado en Trabajo Social',
            'Grado en Turismo',
            'Doble Grado en Administración y Dirección de Empresas y Derecho',
            'Doble Grado en Administración y Dirección de Empresas y Finanzas y Contabilidad',
            'Doble Grado en Administración y Dirección de Empresas y Turismo',

            // Ingenierías
            'Grado en Ingeniería Agrícola',
            'Grado en Ingeniería Eléctrica',
            'Grado en Ingeniería Electrónica Industrial',
            'Grado en Ingeniería Minera',
            'Grado en Ingeniería de Energías Renovables y Tecnologías del Hidrógeno',
            'Grado en Ingeniería Forestal y del Medio Natural',
            'Grado en Ingeniería Informática',
            'Grado en Ingeniería Mecánica',
            'Grado en Ingeniería Química Industrial',
            'Doble Grado en Ingeniería Eléctrica e Ingeniería de Energías Renovables y Tecnologías del Hidrógeno',
            'Doble Grado en Ingeniería Electrónica Industrial e Ingeniería Mecánica',
            'Doble Grado en Ingeniería Forestal y Medio Natural y Ciencias Ambientales',
            'Doble Grado en Ingeniería Mecánica e Ingeniería Minera',
        ];

        foreach ($gradosUhu as $grado) {
            $titulacion = $this->crearTitulacion($grado, $universidad->id, $uhu->id);

            $cursos = str_starts_with($grado, 'Doble Grado')
                ? ['1º', '2º', '3º', '4º', '5º']
                : ['1º', '2º', '3º', '4º'];

            foreach ($cursos as $cursoNombre) {
                $curso = $this->crearCurso($cursoNombre . ' ' . $grado, $universidad->id, $titulacion->id);

                $this->crearAsignaturas($curso->id, [
                    'Asignatura general',
                    'Apuntes de teoría',
                    'Prácticas',
                    'Problemas y ejercicios',
                    'Exámenes',
                    'Trabajos y proyectos',
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | ESO Y BACHILLERATO PARA CENTROS NO UNIVERSITARIOS
        |--------------------------------------------------------------------------
        */

        $centrosNoUniversitarios = Centro::where('nombre', '!=', 'Universidad de Huelva')->get();

        foreach ($centrosNoUniversitarios as $centro) {
            $titulacionESO = $this->crearTitulacion('Educación Secundaria Obligatoria', $eso->id, $centro->id);

            foreach (['1º ESO', '2º ESO', '3º ESO', '4º ESO'] as $cursoNombre) {
                $curso = $this->crearCurso($cursoNombre, $eso->id, $titulacionESO->id);

                $this->crearAsignaturas($curso->id, [
                    'Lengua Castellana y Literatura',
                    'Matemáticas',
                    'Inglés',
                    'Geografía e Historia',
                    'Biología y Geología',
                    'Física y Química',
                    'Educación Física',
                    'Tecnología',
                    'Francés',
                    'Religión / Atención Educativa',
                ]);
            }

            $bachModalidades = [
                'Bachillerato de Ciencias y Tecnología' => [
                    '1º Bachillerato' => [
                        'Lengua Castellana y Literatura I',
                        'Inglés I',
                        'Filosofía',
                        'Educación Física',
                        'Matemáticas I',
                        'Física y Química',
                        'Biología, Geología y Ciencias Ambientales',
                        'Dibujo Técnico I',
                        'Tecnología e Ingeniería I',
                    ],
                    '2º Bachillerato' => [
                        'Lengua Castellana y Literatura II',
                        'Inglés II',
                        'Historia de España',
                        'Historia de la Filosofía',
                        'Matemáticas II',
                        'Física',
                        'Química',
                        'Biología',
                        'Dibujo Técnico II',
                        'Tecnología e Ingeniería II',
                    ],
                ],
                'Bachillerato de Humanidades y Ciencias Sociales' => [
                    '1º Bachillerato' => [
                        'Lengua Castellana y Literatura I',
                        'Inglés I',
                        'Filosofía',
                        'Educación Física',
                        'Latín I',
                        'Griego I',
                        'Matemáticas Aplicadas a las Ciencias Sociales I',
                        'Economía',
                        'Historia del Mundo Contemporáneo',
                    ],
                    '2º Bachillerato' => [
                        'Lengua Castellana y Literatura II',
                        'Inglés II',
                        'Historia de España',
                        'Historia de la Filosofía',
                        'Latín II',
                        'Griego II',
                        'Matemáticas Aplicadas a las Ciencias Sociales II',
                        'Empresa y Diseño de Modelos de Negocio',
                        'Geografía',
                        'Historia del Arte',
                    ],
                ],
                'Bachillerato de Artes' => [
                    '1º Bachillerato' => [
                        'Lengua Castellana y Literatura I',
                        'Inglés I',
                        'Filosofía',
                        'Educación Física',
                        'Dibujo Artístico I',
                        'Cultura Audiovisual',
                        'Volumen',
                        'Proyectos Artísticos',
                    ],
                    '2º Bachillerato' => [
                        'Lengua Castellana y Literatura II',
                        'Inglés II',
                        'Historia de España',
                        'Historia de la Filosofía',
                        'Dibujo Artístico II',
                        'Diseño',
                        'Fundamentos Artísticos',
                        'Técnicas de Expresión Gráfico-Plástica',
                    ],
                ],
            ];

            foreach ($bachModalidades as $modalidad => $cursosBach) {
                $titulacionBach = $this->crearTitulacion($modalidad, $bachillerato->id, $centro->id);

                foreach ($cursosBach as $cursoNombre => $asignaturas) {
                    $curso = $this->crearCurso($cursoNombre . ' - ' . $modalidad, $bachillerato->id, $titulacionBach->id);
                    $this->crearAsignaturas($curso->id, $asignaturas);
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | FORMACIÓN PROFESIONAL
        |--------------------------------------------------------------------------
        */

        $centrosFP = Centro::whereIn('nombre', [
            'IES Fuentepiña',
            'IES La Rábida',
            'IES Pablo Neruda',
            'IES Odiel',
            'IES Virgen de la Cinta',
            'CIFP Zafra',
            'CIFP Profesor Rodríguez Casado',
            'CIFP Marítimo Zaporito',
            'Colegio Salesiano Cristo Sacerdote',
            'Colegio Montessori',
            'IES La Arboleda',
            'IES El Sur',
            'IES Rafael Reyes',
            'IES Juan Ramón Jiménez',
            'IES Doñana',
            'IES Delgado Hernández',
            'IES Don Bosco',
            'IES San Blas',
            'IES Cuenca Minera',
        ])->get();

        $ciclosFP = [
            'CFGM Sistemas Microinformáticos y Redes' => [
                '1º FP' => [
                    'Montaje y mantenimiento de equipos',
                    'Sistemas operativos monopuesto',
                    'Aplicaciones ofimáticas',
                    'Redes locales',
                    'Itinerario personal para la empleabilidad I',
                ],
                '2º FP' => [
                    'Sistemas operativos en red',
                    'Servicios en red',
                    'Seguridad informática',
                    'Aplicaciones web',
                    'Empresa e iniciativa emprendedora',
                    'Proyecto intermodular',
                ],
            ],
            'CFGS Desarrollo de Aplicaciones Multiplataforma' => [
                '1º FP' => [
                    'Programación',
                    'Bases de datos',
                    'Lenguajes de marcas y sistemas de gestión de información',
                    'Sistemas informáticos',
                    'Entornos de desarrollo',
                    'Itinerario personal para la empleabilidad I',
                ],
                '2º FP' => [
                    'Acceso a datos',
                    'Desarrollo de interfaces',
                    'Programación multimedia y dispositivos móviles',
                    'Programación de servicios y procesos',
                    'Sistemas de gestión empresarial',
                    'Proyecto intermodular',
                ],
            ],
            'CFGS Desarrollo de Aplicaciones Web' => [
                '1º FP' => [
                    'Programación',
                    'Bases de datos',
                    'Lenguajes de marcas y sistemas de gestión de información',
                    'Sistemas informáticos',
                    'Entornos de desarrollo',
                    'Itinerario personal para la empleabilidad I',
                ],
                '2º FP' => [
                    'Desarrollo web en entorno cliente',
                    'Desarrollo web en entorno servidor',
                    'Despliegue de aplicaciones web',
                    'Diseño de interfaces web',
                    'Proyecto intermodular',
                    'Empresa e iniciativa emprendedora',
                ],
            ],
            'CFGS Administración de Sistemas Informáticos en Red' => [
                '1º FP' => [
                    'Implantación de sistemas operativos',
                    'Planificación y administración de redes',
                    'Fundamentos de hardware',
                    'Gestión de bases de datos',
                    'Lenguajes de marcas y sistemas de gestión de información',
                    'Itinerario personal para la empleabilidad I',
                ],
                '2º FP' => [
                    'Administración de sistemas operativos',
                    'Servicios de red e internet',
                    'Implantación de aplicaciones web',
                    'Administración de sistemas gestores de bases de datos',
                    'Seguridad y alta disponibilidad',
                    'Proyecto intermodular',
                ],
            ],
            'CFGM Gestión Administrativa' => [
                '1º FP' => [
                    'Comunicación empresarial y atención al cliente',
                    'Operaciones administrativas de compraventa',
                    'Empresa y administración',
                    'Tratamiento informático de la información',
                    'Técnica contable',
                    'Itinerario personal para la empleabilidad I',
                ],
                '2º FP' => [
                    'Operaciones administrativas de recursos humanos',
                    'Tratamiento de la documentación contable',
                    'Empresa en el aula',
                    'Operaciones auxiliares de gestión de tesorería',
                    'Proyecto intermodular',
                ],
            ],
            'CFGS Administración y Finanzas' => [
                '1º FP' => [
                    'Gestión de la documentación jurídica y empresarial',
                    'Recursos humanos y responsabilidad social corporativa',
                    'Ofimática y proceso de la información',
                    'Proceso integral de la actividad comercial',
                    'Comunicación y atención al cliente',
                    'Itinerario personal para la empleabilidad I',
                ],
                '2º FP' => [
                    'Gestión de recursos humanos',
                    'Gestión financiera',
                    'Contabilidad y fiscalidad',
                    'Gestión logística y comercial',
                    'Simulación empresarial',
                    'Proyecto intermodular',
                ],
            ],
            'CFGM Cuidados Auxiliares de Enfermería' => [
                '1º FP' => [
                    'Operaciones administrativas y documentación sanitaria',
                    'Técnicas básicas de enfermería',
                    'Higiene del medio hospitalario y limpieza de material',
                    'Promoción de la salud y apoyo psicológico al paciente',
                    'Técnicas de ayuda odontológica y estomatológica',
                    'Relaciones en el equipo de trabajo',
                    'Formación y orientación laboral',
                ],
            ],
            'CFGS Educación Infantil' => [
                '1º FP' => [
                    'Didáctica de la educación infantil',
                    'Autonomía personal y salud infantil',
                    'El juego infantil y su metodología',
                    'Expresión y comunicación',
                    'Desarrollo cognitivo y motor',
                    'Itinerario personal para la empleabilidad I',
                ],
                '2º FP' => [
                    'Desarrollo socioafectivo',
                    'Habilidades sociales',
                    'Intervención con familias y atención a menores en riesgo social',
                    'Primeros auxilios',
                    'Proyecto intermodular',
                ],
            ],
            'CFGS Comercio Internacional' => [
                '1º FP' => [
                    'Transporte internacional de mercancías',
                    'Gestión económica y financiera de la empresa',
                    'Logística de almacenamiento',
                    'Gestión administrativa del comercio internacional',
                    'Sistema de información de mercados',
                ],
                '2º FP' => [
                    'Marketing internacional',
                    'Negociación internacional',
                    'Financiación internacional',
                    'Medios de pago internacionales',
                    'Comercio digital internacional',
                    'Proyecto intermodular',
                ],
            ],
            'CFGM Cocina y Gastronomía' => [
                '1º FP' => [
                    'Preelaboración y conservación de alimentos',
                    'Técnicas culinarias',
                    'Procesos básicos de pastelería y repostería',
                    'Seguridad e higiene en la manipulación de alimentos',
                    'Itinerario personal para la empleabilidad I',
                ],
                '2º FP' => [
                    'Ofertas gastronómicas',
                    'Productos culinarios',
                    'Postres en restauración',
                    'Empresa e iniciativa emprendedora',
                    'Proyecto intermodular',
                ],
            ],
        ];

        foreach ($centrosFP as $centro) {
            foreach ($ciclosFP as $nombreCiclo => $cursosCiclo) {
                $titulacion = $this->crearTitulacion($nombreCiclo, $fp->id, $centro->id);

                foreach ($cursosCiclo as $cursoNombre => $modulos) {
                    $curso = $this->crearCurso($cursoNombre . ' - ' . $nombreCiclo, $fp->id, $titulacion->id);
                    $this->crearAsignaturas($curso->id, $modulos);
                }
            }
        }
    }

    private function crearTitulacion(string $nombre, int $nivelId, ?int $centroId): Titulacion
    {
        return Titulacion::firstOrCreate([
            'nombre' => $nombre,
            'nivel_id' => $nivelId,
            'centro_id' => $centroId,
        ]);
    }

    private function crearCurso(string $nombre, int $nivelId, ?int $titulacionId): Curso
    {
        return Curso::firstOrCreate([
            'nombre' => $nombre,
            'nivel_id' => $nivelId,
            'titulacion_id' => $titulacionId,
        ]);
    }

    private function crearAsignaturas(int $cursoId, array $asignaturas): void
    {
        foreach ($asignaturas as $nombre) {
            Asignatura::firstOrCreate([
                'nombre' => $nombre,
                'curso_id' => $cursoId,
            ]);
        }
    }
}