<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use PDF;

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
        $response = Http::withHeaders([
            'Authorization' => 'Bearer nOWnqwk1kUgFb416NuxpeWq8c75in6UUPsgLtEagTNVAXt44Ht9KWQQxJGDPZn9m'
        ])->get('http://172.65.10.52/api/softdeletes');

        $packages = [];
        if ($response->successful()) {
            $packages = $response->json();
            
            foreach ($packages as &$package) {
                if (isset($package['deleted_at'])) {
                    $package['deleted_at'] = Carbon::parse($package['deleted_at'])->format('d-m-Y H:i:s');
                }
            }
        }

        if (!empty($this->search)) {
            $packages = array_filter($packages, function($package) {
                return stripos($package['CODIGO'], $this->search) !== false || 
                       stripos($package['DESTINATARIO'], $this->search) !== false;
            });
        }

        if (!empty($this->date)) {
            $packages = array_filter($packages, function($package) {
                return Carbon::parse($package['deleted_at'])->toDateString() == Carbon::parse($this->date)->toDateString();
            });
        }

        if (!empty($this->ventanilla)) {
            $packages = array_filter($packages, function($package) {
                return $package['VENTANILLA'] === $this->ventanilla;
            });
        }

        if (!empty($this->ciudad)) {
            $packages = array_filter($packages, function($package) {
                return stripos($package['CUIDAD'], $this->ciudad) !== false;
            });
        }

        usort($packages, function ($a, $b) {
            return $b['deleted_at'] <=> $a['deleted_at'];
        });

        return $packages;
    }

    public function generatePDF()
    {
        $packages = $this->getFilteredPackages();
        $pdf = PDF::loadView('livewire.package-pdf', compact('packages'));
        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->stream();
        }, 'correspondencia_entregada.pdf');
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
