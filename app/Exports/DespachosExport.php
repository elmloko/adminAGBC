<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DespachosExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $aperturas;

    public function __construct($aperturas)
    {
        $this->aperturas = $aperturas;
    }

    public function collection()
    {
        return collect($this->aperturas)->map(function ($apertura) {
            return [
                'oforigen' => $apertura['oforigen'],
                'ofdestino' => $apertura['ofdestino'],
                'identificador' => $apertura['identificador'],
                'created_at' => $apertura['created_at'],
                'peso_total' => $apertura['peso_total'],
                'paquetes_total' => $apertura['paquetes_total'],
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Oficina Origen',
            'Oficina Destino',
            'Identificador',
            'Fecha de Apertura',
            'Peso Total',
            'Paquetes Totales',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Estilo para la fila de encabezado
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FFFF00',
                ],
            ],
        ]);

        // Estilo para las filas de datos
        $sheet->getStyle('A2:F' . $sheet->getHighestRow())->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'font' => [
                'size' => 12,
            ],
        ]);

        // Autoajustar el ancho de las columnas
        foreach (range('A', 'F') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return [];
    }
}
