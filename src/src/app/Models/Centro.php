<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Centro extends Model
{
    protected $table = 'centros';

    protected $fillable = ['nombre', 'localidad'];

    public function usuarios()
    {
        return $this->hasMany(User::class);
    }

    public function apuntes()
    {
        return $this->hasMany(Apunte::class);
    }

    public function titulaciones()
    {
        return $this->hasMany(Titulacion::class);
    }
}