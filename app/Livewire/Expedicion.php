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

class expedicion extends Component
{
    use WithPagination;

    public $search = '';
    public $date = '';
    public $categoria = '';
    public $filteredexpedicions = [];
    public $sortBy = 'created_at';
    public $sortDirection = 'asc';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->filteredexpedicions = $this->getFilteredexpedicions();
    }

    public function searchexpedicions()
    {
        $this->resetPage();
        $this->filteredexpedicions = $this->getFilteredexpedicions();
    }

    public function applyFilters()
    {
        $this->resetPage();
        $this->filteredexpedicions = $this->getFilteredexpedicions();
    }

    public function getFilteredexpedicions()
    {
        $response = Http::withOptions([
            'verify' => false,
        ])->get('https://correos.gob.bo:8005/api/expedicion');

        $expedicions = [];

        if ($response->successful()) {
            $data = $response->json();
            if ($data['success'] && isset($data['data'])) {
                $expedicions = array_map(function ($item) {
                    $createdAt = Carbon::parse($item['updated_at']);
                    $estado = Carbon::now()->diffInDays($createdAt) > 1 ? 'DEMORADO' : 'A TIEMPO';

                    return [
                        'oforigen' => $item['oforigen'],
                        'ofdestino' => $item['ofdestino'],
                        'identificador' => $item['identificador'],
                        'updated_at' => $createdAt->format('Y-m-d H:i:s'),
                        'peso_total' => array_sum(array_column($item['sacas'], 'peso')),
                        'paquetes_total' => array_reduce($item['sacas'], function ($carry, $saca) {
                            return $carry + array_reduce($saca['contenidos'], function ($subcarry, $contenido) {
                                return $subcarry + array_sum(array_values($contenido));
                            }, 0);
                        }, 0),
                        'estado' => $estado,
                    ];
                }, $data['data']);
            }
        }

        if (!empty($this->search)) {
            $expedicions = array_filter($expedicions, function ($expedicion) {
                return stripos($expedicion['identificador'], $this->search) !== false;
            });
        }

        if (!empty($this->date)) {
            $expedicions = array_filter($expedicions, function ($expedicion) {
                return Carbon::parse($expedicion['created_at'])->toDateString() == Carbon::parse($this->date)->toDateString();
            });
        }

        if (!empty($this->categoria)) {
            $expedicions = array_filter($expedicions, function ($expedicion) {
                return $expedicion['oforigen'] == $this->categoria;
            });
        }

        usort($expedicions, function ($a, $b) {
            return ($this->sortDirection === 'asc' ? 1 : -1) * strcmp($a[$this->sortBy], $b[$this->sortBy]);
        });

        return $expedicions;
    }

    public function generatePDF()
    {
        $expedicions = $this->getFilteredexpedicions();
        $pdf = PDF::loadView('livewire.despachos-pdf', compact('expedicions'));
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'Despachos_expedicions.pdf');
    }

    public function generateExcel()
    {
        $expedicions = $this->getFilteredexpedicions();
        return Excel::download(new DespachosExport($expedicions), 'Despachos_expedicions.xlsx');
    }

    public function render()
    {
        $expedicions = $this->filteredexpedicions;
        if (empty($expedicions)) {
            $expedicions = $this->getFilteredexpedicions();
        }

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 100;
        $currentItems = array_slice($expedicions, ($currentPage - 1) * $perPage, $perPage);
        $paginatedItems = new LengthAwarePaginator($currentItems, count($expedicions), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        return view('livewire.expedicion', [
            'expedicions' => $paginatedItems
        ]);
    }
}
