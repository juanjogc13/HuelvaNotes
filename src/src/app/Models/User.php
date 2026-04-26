<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    // Campos que se pueden rellenar masivamente
    protected $fillable = ['name', 'email', 'password', 'puntos', 'centro_id', 'foto'];

    // Campos ocultos en las respuestas JSON
    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // El usuario pertenece a un centro educativo
    public function centro()
    {
        return $this->belongsTo(Centro::class);
    }

    // El usuario ha subido muchos apuntes
    public function apuntes()
    {
        return $this->hasMany(Apunte::class);
    }

    // El usuario ha realizado muchas descargas
    public function descargas()
    {
        return $this->hasMany(Descarga::class);
    }

    // El usuario ha hecho muchas valoraciones
    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class);
    }

    // El usuario tiene un historial de puntos
    public function transacciones()
    {
        return $this->hasMany(TransaccionPuntos::class);
    }

    // El usuario tiene apuntes guardados en favoritos
    public function favoritos()
    {
        return $this->hasMany(Favorito::class);
    }

    // El usuario tiene notificaciones
    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class);
    }

    // El usuario ha hecho reportes
    public function reportes()
    {
        return $this->hasMany(Reporte::class);
    }
}