<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rol extends Model
{
    use HasFactory;

    // Nombre explícito de la tabla (por si difiere del plural automático)
    protected $table = 'roles';

    // Campos asignables
    protected $fillable = ['name'];

    /**
     * Relación muchos a muchos con usuarios.
     * Un rol puede pertenecer a varios usuarios.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'usuario_roles', 'rol_id', 'user_id');
    }
}
