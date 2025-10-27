<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entrada;
use App\Models\Salida;
use App\Models\User;
use App\Models\Vehiculo;
use App\Models\Espacio;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel; // Para Excel
use App\Exports\EntradasExport; // Export personalizado

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        $usuarios = User::all();
        $vehiculos = Vehiculo::all();

        $queryEntradas = Entrada::with(['vehiculo','usuario','espacio']);
        $querySalidas = Salida::with(['vehiculo','usuario']);

        // Filtros
        if($request->usuario_id) {
            $queryEntradas->where('usuario_id', $request->usuario_id);
            $querySalidas->where('usuario_id', $request->usuario_id);
        }

        if($request->vehiculo_id) {
            $queryEntradas->where('vehiculo_id', $request->vehiculo_id);
            $querySalidas->where('vehiculo_id', $request->vehiculo_id);
        }

        if($request->fecha_inicio) {
            $queryEntradas->whereDate('hora_entrada', '>=', $request->fecha_inicio);
            $querySalidas->whereDate('hora_salida', '>=', $request->fecha_inicio);
        }

        if($request->fecha_fin) {
            $queryEntradas->whereDate('hora_entrada', '<=', $request->fecha_fin);
            $querySalidas->whereDate('hora_salida', '<=', $request->fecha_fin);
        }

        $entradas = $queryEntradas->get();
        $salidas = $querySalidas->get();

        // Estadísticas
        $totalEntradas = $entradas->count();
        $totalSalidas = $salidas->count();
        $promedioEstadia = $salidas->avg('tiempo_estadia');

        // Capacidad parqueo
        $totalEspacios = Espacio::where('activo', true)->count();
        $ocupados = Entrada::where('estado', 'activo')->count();
        $libres = $totalEspacios - $ocupados;

        return view('reportes.index', compact(
            'usuarios', 'vehiculos', 'entradas', 'salidas', 
            'totalEntradas', 'totalSalidas', 'promedioEstadia',
            'totalEspacios', 'ocupados', 'libres'
        ));
    }

    // Exportar PDF

// ...existing code...
public function exportPDF(Request $request)
{
    // Reproducir mismos filtros que en index
    $queryEntradas = Entrada::with(['vehiculo','usuario','espacio']);
    $querySalidas = Salida::with(['vehiculo','usuario']);

    if($request->usuario_id) {
        $queryEntradas->where('usuario_id', $request->usuario_id);
        $querySalidas->where('usuario_id', $request->usuario_id);
    }

    if($request->vehiculo_id) {
        $queryEntradas->where('vehiculo_id', $request->vehiculo_id);
        $querySalidas->where('vehiculo_id', $request->vehiculo_id);
    }

    if($request->fecha_inicio) {
        $queryEntradas->whereDate('hora_entrada', '>=', $request->fecha_inicio);
        $querySalidas->whereDate('hora_salida', '>=', $request->fecha_inicio);
    }

    if($request->fecha_fin) {
        $queryEntradas->whereDate('hora_entrada', '<=', $request->fecha_fin);
        $querySalidas->whereDate('hora_salida', '<=', $request->fecha_fin);
    }

    $entradas = $queryEntradas->get();
    $salidas = $querySalidas->get();

    // Agrupar salidas por vehiculo para buscar la salida correspondiente a cada entrada
    $salidasByVehiculo = $salidas->groupBy('vehiculo_id');

    $rows = $entradas->map(function ($e) use ($salidasByVehiculo) {
        $veh = $e->vehiculo;
        $vehId = $e->vehiculo_id;

        // Buscar la salida del mismo vehículo cuyo hora_salida sea posterior a la entrada.
        $salida = null;
        if ($salidasByVehiculo->has($vehId)) {
            $candidates = $salidasByVehiculo[$vehId]->filter(function($s) use ($e) {
                if (empty($s->hora_salida) || empty($e->hora_entrada)) return false;
                try {
                    return \Carbon\Carbon::parse($s->hora_salida)->greaterThanOrEqualTo(\Carbon\Carbon::parse($e->hora_entrada));
                } catch (\Throwable $ex) {
                    return false;
                }
            })->sortBy('hora_salida');
            $salida = $candidates->first();
        }

        $entradaAt = $e->hora_entrada ? \Carbon\Carbon::parse($e->hora_entrada) : null;
        $salidaAt = $salida && $salida->hora_salida ? \Carbon\Carbon::parse($salida->hora_salida) : null;

        // Calcular tiempo en minutos (si no hay salida usar ahora())
        $tiempo = null;
        if ($entradaAt) {
            try {
                $end = $salidaAt ?: \Carbon\Carbon::now();
                $tiempo = $end->diffInMinutes($entradaAt);
            } catch (\Throwable $ex) {
                $tiempo = null;
            }
        }

        return (object)[
            'id' => $e->id,
            'propietario' => $veh->propietario ?? optional($e->usuario)->name ?? '-',
            'placa' => $veh->placa ?? '-',
            'tipo' => $veh->tipo ?? '-',
            'entrada' => $entradaAt,
            'salida' => $salidaAt,
            'tiempo' => $tiempo,
            'ocupado' => $salidaAt ? false : ($entradaAt ? true : false),
            'espacio' => optional($e->espacio)->nombre,
        ];
    });

    // Totales
    $totalEntradas = $entradas->count();
    $totalSalidas = $salidas->count();
    $promedioEstadia = $salidas->avg('tiempo_estadia');

    // Capacidad / libres (igual que index)
    $totalEspacios = Espacio::where('activo', true)->count();
    $ocupados = Entrada::where('estado', 'activo')->count();
    $libres = $totalEspacios - $ocupados;

    $data = [
        'vehiculos' => $rows,
        'totalEntradas' => $totalEntradas,
        'totalSalidas' => $totalSalidas,
        'promedioEstadia' => round($promedioEstadia ?: 0),
        // pasar ambas variables para evitar incompatibilidades con la vista
        'espaciosLibres' => $libres,
        'libres' => $libres,
        'totalEspacios' => $totalEspacios,
        'ocupados' => $ocupados,
        'desde' => $request->fecha_inicio,
        'hasta' => $request->fecha_fin,
        'filtros' => $request->input('filtros') ?? null,
    ];

    // PRUEBA: primero verificar en browser
    // return view('reportes.pdf', $data);

    $pdf = Pdf::loadView('reportes.pdf', $data)->setPaper('a4', 'landscape');
    return $pdf->download('reporte_entradas_salidas.pdf');
}


