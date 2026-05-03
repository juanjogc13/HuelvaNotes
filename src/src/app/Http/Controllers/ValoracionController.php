<?php

namespace App\Http\Controllers;

use App\Models\Valoracion;
use App\Models\Apunte;
use App\Models\TransaccionPuntos;
use App\Models\Notificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValoracionController extends Controller
{
    public function store(Request $request, $id)
    {
        $apunte = Apunte::findOrFail($id);
        $user = Auth::user();

        // No puedes valorar tu propio apunte
        if ($apunte->user_id === $user->id) {
            return back()->with('error', 'No puedes valorar tu propio apunte.');
        }

        // Solo puedes valorar si lo has descargado antes
        if (!$user->descargas()->where('apunte_id', $id)->exists()) {
            return back()->with('error', 'Debes descargar el apunte antes de valorarlo.');
        }

        // Solo una valoración por usuario por apunte
        if (Valoracion::where('user_id', $user->id)->where('apunte_id', $id)->exists()) {
            return back()->with('error', 'Ya has valorado este apunte.');
        }

        $request->validate([
            'puntuacion' => ['required', 'integer', 'min:1', 'max:5'],
            'comentario' => ['nullable', 'string', 'max:500'],
        ], [
            'puntuacion.required' => 'Selecciona una puntuación.',
            'puntuacion.min'      => 'La puntuación mínima es 1.',
            'puntuacion.max'      => 'La puntuación máxima es 5.',
            'comentario.max'      => 'El comentario no puede superar los 500 caracteres.',
        ]);

        // Guardamos la valoración
        Valoracion::create([
            'user_id'    => $user->id,
            'apunte_id'  => $id,
            'puntuacion' => $request->puntuacion,
            'comentario' => $request->comentario,
        ]);

        // Actualizamos la valoración media del apunte
        $media = Valoracion::where('apunte_id', $id)->avg('puntuacion');
        $apunte->valoracion_media = round($media, 2);
        $apunte->save();

        // Si la valoración es buena (4 o 5) damos puntos extra al autor
        $autor = $apunte->user;
        if ($autor && $request->puntuacion >= 4) {
            $autor->puntos += 5;
            $autor->save();

            TransaccionPuntos::create([
                'user_id'   => $autor->id,
                'cantidad'  => 5,
                'tipo'      => 'valoracion',
                'apunte_id' => $apunte->id,
            ]);

            // Notificamos al autor
            Notificacion::create([
                'user_id' => $autor->id,
                'mensaje' => $user->name . ' ha valorado tu apunte "' . $apunte->titulo . '" con ' . $request->puntuacion . ' estrellas (+5 pts)',
                'url'     => '/apuntes',
            ]);
        }

        return back()->with('status', 'valoracion-enviada');
    }
}