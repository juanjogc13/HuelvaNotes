<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Valoracion extends Model
{
    // Campos que se pueden rellenar masivamente
    protected $fillable = ['user_id', 'apunte_id', 'puntuacion', 'comentario'];

    // La valoración pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // La valoración pertenece a un apunte
    public function apunte()
    {
        return $this->belongsTo(Apunte::class);
    }
}
