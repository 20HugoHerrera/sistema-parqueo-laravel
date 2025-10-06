<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        $adminRol = Rol::where('nombre', 'Administrador')->first();

        $usuario = Usuario::firstOrCreate(
            ['email' => 'admin@sistema.com'],
            [
                'nombre' => 'Admin',
                'password' => Hash::make('admin123'),
            ]
        );

        if (!$usuario->roles->contains($adminRol->id)) {
            $usuario->roles()->attach($adminRol->id);
        }
    }
}
