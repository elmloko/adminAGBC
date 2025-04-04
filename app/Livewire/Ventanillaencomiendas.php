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

class Ventanillaencomiendas extends Component
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
        ])->get('http://correos.gob.bo:8000/api/packagesUENCOMIENDAS');
    
        $packages = [];
        if ($response->successful()) {
            $packages = $response->json();
    
            foreach ($packages as &$package) {
                // Formatear la fecha de actualización
                if (isset($package['updated_at'])) {
                    $package['updated_at'] = Carbon::parse($package['updated_at'])->format('d-m-Y H:i:s');
                }
    
                // Calcular la diferencia de días entre created_at y updated_at
                if (isset($package['created_at'], $package['updated_at'])) {
                    $createdAt = Carbon::parse($package['created_at']);
                    $updatedAt = Carbon::parse($package['updated_at']);
                    $package['date_difference'] = $updatedAt->diffInDays($createdAt);
                } else {
                    $package['date_difference'] = 'No actualizado'; // O cualquier mensaje que desees mostrar
                }
    
                // Determinar el estado basado en date_difference
                if ($package['date_difference'] <= 7) {
                    $package['next_status'] = 'VENTANILLA';
                    $package['status_color'] = 'green';
                } elseif ($package['date_difference'] > 7 && $package['date_difference'] <= 30) {
                    $package['next_status'] = 'CARTERO';
                    $package['status_color'] = 'orange';
                } else {
                    $package['next_status'] = 'REZAGO';
                    $package['status_color'] = 'red';
                }
            }
        }
    
        // Filtrar por estado
        if (!empty($this->ventanilla)) {
            $packages = array_filter($packages, function ($package) {
                return $package['next_status'] === $this->ventanilla; // Filtrado por next_status
            });
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
    
        // Filtrar los paquetes según la ciudad
        if (!empty($this->ciudad)) {
            $packages = array_filter($packages, function ($package) {
                return stripos($package['CUIDAD'], $this->ciudad) !== false;
            });
        }
    
        // Ordenar los paquetes
        usort($packages, function ($a, $b) {
            if (is_null($a['updated_at']) && is_null($b['updated_at'])) {
                return 0;
            } elseif (is_null($a['updated_at'])) {
                return 1;
            } elseif (is_null($b['updated_at'])) {
                return -1;
            }
            return Carbon::parse($b['updated_at']) <=> Carbon::parse($a['updated_at']);
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
        $perPage = 10;
        $currentItems = array_slice($packages, ($currentPage - 1) * $perPage, $perPage);
        $paginatedItems = new LengthAwarePaginator($currentItems, count($packages), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        return view('livewire.ventanillaencomiendas', [
            'packages' => $paginatedItems
        ]);
    }
}
