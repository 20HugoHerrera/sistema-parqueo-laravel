<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'vehiculo_id',
        'usuario_id',       // ← ahora hace referencia directa al usuario autenticado
        'espacio_id',       // ← opcional, si usas control de espacios
        'hora_entrada',
        'estado',
    ];

    // Cada entrada pertenece a un vehículo
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }

    // Cada entrada pertenece a un usuario (quien registró la entrada)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Relación opcional: espacio ocupado por el vehículo
    public function espacio()
    {
        return $this->belongsTo(Espacio::class);
    }
}
