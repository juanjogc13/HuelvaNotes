<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            // Nombre del curso, por ejemplo: 1º ESO, 2º Bachillerato
            $table->string('nombre');
            // A qué nivel pertenece este curso
            $table->foreignId('nivel_id')->constrained('niveles')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
