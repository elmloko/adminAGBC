<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CasillasExport implements FromCollection, WithHeadings, WithStyles
{
    public function __construct($packages)
    {
        $this->packages = $packages;
    }
    public function collection()
    {
        return collect($this->packages)->map(function ($package) {
            return [
                'nombre' => $package['casilla']['nombre'],
                'cliente_nombre' => $package['alquiler']['cliente']['nombre'] ?? 'N/A',
                'categoria_id' => $package['casilla']['categoria_id'],
                'seccione_id' => $package['casilla']['seccione_id'],
                'llaves_id' => $package['casilla']['llaves_id'],
                'estado' => $package['casilla']['estado'],
                'updated_at' => $package['casilla']['updated_at'] ?? $package['casilla']['fin_fecha'],
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nro. Casilla',
            'Cliente',
            'Tamaño',
            'Nro. Sección',
            'Nro. Llaves',
            'Estado',
            'Fecha de Actualización',
        ];
    }
    public function styles(Worksheet $sheet)
    {
        // Establece el espaciado entre las tablas
        $sheet->getStyle('A1:L1')->getAlignment()->setVertical('center');
        $sheet->getStyle('A1:L1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:L1')->getFont()->setBold(true);

        // Establece un espaciado adicional después de cada fila de datos
        $sheet->getStyle('A2:L' . ($sheet->getHighestRow()))->getAlignment()->setVertical('center');
        $sheet->getStyle('A2:L' . ($sheet->getHighestRow()))->getAlignment()->setHorizontal('center');

        // Ajusta el espaciado según tus necesidades
        // $sheet->getStyle('A:L')->getAlignment()->setVertical('center');
        $sheet->getStyle('A:L')->getFont()->setSize(12);

        // Autoajusta el ancho de las columnas
        foreach(range('A', 'L') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}

