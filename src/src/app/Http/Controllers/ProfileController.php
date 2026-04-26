<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Centro;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();

        // Cargamos todos los centros para el selector del perfil
        $centros = Centro::orderBy('localidad')->orderBy('nombre')->get();

        // Estadísticas generales del usuario
        $totalApuntes = $user->apuntes()->count();
        $totalDescargas = $user->descargas()->count();

        // Media de valoraciones de sus apuntes, 0 si no tiene ninguna
        $valoracionMedia = $user->apuntes()->avg('valoracion_media') ?? 0;

        // Últimos 5 apuntes subidos por el usuario
        $apuntes = $user->apuntes()->latest()->take(5)->get();

        // Últimos 5 movimientos de puntos
        $historialPuntos = $user->transacciones()->latest()->take(5)->get();

        // Últimos 5 apuntes guardados como favoritos
        $favoritos = $user->favoritos()->with('apunte')->latest()->take(5)->get();

        return view('profile.edit', compact(
            'user',
            'centros',
            'totalApuntes',
            'totalDescargas',
            'valoracionMedia',
            'apuntes',
            'historialPuntos',
            'favoritos'
        ));
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'centro_id' => ['nullable', 'exists:centros,id'],
            // La foto es opcional, máximo 2MB
            'foto' => ['nullable', 'image', 'max:2048'],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.unique' => 'Este email ya está en uso.',
            'foto.image' => 'El archivo debe ser una imagen.',
            'foto.max' => 'La imagen no puede superar 2MB.',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->centro_id = $request->centro_id;

        // Si sube una foto nueva, borramos la anterior y guardamos la nueva
        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $user->foto = $request->file('foto')->store('fotos', 'public');
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'perfil-actualizado');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8', 'regex:/[A-Z]/', 'regex:/[\W_]/'],
        ], [
            'current_password.required' => 'Introduce tu contraseña actual.',
            'current_password.current_password' => 'La contraseña actual no es correcta.',
            'password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'password.regex' => 'La nueva contraseña debe tener una mayúscula y un carácter especial.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        // Actualizamos la contraseña con hash seguro
        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return Redirect::route('profile.edit')->with('status', 'password-actualizado');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ], [
            'password.current_password' => 'La contraseña no es correcta.',
        ]);

        $user = $request->user();

        // Cerramos sesión antes de eliminar la cuenta
        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}