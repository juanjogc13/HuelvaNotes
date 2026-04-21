<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Centro extends Model
{
    // Campos que se pueden rellenar masivamente
    protected $fillable = ['nombre', 'localidad'];

    // Un centro tiene muchos usuarios
    public function usuarios()
    {
        return $this->hasMany(User::class);
    }

    // Un centro tiene muchos apuntes
    public function apuntes()
    {
        return $this->hasMany(Apunte::class);
    }
}
