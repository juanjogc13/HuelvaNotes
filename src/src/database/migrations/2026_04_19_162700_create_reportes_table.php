<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reportes', function (Blueprint $table) {
            $table->id();
            // Usuario que hizo el reporte
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            // Apunte reportado
            $table->foreignId('apunte_id')->constrained('apuntes')->cascadeOnDelete();
            // Motivo del reporte
            $table->string('motivo');
            // Si el admin ya revisó el reporte o no
            $table->boolean('resuelto')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};
