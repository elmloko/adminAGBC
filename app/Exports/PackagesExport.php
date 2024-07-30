<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PackagesExport implements FromCollection, WithHeadings, WithStyles
{
    protected $packages;

    public function __construct($packages)
    {
        $this->packages = $packages;
    }

    public function collection()
    {
        return collect($this->packages)->map(function ($package) {
            return [
                'id' => $package['id'],
                'CODIGO' => $package['CODIGO'],
                'DESTINATARIO' => $package['DESTINATARIO'],
                'TELEFONO' => $package['TELEFONO'],
                'CUIDAD' => $package['CUIDAD'],
                'VENTANILLA' => $package['VENTANILLA'],
                'PESO' => $package['PESO'],
                'ESTADO' => $package['ESTADO'],
                'REGISTRADO' => $package['created_at'],
                'ACTUALIZADO' => $package['updated_at'],
                'ENTREGADO' => $package['deleted_at'],
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'CODIGO',
            'DESTINATARIO',
            'TELEFONO',
            'CIUDAD',
            'VENTANILLA',
            'PESO',
            'ESTADO',
            'REGISTRADO',
            'ACTUALIZADO',
            'ENTREGADO',
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

