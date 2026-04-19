<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asignaturas', function (Blueprint $table) {
            $table->id();
            // Nombre de la asignatura, por ejemplo: Matemáticas, Historia
            $table->string('nombre');
            // A qué curso pertenece esta asignatura
            $table->foreignId('curso_id')->constrained('cursos')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asignaturas');
    }
};