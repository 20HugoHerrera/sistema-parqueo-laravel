<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salidas', function (Blueprint $table) {
            $table->id();

            // Llaves foráneas
            $table->foreignId('vehiculo_id')->constrained('vehiculos')->onDelete('cascade');
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');

            // Datos
            $table->timestamp('hora_salida')->useCurrent();
            $table->integer('tiempo_estadia')->nullable(); // minutos dentro del parqueo

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salidas');
    }
};
