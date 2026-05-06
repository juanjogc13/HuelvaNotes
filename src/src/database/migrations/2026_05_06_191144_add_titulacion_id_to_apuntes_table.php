<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('apuntes', function (Blueprint $table) {
            if (!Schema::hasColumn('apuntes', 'titulacion_id')) {
                $table->foreignId('titulacion_id')
                    ->nullable()
                    ->after('nivel_id')
                    ->constrained('titulaciones')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('apuntes', function (Blueprint $table) {
            if (Schema::hasColumn('apuntes', 'titulacion_id')) {
                $table->dropConstrainedForeignId('titulacion_id');
            }
        });
    }
};