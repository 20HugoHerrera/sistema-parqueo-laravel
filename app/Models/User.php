<?php

namespace App\Models;

use App\Models\Rol;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles; // <-- importar el trait correcto

class User extends Authenticatable
{
    use Notifiable, HasFactory, HasRoles; // <-- añadir HasRoles

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
    ];

      public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/avatars/' . $this->avatar);
        }

        return asset('images/default-avatar.png');
    }


    /**
     * Relación muchos a muchos con roles.
     */
    public function roles()
    {
        // tabla pivote usuario_roles, columnas: user_id, rol_id
        return $this->belongsToMany(Rol::class, 'usuario_roles', 'user_id', 'rol_id');
    }

    /**
     * Relación uno a muchos con vehículos.
     */
    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class);
    }

    /**
     * Verificar si el usuario tiene un rol específico.
     *
     * Nota: Spatie ya implementa hasRole(); si usas el trait esta función puede eliminarse
     * para evitar conflictos y usar la implementación del paquete.
     */
    public function hasRole($rol)
    {
        return $this->roles()->where('name', $rol)->exists();
    }
}