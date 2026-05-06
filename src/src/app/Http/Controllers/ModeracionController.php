<?php

namespace App\Http\Controllers;

use App\Models\Apunte;
use App\Models\Notificacion;
use App\Models\TransaccionPuntos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ModeracionController extends Controller
{
    public function index()
    {
        $apuntesPendientes = Apunte::with(['user', 'centro', 'nivel', 'curso', 'asignatura'])
            ->where('estado', 'pendiente')
            ->latest()
            ->paginate(10);

        return view('moderacion.index', compact('apuntesPendientes'));
    }

    public function aprobar($id)
    {
        $apunte = Apunte::with('user')->findOrFail($id);

        if ($apunte->estado !== 'pendiente') {
            return back()->with('error', 'Este apunte ya ha sido revisado.');
        }

        DB::transaction(function () use ($apunte) {
            $apunte->estado = 'aprobado';
            $apunte->save();

            $autor = $apunte->user;

            if ($autor) {
                $autor->puntos += 20;
                $autor->save();

                TransaccionPuntos::create([
                    'user_id'   => $autor->id,
                    'cantidad'  => 20,
                    'tipo'      => 'subida_aprobada',
                    'apunte_id' => $apunte->id,
                ]);

                Notificacion::create([
                    'user_id' => $autor->id,
                    'mensaje' => 'Tu apunte "' . $apunte->titulo . '" ha sido aprobado (+20 pts).',
                    'url'     => '/apuntes',
                ]);
            }
        });

        return back()->with('status', 'apunte-aprobado');
    }

    public function rechazar(Request $request, $id)
    {
        $request->validate([
            'motivo' => ['required', 'string', 'max:500'],
        ], [
            'motivo.required' => 'Debes indicar el motivo del rechazo.',
            'motivo.max'      => 'El motivo no puede superar los 500 caracteres.',
        ]);

        $apunte = Apunte::with('user')->findOrFail($id);

        if ($apunte->estado !== 'pendiente') {
            return back()->with('error', 'Este apunte ya ha sido revisado.');
        }

        DB::transaction(function () use ($apunte, $request) {
            $apunte->estado = 'rechazado';
            $apunte->save();

            $autor = $apunte->user;

            if ($autor) {
                Notificacion::create([
                    'user_id' => $autor->id,
                    'mensaje' => 'Tu apunte "' . $apunte->titulo . '" ha sido rechazado. Motivo: ' . $request->motivo,
                    'url'     => '/dashboard',
                ]);
            }

            // Opcional: borrar el archivo físico si se rechaza
            if ($apunte->archivo && Storage::disk('public')->exists($apunte->archivo)) {
                Storage::disk('public')->delete($apunte->archivo);
            }
        });

        return back()->with('status', 'apunte-rechazado');
    }
}