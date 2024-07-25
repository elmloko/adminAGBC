<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class PackageController extends Controller
{
    public function getPackages()
    {
        return view('packages.packages');
    }

    public function getGenerados()
    {
        return view('packages.generados');
    }

    public function getVentanilla()
    {
        return view('packages.ventanilla');
    }

    public function getEstadisticaso()
    {
        // Obtener los datos de las APIs con la cabecera de autorización
        $allPackages = Http::withHeaders([
            'Authorization' => 'Bearer cl7kXbLo9resWfbE4PpmJmWrlpcHXauYCisKc7c5PmYQlx90VEnUP8oGv78bauuY'
        ])->get('http://172.65.10.52/api/packages')->json();

        $softDeletedPackages = Http::withHeaders([
            'Authorization' => 'Bearer cl7kXbLo9resWfbE4PpmJmWrlpcHXauYCisKc7c5PmYQlx90VEnUP8oGv78bauuY'
        ])->get('http://172.65.10.52/api/softdeletes')->json();

        $packageData = array_merge($allPackages, $softDeletedPackages);

        $statistics = [];
        $ingresosStatistics = [];
        $cityStatistics = [];
        
        $paquetesIngreso = 0;
        $paquetesEntregados = 0;
        $paquetesVentanilla = 0;
        $totalIngresos = 0;

        foreach ($packageData as $package) {
            $month = Carbon::parse($package['created_at'])->format('Y-m');
            $city = $package['CUIDAD'];

            // Unificar Sucre y Chuquisaca
            if (in_array($city, ['Sucre', 'Chuquisaca'])) {
                $city = 'Sucre/Chuquisaca';
            }

            if (!isset($statistics[$month])) {
                $statistics[$month] = [
                    'ENTREGADO' => 0,
                    'VENTANILLA' => 0,
                    'CLASIFICACION' => 0,
                ];
            }

            if (isset($statistics[$month][$package['ESTADO']])) {
                $statistics[$month][$package['ESTADO']]++;
            }

            if (!isset($ingresosStatistics[$month])) {
                $ingresosStatistics[$month] = 0;
            }
            $ingresosStatistics[$month] += $package['PRECIO'];

            if (!isset($cityStatistics[$city])) {
                $cityStatistics[$city] = 0;
            }
            $cityStatistics[$city]++;

            // Calcular los valores para las tarjetas de resumen
            if (in_array($package['ESTADO'], ['CLASIFICACION', 'DESPACHO'])) {
                $paquetesIngreso++;
            }

            if ($package['ESTADO'] == 'ENTREGADO') {
                $paquetesEntregados++;
            }

            if ($package['ESTADO'] == 'VENTANILLA') {
                $paquetesVentanilla++;
            }

            $totalIngresos += $package['PRECIO'];
        }

        // Calcular porcentajes (estos son ejemplos, ajusta según tu lógica)
        $porcentajeIngreso = $this->calculatePercentageChange($paquetesIngreso, 'CLASIFICACION', 'DESPACHO');
        $porcentajeEntregados = $this->calculatePercentageChange($paquetesEntregados, 'ENTREGADO');
        $porcentajeVentanilla = $this->calculatePercentageChange($paquetesVentanilla, 'VENTANILLA');
        $porcentajeIngresos = $this->calculatePercentageChange($totalIngresos, 'PRECIO');

        // Pasar los datos a la vista
        return view('packages.estadisticaso', compact(
            'statistics',
            'ingresosStatistics',
            'cityStatistics',
            'paquetesIngreso',
            'paquetesEntregados',
            'paquetesVentanilla',
            'totalIngresos',
            'porcentajeIngreso',
            'porcentajeEntregados',
            'porcentajeVentanilla',
            'porcentajeIngresos'
        ));
    }

    private function calculatePercentageChange($currentValue, $state1 = null, $state2 = null)
    {
        // Obtener el valor anterior desde la API
        $previousValue = $this->getPreviousValueFromApi($state1, $state2);
    
        // Evitar la división por cero
        if ($previousValue == 0) {
            return $currentValue > 0 ? 100 : 0;
        }
    
        // Calcular el cambio porcentual
        $percentageChange = (($currentValue - $previousValue) / $previousValue) * 100;
    
        return round($percentageChange, 2); // Redondear a dos decimales
    }
    
    private function getPreviousValueFromApi($state1 = null, $state2 = null)
    {
        // Obtener la fecha del mes anterior
        $previousMonth = Carbon::now()->subMonth()->format('Y-m');
    
        // Obtener los datos de la API
        $allPackages = Http::withHeaders([
            'Authorization' => 'Bearer cl7kXbLo9resWfbE4PpmJmWrlpcHXauYCisKc7c5PmYQlx90VEnUP8oGv78bauuY'
        ])->get('http://172.65.10.52/api/packages')->json();
    
        $softDeletedPackages = Http::withHeaders([
            'Authorization' => 'Bearer cl7kXbLo9resWfbE4PpmJmWrlpcHXauYCisKc7c5PmYQlx90VEnUP8oGv78bauuY'
        ])->get('http://172.65.10.52/api/softdeletes')->json();
    
        $packageData = array_merge($allPackages, $softDeletedPackages);
    
        // Filtrar los datos del mes anterior
        $previousMonthData = array_filter($packageData, function($package) use ($previousMonth) {
            return strpos($package['created_at'], $previousMonth) !== false;
        });
    
        // Calcular el valor anterior basado en los estados proporcionados
        $previousValue = 0;
        foreach ($previousMonthData as $package) {
            if ($state1 && $state2) {
                if (in_array($package['ESTADO'], [$state1, $state2])) {
                    $previousValue++;
                }
            } elseif ($state1) {
                if ($package['ESTADO'] == $state1) {
                    $previousValue++;
                }
            } else {
                $previousValue += $package['PRECIO'];
            }
        }
    
        return $previousValue;
    }
}
