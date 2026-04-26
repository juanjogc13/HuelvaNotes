<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Últimos apuntes subidos por el usuario
        $apuntesSubidos = $user->apuntes()
            ->latest()
            ->take(5)
            ->get();

        // Últimas descargas del usuario
        $ultimasDescargas = $user->descargas()
            ->with('apunte')
            ->latest()
            ->take(5)
            ->get();

        // Notificaciones sin leer
        $notificaciones = $user->notificaciones()
            ->where('leida', false)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'user',
            'apuntesSubidos',
            'ultimasDescargas',
            'notificaciones'
        ));
    }
}