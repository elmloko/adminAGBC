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

    public function render()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer nOWnqwk1kUgFb416NuxpeWq8c75in6UUPsgLtEagTNVAXt44Ht9KWQQxJGDPZn9m'
        ])->get('http://172.65.10.52/api/packages');

        $packages = [];
        if ($response->successful()) {
            $packages = $response->json();
            
            // Formatear las fechas
            foreach ($packages as &$package) {
                if (isset($package['created_at'])) {
                    $package['created_at'] = Carbon::parse($package['created_at'])->format('d-m-Y H:i:s');
                }
            }
        }
        
        // Ordenar los paquetes en orden descendente (asumiendo que tienen una clave 'id')
        usort($packages, function ($a, $b) {
            return $b['created_at'] <=> $a['created_at'];
        });

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
