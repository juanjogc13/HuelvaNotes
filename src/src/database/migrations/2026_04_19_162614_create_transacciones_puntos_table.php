<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transacciones_puntos', function (Blueprint $table) {
            $table->id();
            // Usuario al que pertenece la transacción
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            // Puntos ganados (positivo) o gastados (negativo)
            $table->integer('cantidad');
            // Motivo: subida, descarga o valoracion
            $table->enum('tipo', ['subida', 'descarga', 'valoracion']);
            // Apunte relacionado con la transacción
            $table->foreignId('apunte_id')->nullable()->constrained('apuntes')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transacciones_puntos');
    }
};