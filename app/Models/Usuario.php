<?php
;


namespace App\Models;
use App\Models\Rol;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
        public function roles()
    {
        return $this->belongsToMany(Rol::class, 'usuario_roles', 'usuario_id', 'rol_id');
    }

    protected $fillable = [
    'name',
    'email',
    'password',
];


}
