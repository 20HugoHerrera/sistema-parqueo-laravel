
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehiculos', function (Blueprint $table) {
            $table->dropColumn('usuario_id');
        });
    }

    public function down(): void
    {
        Schema::table('vehiculos', function (Blueprint $table) {
            $table->unsignedBigInteger('usuario_id');
            // Si querés, podés agregar la llave foránea:
            // $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
