<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class Package extends Component
{
    use WithPagination;

    public $search = '';
    public $filteredPackages = [];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function searchPackages()
    {
        $this->resetPage(); // Reset paginación al buscar
        $this->filteredPackages = $this->getFilteredPackages();
    }

    public function getFilteredPackages()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer nOWnqwk1kUgFb416NuxpeWq8c75in6UUPsgLtEagTNVAXt44Ht9KWQQxJGDPZn9m'
        ])->get('http://172.65.10.52/api/softdeletes');

        $packages = [];
        if ($response->successful()) {
            $packages = $response->json();
            
            // Formatear las fechas
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

        // Ordenar los paquetes en orden descendente (asumiendo que tienen una clave 'id')
        usort($packages, function ($a, $b) {
            return $b['deleted_at'] <=> $a['deleted_at'];
        });

        return $packages;
    }

    public function render()
    {
        $packages = $this->filteredPackages;
        if (empty($packages)) {
            $packages = $this->getFilteredPackages();
        }

        // Convertir el array de paquetes en una colección paginada
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 100; // Define el número de elementos por página
        $currentItems = array_slice($packages, ($currentPage - 1) * $perPage, $perPage);
        $paginatedItems = new LengthAwarePaginator($currentItems, count($packages), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        return view('livewire.package', [
            'packages' => $paginatedItems
        ]);
    }
}
