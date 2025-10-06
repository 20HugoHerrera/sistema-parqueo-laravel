<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Rol extends Model
{
    protected $table = 'roles';
    protected $fillable = ['name'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'usuario_roles', 'rol_id', 'user_id');
    }
}
