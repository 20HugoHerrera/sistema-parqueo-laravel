<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Rol;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    // Mostrar formulario de registro
    public function create()
    {
        return view('auth.register');
    }

public function store(Request $request)
{
    // Validación del formulario
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'role' => ['required'], // ✅ nuevo campo
    ]);

    // Crear el usuario
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    // Asignar rol
    $rol = Rol::where('name', 'Usuario')->first();
    $user->roles()->attach($rol->id);

    // Redirigir al login con mensaje de éxito
    return redirect()->route('login')->with('success', 'Usuario registrado correctamente, por favor inicie sesión.');
}



}
