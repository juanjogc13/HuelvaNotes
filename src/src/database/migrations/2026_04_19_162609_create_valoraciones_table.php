<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('valoraciones', function (Blueprint $table) {
            $table->id();
            // Usuario que valoró el apunte
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            // Apunte que fue valorado
            $table->foreignId('apunte_id')->constrained('apuntes')->cascadeOnDelete();
            // Puntuación del 1 al 5
            $table->tinyInteger('puntuacion');
            // Comentario opcional sobre el apunte
            $table->text('comentario')->nullable();
            // Un usuario solo puede valorar un apunte una vez
            $table->unique(['user_id', 'apunte_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('valoraciones');
    }
};