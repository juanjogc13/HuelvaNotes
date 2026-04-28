<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transacciones_puntos', function (Blueprint $table) {
            // Cambiamos de ENUM a string para aceptar cualquier tipo de transacción
            $table->string('tipo')->change();
        });
    }

    public function down(): void
    {
        Schema::table('transacciones_puntos', function (Blueprint $table) {
            $table->enum('tipo', ['subida', 'descarga', 'valoracion'])->change();
        });
    }
};