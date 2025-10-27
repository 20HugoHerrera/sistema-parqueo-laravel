<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    // Aplicar middleware en el constructor
  

    /**
     * Mostrar listado de usuarios
     */
    public function index()
    {
        $usuarios = User::with('roles')->latest()->get();
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Mostrar formulario para crear usuario
     */
    public function create()
    {
        $roles = Rol::all();
        return view('usuarios.create', compact('roles'));
    }

    /**
     * Guardar nuevo usuario y asignar roles
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'roles' => 'required|array',
        ]);

        $usuario = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Asignar roles
        $usuario->roles()->attach($request->roles);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Mostrar formulario para editar usuario
     */
    public function edit(User $usuario)
    {
        $roles = Rol::all();
        
        $usuarioRoles = $usuario->roles->pluck('id')->toArray();

        return view('usuarios.edit', compact('usuario', 'roles', 'usuarioRoles'));
    }

    /**
     * Actualizar usuario y roles
     */
    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $usuario->id,
            'password' => 'nullable|string|min:6|confirmed',
            'roles' => 'required|array',
        ]);

        $usuario->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $usuario->password,
        ]);

        // Sincronizar roles
        $usuario->roles()->sync($request->roles);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Eliminar usuario
     */
    public function destroy(User $usuario)
    {
        $usuario->roles()->detach(); // eliminar relaciones
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
