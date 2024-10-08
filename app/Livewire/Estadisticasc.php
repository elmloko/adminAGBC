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
    public $ingresosMensuales = [];

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
        if (is_null($dataLibres)) {
            dd('Error en la respuesta de casillas libres', $responseLibres->getBody()->getContents());
        }

        // Obtener datos de casillas ocupadas
        $responseOcupadas = $client->get('http://172.65.10.33:8000/cajero/ocupadas/');
        $dataOcupadas = json_decode($responseOcupadas->getBody(), true);
        if (is_null($dataOcupadas)) {
            dd('Error en la respuesta de casillas ocupadas', $responseOcupadas->getBody()->getContents());
        }

        // Obtener datos de casillas reservadas
        $responseReservadas = $client->get('http://172.65.10.33:8000/cajero/reservadas/');
        $this->reservadas = json_decode($responseReservadas->getBody(), true);
        if (is_null($this->reservadas)) {
            dd('Error en la respuesta de casillas reservadas', $responseReservadas->getBody()->getContents());
        }

        // Obtener datos de correspondencia
        $responseCorrespondencia = $client->get('http://172.65.10.33:8000/cajero/correspondencia/');
        $this->correspondencia = json_decode($responseCorrespondencia->getBody(), true);
        if (is_null($this->correspondencia)) {
            dd('Error en la respuesta de correspondencia', $responseCorrespondencia->getBody()->getContents());
        }

        // Obtener datos de casillas vencidas
        $responseVencidas = $client->get('http://172.65.10.33:8000/cajero/vencidas/');
        $this->vencidas = json_decode($responseVencidas->getBody(), true);
        if (is_null($this->vencidas)) {
            dd('Error en la respuesta de casillas vencidas', $responseVencidas->getBody()->getContents());
        }

        // Obtener datos de mantenimiento
        $responseMantenimiento = $client->get('http://172.65.10.33:8000/cajero/mantenimiento/');
        $this->mantenimiento = json_decode($responseMantenimiento->getBody(), true);
        if (is_null($this->mantenimiento)) {
            dd('Error en la respuesta de mantenimiento', $responseMantenimiento->getBody()->getContents());
        }

        // Obtener datos de alquileres
        $responseAlquileres = $client->get('http://172.65.10.33:8000/cajero/alquileres/');
        $dataAlquileres = json_decode($responseAlquileres->getBody(), true);
        if (is_null($dataAlquileres)) {
            dd('Error en la respuesta de alquileres', $responseAlquileres->getBody()->getContents());
        }

        // Procesar los datos
        $this->estadisticasPorMes = $this->procesarDatosPorMes($dataLibres, $dataOcupadas, $this->reservadas, $this->vencidas, $this->correspondencia, $this->mantenimiento);
        $this->estadisticasPorTamano = $this->procesarDatosPorTamano($dataLibres);
        $this->estadisticasOcupadasPorTamano = $this->procesarDatosPorTamano($dataOcupadas);
        $this->reservadas = $this->procesarDatosPorTamano($this->reservadas);
        $this->correspondencia = $this->procesarDatosPorTamano($this->correspondencia);
        $this->vencidas = $this->procesarDatosPorTamano($this->vencidas);
        $this->mantenimiento = $this->procesarDatosPorTamano($this->mantenimiento);
        $this->ingresosMensuales = $this->procesarIngresosMensuales($dataAlquileres);

        // Calcular el total de casillas libres
        $this->totalCasillasLibres = array_sum($this->estadisticasPorTamano);
    }

    private function procesarDatosPorMes($dataLibres, $dataOcupadas, $dataReservadas, $dataVencidas, $dataCorrespondencia, $dataMantenimiento)
    {
        $estadisticas = [];

        foreach ($dataLibres as $item) {
            if (isset($item['casilla']['updated_at'])) {
                $mes = Carbon::parse($item['casilla']['updated_at'])->format('Y-m');
                if (!isset($estadisticas[$mes])) {
                    $estadisticas[$mes] = ['libres' => 0, 'ocupadas' => 0, 'reservadas' => 0, 'vencidas' => 0, 'correspondencia' => 0, 'mantenimiento' => 0];
                }
                $estadisticas[$mes]['libres']++;
            }
        }

        foreach ($dataOcupadas as $item) {
            if (isset($item['casilla']['updated_at'])) {
                $mes = Carbon::parse($item['casilla']['updated_at'])->format('Y-m');
                if (!isset($estadisticas[$mes])) {
                    $estadisticas[$mes] = ['libres' => 0, 'ocupadas' => 0, 'reservadas' => 0, 'vencidas' => 0, 'correspondencia' => 0, 'mantenimiento' => 0];
                }
                $estadisticas[$mes]['ocupadas']++;
            }
        }

        foreach ($dataReservadas as $item) {
            if (isset($item['casilla']['updated_at'])) {
                $mes = Carbon::parse($item['casilla']['updated_at'])->format('Y-m');
                if (!isset($estadisticas[$mes])) {
                    $estadisticas[$mes] = ['libres' => 0, 'ocupadas' => 0, 'reservadas' => 0, 'vencidas' => 0, 'correspondencia' => 0, 'mantenimiento' => 0];
                }
                $estadisticas[$mes]['reservadas']++;
            }
        }

        foreach ($dataVencidas as $item) {
            if (isset($item['casilla']['updated_at'])) {
                $mes = Carbon::parse($item['casilla']['updated_at'])->format('Y-m');
                if (!isset($estadisticas[$mes])) {
                    $estadisticas[$mes] = ['libres' => 0, 'ocupadas' => 0, 'reservadas' => 0, 'vencidas' => 0, 'correspondencia' => 0, 'mantenimiento' => 0];
                }
                $estadisticas[$mes]['vencidas']++;
            }
        }

        foreach ($dataCorrespondencia as $item) {
            if (isset($item['casilla']['updated_at'])) {
                $mes = Carbon::parse($item['casilla']['updated_at'])->format('Y-m');
                if (!isset($estadisticas[$mes])) {
                    $estadisticas[$mes] = ['libres' => 0, 'ocupadas' => 0, 'reservadas' => 0, 'vencidas' => 0, 'correspondencia' => 0, 'mantenimiento' => 0];
                }
                $estadisticas[$mes]['correspondencia']++;
            }
        }

        foreach ($dataMantenimiento as $item) {
            if (isset($item['casilla']['updated_at'])) {
                $mes = Carbon::parse($item['casilla']['updated_at'])->format('Y-m');
                if (!isset($estadisticas[$mes])) {
                    $estadisticas[$mes] = ['libres' => 0, 'ocupadas' => 0, 'reservadas' => 0, 'vencidas' => 0, 'correspondencia' => 0, 'mantenimiento' => 0];
                }
                $estadisticas[$mes]['mantenimiento']++;
            }
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
            $tamanoId = $item['casilla']['categoria_id'] ?? null;
            if ($tamanoId && isset($tamanoLabels[$tamanoId])) {
                $tamano = $tamanoLabels[$tamanoId];
                $estadisticas[$tamano]++;
            }
        }

        return $estadisticas;
    }

    private function procesarIngresosMensuales($data)
    {
        $ingresos = [];

        foreach ($data as $item) {
            $mes = Carbon::parse($item['created_at'])->format('Y-m');

            // Asegúrate de que los campos contienen valores numéricos y no texto
            $nombre = $this->convertirAFloat($item['nombre'] ?? 0);
            $estadoPago = $this->convertirAFloat($item['estado_pago'] ?? 0);
            $habilitacion = $this->convertirAFloat($item['habilitacion'] ?? 0);
            $precio = $this->convertirAFloat($item['precio']['precio'] ?? 0);

            if (!isset($ingresos[$mes])) {
                $ingresos[$mes] = [
                    'multa' => 0,
                    'casilla' => 0,
                    'llave' => 0,
                    'habilitacion' => 0
                ];
            }

            $ingresos[$mes]['multa'] += $nombre;
            $ingresos[$mes]['casilla'] += $precio;
            $ingresos[$mes]['llave'] += $estadoPago;
            $ingresos[$mes]['habilitacion'] += $habilitacion;
        }

        return $ingresos;
    }

    private function convertirAFloat($valor)
    {
        // Quitar el texto y convertir a número flotante
        return floatval(preg_replace('/[^0-9.,-]/', '', $valor));
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
            'totalCasillasLibres' => $this->totalCasillasLibres,
            'ingresosMensuales' => $this->ingresosMensuales
        ]);
    }
}
