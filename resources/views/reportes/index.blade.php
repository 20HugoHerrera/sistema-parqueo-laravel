@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Reportes 📊</h2>

    <!-- Filtros -->
    <form method="GET" action="{{ route('reportes.index') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <select name="usuario_id" class="form-select">
                <option value="">-- Todos los usuarios --</option>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}" {{ request('usuario_id')==$usuario->id ? 'selected' : '' }}>{{ $usuario->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="vehiculo_id" class="form-select">
                <option value="">-- Todos los vehículos --</option>
                @foreach($vehiculos as $vehiculo)
                    <option value="{{ $vehiculo->id }}" {{ request('vehiculo_id')==$vehiculo->id ? 'selected' : '' }}>{{ $vehiculo->placa }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2"><input type="date" name="fecha_inicio" class="form-control" value="{{ request('fecha_inicio') }}"></div>
        <div class="col-md-2"><input type="date" name="fecha_fin" class="form-control" value="{{ request('fecha_fin') }}"></div>
        <div class="col-md-2 text-end">
            <button class="btn btn-primary">Filtrar</button>
        </div>
    </form>

    <!-- Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-3"><div class="card text-center shadow-sm p-3">Total Entradas: {{ $totalEntradas }}</div></div>
        <div class="col-md-3"><div class="card text-center shadow-sm p-3">Total Salidas: {{ $totalSalidas }}</div></div>
        <div class="col-md-3"><div class="card text-center shadow-sm p-3">Promedio Estadia: {{ round($promedioEstadia, 2) }} min</div></div>
        <div class="col-md-3"><div class="card text-center shadow-sm p-3">Espacios libres: {{ $libres }}/{{ $totalEspacios }}</div></div>
    </div>

    <!-- Botones Exportar -->
    <div class="mb-3 text-end">
        <a href="{{ route('reportes.pdf', request()->query()) }}" class="btn btn-danger"><i class="fas fa-file-pdf"></i> PDF</a>

        <a href="{{ route('reportes.exportCsv', request()->query()) }}" class="btn btn-success"><i class="fas fa-file-excel"></i> Excel</a>
        

    </div>

    <!-- Gráficos -->
    <div class="row mb-4">
        <div class="col-md-6"><canvas id="graficoOcupacion"></canvas></div>
        <div class="col-md-6"><canvas id="graficoUsuarios"></canvas></div>
    </div>

    <!-- Tabla de entradas -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-dark text-white">Historial de Entradas y Salidas</div>
        <div class="card-body p-0">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Placa</th>
                        <th>Propietario</th>
                        <th>Usuario</th>
                        <th>Espacio</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                        <th>Tiempo Estadia</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($entradas as $entrada)
                        @php
                            $salida = $salidas->where('vehiculo_id',$entrada->vehiculo_id)->first();
                        @endphp
                        <tr>
                            <td>{{ $entrada->vehiculo->placa }}</td>
                            <td>{{ $entrada->vehiculo->propietario ?? 'No asignado' }}</td>
                            <td>{{ $entrada->usuario->name ?? 'No asignado' }}</td>
                            <td>{{ $entrada->espacio->nombre ?? 'No asignado' }}</td>
                            <td>{{ $entrada->hora_entrada }}</td>
                            <td>{{ $salida->hora_salida ?? 'Activo' }} </td>
        
                            <td>{{ $salida ? $salida->tiempo_estadia.' min' : '-' }}</td>
                        </tr>

                        
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx1 = document.getElementById('graficoOcupacion').getContext('2d');
const graficoOcupacion = new Chart(ctx1, {
    type: 'doughnut',
    data: {
        labels: ['Ocupados', 'Libres'],
        datasets: [{
            data: [{{ $ocupados }}, {{ $libres }}],
            backgroundColor: ['#dc3545','#28a745']
        }]
    }
});

const ctx2 = document.getElementById('graficoUsuarios').getContext('2d');
const graficoUsuarios = new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: {!! json_encode($usuarios->pluck('name')) !!},
        datasets: [{
            label: 'Entradas por usuario',
            data: {!! json_encode($usuarios->map(fn($u)=>$entradas->where('usuario_id',$u->id)->count())) !!},
            backgroundColor: '#007bff'
        }]
    }
});
</script>
@endsection
