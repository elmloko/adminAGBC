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
        // Obtener los paquetes desde el primer endpoint
        $responsePackages = Http::withHeaders([
            'Authorization' => 'Bearer nOWnqwk1kUgFb416NuxpeWq8c75in6UUPsgLtEagTNVAXt44Ht9KWQQxJGDPZn9m'
        ])->get('http://172.65.10.52/api/packages');

        // Obtener los paquetes eliminados suavemente desde el segundo endpoint
        $responseSoftDeletes = Http::withHeaders([
            'Authorization' => 'Bearer nOWnqwk1kUgFb416NuxpeWq8c75in6UUPsgLtEagTNVAXt44Ht9KWQQxJGDPZn9m'
        ])->get('http://172.65.10.52/api/softdeletes');

        $packages = [];

        // Verificar si ambas solicitudes fueron exitosas
        if ($responsePackages->successful() && $responseSoftDeletes->successful()) {
            $packages = array_merge($responsePackages->json(), $responseSoftDeletes->json());

            // Formatear las fechas
            foreach ($packages as &$package) {
                if (isset($package['created_at'])) {
                    $package['created_at'] = Carbon::parse($package['created_at'])->format('d-m-Y H:i:s');
                }
                if (isset($package['deleted_at'])) {
                    $package['deleted_at'] = Carbon::parse($package['deleted_at'])->format('d-m-Y H:i:s');
                }
            }

            // Ordenar los paquetes por fecha de creación descendente
            usort($packages, function ($a, $b) {
                return strtotime($b['created_at']) - strtotime($a['created_at']);
            });
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
