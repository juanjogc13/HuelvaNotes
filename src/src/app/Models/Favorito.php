<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorito extends Model
{
    // Campos que se pueden rellenar masivamente
    protected $fillable = ['user_id', 'apunte_id'];

    // El favorito pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // El favorito pertenece a un apunte
    public function apunte()
    {
        return $this->belongsTo(Apunte::class);
    }
}
