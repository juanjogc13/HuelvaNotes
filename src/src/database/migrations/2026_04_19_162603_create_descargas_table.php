<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('descargas', function (Blueprint $table) {
            $table->id();
            // Usuario que realizó la descarga
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            // Apunte que fue descargado
            $table->foreignId('apunte_id')->constrained('apuntes')->cascadeOnDelete();
            // Para evitar que el mismo usuario descargue el mismo apunte dos veces
            $table->unique(['user_id', 'apunte_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('descargas');
    }
};