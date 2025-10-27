<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EntradasExport implements FromCollection, WithHeadings, WithMapping
{
    protected Collection $rows;

    public function __construct(Collection $rows)
    {
        $this->rows = $rows;
    }

    public function collection()
    {
        return $this->rows;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Propietario',
            'Placa',
            'Marca/Tipo',
            'Espacio',
            'Entrada',
            'Salida',
            'Tiempo (min)',
            'Usuario',
        ];
    }

    public function map($row): array
    {
        $entrada = '-';
        if (!empty($row->entrada)) {
            $entrada = $row->entrada instanceof \Carbon\Carbon
                ? $row->entrada->format('d/m/Y H:i')
                : (\Carbon\Carbon::parse($row->entrada)->format('d/m/Y H:i') ?? '-');
        }

        $salida = '-';
        if (!empty($row->salida)) {
            $salida = $row->salida instanceof \Carbon\Carbon
                ? $row->salida->format('d/m/Y H:i')
                : (\Carbon\Carbon::parse($row->salida)->format('d/m/Y H:i') ?? '-');
        }

        $tiempo = $row->tiempo !== null ? $row->tiempo : '-';

        return [
            $row->id,
            $row->propietario ?? '-',
            $row->placa ?? '-',
            $row->tipo ?? '-',
            $row->espacio ?? '-',
            $entrada,
            $salida,
            $tiempo,
            $row->usuario ?? '-',
        ];
    }
}