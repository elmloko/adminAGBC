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
        // Consumir la API de informaciones
        $response = Http::withOptions([
            'verify' => false,
        ])->get('https://correos.gob.bo:8002/api/informations');

        $informaciones = [];

        if ($response->successful()) {
            // Suponemos que la respuesta es un arreglo de objetos
            $data = $response->json();
            $informaciones = array_map(function ($item) {
                // Convertir las fechas con Carbon
                $createdAt = Carbon::parse($item['created_at']);
                $lastDate  = Carbon::parse($item['last_date']);
                return [
                    'id'            => $item['id'],
                    'correlativo'   => $item['correlativo'],
                    'codigo'        => $item['codigo'],
                    'ventanilla'    => $item['ventanilla'],
                    'feedback'      => $item['feedback'],
                    'destinatario'  => $item['destinatario'],
                    'last_event'    => $item['last_event'],
                    'ciudad'        => $item['ciudad'],
                    'estado'        => $item['estado'],
                    'last_date'     => $lastDate->format('Y-m-d H:i:s'),
                    'created_at'    => $createdAt->format('Y-m-d H:i:s'),
                ];
            }, $data);
        }

        // Filtro por búsqueda (en destinatario, código o correlativo)
        if (!empty($this->search)) {
            $informaciones = array_filter($informaciones, function ($info) {
                return stripos($info['destinatario'], $this->search) !== false ||
                    stripos($info['codigo'], $this->search) !== false ||
                    stripos($info['correlativo'], $this->search) !== false;
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
