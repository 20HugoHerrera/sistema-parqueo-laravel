<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Rol;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    // Relación con roles (Muchos a Muchos)
    public function roles()
    {
        // IMPORTANTE: tabla pivote 'usuario_roles', columnas correctas
        return $this->belongsToMany(Rol::class, 'usuario_roles', 'user_id', 'rol_id');
    }

    // Relación con vehículos (Un usuario puede tener varios)
    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class);
    }

    // Verificar si el usuario tiene un rol específico
    public function hasRole($rol)
    {
        return $this->roles()->where('name', $rol)->exists();
    }
}
