@extends('layouts.app')

@section('title', 'Registro de Salidas')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Gestión de Salidas</h2>

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

    
    {{-- Formulario de salida --}}
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
                        <option value="">- Seleccionar vehículo -</option>
                        @foreach($vehiculos as $vehiculo)
                            <option value="{{ $vehiculo->id }}">
                                {{ $vehiculo->placa }} | {{ $vehiculo->tipo ?? '' }}
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


    {{-- Filtros --}}
    <div class="card mb-4 p-3 shadow-sm">
        <div class="row g-3">
            <div class="col-md-3">
                <select id="filtro_usuario" class="form-select">
                    <option value="">-- Todos los usuarios --</option>
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select id="filtro_vehiculo" class="form-select">
                    <option value="">-- Todos los vehículos --</option>
                    @foreach($vehiculos as $vehiculo)
                        <option value="{{ $vehiculo->id }}">{{ $vehiculo->placa }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" id="fecha_inicio" class="form-control">
            </div>
            <div class="col-md-3">
                <input type="date" id="fecha_fin" class="form-control">
            </div>
        </div>
        <div class="text-end mt-2">
            <button type="button" id="btnFiltrar" class="btn btn-primary">Filtrar</button>
            <button type="button" id="btnReset" class="btn btn-secondary">Restablecer</button>
        </div>
    </div>

    {{-- Tabla de salidas --}}
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            Historial de Salidas
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle" id="tablaSalidas">
                <thead class="table-secondary">
                    <tr>
                        <th>#</th>
                        <th>Placa</th>
                        <th>Hora de salida</th>
                        <th>Tiempo de estadía</th>
                        <th>Registrado por</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($salidas as $salida)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $salida->vehiculo->placa ?? 'No disponible' }}</td>
                            <td>{{ \Carbon\Carbon::parse($salida->hora_salida)->format('d/m/Y H:i') }}</td>
                            <td>
                                @php
                                    $horas = floor($salida->tiempo_estadia / 60);
                                    $minutos = $salida->tiempo_estadia % 60;
                                @endphp
                                {{ $horas > 0 ? $horas . ' h ' : '' }}{{ $minutos }} min
                            </td>
                            <td>{{ $salida->usuario->name ?? 'Desconocido' }}</td>
                            <td>{{ $salida->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<script>
$(document).ready(function(){

    // Filtrar salidas
    $('#btnFiltrar').click(function(event){
        event.preventDefault();

        let usuario_id = $('#filtro_usuario').val();
        let vehiculo_id = $('#filtro_vehiculo').val();
        let fecha_inicio = $('#fecha_inicio').val();
        let fecha_fin = $('#fecha_fin').val();

        $.ajax({
            url: '{{ route("salidas.filtrar") }}',
            type: 'GET',
            data: { usuario_id, vehiculo_id, fecha_inicio, fecha_fin },
            success: function(res){
                let tbody = '';
                if(res.length > 0){
                    res.forEach(function(e, i){
                        let horas = Math.floor(e.tiempo_estadia / 60);
                        let minutos = e.tiempo_estadia % 60;
                        tbody += `<tr>
                            <td>${i+1}</td>
                            <td>${e.vehiculo.placa ?? 'No disponible'}</td>
                            <td>${new Date(e.hora_salida).toLocaleString()}</td>
                            <td>${horas > 0 ? horas+' h ' : ''}${minutos} min</td>
                            <td>${e.usuario.name ?? 'Desconocido'}</td>
                            <td>${new Date(e.created_at).toLocaleDateString()}</td>
                        </tr>`;
                    });
                } else {
                    tbody = '<tr><td colspan="6" class="text-center">No hay registros</td></tr>';
                }
                $('#tablaSalidas tbody').html(tbody);
            }
        });
    });

    // Restablecer filtros
    $('#btnReset').click(function(event){
        event.preventDefault();
        $('#filtro_usuario').val('');
        $('#filtro_vehiculo').val('');
        $('#fecha_inicio').val('');
        $('#fecha_fin').val('');
        $('#btnFiltrar').click();
    });

});
</script>
@endsection
