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

class observado extends Component
{
    use WithPagination;

    public $search = '';
    public $date = '';
    public $categoria = '';
    public $filteredobservados = [];
    public $sortBy = 'created_at';
    public $sortDirection = 'asc';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->filteredobservados = $this->getFilteredobservados();
    }

    public function searchobservados()
    {
        $this->resetPage();
        $this->filteredobservados = $this->getFilteredobservados();
    }

    public function applyFilters()
    {
        $this->resetPage();
        $this->filteredobservados = $this->getFilteredobservados();
    }

    public function getFilteredobservados()
    {
        $response = Http::withOptions([
            'verify' => false,
            'curl' => [
                CURLOPT_SSLVERSION   => CURL_SSLVERSION_TLSv1_2,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_IPRESOLVE    => CURL_IPRESOLVE_V4,
            ],
        ])->get('https://correos.gob.bo:8005/api/observado');

        $observados = [];

        if ($response->successful()) {
            $data = $response->json();
            if ($data['success'] && isset($data['data'])) {
                $observados = array_map(function ($item) {
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
            $observados = array_filter($observados, function ($observado) {
                return stripos($observado['identificador'], $this->search) !== false;
            });
        }

        if (!empty($this->date)) {
            $observados = array_filter($observados, function ($observado) {
                return Carbon::parse($observado['created_at'])->toDateString() == Carbon::parse($this->date)->toDateString();
            });
        }

        if (!empty($this->categoria)) {
            $observados = array_filter($observados, function ($observado) {
                return $observado['oforigen'] == $this->categoria;
            });
        }

        usort($observados, function ($a, $b) {
            return ($this->sortDirection === 'asc' ? 1 : -1) * strcmp($a[$this->sortBy], $b[$this->sortBy]);
        });

        return $observados;
    }

    public function generatePDF()
    {
        $observados = $this->getFilteredobservados();
        $pdf = PDF::loadView('livewire.despachos-pdf', compact('observados'));
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'Despachos_observados.pdf');
    }

    public function generateExcel()
    {
        $observados = $this->getFilteredobservados();
        return Excel::download(new DespachosExport($observados), 'Despachos_observados.xlsx');
    }

    public function render()
    {
        $observados = $this->filteredobservados;
        if (empty($observados)) {
            $observados = $this->getFilteredobservados();
        }

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 100;
        $currentItems = array_slice($observados, ($currentPage - 1) * $perPage, $perPage);
        $paginatedItems = new LengthAwarePaginator($currentItems, count($observados), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        return view('livewire.observado', [
            'observados' => $paginatedItems
        ]);
    }
}
