<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApunteController;
use App\Http\Controllers\ApunteListadoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// El Dashboard solo para usuarios autenticados
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Rutas de Perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Ruta para cambiar la contraseña desde el perfil
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas de Apuntes
Route::middleware('auth')->group(function () {
    Route::get('/apuntes', [ApunteListadoController::class, 'index'])->name('apuntes.index');
    Route::get('/apuntes/subir', [ApunteController::class, 'create'])->name('apuntes.create');
    Route::post('/apuntes', [ApunteController::class, 'store'])->name('apuntes.store');
    Route::delete('/apuntes/{id}', [ApunteController::class, 'destroy'])->name('apuntes.destroy');
});

// Importante: aquí están las rutas de login, registro, etc.
require __DIR__.'/auth.php';