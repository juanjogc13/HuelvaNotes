<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apunte extends Model
{
    // Le decimos a Laravel el nombre real de la tabla
    protected $table = 'apuntes';

    // Campos que se pueden rellenar masivamente
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
        'curso_id',
        'asignatura_id',
    ];

    // El apunte pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // El apunte pertenece a un centro
    public function centro()
    {
        return $this->belongsTo(Centro::class);
    }

    // El apunte pertenece a un nivel
    public function nivel()
    {
        return $this->belongsTo(Nivel::class);
    }

    // El apunte pertenece a un curso
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    // El apunte pertenece a una asignatura
    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }

    // Un apunte tiene muchas descargas
    public function descargas()
    {
        return $this->hasMany(Descarga::class);
    }

    // Un apunte tiene muchas valoraciones
    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class);
    }

    // Un apunte puede tener muchas etiquetas
    public function etiquetas()
    {
        return $this->belongsToMany(Etiqueta::class, 'apunte_tag');
    }

    // Un apunte puede estar en favoritos de muchos usuarios
    public function favoritos()
    {
        return $this->hasMany(Favorito::class);
    }

    // Un apunte puede tener muchos reportes
    public function reportes()
    {
        return $this->hasMany(Reporte::class);
    }
}
