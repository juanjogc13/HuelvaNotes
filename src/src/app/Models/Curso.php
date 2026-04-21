<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    // Campos que se pueden rellenar masivamente
    protected $fillable = ['nombre', 'nivel_id'];

    // El curso pertenece a un nivel
    public function nivel()
    {
        return $this->belongsTo(Nivel::class);
    }

    // Un curso tiene muchas asignaturas
    public function asignaturas()
    {
        return $this->hasMany(Asignatura::class);
    }

    // Un curso tiene muchos apuntes
    public function apuntes()
    {
        return $this->hasMany(Apunte::class);
    }
}