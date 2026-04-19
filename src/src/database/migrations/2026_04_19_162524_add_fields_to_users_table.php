<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Cada usuario empieza con 50 puntos para poder descargar
            $table->integer('puntos')->default(50);
            // El centro al que pertenece el usuario (puede no tener)
            $table->foreignId('centro_id')->nullable()->constrained('centros')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Si deshacemos la migración, eliminamos los campos añadidos
            $table->dropColumn(['puntos', 'centro_id']);
        });
    }
};
