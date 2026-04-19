<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            // Usuario que recibe la notificación
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            // Mensaje de la notificación
            $table->string('mensaje');
            // Enlace al que lleva la notificación
            $table->string('url')->nullable();
            // Si el usuario ya la ha leído o no
            $table->boolean('leida')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};
