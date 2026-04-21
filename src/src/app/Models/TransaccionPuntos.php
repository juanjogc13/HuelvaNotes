<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaccionPuntos extends Model
{
    // Campos que se pueden rellenar masivamente
    protected $fillable = ['user_id', 'cantidad', 'tipo', 'apunte_id'];

    // La transacción pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // La transacción puede estar relacionada con un apunte
    public function apunte()
    {
        return $this->belongsTo(Apunte::class);
    }
}
