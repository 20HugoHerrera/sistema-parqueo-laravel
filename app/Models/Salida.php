<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salida extends Model
{
    protected $fillable = [
        'vehiculo_id',
        'usuario_id',        // ← usuario que registró la salida
        'hora_salida',
        'tiempo_estadia',    // ← duración en minutos (opcional)
    ];

    // Relación con el vehículo
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }

    // Relación con el usuario (quien registró la salida)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
