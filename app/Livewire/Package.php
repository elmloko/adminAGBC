<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Exports\PackagesExport;
use Carbon\Carbon;
use PDF;
use Excel;

class Package extends Component
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
        $client = new Client([
            'verify' => false, // Deshabilitar verificación SSL
            'curl' => [
                CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_3, // Usar TLSv1.3
            ],
        ]);

        try {
            $response = $client->request('GET', 'https://correos.gob.bo:8000/api/softdeletes', [
                'headers' => [
                    'Authorization' => 'Bearer eZMlItx6mQMNZjxoijEvf7K3pYvGGXMvEHmQcqvtlAPOEAPgyKDVOpyF7JP0ilbK',
                ]
            ]);

            $packages = [];
            if ($response->getStatusCode() == 200) {
                $packages = json_decode($response->getBody(), true);

                foreach ($packages as &$package) {
                    if (isset($package['deleted_at'])) {
                        $package['deleted_at'] = Carbon::parse($package['deleted_at'])->format('d-m-Y H:i:s');
                    }
                }
            }

            // Filtrar los paquetes según la búsqueda
            if (!empty($this->search)) {
                $packages = array_filter($packages, function($package) {
                    return stripos($package['CODIGO'], $this->search) !== false || 
                           stripos($package['DESTINATARIO'], $this->search) !== false;
                });
            }

            // Filtrar los paquetes según la fecha
            if (!empty($this->date)) {
                $packages = array_filter($packages, function($package) {
                    return Carbon::parse($package['deleted_at'])->toDateString() == Carbon::parse($this->date)->toDateString();
                });
            }

            // Filtrar los paquetes según la ventanilla
            if (!empty($this->ventanilla)) {
                $packages = array_filter($packages, function($package) {
                    return $package['VENTANILLA'] === $this->ventanilla;
                });
            }

            // Filtrar los paquetes según la ciudad
            if (!empty($this->ciudad)) {
                $packages = array_filter($packages, function($package) {
                    return stripos($package['CUIDAD'], $this->ciudad) !== false;
                });
            }

            usort($packages, function ($a, $b) {
                return Carbon::parse($b['deleted_at']) <=> Carbon::parse($a['deleted_at']);
            });

            return $packages;

        } catch (\Exception $e) {
            // Manejar el error
            return [];
        }
    }

    public function generatePDF()
    {
        $packages = $this->getFilteredPackages();
        $pdf = PDF::loadView('livewire.package-pdf', compact('packages'));
        return response()->streamDownload(function() use ($pdf) {
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

        return view('livewire.package', [
            'packages' => $paginatedItems
        ]);
    }
}
