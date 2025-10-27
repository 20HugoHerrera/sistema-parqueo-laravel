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

    <!-- Card principal -->
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-primary text-white fw-semibold">
            <i class="fas fa-parking me-2"></i> Espacios de Parqueo
        </div>
        <div class="card-body p-0">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($espacios as $espacio)
                        @php
                            // Verificar si el espacio tiene una entrada activa
                            $ocupado = $espacio->entradas()->where('estado', 'activo')->exists();
                        @endphp
                        <tr>
                            <td class="fw-semibold">{{ $espacio->nombre }}</td>
                            <td>{{ $espacio->descripcion ?? 'Sin descripción' }}</td>

                            <!-- Estado -->
                            <td class="text-center">
                                @if($ocupado)
                                    <span class="badge bg-danger px-3 py-2">
                                        <i class="fas fa-car me-1"></i> Ocupado
                                    </span>
                                @else
                                    <span class="badge bg-success px-3 py-2">
                                        <i class="fas fa-parking me-1"></i> Disponible
                                    </span>
                                @endif
                            </td>

                            <td class="text-center">
                                <!-- Botón Editar -->
                                <a href="{{ route('espacios.edit', $espacio) }}" class="btn btn-warning btn-sm me-2">
                                    <i class="fas fa-edit"></i> Editar
                                </a>

                                <!-- Botón Eliminar -->
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmarEliminarEspacio{{ $espacio->id }}">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>

                                <!-- Modal Confirmación -->
                                <div class="modal fade" id="confirmarEliminarEspacio{{ $espacio->id }}" tabindex="-1" aria-labelledby="confirmarEliminarEspacioLabel{{ $espacio->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content shadow-lg border-danger">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title">
                                                    <i class="fas fa-exclamation-triangle me-2"></i> Confirmar eliminación
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <p class="mb-3">
                                                    ¿Estás seguro de que deseas eliminar el espacio 
                                                    <strong>{{ $espacio->nombre }}</strong>?
                                                </p>
                                                <p class="text-muted small">Esta acción no se puede deshacer.</p>
                                            </div>
                                            <div class="modal-footer justify-content-center">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                    <i class="fas fa-times me-2"></i> Cancelar
                                                </button>
                                                <form action="{{ route('espacios.destroy', $espacio) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-trash-alt me-2"></i> Sí, eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-info-circle me-2"></i> No hay espacios registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endpush
