<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApunteController;
use App\Http\Controllers\ApunteListadoController;
use App\Http\Controllers\ValoracionController;
use App\Http\Controllers\ModeracionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/apuntes', [ApunteListadoController::class, 'index'])->name('apuntes.index');
    Route::get('/apuntes/subir', [ApunteController::class, 'create'])->name('apuntes.create');
    Route::post('/apuntes', [ApunteController::class, 'store'])->name('apuntes.store');
    Route::post('/apuntes/{id}/descargar', [ApunteController::class, 'download'])->name('apuntes.download');
    Route::delete('/apuntes/{id}', [ApunteController::class, 'destroy'])->name('apuntes.destroy');
    Route::post('/apuntes/{id}/valorar', [ValoracionController::class, 'store'])->name('apuntes.valorar');
});

Route::middleware(['auth', 'moderador'])->group(function () {
    Route::get('/moderacion', [ModeracionController::class, 'index'])->name('moderacion.index');
    Route::patch('/moderacion/{id}/aprobar', [ModeracionController::class, 'aprobar'])->name('moderacion.aprobar');
    Route::patch('/moderacion/{id}/rechazar', [ModeracionController::class, 'rechazar'])->name('moderacion.rechazar');
});

require __DIR__.'/auth.php';