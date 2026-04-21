<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    // Campos que se pueden rellenar masivamente
    protected $fillable = ['user_id', 'mensaje', 'url', 'leida'];

    // La notificación pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
