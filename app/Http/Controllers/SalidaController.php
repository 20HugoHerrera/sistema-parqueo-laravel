<?php

namespace App\Http\Controllers;

use App\Models\Salida;
use App\Models\Entrada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SalidaController extends Controller
{
    /**
     * Mostrar listado de salidas registradas
     */
    public function index()
    {
        $salidas = Salida::with(['vehiculo', 'usuario'])->latest()->get();
        return view('salidas.index', compact('salidas'));
    }

    /**
     * Registrar la salida de un vehículo
     */
    public function store(Request $request)
    {
        $request->validate([
            'vehiculo_id' => 'required|exists:vehiculos,id',
        ]);

        // Buscar la entrada activa del vehículo
        $entrada = Entrada::where('vehiculo_id', $request->vehiculo_id)
            ->where('estado', 'activo')
            ->first();

        if (!$entrada) {
            return back()->with('error', 'Este vehículo no tiene una entrada activa.');
        }

        $horaSalida = Carbon::now();
        $horaEntrada = Carbon::parse($entrada->hora_entrada);
        $duracionMinutos = $horaEntrada->diffInMinutes($horaSalida);

        // Registrar salida
        Salida::create([
            'vehiculo_id' => $request->vehiculo_id,
            'hora_salida' => $horaSalida,
            'usuario_id' => Auth::id(),   // <-- corregido
            'tiempo_estadia' => $duracionMinutos,
        ]);

        // Finalizar entrada para liberar espacio
        $entrada->update([
            'estado' => 'finalizado',
            'hora_salida' => $horaSalida,
        ]);

        return redirect()->route('salidas.index')->with('success', 'Salida registrada correctamente. Duración: ' . $duracionMinutos . ' minutos');
    }
}
