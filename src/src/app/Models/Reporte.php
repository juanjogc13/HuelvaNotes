<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    // Le decimos a Laravel el nombre real de la tabla
    protected $table = 'reportes';

    // Campos que se pueden rellenar masivamente
    protected $fillable = ['user_id', 'apunte_id', 'motivo', 'resuelto'];

    // El reporte pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // El reporte pertenece a un apunte
    public function apunte()
    {
        return $this->belongsTo(Apunte::class);
    }
}
