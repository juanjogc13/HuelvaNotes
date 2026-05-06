<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('apuntes', function (Blueprint $table) {
            if (!Schema::hasColumn('apuntes', 'estado')) {
                $table->string('estado')->default('pendiente')->after('coste_puntos');
            }
        });
    }

    public function down(): void
    {
        Schema::table('apuntes', function (Blueprint $table) {
            if (Schema::hasColumn('apuntes', 'estado')) {
                $table->dropColumn('estado');
            }
        });
    }
};