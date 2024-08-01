<?php

namespace App\Livewire;

use Livewire\Component;
use GuzzleHttp\Client;
use Carbon\Carbon;

class Estadisticasc extends Component
{
    public $estadisticasPorMes = [];
    public $estadisticasPorTamano = [];
    public $totalCasillasLibres = 0;

    public function mount()
    {
        $this->getEstadisticasc();
    }

    public function getEstadisticasc()
    {
        $client = new Client();
        $response = $client->get('http://172.65.10.33:8000/cajero/libres/');
        $data = json_decode($response->getBody(), true);

        // Procesar los datos por mes
        $this->estadisticasPorMes = $this->procesarDatosPorMes($data);
        // Procesar los datos por tamaño
        $this->estadisticasPorTamano = $this->procesarDatosPorTamano($data);
        // Calcular el total de casillas libres
        $this->totalCasillasLibres = array_sum($this->estadisticasPorTamano);
    }

    private function procesarDatosPorMes($data)
    {
        $estadisticas = [];

        foreach ($data as $item) {
            $mes = Carbon::parse($item['casilla']['updated_at'])->format('Y-m');
            if (!isset($estadisticas[$mes])) {
                $estadisticas[$mes] = 0;
            }
            $estadisticas[$mes]++;
        }

        return $estadisticas;
    }

    private function procesarDatosPorTamano($data)
    {
        $tamanoLabels = [
            1 => 'PEQUEÑA',
            2 => 'MEDIANA',
            3 => 'GABETA',
            4 => 'CAJON'
        ];

        $estadisticas = [
            'PEQUEÑA' => 0,
            'MEDIANA' => 0,
            'GABETA' => 0,
            'CAJON' => 0
        ];

        foreach ($data as $item) {
            $tamanoId = $item['casilla']['categoria_id'];
            if (isset($tamanoLabels[$tamanoId])) {
                $tamano = $tamanoLabels[$tamanoId];
                $estadisticas[$tamano]++;
            }
        }

        return $estadisticas;
    }

    public function render()
    {
        return view('livewire.estadisticasc');
    }
}
