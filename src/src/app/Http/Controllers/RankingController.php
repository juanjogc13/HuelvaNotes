<?php

namespace App\Http\Controllers;

use App\Models\User;

class RankingController extends Controller
{
    public function index()
    {
        $usuarios = User::with('centro')
            ->orderByDesc('puntos')
            ->orderBy('name')
            ->paginate(20);

        return view('ranking.index', compact('usuarios'));
    }
}