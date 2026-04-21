<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etiqueta extends Model
{
    // Campos que se pueden rellenar masivamente
    protected $fillable = ['nombre'];

    // Una etiqueta puede estar en muchos apuntes
    public function apuntes()
    {
        return $this->belongsToMany(Apunte::class, 'apunte_tag');
    }
}
