<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use App\Exports\DespachosExport;
use PDF;
use Excel;

class Apertura extends Component
{
    use WithPagination;

    public $search = '';
    public $date = '';
    public $categoria = '';
    public $filteredAperturas = [];
    public $sortBy = 'created_at';
    public $sortDirection = 'asc';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->filteredAperturas = $this->getFilteredAperturas();
    }

    public function searchAperturas()
    {
        $this->resetPage();
        $this->filteredAperturas = $this->getFilteredAperturas();
    }

    public function applyFilters()
    {
        $this->resetPage();
        $this->filteredAperturas = $this->getFilteredAperturas();
    }

    public function getFilteredAperturas()
    {
        $response = Http::withOptions([
            'verify' => false,
        ])->get('https://correos.gob.bo:8005/api/apertura');

        $aperturas = [];

        if ($response->successful()) {
            $data = $response->json();
            if ($data['success'] && isset($data['data'])) {
                $aperturas = array_map(function ($item) {
                    return [
                        'oforigen' => $item['oforigen'],
                        'ofdestino' => $item['ofdestino'],
                        'identificador' => $item['identificador'],
                        'created_at' => Carbon::parse($item['created_at'])->format('Y-m-d H:i:s'),
                        'peso_total' => array_sum(array_column($item['sacas'], 'peso')),
                        'paquetes_total' => array_reduce($item['sacas'], function ($carry, $saca) {
                            return $carry + array_reduce($saca['contenidos'], function ($subcarry, $contenido) {
                                return $subcarry + array_sum(array_values($contenido));
                            }, 0);
                        }, 0),
                    ];
                }, $data['data']);
            }
        }

        if (!empty($this->search)) {
            $aperturas = array_filter($aperturas, function ($apertura) {
                return stripos($apertura['identificador'], $this->search) !== false;
            });
        }

        if (!empty($this->date)) {
            $aperturas = array_filter($aperturas, function ($apertura) {
                return Carbon::parse($apertura['created_at'])->toDateString() == Carbon::parse($this->date)->toDateString();
            });
        }

        if (!empty($this->categoria)) {
            $aperturas = array_filter($aperturas, function ($apertura) {
                return $apertura['oforigen'] == $this->categoria;
            });
        }

        usort($aperturas, function ($a, $b) {
            return ($this->sortDirection === 'asc' ? 1 : -1) * strcmp($a[$this->sortBy], $b[$this->sortBy]);
        });

        return $aperturas;
    }

    public function generatePDF()
    {
        $aperturas = $this->getFilteredAperturas();
        $pdf = PDF::loadView('livewire.despachos-pdf', compact('aperturas'));
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'Despachos_Aperturas.pdf');
    }

    public function generateExcel()
    {
        $aperturas = $this->getFilteredAperturas();
        return Excel::download(new DespachosExport($aperturas), 'Despachos_Aperturas.xlsx');
    }

    public function render()
    {
        $aperturas = $this->filteredAperturas;
        if (empty($aperturas)) {
            $aperturas = $this->getFilteredAperturas();
        }

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 100;
        $currentItems = array_slice($aperturas, ($currentPage - 1) * $perPage, $perPage);
        $paginatedItems = new LengthAwarePaginator($currentItems, count($aperturas), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        return view('livewire.apertura', [
            'aperturas' => $paginatedItems
        ]);
    }
}
