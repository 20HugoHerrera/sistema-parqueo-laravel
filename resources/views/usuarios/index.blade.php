@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4"> Gestión de Usuarios</h2>

    <div class="d-flex justify-content-between align-items-center mb-4">

        <a href="{{ route('usuarios.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i> Nuevo Usuario
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>
                                @foreach($usuario->roles as $rol)
                                    <span class="badge bg-primary">{{ ucfirst($rol->name) }}</span>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit me-1"></i> Editar
                                </a>
                                <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este usuario?')">
                                        <i class="fas fa-trash me-1"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="fas fa-info-circle me-2"></i> No hay usuarios registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
