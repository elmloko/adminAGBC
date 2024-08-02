<?php

namespace App\Livewire;

use Livewire\Component;
use GuzzleHttp\Client;
use Carbon\Carbon;

class Estadisticasc extends Component
{
    public $estadisticasPorMes = [];
    public $estadisticasPorTamano = [];
    public $estadisticasOcupadasPorTamano = []; // Define la variable aquí
    public $totalCasillasLibres = 0;

    public function mount()
    {
        $this->getEstadisticasc();
    }

    public function getEstadisticasc()
    {
        $client = new Client();

        // Obtener datos de casillas libres
        $responseLibres = $client->get('http://172.65.10.33:8000/cajero/libres/');
        $dataLibres = json_decode($responseLibres->getBody(), true);

        // Obtener datos de casillas ocupadas
        $responseOcupadas = $client->get('http://172.65.10.33:8000/cajero/ocupadas/');
        $dataOcupadas = json_decode($responseOcupadas->getBody(), true);

        // Procesar los datos por mes
        $this->estadisticasPorMes = $this->procesarDatosPorMes($dataLibres, $dataOcupadas);
        // Procesar los datos por tamaño
        $this->estadisticasPorTamano = $this->procesarDatosPorTamano($dataLibres);
        $this->estadisticasOcupadasPorTamano = $this->procesarDatosPorTamano($dataOcupadas); // Añade este procesamiento
        // Calcular el total de casillas libres
        $this->totalCasillasLibres = array_sum($this->estadisticasPorTamano);
    }

    private function procesarDatosPorMes($dataLibres, $dataOcupadas)
    {
        $estadisticas = [];

        foreach ($dataLibres as $item) {
            $mes = Carbon::parse($item['casilla']['updated_at'])->format('Y-m');
            if (!isset($estadisticas[$mes])) {
                $estadisticas[$mes] = ['libres' => 0, 'ocupadas' => 0];
            }
            $estadisticas[$mes]['libres']++;
        }

        foreach ($dataOcupadas as $item) {
            $mes = Carbon::parse($item['casilla']['updated_at'])->format('Y-m');
            if (!isset($estadisticas[$mes])) {
                $estadisticas[$mes] = ['libres' => 0, 'ocupadas' => 0];
            }
            $estadisticas[$mes]['ocupadas']++;
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
        return view('livewire.estadisticasc', [
            'estadisticasPorMes' => $this->estadisticasPorMes,
            'estadisticasPorTamano' => $this->estadisticasPorTamano,
            'estadisticasOcupadasPorTamano' => $this->estadisticasOcupadasPorTamano // Pasa la variable a la vista
        ]);
    }
}