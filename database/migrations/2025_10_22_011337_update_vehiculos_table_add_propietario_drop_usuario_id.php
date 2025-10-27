<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehiculos', function (Blueprint $table) {
            // Eliminar columna usuario_id si existe
            if (Schema::hasColumn('vehiculos', 'usuario_id')) {
                $table->dropColumn('usuario_id');
            }

            // Agregar columna propietario si no existe
            if (!Schema::hasColumn('vehiculos', 'propietario')) {
                $table->string('propietario')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('vehiculos', function (Blueprint $table) {
            // Revertir cambios
            if (Schema::hasColumn('vehiculos', 'propietario')) {
                $table->dropColumn('propietario');
            }

            if (!Schema::hasColumn('vehiculos', 'usuario_id')) {
                $table->foreignId('usuario_id')->nullable()->constrained('users')->onDelete('cascade');
            }
        });
    }
};

