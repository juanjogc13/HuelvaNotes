<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    // Le decimos a Laravel el nombre real de la tabla
    protected $table = 'asignaturas';

    // Campos que se pueden rellenar masivamente
    protected $fillable = ['nombre', 'curso_id'];

    // La asignatura pertenece a un curso
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    // Una asignatura tiene muchos apuntes
    public function apuntes()
    {
        return $this->hasMany(Apunte::class);
    }
}