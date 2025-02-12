<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use PDF;
use Excel;

class Informaciones extends Component
{
    use WithPagination;

    public $search = '';
    public $date = '';
    public $ciudad = '';
    public $estado = '';
    public $filteredInformaciones = [];
    public $sortBy = 'created_at';
    public $sortDirection = 'asc';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->filteredInformaciones = $this->getFilteredInformaciones();
    }

    public function searchInformaciones()
    {
        $this->resetPage();
        $this->filteredInformaciones = $this->getFilteredInformaciones();
    }

    public function applyFilters()
    {
        $this->resetPage();
        $this->filteredInformaciones = $this->getFilteredInformaciones();
    }

    public function getFilteredInformaciones()
    {
        $urls = [
            'https://correos.gob.bo:8002/api/informations',
            'https://correos.gob.bo:8002/api/informationll',
            'https://correos.gob.bo:8002/api/informationsm'
        ];

        $informaciones = [];

        foreach ($urls as $url) {
            $response = Http::withOptions(['verify' => false])->get($url);

            if ($response->successful()) {
                $data = $response->json();
                foreach ($data as $item) {
                    $createdAt = Carbon::parse($item['created_at']);
                    $lastDate  = isset($item['last_date']) ? Carbon::parse($item['last_date']) : null;

                    $informaciones[] = [
                        'id'            => $item['id'],
                        'correlativo'   => $item['correlativo'] ?? '',
                        'codigo'        => $item['codigo'] ?? '',
                        'ventanilla'    => $item['ventanilla'] ?? '',
                        'feedback'      => $item['feedback'] ?? '',
                        'destinatario'  => $item['destinatario'] ?? '',
                        'last_event'    => $item['last_event'] ?? '',
                        'ciudad'        => $item['ciudad'] ?? '',
                        'estado'        => $item['estado'] ?? '',
                        'last_date'     => $lastDate ? $lastDate->format('Y-m-d H:i:s') : '',
                        'created_at'    => $createdAt->format('Y-m-d H:i:s'),
                    ];
                }
            }
        }

        // Filtro por búsqueda
        if (!empty($this->search)) {
            $informaciones = array_filter($informaciones, function ($info) {
                return stripos($info['destinatario'], $this->search) !== false ||
                    stripos($info['codigo'], $this->search) !== false ||
                    stripos($info['correlativo'], $this->search) !== false;
            });
        }

        // Filtro por fecha
        if (!empty($this->date)) {
            $informaciones = array_filter($informaciones, function ($info) {
                return Carbon::parse($info['created_at'])->toDateString() == Carbon::parse($this->date)->toDateString();
            });
        }

        // Filtro por estado
        if (!empty($this->estado)) {
            $informaciones = array_filter($informaciones, function ($info) {
                return $info['estado'] == $this->estado;
            });
        }

        // Filtro por ciudad
        if (!empty($this->ciudad)) {
            $informaciones = array_filter($informaciones, function ($info) {
                return $info['ciudad'] == $this->ciudad;
            });
        }

        // Ordenar resultados
        usort($informaciones, function ($a, $b) {
            return ($this->sortDirection === 'asc' ? 1 : -1) * strcmp($a[$this->sortBy], $b[$this->sortBy]);
        });

        return $informaciones;
    }

    public function generatePDF()
    {
        $informaciones = $this->getFilteredInformaciones();
        $pdf = PDF::loadView('livewire.reclamos-pdf', compact('informaciones'));

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'Informaciones.pdf');
    }

    public function generateExcel()
    {
        $informaciones = $this->getFilteredInformaciones();
        return Excel::download(new \App\Exports\ReclamosExport($informaciones), 'Informaciones.xlsx');
    }

    public function render()
    {
        $informaciones = $this->filteredInformaciones;
        if (empty($informaciones)) {
            $informaciones = $this->getFilteredInformaciones();
        }

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 50;
        $currentItems = array_slice($informaciones, ($currentPage - 1) * $perPage, $perPage);
        $paginatedItems = new LengthAwarePaginator($currentItems, count($informaciones), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        return view('livewire.informaciones', [
            'informaciones' => $paginatedItems
        ]);
    }
}
