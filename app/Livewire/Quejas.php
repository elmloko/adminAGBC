<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use PDF;
use Excel;

class Quejas extends Component
{
    use WithPagination;

    public $search = '';
    public $date = '';
    public $tipo = '';
    public $ciudad = '';
    public $filteredInformaciones = [];
    public $sortBy = 'created_at';
    public $sortDirection = 'asc';

    // Resetea la paginación al cambiar el valor de búsqueda
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
            'https://correos.gob.bo:8002/api/complaintso',
            'https://correos.gob.bo:8002/api/complaintsa',
        ];

        $informaciones = [];

        foreach ($urls as $url) {
            $response = Http::withOptions(['verify' => false])->get($url);

            if ($response->successful()) {
                $data = $response->json();
                foreach ($data as $item) {
                    $createdAt = Carbon::parse($item['created_at']);

                    $informaciones[] = [
                        'id'            => $item['id'],
                        'correlativo'   => $item['correlativo'],
                        'cliente'        => $item['cliente'],
                        'telf'    => $item['telf'],
                        'ci'      => $item['ci'],
                        'email'  => $item['email'],
                        'queja'    => $item['queja'],
                        'funcionario'        => $item['funcionario'],
                        'tipo'        => $item['tipo'],
                        'estado'        => $item['estado'],
                        'feedback'        => $item['feedback'],
                        'ciudad'        => $item['ciudad'],
                        'created_at'    => $createdAt->format('Y-m-d H:i:s'),
                    ];
                }
            }
        }

        // Filtro por búsqueda (en destinatario, código o correlativo)
        if (!empty($this->search)) {
            $informaciones = array_filter($informaciones, function ($info) {
                return stripos($info['correlativo'], $this->search) !== false ||
                    stripos($info['cliente'], $this->search) !== false;
            });
        }

        // Filtro por fecha (usando la fecha de creación)
        if (!empty($this->date)) {
            $informaciones = array_filter($informaciones, function ($info) {
                return Carbon::parse($info['created_at'])->toDateString() == Carbon::parse($this->date)->toDateString();
            });
        }

        // Filtro por ciudad
        if (!empty($this->ciudad)) {
            $informaciones = array_filter($informaciones, function ($info) {
                return $info['ciudad'] == $this->ciudad;
            });
        }
        // Filtro por estado
        if (!empty($this->tipo)) {
            $informaciones = array_filter($informaciones, function ($info) {
                return $info['tipo'] == $this->tipo;
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
        // Obtén la información filtrada y la asignas a la variable $reclamos
        $informaciones = $this->getFilteredInformaciones();

        // Carga la vista 'livewire.reclamos-pdf' pasando la variable $reclamos
        $pdf = PDF::loadView('livewire.reclamos2-pdf', compact('informaciones'));

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'Quejas.pdf');
    }


    public function generateExcel()
    {
        $informaciones = $this->getFilteredInformaciones();
        return Excel::download(new \App\Exports\Reclamos2Export($informaciones), 'Quejas.xlsx');
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

        return view('livewire.quejas', [
            'informaciones' => $paginatedItems
        ]);
    }
}
