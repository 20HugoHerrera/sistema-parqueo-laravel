<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use App\Models\Vehiculo;
use App\Models\Espacio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntradaController extends Controller
{
    /**
     * Muestra todas las entradas registradas
     */
    public function index()
    {
        $entradas = Entrada::with(['vehiculo', 'usuario', 'espacio'])->latest()->get();
        $vehiculos = Vehiculo::all();
        $usuarios = User::all();
        $espacios = Espacio::where('activo', true)->get();

        // Espacios ocupados
        $espaciosOcupados = Entrada::where('estado', 'activo')->pluck('espacio_id')->toArray();

        // Espacios libres
        $libres = $espacios->count() - count($espaciosOcupados);

        return view('entradas.index', compact(
            'entradas',
            'vehiculos',
            'usuarios',
            'espacios',
            'espaciosOcupados',
            'libres'
        ));
    }

    /**
     * Registra una nueva entrada
     */
    public function store(Request $request)
    {
        $request->validate([
            'placa' => 'required|string|max:10',
            'espacio_id' => 'required|exists:espacios,id',
        ]);

        // Buscar vehículo por placa
        $vehiculo = Vehiculo::where('placa', $request->placa)->first();
        if (!$vehiculo) {
            return back()->withErrors(['placa' => 'El vehículo no está registrado.']);
        }

        // Verificar si el vehículo ya tiene una entrada activa
        $entradaActiva = Entrada::where('vehiculo_id', $vehiculo->id)
            ->where('estado', 'activo')
            ->first();

        if ($entradaActiva) {
            return back()->withErrors(['placa' => 'Este vehículo ya está dentro del parqueo.']);
        }

        // Verificar si el espacio está ocupado
        $ocupado = Entrada::where('espacio_id', $request->espacio_id)
            ->where('estado', 'activo')
            ->exists();

        if ($ocupado) {
            return back()->withErrors(['espacio_id' => 'El espacio seleccionado ya está ocupado.']);
        }

        // Registrar la entrada
        Entrada::create([
            'vehiculo_id' => $vehiculo->id,
            'usuario_id' => Auth::id(),
            'espacio_id' => $request->espacio_id,
            'hora_entrada' => now(),
            'estado' => 'activo',
        ]);

        return redirect()->route('entradas.index')->with('success', 'Entrada registrada correctamente.');
    }

    /**
     * Finalizar entrada manualmente
     */
    public function finalizar($id)
    {
        $entrada = Entrada::findOrFail($id);
        $entrada->estado = 'finalizado';
        $entrada->hora_salida = now();
        $entrada->save();

        return redirect()->route('entradas.index')->with('success', 'Entrada finalizada correctamente.');
    }
}
