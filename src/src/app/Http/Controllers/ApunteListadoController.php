<?php

namespace App\Http\Controllers;

use App\Models\Apunte;
use App\Models\Centro;
use App\Models\Nivel;
use App\Models\Curso;
use App\Models\Asignatura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApunteListadoController extends Controller
{
    public function index(Request $request)
    {
        // Usuario actual para comprobar descargas y puntos en las tarjetas
        $user = Auth::user();

        // Cargamos los datos para los filtros de la barra lateral
        $niveles     = Nivel::orderBy('nombre')->get();
        $centros     = Centro::orderBy('localidad')->orderBy('nombre')->get();
        $cursos      = Curso::orderBy('nombre')->get();
        $asignaturas = Asignatura::orderBy('nombre')->get();

        // Construimos la query con los filtros aplicados
        $query = Apunte::with(['user', 'asignatura', 'centro', 'nivel', 'curso'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('nivel_id')) {
            $query->where('nivel_id', $request->nivel_id);
        }

        if ($request->filled('curso_id')) {
            $query->where('curso_id', $request->curso_id);
        }

        if ($request->filled('asignatura_id')) {
            $query->where('asignatura_id', $request->asignatura_id);
        }

        if ($request->filled('centro_id')) {
            $query->where('centro_id', $request->centro_id);
        }

        if ($request->filled('formato')) {
            $query->where('formato', $request->formato);
        }

        if ($request->filled('q')) {
            $query->where('titulo', 'like', '%' . $request->q . '%');
        }

        $apuntes = $query->paginate(12)->withQueryString();

        return view('apuntes.index', compact(
            'apuntes',
            'niveles',
            'centros',
            'cursos',
            'asignaturas',
            'user'
        ));
    }
}