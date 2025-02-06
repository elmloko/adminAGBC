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

class admitido extends Component
{
    use WithPagination;

    public $search = '';
    public $date = '';
    public $categoria = '';
    public $filteredadmitidos = [];
    public $sortBy = 'created_at';
    public $sortDirection = 'asc';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->filteredadmitidos = $this->getFilteredadmitidos();
    }

    public function searchadmitidos()
    {
        $this->resetPage();
        $this->filteredadmitidos = $this->getFilteredadmitidos();
    }

    public function applyFilters()
    {
        $this->resetPage();
        $this->filteredadmitidos = $this->getFilteredadmitidos();
    }

    public function getFilteredadmitidos()
    {
        $response = Http::withOptions([
            'verify' => false,
        ])->get('https://correos.gob.bo:8005/api/admitido');

        $admitidos = [];

        if ($response->successful()) {
            $data = $response->json();
            if ($data['success'] && isset($data['data'])) {
                $admitidos = array_map(function ($item) {
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
            $admitidos = array_filter($admitidos, function ($admitido) {
                return stripos($admitido['identificador'], $this->search) !== false;
            });
        }

        if (!empty($this->date)) {
            $admitidos = array_filter($admitidos, function ($admitido) {
                return Carbon::parse($admitido['created_at'])->toDateString() == Carbon::parse($this->date)->toDateString();
            });
        }

        if (!empty($this->categoria)) {
            $admitidos = array_filter($admitidos, function ($admitido) {
                return $admitido['oforigen'] == $this->categoria;
            });
        }

        usort($admitidos, function ($a, $b) {
            return ($this->sortDirection === 'asc' ? 1 : -1) * strcmp($a[$this->sortBy], $b[$this->sortBy]);
        });

        return $admitidos;
    }

    public function generatePDF()
    {
        $admitidos = $this->getFilteredadmitidos();
        $pdf = PDF::loadView('livewire.despachos-pdf', compact('admitidos'));
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'Despachos_admitidos.pdf');
    }

    public function generateExcel()
    {
        $admitidos = $this->getFilteredadmitidos();
        return Excel::download(new DespachosExport($admitidos), 'Despachos_admitidos.xlsx');
    }

    public function render()
    {
        $admitidos = $this->filteredadmitidos;
        if (empty($admitidos)) {
            $admitidos = $this->getFilteredadmitidos();
        }

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 100;
        $currentItems = array_slice($admitidos, ($currentPage - 1) * $perPage, $perPage);
        $paginatedItems = new LengthAwarePaginator($currentItems, count($admitidos), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        return view('livewire.admitido', [
            'admitidos' => $paginatedItems
        ]);
    }
}
