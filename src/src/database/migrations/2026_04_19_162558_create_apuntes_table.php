<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apuntes', function (Blueprint $table) {
            $table->id();
            // Título del apunte
            $table->string('titulo');
            // Descripción opcional de lo que contiene
            $table->text('descripcion')->nullable();
            // Ruta del archivo guardado en el servidor
            $table->string('archivo');
            // Formato del archivo: PDF, DOCX, PPTX...
            $table->string('formato');
            // Puntos que cuesta descargar este apunte
            $table->integer('coste_puntos')->default(5);
            // Media de valoraciones recibidas
            $table->decimal('valoracion_media', 3, 2)->default(0);
            // Número total de descargas
            $table->integer('total_descargas')->default(0);
            // Usuario que subió el apunte
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            // Centro, nivel, curso y asignatura al que pertenece
            $table->foreignId('centro_id')->constrained('centros')->cascadeOnDelete();
            $table->foreignId('nivel_id')->constrained('niveles')->cascadeOnDelete();
            $table->foreignId('curso_id')->constrained('cursos')->cascadeOnDelete();
            $table->foreignId('asignatura_id')->constrained('asignaturas')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apuntes');
    }
};