@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-4">Registro de Entradas</h1>
        <div class="d-flex align-items-center gap-3">
            <!-- Contador de espacios -->
            <div class="alert {{ $libres > 0 ? 'alert-success' : 'alert-danger' }} m-0 py-2 px-3 shadow-sm">
                <i class="fas fa-parking me-2"></i>
                {{ $libres > 0 ? "$libres espacio(s) disponible(s)" : '🚫 Parqueo lleno' }}
            </div>
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

    <!-- Formulario de nueva entrada -->
    <div class="card border-0 shadow-lg mb-5">
        <div class="card-header bg-primary text-white fw-semibold">
            <i class="fas fa-plus-circle me-2"></i> Nueva Entrada
        </div>
        <div class="card-body">
            @if($libres > 0)
                <form action="{{ route('entradas.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="placa" class="form-label fw-semibold">Placa del Vehículo</label>
                        <input type="text" name="placa" id="placa" class="form-control" placeholder="Ej: P123-XYZ" required>
                        <div class="form-text text-muted">Debe estar registrado en el sistema.</div>
                    </div>
                    <div class="mb-3">
                        <label for="espacio_id" class="form-label fw-semibold">Espacio</label>
                        <select name="espacio_id" id="espacio_id" class="form-select" required>
                            <option value="">-- Selecciona un espacio --</option>
                            @foreach($espacios as $espacio)
                                @php $ocupado = in_array($espacio->id, $espaciosOcupados); @endphp
                                <option value="{{ $espacio->id }}" {{ $ocupado ? 'disabled' : '' }}>
                                    {{ $espacio->nombre ?? 'Espacio ' . $espacio->id }}
                                    {{ $ocupado ? ' (Ocupado)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
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

    <!-- Filtros -->
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

    <!-- Tabla de historial -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-dark text-white fw-semibold">
            <i class="fas fa-history me-2"></i> Historial de Entradas
        </div>
        <div class="card-body p-0">
            <table class="table table-hover table-striped align-middle mb-0" id="tablaEntradas">
                <thead class="table-light">
                    <tr>
                        <th>Placa</th>
                        <th>Propietario</th>
                        <th>Registrado por</th>
                        <th>Espacio</th>
                        <th>Hora de Entrada</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($entradas as $entrada)
                        <tr>
                            <td>{{ $entrada->vehiculo->placa }}</td>
                            <td>{{ $entrada->vehiculo->propietario ?? 'No asignado' }}</td>
                            <td>{{ $entrada->usuario->name ?? 'No asignado' }}</td>
                            <td>{{ $entrada->espacio->nombre ?? 'No asignado' }}</td>
                            <td>{{ \Carbon\Carbon::parse($entrada->hora_entrada)->format('d/m/Y | H:i') }}
                            <td> 
                                <span class="badge bg-{{ $entrada->estado === 'activo' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($entrada->estado) }}
                                </span>
                             </td>
                                                           
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<script>
    $(document).ready(function(){

        // Filtrar entradas
        $('#btnFiltrar').click(function(event) {
            event.preventDefault();

            let usuario_id = $('#filtro_usuario').val();
            let vehiculo_id = $('#filtro_vehiculo').val();
            let fecha_inicio = $('#fecha_inicio').val();
            let fecha_fin = $('#fecha_fin').val();

            $.ajax({
                url: '{{ route("entradas.filtrar") }}',
                type: 'GET',
                data: { usuario_id, vehiculo_id, fecha_inicio, fecha_fin },
                success: function(res) {
                    let tbody = '';
                    if(res.length > 0){
                        res.forEach(function(e){
                            tbody += `<tr>
                                <td>${e.vehiculo.placa}</td>
                                <td>${e.vehiculo.propietario ?? 'No asignado'}</td>
                                <td>${e.usuario.name ?? 'No asignado'}</td>
                                <td>${e.espacio.nombre ?? 'No asignado'}</td>
                                <td>${new Date(e.hora_entrada).toLocaleString()}</td>
                                <td>${e.estado.charAt(0).toUpperCase() + e.estado.slice(1)}</td>
                            </tr>`;
                        });
                    } else {
                        tbody = '<tr><td colspan="6" class="text-center">No hay registros</td></tr>';
                    }
                    $('#tablaEntradas tbody').html(tbody);
                }
            });
        });

        // Restablecer filtros
        $('#btnReset').click(function(event) {
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
