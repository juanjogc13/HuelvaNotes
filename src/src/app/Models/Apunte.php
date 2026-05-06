<?php

namespace App\Models;

use App\Models\User;
use App\Models\Centro;
use App\Models\Nivel;
use App\Models\Curso;
use App\Models\Asignatura;
use App\Models\Descarga;
use App\Models\Valoracion;
use App\Models\Etiqueta;
use App\Models\Favorito;
use App\Models\Reporte;
use App\Models\Titulacion;
use Illuminate\Database\Eloquent\Model;

class Apunte extends Model
{
    protected $table = 'apuntes';

    protected $fillable = [
        'titulo',
        'descripcion',
        'archivo',
        'formato',
        'coste_puntos',
        'valoracion_media',
        'total_descargas',
        'user_id',
        'centro_id',
        'nivel_id',
        'titulacion_id',
        'curso_id',
        'asignatura_id',
        'estado',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function centro()
    {
        return $this->belongsTo(Centro::class);
    }

    public function nivel()
    {
        return $this->belongsTo(Nivel::class);
    }

    public function titulacion()
    {
        return $this->belongsTo(Titulacion::class);
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }

    public function descargas()
    {
        return $this->hasMany(Descarga::class);
    }

    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class);
    }

    public function etiquetas()
    {
        return $this->belongsToMany(Etiqueta::class, 'apunte_tag');
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class);
    }

    public function reportes()
    {
        return $this->hasMany(Reporte::class);
    }
}