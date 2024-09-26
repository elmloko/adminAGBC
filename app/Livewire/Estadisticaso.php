<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class Estadisticaso extends Component
{
    public $totalPackagesByMonth;
    public $despachoPackagesByMonth;
    public $packagesByCity;
    public $despachoPackagesByCity;
    public $ventanillaPackagesByMonth;
    public $ventanillaByService;
    public $ventanillaByCity;
    public $entregadoPricesByMonth;
    public $entregadoByCity;
    public $entregadoByService;
    
    public function mount()
    {
        // Configuración del encabezado y verificación de SSL
        $headers = [
            'Authorization' => 'Bearer eZMlItx6mQMNZjxoijEvf7K3pYvGGXMvEHmQcqvtlAPOEAPgyKDVOpyF7JP0ilbK'
        ];

        // Llamada a la API para los estados CLASIFICACION y DESPACHO
        $responseClasi = Http::withHeaders($headers)->withOptions(['verify' => false])->get('https://correos.gob.bo:8000/api/callclasi');
        if ($responseClasi->successful()) {
            $dataClasi = $responseClasi->json();

            $this->totalPackagesByMonth = collect($dataClasi)->filter(function($item) {
                return isset($item['created_at']); // Asegurarse de que existe 'created_at'
            })->groupBy(function($item) {
                // Convertir created_at en objeto de Carbon para extraer el año y mes
                $createdAt = Carbon::parse($item['created_at']);
                return $createdAt->format('Y-m'); // Formato año-mes
            })->map(function ($group) {
                return [
                    'year' => Carbon::parse($group[0]['created_at'])->year, // Extraer el año
                    'month' => Carbon::parse($group[0]['created_at'])->month, // Extraer el mes
                    'total' => count($group), // Contar los paquetes
                ];
            })->values();

            $this->packagesByCity = collect($dataClasi)->groupBy('city')->map(function ($group, $city) {
                return [
                    'city' => $city,
                    'total' => count($group),
                ];
            })->values();
        }

        // Llamada a la API para el estado VENTANILLA
        $responseVentanilla = Http::withHeaders($headers)->withOptions(['verify' => false])->get('https://correos.gob.bo:8000/api/callclasi');
        if ($responseVentanilla->successful()) {
            $dataVentanilla = $responseVentanilla->json();

            $this->ventanillaPackagesByMonth = collect($dataVentanilla)->filter(function($item) {
                return isset($item['created_at']); // Asegurarse de que existe 'created_at'
            })->groupBy(function($item) {
                $createdAt = Carbon::parse($item['created_at']);
                return $createdAt->format('Y-m'); // Formato año-mes
            })->map(function ($group) {
                return [
                    'year' => Carbon::parse($group[0]['created_at'])->year,
                    'month' => Carbon::parse($group[0]['created_at'])->month,
                    'total' => count($group),
                ];
            })->values();

            $this->ventanillaByService = collect($dataVentanilla)->groupBy('service')->map(function ($group, $service) {
                return [
                    'service' => $service,
                    'total' => count($group),
                ];
            })->values();

            $this->ventanillaByCity = collect($dataVentanilla)->groupBy('city')->map(function ($group, $city) {
                return [
                    'city' => $city,
                    'total' => count($group),
                ];
            })->values();
        }

        // Llamada a la API para el estado ENTREGADO
        $responseEntregado = Http::withHeaders($headers)->withOptions(['verify' => false])->get('https://correos.gob.bo:8000/api/softdeletes');
        if ($responseEntregado->successful()) {
            $dataEntregado = $responseEntregado->json();

            $this->entregadoPricesByMonth = collect($dataEntregado)->filter(function($item) {
                return isset($item['created_at']); // Asegurarse de que existe 'created_at'
            })->groupBy(function($item) {
                $createdAt = Carbon::parse($item['created_at']);
                return $createdAt->format('Y-m'); // Formato año-mes
            })->map(function ($group) {
                return [
                    'year' => Carbon::parse($group[0]['created_at'])->year,
                    'month' => Carbon::parse($group[0]['created_at'])->month,
                    'total' => array_sum(array_column($group->toArray(), 'price')),
                ];
            })->values();

            $this->entregadoByCity = collect($dataEntregado)->groupBy('city')->map(function ($group, $city) {
                return [
                    'city' => $city,
                    'total' => count($group),
                ];
            })->values();

            $this->entregadoByService = collect($dataEntregado)->groupBy('service')->map(function ($group, $service) {
                return [
                    'service' => $service,
                    'total' => count($group),
                ];
            })->values();
        }
    }

    public function render()
    {
        return view('livewire.estadisticaso');
    }
}
