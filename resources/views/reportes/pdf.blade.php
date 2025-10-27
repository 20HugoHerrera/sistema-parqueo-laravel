
// ...existing code...
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Vehículos</title>
    <style>
        @page { margin: 20mm 15mm; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #222; margin: 0; }
        .container { padding: 6mm; }
        .header { display:flex; align-items:center; justify-content:space-between; margin-bottom:8px; }
        .brand { display:flex; align-items:center; gap:10px; }
        .brand img { height:50px; object-fit:contain; }
        .title { text-align:center; }
        h1 { margin:0; font-size:16px; }
        .subtitle { margin:0; font-size:12px; color:#555; }
        .summary { display:flex; gap:12px; flex-wrap:wrap; margin:12px 0; }
        .summary .item { background:#f5f7fb; padding:8px 10px; border-radius:4px; font-size:12px; }
        table { width:100%; border-collapse:collapse; font-size:11px; }
        th, td { border:1px solid #ccc; padding:6px 8px; text-align:left; vertical-align:middle; }
        th { background:#1a73e8; color:#fff; font-weight:600; font-size:11px; }
        tr:nth-child(even) td { background:#fbfcfe; }
        .footer { position:fixed; left:0; right:0; bottom:10px; text-align:center; font-size:10px; color:#666; }
        tr { page-break-inside: avoid; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="brand">
                @php $logoPath = public_path('images/logo.png'); @endphp
                @if(file_exists($logoPath))
                    <img src="{{ $logoPath }}" alt="Logo">
                @endif
                <div class="title">
                    <h1>Reporte de Vehículos</h1>
                    <p class="subtitle">Sistema de Parqueo</p>
                </div>
            </div>

            <div style="text-align:right;">
                <strong>Generado:</strong><br>
                {{ now()->format('d/m/Y H:i') }}
            </div>
        </div>

        <div style="margin-top:6px;">
            <small>
                @if(!empty($desde) || !empty($hasta))
                    Rango: {{ $desde ?? '-' }} — {{ $hasta ?? '-' }}.
                @endif
                @if(!empty($filtros))
                    &nbsp;|&nbsp; Filtros: {{ $filtros }}
                @endif
            </small>
        </div>

        @php
            $collection = is_iterable($vehiculos) ? collect($vehiculos) : collect();
            $ocupados = $collection->filter(fn($v) => ($v->ocupado ?? false) === true)->count();
            $espacios_libres = $espaciosLibres ?? $libres ?? (isset($capacidad) ? max(0, $capacidad - $ocupados) : null);
        @endphp

        <div class="summary" style="margin-top:10px;">
            <div class="item">Total Entradas: <strong>{{ number_format($totalEntradas ?? 0) }}</strong></div>
            <div class="item">Total Salidas: <strong>{{ number_format($totalSalidas ?? 0) }}</strong></div>
            <div class="item">Promedio Estadia: <strong>{{ number_format($promedioEstadia ?? 0, 0) }} min</strong></div>
            <div class="item">Espacios libres: <strong>{{ $espacios_libres !== null ? number_format($espacios_libres) : '-' }}</strong></div>
            @if(isset($totalEspacios))
                <div class="item">Capacidad: <strong>{{ number_format($totalEspacios) }}</strong></div>
                <div class="item">Ocupados: <strong>{{ number_format($ocupados) }}</strong></div>
            @endif
        </div>

        @if($collection->isEmpty())
            <p>No hay registros para mostrar.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th style="width:4%;">ID</th>
                        <th style="width:18%;">Propietario</th>
                        <th style="width:10%;">Placa</th>
                        <th style="width:12%;">Marca/Tipo</th>
                        <th style="width:12%;">Espacio</th>
                        <th style="width:12%;">Entrada</th>
                        <th style="width:12%;">Salida</th>
                        <th style="width:10%; text-align:right;">Tiempo (min)</th>
                        <th style="width:10%;">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($collection as $vehiculo)
                        @php
                            $entradaRaw = $vehiculo->entrada ?? null;
                            $salidaRaw  = $vehiculo->salida ?? null;

                            // Formatear entrada
                            $entradaFormatted = '-';
                            if ($entradaRaw instanceof \Carbon\Carbon) {
                                $entradaFormatted = $entradaRaw->format('d/m/Y H:i');
                            } elseif (!empty($entradaRaw)) {
                                try { $entradaFormatted = \Carbon\Carbon::parse($entradaRaw)->format('d/m/Y H:i'); } catch (\Throwable $e) { $entradaFormatted = (string)$entradaRaw; }
                            }

                            // Formatear salida
                            $salidaFormatted = '-';
                            if ($salidaRaw instanceof \Carbon\Carbon) {
                                $salidaFormatted = $salidaRaw->format('d/m/Y H:i');
                            } elseif (!empty($salidaRaw)) {
                                try { $salidaFormatted = \Carbon\Carbon::parse($salidaRaw)->format('d/m/Y H:i'); } catch (\Throwable $e) { $salidaFormatted = (string)$salidaRaw; }
                            }

                            $tiempo = isset($vehiculo->tiempo) ? $vehiculo->tiempo : null;
                            $estado = ($vehiculo->ocupado ?? false) ? 'Activo' : 'Finalizado';
                        @endphp
                        <tr>
                            <td>{{ $vehiculo->id ?? '-' }}</td>
                            <td>{{ $vehiculo->propietario ?? '-' }}</td>
                            <td>{{ $vehiculo->placa ?? '-' }}</td>
                            <td>{{ $vehiculo->tipo ?? '-' }}</td>
                            <td>{{ $vehiculo->espacio ?? '-' }}</td>
                            <td>{{ $entradaFormatted }}</td>
                            <td>{{ $salidaFormatted }}</td>
                            <td style="text-align:right;">{{ $tiempo !== null ? number_format($tiempo, 0) : '-' }}</td>
                            <td>{{ $estado }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>

    <div class="footer">
        Página <span class="page">{PAGE_NUM}</span> de {PAGE_COUNT} — Generado el {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>