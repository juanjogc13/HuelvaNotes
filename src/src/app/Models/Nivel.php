<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    // Campos que se pueden rellenar masivamente
    protected $fillable = ['nombre'];

    // Un nivel tiene muchos cursos
    public function cursos()
    {
        return $this->hasMany(Curso::class);
    }

    // Un nivel tiene muchos apuntes
    public function apuntes()
    {
        return $this->hasMany(Apunte::class);
    }
}
