@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <h2 class="mb-4">Gestión de Vehículos</h2>
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <div class="d-flex align-items-center gap-3 mb-3">
        <button class="btn btn-success d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalAgregarVehiculo">
            <i class="fas fa-car-side me-2"></i> Nuevo Vehículo
        </button>
    </div>

    <!-- Modal Agregar Vehículo -->
    <div class="modal fade" id="modalAgregarVehiculo" tabindex="-1" aria-labelledby="modalAgregarVehiculoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content shadow-lg">
                <form action="{{ route('vehiculos.store') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title fw-semibold">
                            <i class="fas fa-car me-2"></i> Registrar Nuevo Vehículo
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="placa" class="form-label">Placa</label>
                            <input type="text" name="placa" id="placa" class="form-control" placeholder="Ej: P123-ABC" required>
                        </div>

                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo</label>
                            <input type="text" name="tipo" id="tipo" class="form-control" placeholder="Ej: Carro, Moto..." required>
                        </div>

                        <div class="mb-3">
                            <label for="propietario" class="form-label">Propietario</label>
                            <input type="text" name="propietario" id="propietario" class="form-control" placeholder="Nombre del propietario" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> Guardar Vehículo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabla de Vehículos -->
        <div class="card shadow-sm mt-4">        
            <div class="card-header bg-primary text-white fw-semibold">
                <i class="fas me-2"></i>Vehiculos 🚗
            </div>
        <div class="card-body p-0">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Placa</th>
                        <th>Tipo</th>
                        <th>Propietario</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vehiculos as $vehiculo)
                        <tr>
                            <td class="fw-semibold">{{ $vehiculo->placa }}</td>
                            <td>{{ $vehiculo->tipo ?? 'No asignado' }}</td>
                            <td>{{ $vehiculo->propietario ?? 'No asignado' }}</td>
                            <td class="text-center">
                                <!-- Botón Editar -->
                                <button class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#modalEditarVehiculo{{ $vehiculo->id }}">
                                    <i class="fas fa-edit"></i> Editar
                                </button>

                                <!-- Botón Eliminar -->
                                <form action="{{ route('vehiculos.destroy', $vehiculo->id) }}" method="POST" class="d-inline" <!-- Botón Eliminar -->
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmarEliminar{{ $vehiculo->id }}">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>

                                <!-- Modal de Confirmación -->
                                <div class="modal fade" id="confirmarEliminar{{ $vehiculo->id }}" tabindex="-1" aria-labelledby="confirmarEliminarLabel{{ $vehiculo->id }}" aria-hidden="true">
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
                                                    ¿Estás seguro de que deseas eliminar el vehículo <strong>{{ $vehiculo->placa }}</strong>?
                                                </p>
                                                <p class="text-muted small">Esta acción no se puede deshacer.</p>
                                            </div>

                                            <div class="modal-footer justify-content-center">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                    <i class="fas fa-times me-2"></i> Cancelar
                                                </button>
                                                <form action="{{ route('vehiculos.destroy', $vehiculo->id) }}" method="POST" class="d-inline">
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
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Editar Vehículo -->
                        <div class="modal fade" id="modalEditarVehiculo{{ $vehiculo->id }}" tabindex="-1" aria-labelledby="modalEditarVehiculoLabel{{ $vehiculo->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content shadow-lg">
                                    <form action="{{ route('vehiculos.update', $vehiculo->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-header bg-warning text-dark">
                                            <h5 class="modal-title fw-semibold">
                                                <i class="fas fa-edit me-2"></i> Editar Vehículo
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Placa</label>
                                                <input type="text" name="placa" class="form-control" value="{{ $vehiculo->placa }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Tipo</label>
                                                <input type="text" name="tipo" class="form-control" value="{{ $vehiculo->tipo }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Propietario</label>
                                                <input type="text" name="propietario" class="form-control" value="{{ $vehiculo->propietario }}" required>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                <i class="fas fa-times me-2"></i> Cancelar
                                            </button>
                                            <button type="submit" class="btn btn-warning">
                                                <i class="fas fa-save me-2"></i> Actualizar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="fas fa-info-circle me-2"></i> No hay vehículos registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
