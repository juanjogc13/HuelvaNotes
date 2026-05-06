<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Titulacion extends Model
{
    protected $table = 'titulaciones';

    protected $fillable = [
        'nombre',
        'nivel_id',
        'centro_id',
    ];

    public function nivel()
    {
        return $this->belongsTo(Nivel::class);
    }

    public function centro()
    {
        return $this->belongsTo(Centro::class);
    }

    public function cursos()
    {
        return $this->hasMany(Curso::class);
    }

    public function apuntes()
    {
        return $this->hasMany(Apunte::class);
    }
}