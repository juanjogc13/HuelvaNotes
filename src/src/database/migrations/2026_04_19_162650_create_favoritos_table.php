<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favoritos', function (Blueprint $table) {
            $table->id();
            // Usuario que guardó el apunte como favorito
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            // Apunte guardado como favorito
            $table->foreignId('apunte_id')->constrained('apuntes')->cascadeOnDelete();
            // Un usuario no puede tener el mismo apunte en favoritos dos veces
            $table->unique(['user_id', 'apunte_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favoritos');
    }
};
