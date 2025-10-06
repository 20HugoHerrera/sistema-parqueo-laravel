@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Gestión de Espacios</h2>

    <a href="{{ route('espacios.create') }}" class="btn btn-success mb-3">
        <i class="fas fa-plus me-2"></i> Agregar Nuevo Espacio
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($espacios as $espacio)
                <tr>
                    <td>{{ $espacio->nombre }}</td>
                    <td>{{ $espacio->descripcion }}</td>
                    <td>{{ $espacio->activo ? 'Sí' : 'No' }}</td>
                    <td>
                        <a href="{{ route('espacios.edit', $espacio) }}" class="btn btn-sm btn-primary">
                            Editar
                        </a>
                        <form action="{{ route('espacios.destroy', $espacio) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este espacio?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No hay espacios registrados</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
