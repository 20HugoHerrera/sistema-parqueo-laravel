<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use App\Models\User;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    /**
     * Muestra el listado de vehículos
     */
    public function index()
    {
        $vehiculos = Vehiculo::with('user')->latest()->get();
        return view('vehiculos.index', compact('vehiculos'));
    }

    /**
     * Guarda un nuevo vehículo
     */
    public function store(Request $request)
    {
        $request->validate([
            'placa' => 'required|string|max:10|unique:vehiculos,placa',
            'tipo' => 'required|string|max:50',
            'user_id' => 'required|exists:users,id',
        ]);

        Vehiculo::create($request->only('placa', 'tipo', 'user_id'));

        return redirect()->back()->with('success', 'Vehículo registrado correctamente.');
    }
}
