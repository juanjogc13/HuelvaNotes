<?php

namespace App\Http\Controllers;

use App\Models\Apunte;
use App\Models\Asignatura;
use App\Models\Centro;
use App\Models\Curso;
use App\Models\Descarga;
use App\Models\Nivel;
use App\Models\Notificacion;
use App\Models\Titulacion;
use App\Models\TransaccionPuntos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ApunteController extends Controller
{
    // Muestra el formulario de subida
    public function create()
    {
        $user = Auth::user();

        if (!$user->centro_id) {
            return redirect()
                ->route('profile.edit')
                ->withErrors([
                    'centro_id' => 'Antes de subir apuntes debes tener un centro educativo asignado.',
                ]);
        }

        $user->load('centro');

        $niveles = Nivel::orderBy('nombre')->get();

        // Solo titulaciones del centro del usuario
        $titulaciones = Titulacion::where('centro_id', $user->centro_id)
            ->orderBy('nombre')
            ->get();

        // Solo cursos asociados a esas titulaciones
        $cursos = Curso::whereIn('titulacion_id', $titulaciones->pluck('id'))
            ->orderBy('nombre')
            ->get();

        // Solo asignaturas asociadas a esos cursos
        $asignaturas = Asignatura::whereIn('curso_id', $cursos->pluck('id'))
            ->orderBy('nombre')
            ->get();

        return view('apuntes.create', compact(
            'user',
            'niveles',
            'titulaciones',
            'cursos',
            'asignaturas'
        ));
    }

    // Guarda el apunte en la base de datos. Queda pendiente hasta que un moderador/admin lo apruebe.
    public function store(Request $request)
    {
        $request->validate([
            'titulo'        => ['required', 'string', 'max:100'],
            'descripcion'   => ['nullable', 'string', 'max:500'],
            'nivel_id'      => ['required', 'exists:niveles,id'],
            'titulacion_id' => ['required', 'exists:titulaciones,id'],
            'curso_id'      => ['required', 'exists:cursos,id'],
            'asignatura_id' => ['required', 'exists:asignaturas,id'],
            'archivo'       => ['required', 'file', 'mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png', 'max:15360'],
        ], [
            'titulo.required'        => 'El título es obligatorio.',
            'titulo.max'             => 'El título no puede superar los 100 caracteres.',
            'nivel_id.required'      => 'Selecciona un nivel.',
            'titulacion_id.required' => 'Selecciona una titulación.',
            'curso_id.required'      => 'Selecciona un curso.',
            'asignatura_id.required' => 'Selecciona una asignatura.',
            'archivo.required'       => 'Debes subir un archivo.',
            'archivo.mimes'          => 'Formato no permitido. Usa PDF, Word, PowerPoint o imagen.',
            'archivo.max'            => 'El archivo no puede superar los 15MB.',
        ]);

        $user = Auth::user();

        if (!$user->centro_id) {
            return back()
                ->withInput()
                ->withErrors([
                    'centro_id' => 'Tu usuario no tiene un centro asignado. Actualiza tu perfil antes de subir apuntes.',
                ]);
        }

        // La titulación debe pertenecer al centro del usuario y al nivel elegido
        $titulacionValida = Titulacion::where('id', $request->titulacion_id)
            ->where('nivel_id', $request->nivel_id)
            ->where('centro_id', $user->centro_id)
            ->exists();

        if (!$titulacionValida) {
            return back()
                ->withInput()
                ->withErrors([
                    'titulacion_id' => 'La titulación seleccionada no pertenece a tu centro o nivel.',
                ]);
        }

        // El curso debe pertenecer a la titulación elegida
        $cursoValido = Curso::where('id', $request->curso_id)
            ->where('titulacion_id', $request->titulacion_id)
            ->exists();

        if (!$cursoValido) {
            return back()
                ->withInput()
                ->withErrors([
                    'curso_id' => 'El curso seleccionado no pertenece a la titulación indicada.',
                ]);
        }

        // La asignatura debe pertenecer al curso elegido
        $asignaturaValida = Asignatura::where('id', $request->asignatura_id)
            ->where('curso_id', $request->curso_id)
            ->exists();

        if (!$asignaturaValida) {
            return back()
                ->withInput()
                ->withErrors([
                    'asignatura_id' => 'La asignatura seleccionada no pertenece al curso indicado.',
                ]);
        }

        // Guardamos el archivo en storage/app/public/apuntes
        $ruta = $request->file('archivo')->store('apuntes', 'public');

        // Si por permisos o fallo de storage no se guarda, no creamos el apunte roto
        if (!$ruta) {
            return back()
                ->withInput()
                ->withErrors([
                    'archivo' => 'No se pudo guardar el archivo en el servidor. Revisa permisos de storage.',
                ]);
        }

        Apunte::create([
            'titulo'        => $request->titulo,
            'descripcion'   => $request->descripcion,
            'centro_id'     => $user->centro_id,
            'nivel_id'      => $request->nivel_id,
            'titulacion_id' => $request->titulacion_id,
            'curso_id'      => $request->curso_id,
            'asignatura_id' => $request->asignatura_id,
            'user_id'       => $user->id,
            'archivo'       => $ruta,
            'formato'       => strtolower($request->file('archivo')->getClientOriginalExtension()),
            'coste_puntos'  => 5,
            'estado'        => 'pendiente',
        ]);

        return redirect()->route('dashboard')->with('status', 'apunte-pendiente');
    }

    // Descarga un apunte restando puntos al usuario
    public function download($id)
    {
        $apunte = Apunte::with('user')->findOrFail($id);
        $user = Auth::user();

        if ($apunte->estado !== 'aprobado') {
            return back()->with('error', 'Este apunte no está disponible.');
        }

        if ($apunte->user_id === $user->id) {
            return back()->with('error', 'No puedes descargar tu propio apunte.');
        }

        // Importante: comprobar archivo ANTES de tocar puntos, descargas o transacciones
        if (!$apunte->archivo || !Storage::disk('public')->exists($apunte->archivo)) {
            return back()->with('error', 'El archivo de este apunte no está disponible. Contacta con un administrador.');
        }

        $yaDescargado = $user->descargas()
            ->where('apunte_id', $apunte->id)
            ->exists();

        if (!$yaDescargado) {
            if ($user->puntos < $apunte->coste_puntos) {
                return back()->with('error', 'No tienes suficientes puntos. Sube apuntes para ganar más.');
            }

            DB::transaction(function () use ($user, $apunte) {
                // Restamos puntos al usuario que descarga
                $user->puntos -= $apunte->coste_puntos;
                $user->save();

                // Registramos descarga
                Descarga::create([
                    'user_id'   => $user->id,
                    'apunte_id' => $apunte->id,
                ]);

                // Registramos transacción del usuario que descarga
                TransaccionPuntos::create([
                    'user_id'   => $user->id,
                    'cantidad'  => -$apunte->coste_puntos,
                    'tipo'      => 'descarga',
                    'apunte_id' => $apunte->id,
                ]);

                // Incrementamos contador
                $apunte->increment('total_descargas');

                // Sumamos puntos al autor
                $autor = $apunte->user;

                if ($autor) {
                    $autor->puntos += 3;
                    $autor->save();

                    TransaccionPuntos::create([
                        'user_id'   => $autor->id,
                        'cantidad'  => 3,
                        'tipo'      => 'descarga',
                        'apunte_id' => $apunte->id,
                    ]);

                    Notificacion::create([
                        'user_id' => $autor->id,
                        'mensaje' => $user->name . ' ha descargado tu apunte "' . $apunte->titulo . '" (+3 pts)',
                        'url'     => '/apuntes',
                    ]);
                }
            });
        }

        return Storage::disk('public')->download(
            $apunte->archivo,
            $apunte->titulo . '.' . $apunte->formato
        );
    }

    // Elimina un apunte. Puede hacerlo el autor o un admin.
    public function destroy($id)
    {
        $apunte = Apunte::findOrFail($id);
        $user = Auth::user();

        if ($apunte->user_id !== $user->id && $user->rol !== 'admin') {
            abort(403);
        }

        DB::transaction(function () use ($apunte, $user) {
            // Borramos archivo físico si existe
            if ($apunte->archivo && Storage::disk('public')->exists($apunte->archivo)) {
                Storage::disk('public')->delete($apunte->archivo);
            }

            $debeRegistrarEliminacion = $apunte->user_id === $user->id && $apunte->estado === 'aprobado';

            // Si el autor borra su propio apunte aprobado, se le restan los puntos de subida
            if ($debeRegistrarEliminacion) {
                $user->puntos = max(0, $user->puntos - 20);
                $user->save();
            }

            // Limpiamos relaciones para evitar errores de claves foráneas
            $apunte->etiquetas()->detach();
            $apunte->descargas()->delete();
            $apunte->valoraciones()->delete();
            $apunte->favoritos()->delete();
            $apunte->reportes()->delete();

            // Borramos transacciones anteriores relacionadas con este apunte
            TransaccionPuntos::where('apunte_id', $apunte->id)->delete();

            // Si queremos dejar constancia de la eliminación, la creamos después de borrar las anteriores
            if ($debeRegistrarEliminacion) {
                TransaccionPuntos::create([
                    'user_id'   => $user->id,
                    'cantidad'  => -20,
                    'tipo'      => 'eliminacion',
                    'apunte_id' => $apunte->id,
                ]);
            }

            // Finalmente borramos el apunte
            $apunte->delete();
        });

        return back()->with('status', 'apunte-eliminado');
    }
}