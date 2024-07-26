<?php

namespace App\Livewire;

use Livewire\Component;
use GuzzleHttp\Client;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class Alquiladas extends Component
{
    use WithPagination;

    public $search = '';
    public $date = '';
    public $ventanilla = '';
    public $categoria = '';
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

    public $sortBy = 'casilla.nombre'; // Columna por defecto
    public $sortDirection = 'asc'; // Dirección de ordenación por defecto
    public function getFilteredPackages()
    {
        $libresResponse = Http::get('http://172.65.10.33:8000/cajero/ocupadas/');
        $packages = [];

        if ($libresResponse->successful()) {
            $libres = $libresResponse->json();

            foreach ($libres as &$package) {
                if (isset($package['casilla']['created_at'])) {
                    $package['casilla']['created_at'] = Carbon::parse($package['casilla']['created_at'])->format('d-m-Y H:i:s');
                }

                if (isset($package['casilla']['categoria_id'])) {
                    $package['casilla']['categoria_id'] = $this->getCategoriaNombre($package['casilla']['categoria_id']);
                }

                $package['casilla']['fin_fecha'] = null;
            }

            $packages = $libres;
        }

        if (!empty($this->search)) {
            $packages = array_filter($packages, function ($package) {
                return stripos($package['casilla']['nombre'], $this->search) !== false;
            });
        }

        if (!empty($this->date)) {
            $packages = array_filter($packages, function ($package) {
                return Carbon::parse($package['casilla']['created_at'])->toDateString() == Carbon::parse($this->date)->toDateString();
            });
        }

        if (!empty($this->categoria)) {
            $packages = array_filter($packages, function ($package) {
                return $package['casilla']['categoria_id'] == $this->getCategoriaNombre($this->categoria);
            });
        }

        usort($packages, function ($a, $b) {
            $sortBy = explode('.', $this->sortBy);
            $column = $sortBy[0];
            $subColumn = $sortBy[1] ?? null;

            if ($subColumn) {
                return ($this->sortDirection === 'asc' ? 1 : -1) * strcmp($a[$column][$subColumn], $b[$column][$subColumn]);
            }

            return ($this->sortDirection === 'asc' ? 1 : -1) * strcmp($a[$column], $b[$column]);
        });

        return $packages;
    }


    public function getCategoriaNombre($categoriaId)
    {
        $categorias = [
            1 => 'PEQUEÑA',
            2 => 'MEDIANA',
            3 => 'GABETA',
            4 => 'CAJON',
        ];

        return $categorias[$categoriaId] ?? 'DESCONOCIDO';
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

        return view('livewire.alquiladas', [
            'packages' => $paginatedItems
        ]);
    }
}