<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    protected $table = 'niveles';

    protected $fillable = ['nombre'];

    public function cursos()
    {
        return $this->hasMany(Curso::class);
    }

    public function titulaciones()
    {
        return $this->hasMany(Titulacion::class);
    }

    public function apuntes()
    {
        return $this->hasMany(Apunte::class);
    }
}