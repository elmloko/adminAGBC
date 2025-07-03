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

class cerrado extends Component
{
    use WithPagination;

    public $search = '';
    public $date = '';
    public $categoria = '';
    public $filteredcerrados = [];
    public $sortBy = 'created_at';
    public $sortDirection = 'asc';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->filteredcerrados = $this->getFilteredcerrados();
    }

    public function searchcerrados()
    {
        $this->resetPage();
        $this->filteredcerrados = $this->getFilteredcerrados();
    }

    public function applyFilters()
    {
        $this->resetPage();
        $this->filteredcerrados = $this->getFilteredcerrados();
    }

    public function getFilteredcerrados()
    {
        $response = Http::withOptions([
            'verify' => false,
            'curl' => [
                CURLOPT_SSLVERSION   => CURL_SSLVERSION_TLSv1_2,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_IPRESOLVE    => CURL_IPRESOLVE_V4,
            ],
        ])->get('https://correos.gob.bo:8005/api/cerrado');
    
        $cerrados = [];
    
        if ($response->successful()) {
            $data = $response->json();
            if ($data['success'] && isset($data['data'])) {
                $cerrados = array_map(function ($item) {
                    $createdAt = Carbon::parse($item['created_at']);
                    $estado = Carbon::now()->diffInDays($createdAt) > 1 ? 'DEMORADO' : 'A TIEMPO';
    
                    return [
                        'oforigen' => $item['oforigen'],
                        'ofdestino' => $item['ofdestino'],
                        'identificador' => $item['identificador'],
                        'created_at' => $createdAt->format('Y-m-d H:i:s'),
                        'peso_total' => array_sum(array_column($item['sacas'], 'peso')),
                        'paquetes_total' => array_reduce($item['sacas'], function ($carry, $saca) {
                            return $carry + array_reduce($saca['contenidos'], function ($subcarry, $contenido) {
                                return $subcarry + array_sum(array_values($contenido));
                            }, 0);
                        }, 0),
                        'estado' => $estado, // Agregar el estado aquí
                    ];
                }, $data['data']);
            }
        }
    
        // Aplicar filtros (búsqueda, fecha, categoría)
        if (!empty($this->search)) {
            $cerrados = array_filter($cerrados, function ($cerrado) {
                return stripos($cerrado['identificador'], $this->search) !== false;
            });
        }
    
        if (!empty($this->date)) {
            $cerrados = array_filter($cerrados, function ($cerrado) {
                return Carbon::parse($cerrado['created_at'])->toDateString() == Carbon::parse($this->date)->toDateString();
            });
        }
    
        if (!empty($this->categoria)) {
            $cerrados = array_filter($cerrados, function ($cerrado) {
                return $cerrado['oforigen'] == $this->categoria;
            });
        }
    
        // Ordenar resultados
        usort($cerrados, function ($a, $b) {
            return ($this->sortDirection === 'asc' ? 1 : -1) * strcmp($a[$this->sortBy], $b[$this->sortBy]);
        });
    
        return $cerrados;
    }    

    public function generatePDF()
    {
        $cerrados = $this->getFilteredcerrados();
        $pdf = PDF::loadView('livewire.despachos-pdf', compact('cerrados'));
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'Despachos_cerrados.pdf');
    }

    public function generateExcel()
    {
        $cerrados = $this->getFilteredcerrados();
        return Excel::download(new DespachosExport($cerrados), 'Despachos_cerrados.xlsx');
    }

    public function render()
    {
        $cerrados = $this->filteredcerrados;
        if (empty($cerrados)) {
            $cerrados = $this->getFilteredcerrados();
        }

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 100;
        $currentItems = array_slice($cerrados, ($currentPage - 1) * $perPage, $perPage);
        $paginatedItems = new LengthAwarePaginator($currentItems, count($cerrados), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        return view('livewire.cerrado', [
            'cerrados' => $paginatedItems
        ]);
    }
}
