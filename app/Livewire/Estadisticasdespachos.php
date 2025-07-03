<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class Estadisticasdespachos extends Component
{
    public $data = [];

    public function mount()
    {
        $apis = [
            'apertura' => 'https://correos.gob.bo:8005/api/apertura',
            'cerrado' => 'https://correos.gob.bo:8005/api/cerrado',
            'expedicion' => 'https://correos.gob.bo:8005/api/expedicion',
            'observado' => 'https://correos.gob.bo:8005/api/observado',
            'admitido' => 'https://correos.gob.bo:8005/api/admitido'
        ];

        foreach ($apis as $key => $url) {
            $response = Cache::remember($key, now()->addMinutes(10), function () use ($url) {
                return Http::withOptions([
                    'verify' => false,
                    'curl' => [
                        CURLOPT_SSLVERSION   => CURL_SSLVERSION_TLSv1_2,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_IPRESOLVE    => CURL_IPRESOLVE_V4,
                    ],
                ])->get($url)->json();
            });

            if (!isset($response['success']) || !$response['success']) {
                continue; // Evita procesar respuestas inválidas
            }

            if (!isset($response['data']) || empty($response['data'])) {
                continue; // Evita errores si la API devuelve datos vacíos
            }

            $this->data[$key] = $this->formatData($response['data']);
        }
    }

    private function formatData($items)
    {
        $countByDepto = collect($items)->groupBy('depto')->map->count();
        $total = $countByDepto->sum();

        return $countByDepto->map(function ($count, $depto) use ($total) {
            return [
                'name' => $depto,
                'y' => $total > 0 ? round(($count / $total) * 100, 2) : 0,
                'count' => $count
            ];
        })->values();
    }

    public function render()
    {
        return view('livewire.estadisticasdespachos', [
            'data' => $this->data
        ]);
    }
}
