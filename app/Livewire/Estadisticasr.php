<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class Estadisticasr extends Component
{
    // Datos para el gráfico de líneas (agrupados por fecha)
    public $allDates;
    public $seriesData1;
    public $seriesData2;
    public $seriesData3;
    public $seriesData4;

    // Datos para los gráficos de torta (agrupados por ciudad)
    public $pieData1;
    public $pieData2;
    public $pieData3;
    public $pieData4;

    public function mount()
    {
        // --- Definición de URLs para cada grupo ---

        // Grupo 1: Información
        $group1_urls = [
            'https://correos.gob.bo:8002/api/informations',
            'https://correos.gob.bo:8002/api/informationll',
            'https://correos.gob.bo:8002/api/informationsm'
        ];

        // Grupo 2: Quejas
        $group2_urls = [
            'https://correos.gob.bo:8002/api/complaintsa',
            'https://correos.gob.bo:8002/api/complaintso'
        ];

        // Grupo 3: Sugerencias
        $group3_urls = [
            'https://correos.gob.bo:8002/api/suggestion'
        ];

        // Grupo 4: Reclamos
        $group4_urls = [
            'https://correos.gob.bo:8002/api/claims'
        ];

        // --- Procesamiento para el gráfico de líneas (por fecha) ---

        // Obtener conteos por fecha (created_at) para cada grupo
        $dataGroup1 = $this->getCreatedAtCounts($group1_urls);
        $dataGroup2 = $this->getCreatedAtCounts($group2_urls);
        $dataGroup3 = $this->getCreatedAtCounts($group3_urls);
        $dataGroup4 = $this->getCreatedAtCounts($group4_urls);

        // Se obtienen las fechas (keys) de cada grupo
        $dates1 = array_keys($dataGroup1);
        $dates2 = array_keys($dataGroup2);
        $dates3 = array_keys($dataGroup3);
        $dates4 = array_keys($dataGroup4);

        // Unificar todas las fechas para que el eje X sea común en el gráfico
        $allDates = array_unique(array_merge($dates1, $dates2, $dates3, $dates4));
        sort($allDates);
        $this->allDates = $allDates;

        // Completar los datos de cada serie: si para alguna fecha no hay registros se asigna 0
        $this->seriesData1 = $this->fillSeriesData($allDates, $dataGroup1);
        $this->seriesData2 = $this->fillSeriesData($allDates, $dataGroup2);
        $this->seriesData3 = $this->fillSeriesData($allDates, $dataGroup3);
        $this->seriesData4 = $this->fillSeriesData($allDates, $dataGroup4);

        // --- Procesamiento para los gráficos de torta (por ciudad) ---

        // Obtener conteos por ciudad para cada grupo
        $cityGroup1 = $this->getCityCounts($group1_urls);
        $cityGroup2 = $this->getCityCounts($group2_urls);
        $cityGroup3 = $this->getCityCounts($group3_urls);
        $cityGroup4 = $this->getCityCounts($group4_urls);

        // Formatear los datos para Highcharts (array de objetos: ['name' => ciudad, 'y' => count])
        $this->pieData1 = $this->formatPieData($cityGroup1);
        $this->pieData2 = $this->formatPieData($cityGroup2);
        $this->pieData3 = $this->formatPieData($cityGroup3);
        $this->pieData4 = $this->formatPieData($cityGroup4);
    }

    public function render()
    {
        return view('livewire.estadisticasr');
    }


    private function getCreatedAtCounts($urls)
    {
        $counts = [];
        foreach ($urls as $url) {
            $response = Http::withOptions([
                'verify' => false,
                'curl' => [
                    CURLOPT_SSLVERSION   => CURL_SSLVERSION_TLSv1_2,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_IPRESOLVE    => CURL_IPRESOLVE_V4,
                ],
            ])->get($url);
            if ($response->successful()) {
                $data = $response->json();
                foreach ($data as $item) {
                    if (isset($item['created_at'])) {
                        // Convertir la fecha a formato 'Y-m-d'
                        $date = date('Y-m-d', strtotime($item['created_at']));
                        if (!isset($counts[$date])) {
                            $counts[$date] = 0;
                        }
                        $counts[$date]++;
                    }
                }
            }
        }
        return $counts;
    }

    private function fillSeriesData($allDates, $groupData)
    {
        $series = [];
        foreach ($allDates as $date) {
            $series[] = isset($groupData[$date]) ? $groupData[$date] : 0;
        }
        return $series;
    }

    private function getCityCounts($urls)
    {
        $counts = [];
        foreach ($urls as $url) {
            $response = Http::withOptions([
                'verify' => false,
                'curl' => [
                    CURLOPT_SSLVERSION   => CURL_SSLVERSION_TLSv1_2,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_IPRESOLVE    => CURL_IPRESOLVE_V4,
                ],
            ])->get($url);
            if ($response->successful()) {
                $data = $response->json();
                foreach ($data as $item) {
                    if (isset($item['ciudad'])) {
                        $city = $item['ciudad'];
                        if (!isset($counts[$city])) {
                            $counts[$city] = 0;
                        }
                        $counts[$city]++;
                    }
                }
            }
        }
        return $counts;
    }

    private function formatPieData($cityCounts)
    {
        $pieData = [];
        foreach ($cityCounts as $city => $count) {
            $pieData[] = [
                'name' => $city,
                'y' => $count
            ];
        }
        return $pieData;
    }
}
