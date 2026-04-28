<?php

namespace App\Http\Controllers;

use App\Models\Apunte;
use App\Models\Centro;
use App\Models\Nivel;
use App\Models\Curso;
use App\Models\Asignatura;
use App\Models\TransaccionPuntos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApunteController extends Controller
{
    // Muestra el formulario de subida
    public function create()
    {
        $user = Auth::user();
        $centros = Centro::orderBy('localidad')->orderBy('nombre')->get();
        $niveles = Nivel::orderBy('nombre')->get();

        // Pasamos todos los cursos y asignaturas en JSON para el selector en cascada
        $cursos = Curso::orderBy('nombre')->get();
        $asignaturas = Asignatura::orderBy('nombre')->get();

        return view('apuntes.create', compact('user', 'centros', 'niveles', 'cursos', 'asignaturas'));
    }

    // Guarda el apunte en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'titulo'        => ['required', 'string', 'max:100'],
            'descripcion'   => ['nullable', 'string', 'max:500'],
            'centro_id'     => ['required', 'exists:centros,id'],
            'nivel_id'      => ['required', 'exists:niveles,id'],
            'curso_id'      => ['required', 'exists:cursos,id'],
            'asignatura_id' => ['required', 'exists:asignaturas,id'],
            'archivo'       => ['required', 'file', 'mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png', 'max:15360'],
        ], [
            'titulo.required'        => 'El título es obligatorio.',
            'titulo.max'             => 'El título no puede superar los 100 caracteres.',
            'centro_id.required'     => 'Selecciona un centro.',
            'nivel_id.required'      => 'Selecciona un nivel.',
            'curso_id.required'      => 'Selecciona un curso.',
            'asignatura_id.required' => 'Selecciona una asignatura.',
            'archivo.required'       => 'Debes subir un archivo.',
            'archivo.mimes'          => 'Formato no permitido. Usa PDF, Word, PowerPoint o imagen.',
            'archivo.max'            => 'El archivo no puede superar los 15MB.',
        ]);

        // Guardamos el archivo en storage/app/public/apuntes
        $ruta = $request->file('archivo')->store('apuntes', 'public');

        // Creamos el apunte con los campos exactos de la tabla
        $apunte = Apunte::create([
            'titulo'        => $request->titulo,
            'descripcion'   => $request->descripcion,
            'centro_id'     => $request->centro_id,
            'nivel_id'      => $request->nivel_id,
            'curso_id'      => $request->curso_id,
            'asignatura_id' => $request->asignatura_id,
            'user_id'       => Auth::id(),
            'archivo'       => $ruta,
            'formato'       => $request->file('archivo')->getClientOriginalExtension(),
            // Coste por defecto 5 puntos para descargar
            'coste_puntos'  => 5,
        ]);

        // Sumamos 20 puntos al usuario por subir el apunte
        $user = Auth::user();
        $user->puntos += 20;
        $user->save();

        // Registramos la transacción de puntos
        TransaccionPuntos::create([
            'user_id'   => $user->id,
            'cantidad'  => 20,
            'tipo'      => 'subida',
            'apunte_id' => $apunte->id,
        ]);

        return redirect()->route('dashboard')->with('status', 'apunte-subido');
    }

    // Descarga un apunte restando puntos al usuario
    public function download($id)
    {
        $apunte = Apunte::findOrFail($id);
        $user = Auth::user();

        // No puedes descargar tu propio apunte
        if ($apunte->user_id === $user->id) {
            return back()->with('error', 'No puedes descargar tu propio apunte.');
        }

        // Comprobamos si ya lo había descargado antes
        $yaDescargado = $user->descargas()->where('apunte_id', $apunte->id)->exists();

        if (!$yaDescargado) {
            // Comprobamos que tiene puntos suficientes
            if ($user->puntos < $apunte->coste_puntos) {
                return back()->with('error', 'No tienes suficientes puntos. Sube apuntes para ganar más.');
            }

            // Restamos los puntos al usuario
            $user->puntos -= $apunte->coste_puntos;
            $user->save();

            // Registramos la descarga
            \App\Models\Descarga::create([
                'user_id'   => $user->id,
                'apunte_id' => $apunte->id,
            ]);

            // Registramos la transacción del que descarga
            TransaccionPuntos::create([
                'user_id'   => $user->id,
                'cantidad'  => -$apunte->coste_puntos,
                'tipo'      => 'descarga',
                'apunte_id' => $apunte->id,
            ]);

            // Actualizamos el contador de descargas del apunte
            $apunte->increment('total_descargas');

            // Si el apunte tiene autor registrado le sumamos puntos y notificamos
            $autor = $apunte->user;
            if ($autor) {
                $autor->puntos += 3;
                $autor->save();

                // Registramos la transacción del autor
                TransaccionPuntos::create([
                    'user_id'   => $autor->id,
                    'cantidad'  => 3,
                    'tipo'      => 'descarga',
                    'apunte_id' => $apunte->id,
                ]);

                // Notificamos al autor
                \App\Models\Notificacion::create([
                    'user_id' => $autor->id,
                    'mensaje' => $user->name . ' ha descargado tu apunte "' . $apunte->titulo . '" (+3 pts)',
                    'url'     => '/apuntes',
                ]);
            }
        }

        // Descargamos el archivo
        return Storage::disk('public')->download($apunte->archivo, $apunte->titulo . '.' . $apunte->formato);
    }

    // Elimina un apunte
    public function destroy($id)
    {
        $apunte = Apunte::findOrFail($id);

        // Solo el autor puede eliminar su apunte
        if ($apunte->user_id !== Auth::id()) {
            abort(403);
        }

        // Borramos el archivo físico del storage
        Storage::disk('public')->delete($apunte->archivo);

        // Restamos los 20 puntos que ganó al subirlo
        $user = Auth::user();
        $user->puntos = max(0, $user->puntos - 20);
        $user->save();

        // Registramos la transacción de puntos
        TransaccionPuntos::create([
            'user_id'   => $user->id,
            'cantidad'  => -20,
            'tipo'      => 'eliminacion',
            'apunte_id' => $apunte->id,
        ]);

        $apunte->delete();

        return redirect()->route('profile.edit')->with('status', 'apunte-eliminado');
    }
}