@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="fas fa-sign-in-alt me-2"></i> Registro de Entradas
        </h2>

        <div class="d-flex align-items-center gap-3">
            <!-- Mostrar contador de espacios -->
            <div class="alert {{ $libres > 0 ? 'alert-success' : 'alert-danger' }} m-0 py-2 px-3 shadow-sm">
                <i class="fas fa-parking me-2"></i>
                {{ $libres > 0 ? "$libres espacio(s) disponible(s)" : '🚫 Parqueo lleno' }}
            </div>

            <button class="btn btn-success d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalAgregarVehiculo">
                <i class="fas fa-car-side me-2"></i> Nuevo Vehículo
            </button>
        </div>
    </div>

    <!-- Mensajes -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i> Se encontraron algunos errores:
            <ul class="mt-2 mb-0">
                @foreach($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Formulario de entrada -->
    <div class="card border-0 shadow-lg mb-5">
        <div class="card-header bg-primary text-white fw-semibold">
            <i class="fas fa-plus-circle me-2"></i> Nueva Entrada
        </div>
        <div class="card-body">

            @if($libres > 0)
                <form action="{{ route('entradas.store') }}" method="POST">
                    @csrf

                    <!-- Placa (para buscar vehículo existente) -->
                    <div class="mb-3">
                        <label for="placa" class="form-label fw-semibold">Placa del Vehículo</label>
                        <input type="text" name="placa" id="placa" class="form-control" placeholder="Ej: P123-XYZ" required>
                        <div class="form-text text-muted">Debe estar registrado en el sistema.</div>
                    </div>

                    <!-- Espacio -->
                    <div class="mb-3">
                        <label for="espacio_id" class="form-label fw-semibold">Espacio</label>
                        <select name="espacio_id" id="espacio_id" class="form-select" required>
                            <option value="">-- Selecciona un espacio --</option>
                            @foreach($espacios as $espacio)
                                @php
                                    $ocupado = in_array($espacio->id, $espaciosOcupados);
                                @endphp
                                <option value="{{ $espacio->id }}" {{ $ocupado ? 'disabled' : '' }}>
                                    {{ $espacio->nombre ?? 'Espacio ' . $espacio->id }}
                                    {{ $ocupado ? ' — (Ocupado)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Botón -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> Registrar Entrada
                        </button>
                    </div>
                </form>
            @else
                <div class="alert alert-warning text-center fw-semibold py-3 mb-0">
                    🚫 No hay espacios disponibles actualmente. Espere una salida.
                </div>
            @endif
        </div>
    </div>

    <!-- Tabla de historial -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-dark text-white fw-semibold">
            <i class="fas fa-history me-2"></i> Historial de Entradas
        </div>
        <div class="card-body p-0">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Placa</th>
                        <th>Propietario</th>
                        <th>Espacio</th>
                        <th>Hora de Entrada</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($entradas as $entrada)
                        <tr>
                            <td class="fw-semibold">{{ $entrada->vehiculo->placa }}</td>
                            <td>{{ $entrada->vehiculo->user->name ?? 'No asignado' }}</td>
                            <td>{{ $entrada->espacio->nombre ?? 'Sin espacio' }}</td>
                            <td>{{ $entrada->hora_entrada }}</td>
                            <td>
                                <span class="badge bg-{{ $entrada->estado === 'activo' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($entrada->estado) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-info-circle me-2"></i> No hay entradas registradas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

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
                <label for="user_id" class="form-label">Propietario</label>
                <select name="user_id" id="user_id" class="form-select" required>
                    <option value="">-- Selecciona un usuario --</option>
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                    @endforeach
                </select>
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
@endsection
