<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Reclamos2Export implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $reclamos;

    /**
     * Se inyecta la información (en este caso, se llama $reclamos)
     *
     * @param array $reclamos
     */
    public function __construct($reclamos)
    {
        $this->reclamos = $reclamos;
    }

    /**
     * Convierte los datos en una colección para Excel.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect($this->reclamos)->map(function ($info) {
            return [
                'id'            => $info['id'],
                'correlativo'   => $info['correlativo'],
                'cliente'       => $info['cliente'],
                'telf'          => $info['telf'],
                'ci'            => $info['ci'],
                'email'         => $info['email'],
                'queja'         => $info['queja'],
                'funcionario'   => $info['funcionario'],
                'tipo'          => $info['tipo'],
                'estado'        => $info['estado'],
                'feedback'      => $info['feedback'],
                'ciudad'        => $info['ciudad'],
                'created_at'    => $info['created_at'],

            ];
        });
    }

    /**
     * Define los encabezados de la hoja de Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Correlativo',
            'Cliente',
            'Teléfono',
            'CI',
            'Email',
            'Queja',
            'Funcionario',
            'Tipo',
            'Estado',
            'Feedback',
            'Ciudad',
            'Fecha de Creación',

        ];
    }

    /**
     * Aplica estilos a la hoja de Excel.
     *
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        // Estilo para la fila de encabezado (A1 a J1)
        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FFFF00',
                ],
            ],
        ]);

        // Estilo para las filas de datos (A2 hasta la última fila)
        $sheet->getStyle('A2:J' . $sheet->getHighestRow())->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'font' => [
                'size' => 12,
            ],
        ]);

        // Autoajustar el ancho de las columnas desde la A hasta la J
        foreach (range('A', 'J') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return [];
    }
}