public function exportExcelCsv(Request $request)
{
    $query = Entrada::with(['vehiculo','usuario','espacio']);
    if($request->usuario_id) $query->where('usuario_id', $request->usuario_id);
    if($request->vehiculo_id) $query->where('vehiculo_id', $request->vehiculo_id);
    if($request->fecha_inicio) $query->whereDate('hora_entrada', '>=', $request->fecha_inicio);
    if($request->fecha_fin) $query->whereDate('hora_entrada', '<=', $request->fecha_fin);

    $entradas = $query->get();
    $salidas = Salida::whereIn('vehiculo_id', $entradas->pluck('vehiculo_id'))->get()->groupBy('vehiculo_id');

    $rows = $entradas->map(function($e) use ($salidas) {
        $entradaAt = $e->hora_entrada ? \Carbon\Carbon::parse($e->hora_entrada) : null;

        $salidaRec = null;
        if ($entradaAt && isset($salidas[$e->vehiculo_id])) {
            $candidates = collect($salidas[$e->vehiculo_id])->filter(function($s) use ($entradaAt){
                return !empty($s->hora_salida) && \Carbon\Carbon::parse($s->hora_salida)->greaterThanOrEqualTo($entradaAt);
            })->sortBy('hora_salida');
            $salidaRec = $candidates->first();
        }

        $salidaAt = $salidaRec && $salidaRec->hora_salida ? \Carbon\Carbon::parse($salidaRec->hora_salida) : null;
        $tiempo = $entradaAt ? ($salidaAt ?: \Carbon\Carbon::now())->diffInMinutes($entradaAt) : null;

        return [
            'id' => $e->id,
            'propietario' => optional($e->vehiculo)->propietario ?? optional($e->usuario)->name ?? '-',
            'placa' => optional($e->vehiculo)->placa ?? '-',
            'tipo' => optional($e->vehiculo)->tipo ?? '-',
            'espacio' => optional($e->espacio)->nombre ?? '-',
            'entrada' => $entradaAt ? $entradaAt->format('d/m/Y H:i') : '-',
            'salida' => $salidaAt ? $salidaAt->format('d/m/Y H:i') : '-',
            'tiempo' => $tiempo !== null ? $tiempo : '-',
            'usuario' => optional($e->usuario)->name ?? '-',
        ];
    });

    $filename = 'reporte_entradas.csv';
    $headers = [
        'Content-Type' => 'text/csv; charset=UTF-8',
        'Content-Disposition' => "attachment; filename=\"$filename\"",
    ];

    $callback = function() use ($rows) {
        $out = fopen('php://output', 'w');
        // encabezados
        fputcsv($out, ['ID','Propietario','Placa','Marca/Tipo','Espacio','Entrada','Salida','Tiempo (min)','Usuario']);
        foreach ($rows as $r) {
            fputcsv($out, array_values($r));
        }
        fclose($out);
    };

    return response()->stream($callback, 200, $headers);
}
}
