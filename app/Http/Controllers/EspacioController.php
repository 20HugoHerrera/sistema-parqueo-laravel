<?php

namespace App\Http\Controllers;

use App\Models\Espacio;
use Illuminate\Http\Request;

class EspacioController extends Controller
{
    public function index()
    {
        $espacios = Espacio::all();
        return view('espacios.index', compact('espacios'));
    }

    public function create()
    {
        return view('espacios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|unique:espacios,nombre',
            'descripcion' => 'nullable|string',
        ]);

        Espacio::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'activo' => true,
        ]);

        return redirect()->route('espacios.index')->with('success', 'Espacio agregado correctamente.');
    }

    public function edit(Espacio $espacio)
    {
        return view('espacios.edit', compact('espacio'));
    }

    public function update(Request $request, Espacio $espacio)
    {
        $request->validate([
            'nombre' => 'required|string|unique:espacios,nombre,' . $espacio->id,
            'descripcion' => 'nullable|string',
        ]);

        $espacio->update($request->only('nombre', 'descripcion'));

        return redirect()->route('espacios.index')->with('success', 'Espacio actualizado correctamente.');
    }

    public function destroy(Espacio $espacio)
    {
        $espacio->delete();
        return redirect()->route('espacios.index')->with('success', 'Espacio eliminado correctamente.');
    }
}
