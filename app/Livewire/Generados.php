<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Exports\PackagesExport;
use Carbon\Carbon;
use PDF;
use Excel;

class Generados extends Component
{
    use WithPagination;

    public $search = '';
    public $date = '';
    public $ventanilla = '';
    public $ciudad = '';
    public $filteredPackages = [];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function searchPackages()
    {
        $this->resetPage();
        $this->filteredPackages = $this->getFilteredPackages();
    }

    public function applyFilters()
    {
        $this->resetPage();
        $this->filteredPackages = $this->getFilteredPackages();
    }

    public function getFilteredPackages()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer eZMlItx6mQMNZjxoijEvf7K3pYvGGXMvEHmQcqvtlAPOEAPgyKDVOpyF7JP0ilbK'
        ])->withOptions([
            'verify' => false,
            'curl' => [
                CURLOPT_SSLVERSION   => CURL_SSLVERSION_TLSv1_2,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_IPRESOLVE    => CURL_IPRESOLVE_V4,
            ],
        ])->get('https://correos.gob.bo:8000/api/callclasi');

        $packages = [];
        if ($response->successful()) {
            $packages = $response->json();

            foreach ($packages as &$package) {
                if (isset($package['created_at'])) {
                    $package['created_at'] = Carbon::parse($package['created_at'])->format('d-m-Y H:i:s');
                }
            }
        }

        // Filtrar los paquetes según la búsqueda
        if (!empty($this->search)) {
            $packages = array_filter($packages, function ($package) {
                return stripos($package['CODIGO'], $this->search) !== false ||
                    stripos($package['DESTINATARIO'], $this->search) !== false;
            });
        }

        // Filtrar los paquetes según la fecha
        if (!empty($this->date)) {
            $packages = array_filter($packages, function ($package) {
                return Carbon::parse($package['created_at'])->toDateString() == Carbon::parse($this->date)->toDateString();
            });
        }

        // Filtrar los paquetes según la ventanilla
        if (!empty($this->ventanilla)) {
            $packages = array_filter($packages, function ($package) {
                return $package['VENTANILLA'] === $this->ventanilla;
            });
        }

        // Filtrar los paquetes según la ciudad
        if (!empty($this->ciudad)) {
            $packages = array_filter($packages, function ($package) {
                return stripos($package['CUIDAD'], $this->ciudad) !== false;
            });
        }

        // Filtrar los paquetes cuyo estado sea "DESPACHO" o "CLASIFICACION"
        $packages = array_filter($packages, function ($package) {
            return $package['ESTADO'] === 'DESPACHO' || $package['ESTADO'] === 'CLASIFICACION';
        });

        usort($packages, function ($a, $b) {
            return Carbon::parse($b['created_at']) <=> Carbon::parse($a['created_at']);
        });

        return $packages;
    }

    public function generatePDF()
    {
        $packages = $this->getFilteredPackages();
        $pdf = PDF::loadView('livewire.package-pdf', compact('packages'));
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'correspondencia_entregada.pdf');
    }

    public function generateExcel()
    {
        $packages = $this->getFilteredPackages();
        return Excel::download(new PackagesExport($packages), 'Reporte Paquetes Ordinarios.xlsx');
    }

    public function render()
    {
        $packages = $this->filteredPackages;
        if (empty($packages)) {
            $packages = $this->getFilteredPackages();
        }

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 100;
        $currentItems = array_slice($packages, ($currentPage - 1) * $perPage, $perPage);
        $paginatedItems = new LengthAwarePaginator($currentItems, count($packages), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        return view('livewire.generados', [
            'packages' => $paginatedItems
        ]);
    }
}
