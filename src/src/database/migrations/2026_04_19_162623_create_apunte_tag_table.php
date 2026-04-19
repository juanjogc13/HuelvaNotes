<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apunte_tag', function (Blueprint $table) {
            $table->id();
            // Relación entre apunte y etiqueta
            $table->foreignId('apunte_id')->constrained('apuntes')->cascadeOnDelete();
            $table->foreignId('etiqueta_id')->constrained('etiquetas')->cascadeOnDelete();
            // Un apunte no puede tener la misma etiqueta dos veces
            $table->unique(['apunte_id', 'etiqueta_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apunte_tag');
    }
};
