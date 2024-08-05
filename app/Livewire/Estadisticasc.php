<?php

namespace App\Livewire;

use Livewire\Component;
use GuzzleHttp\Client;
use Carbon\Carbon;

class Estadisticasc extends Component
{
    public $estadisticasPorMes = [];
    public $estadisticasPorTamano = [];
    public $estadisticasOcupadasPorTamano = [];
    public $reservadas = [];
    public $correspondencia = [];
    public $vencidas = [];
    public $mantenimiento = [];
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
    
        // Obtener datos de casillas reservadas
        $responseReservadas = $client->get('http://172.65.10.33:8000/cajero/reservadas/');
        $this->reservadas = json_decode($responseReservadas->getBody(), true);
    
        // Obtener datos de correspondencia
        $responseCorrespondencia = $client->get('http://172.65.10.33:8000/cajero/correspondencia/');
        $this->correspondencia = json_decode($responseCorrespondencia->getBody(), true);
    
        // Obtener datos de casillas vencidas
        $responseVencidas = $client->get('http://172.65.10.33:8000/cajero/vencidas/');
        $this->vencidas = json_decode($responseVencidas->getBody(), true);
    
        // Obtener datos de mantenimiento
        $responseMantenimiento = $client->get('http://172.65.10.33:8000/cajero/mantenimiento/');
        $this->mantenimiento = json_decode($responseMantenimiento->getBody(), true);
    
        // Procesar los datos por mes
        $this->estadisticasPorMes = $this->procesarDatosPorMes($dataLibres, $dataOcupadas, $this->reservadas, $this->vencidas, $this->correspondencia, $this->mantenimiento);
        // Procesar los datos por tamaño
        $this->estadisticasPorTamano = $this->procesarDatosPorTamano($dataLibres);
        $this->estadisticasOcupadasPorTamano = $this->procesarDatosPorTamano($dataOcupadas); // Añade este procesamiento
        // Calcular el total de casillas libres
        $this->totalCasillasLibres = array_sum($this->estadisticasPorTamano);
    }

    private function procesarDatosPorMes($dataLibres, $dataOcupadas, $dataReservadas, $dataVencidas, $dataCorrespondencia, $dataMantenimiento)
    {
        $estadisticas = [];
    
        foreach ($dataLibres as $item) {
            $mes = Carbon::parse($item['casilla']['updated_at'])->format('Y-m');
            if (!isset($estadisticas[$mes])) {
                $estadisticas[$mes] = ['libres' => 0, 'ocupadas' => 0, 'reservadas' => 0, 'vencidas' => 0, 'correspondencia' => 0, 'mantenimiento' => 0];
            }
            $estadisticas[$mes]['libres']++;
        }
    
        foreach ($dataOcupadas as $item) {
            $mes = Carbon::parse($item['casilla']['updated_at'])->format('Y-m');
            if (!isset($estadisticas[$mes])) {
                $estadisticas[$mes] = ['libres' => 0, 'ocupadas' => 0, 'reservadas' => 0, 'vencidas' => 0, 'correspondencia' => 0, 'mantenimiento' => 0];
            }
            $estadisticas[$mes]['ocupadas']++;
        }
    
        foreach ($dataReservadas as $item) {
            $mes = Carbon::parse($item['casilla']['updated_at'])->format('Y-m');
            if (!isset($estadisticas[$mes])) {
                $estadisticas[$mes] = ['libres' => 0, 'ocupadas' => 0, 'reservadas' => 0, 'vencidas' => 0, 'correspondencia' => 0, 'mantenimiento' => 0];
            }
            $estadisticas[$mes]['reservadas']++;
        }
    
        foreach ($dataVencidas as $item) {
            $mes = Carbon::parse($item['casilla']['updated_at'])->format('Y-m');
            if (!isset($estadisticas[$mes])) {
                $estadisticas[$mes] = ['libres' => 0, 'ocupadas' => 0, 'reservadas' => 0, 'vencidas' => 0, 'correspondencia' => 0, 'mantenimiento' => 0];
            }
            $estadisticas[$mes]['vencidas']++;
        }
    
        foreach ($dataCorrespondencia as $item) {
            $mes = Carbon::parse($item['casilla']['updated_at'])->format('Y-m');
            if (!isset($estadisticas[$mes])) {
                $estadisticas[$mes] = ['libres' => 0, 'ocupadas' => 0, 'reservadas' => 0, 'vencidas' => 0, 'correspondencia' => 0, 'mantenimiento' => 0];
            }
            $estadisticas[$mes]['correspondencia']++;
        }
    
        foreach ($dataMantenimiento as $item) {
            $mes = Carbon::parse($item['casilla']['updated_at'])->format('Y-m');
            if (!isset($estadisticas[$mes])) {
                $estadisticas[$mes] = ['libres' => 0, 'ocupadas' => 0, 'reservadas' => 0, 'vencidas' => 0, 'correspondencia' => 0, 'mantenimiento' => 0];
            }
            $estadisticas[$mes]['mantenimiento']++;
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
            'estadisticasOcupadasPorTamano' => $this->estadisticasOcupadasPorTamano,
            'reservadas' => $this->reservadas,
            'correspondencia' => $this->correspondencia,
            'vencidas' => $this->vencidas,
            'mantenimiento' => $this->mantenimiento,
        ]);
    }
}
