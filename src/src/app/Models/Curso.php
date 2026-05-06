<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'cursos';

    protected $fillable = ['nombre', 'nivel_id', 'titulacion_id'];

    public function nivel()
    {
        return $this->belongsTo(Nivel::class);
    }

    public function titulacion()
    {
        return $this->belongsTo(Titulacion::class);
    }

    public function asignaturas()
    {
        return $this->hasMany(Asignatura::class);
    }

    public function apuntes()
    {
        return $this->hasMany(Apunte::class);
    }
}