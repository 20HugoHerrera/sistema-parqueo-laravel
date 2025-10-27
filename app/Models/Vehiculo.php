<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $fillable = [
        'placa', 'tipo', 'propietario', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function entradas()
    {
        return $this->hasMany(Entrada::class);
    }

    public function salidas()
    {
        return $this->hasMany(Salida::class);
    }
}
