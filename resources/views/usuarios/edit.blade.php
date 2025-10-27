@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <h2 class="fw-bold text-primary mb-4">
        <i class="fas fa-user-edit me-2"></i> Editar Usuario
    </h2>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm">
            <i class="fas fa-exclamation-triangle me-2"></i> Se encontraron errores:
            <ul class="mt-2 mb-0">
                @foreach($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-lg">
        <div class="card-body">
            <form action="{{ route('usuarios.update', $usuario) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Nombre</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $usuario->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $usuario->email) }}" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Nueva Contraseña (opcional)</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label fw-semibold">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Roles</label>
                    <div class="d-flex gap-3 flex-wrap">
                        @foreach($roles as $rol)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $rol->id }}"
                                    id="rol_{{ $rol->id }}"
                                    {{ in_array($rol->id, $usuarioRoles) ? 'checked' : '' }}>
                                <label class="form-check-label" for="rol_{{ $rol->id }}">{{ ucfirst($rol->name) }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="text-end">
                    <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> Actualizar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
