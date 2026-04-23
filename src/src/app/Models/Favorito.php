<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorito extends Model
{
    // Le decimos a Laravel el nombre real de la tabla
    protected $table = 'favoritos';

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
