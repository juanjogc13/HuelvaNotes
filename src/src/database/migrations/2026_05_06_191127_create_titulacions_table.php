<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('titulaciones', function (Blueprint $table) {
            $table->id();

            // Ejemplo: Grado en Ingeniería Informática, DAM, DAW, Bachillerato Ciencias...
            $table->string('nombre');

            // Universidad, FP, Bachillerato, ESO...
            $table->foreignId('nivel_id')
                ->constrained('niveles')
                ->onDelete('cascade');

            // Centro al que pertenece la titulación.
            // Ejemplo: Universidad de Huelva, IES La Marisma, IES Fuentepiña...
            $table->foreignId('centro_id')
                ->nullable()
                ->constrained('centros')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('titulaciones');
    }
};