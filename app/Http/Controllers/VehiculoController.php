<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehiculoController extends Controller
{
    /**
     * Muestra el listado de vehículos.
     */
    public function index()
    {
        $vehiculos = Vehiculo::latest()->get();
        return view('vehiculos.index', compact('vehiculos'));
    }

    /**
     * Guarda un nuevo vehículo (solo admin).
     */
    public function store(Request $request)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'No tienes permiso para realizar esta acción.');
        }

        $request->validate([
            'placa' => 'required|string|max:10|unique:vehiculos,placa',
            'tipo' => 'required|string|max:50',
            'propietario' => 'required|string|max:100',
        ]);

        Vehiculo::create([
            'placa' => $request->placa,
            'tipo' => $request->tipo,
            'propietario' => $request->propietario,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('vehiculos.index')->with('success', 'Vehículo registrado correctamente.');
    }

    /**
     * Actualiza los datos de un vehículo (solo admin).
     */
    public function update(Request $request, Vehiculo $vehiculo)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'No tienes permiso para realizar esta acción.');
        }

        $request->validate([
            'placa' => 'required|string|max:10|unique:vehiculos,placa,' . $vehiculo->id,
            'tipo' => 'required|string|max:50',
            'propietario' => 'required|string|max:100',
        ]);

        $vehiculo->update([
            'placa' => $request->placa,
            'tipo' => $request->tipo,
            'propietario' => $request->propietario,
        ]);

        return redirect()->route('vehiculos.index')->with('success', 'Vehículo actualizado correctamente.');
    }

    /**
     * Elimina un vehículo (solo admin).
     */
    public function destroy(Vehiculo $vehiculo)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'No tienes permiso para realizar esta acción.');
        }

        // Verificar si el vehículo tiene una salida registrada
        $tieneSalida = \DB::table('salidas')
            ->where('vehiculo_id', $vehiculo->id)
            ->exists();

        if (!$tieneSalida) {
            return redirect()->route('vehiculos.index')
                ->with('error', 'No se puede eliminar el vehículo porque aún no ha salido.');
        }

        $vehiculo->delete();

        return redirect()->route('vehiculos.index')
            ->with('success', 'Vehículo eliminado correctamente.');
    }

}

