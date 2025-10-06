@extends('layouts.app')

@section('title', 'Registro de Salidas')

@section('content')
<div class="container mt-4">

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">🚗 Registro de Salidas</h2>
    </div>

    {{-- Alertas --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <strong>✅ Éxito:</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>⚠️ Error:</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Formulario de registro --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            Registrar Salida
        </div>
        <div class="card-body">
            <form action="{{ route('salidas.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="vehiculo_id" class="form-label">Seleccione el vehículo</label>
                    <select name="vehiculo_id" id="vehiculo_id" class="form-select" required>
                        <option value="">-- Seleccionar vehículo --</option>
                        @foreach(\App\Models\Vehiculo::all() as $vehiculo)
                            <option value="{{ $vehiculo->id }}">
                                {{ $vehiculo->placa }} — {{ $vehiculo->marca ?? 'Sin marca' }}
                            </option>
                        @endforeach
                    </select>
                    @error('vehiculo_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-sign-out-alt"></i> Registrar salida
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabla de salidas --}}
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            Historial de Salidas
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-secondary">
                    <tr>
                        <th>#</th>
                        <th>Placa</th>
                        <th>Hora de salida</th>
                        <th>Registrado por</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($salidas as $salida)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $salida->vehiculo->placa ?? 'No disponible' }}</td>
                            <td>{{ \Carbon\Carbon::parse($salida->hora_salida)->format('d/m/Y H:i') }}</td>
                            <td>{{ $salida->usuario_registro ? \App\Models\User::find($salida->usuario_registro)->name : 'Desconocido' }}</td>
                            <td>{{ $salida->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay registros de salidas aún</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
