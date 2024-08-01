<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Carbon\Carbon;

class CasillasController extends Controller
{
    public function getAlquiladas()
    {
        return view('casillas.alquiladas');
    }

    public function getLibres()
    {
        return view('casillas.libres');
    }

    public function getMantenimiento()
    {
        return view('casillas.mantenimiento');
    }

    public function getVencidas()
    {
        return view('casillas.vencidas');
    }
    public function getCorrespondencia()
    {
        return view('casillas.correspondencia');
    }
    public function getReservadas()
    {
        return view('casillas.reservadas');
    }
    public function getEstadisticasc()
    {
        $client = new Client();
        $response = $client->get('http://172.65.10.33:8000/cajero/libres/');
        $data = json_decode($response->getBody(), true);

        // Procesar los datos por mes
        $estadisticasPorMes = $this->procesarDatosPorMes($data);
        // Procesar los datos por tamaño
        $estadisticasPorTamano = $this->procesarDatosPorTamano($data);
        // Calcular el total de casillas libres
        $totalCasillasLibres = array_sum($estadisticasPorTamano);

        return view('casillas.estadisticasc', compact('estadisticasPorMes', 'estadisticasPorTamano', 'totalCasillasLibres'));
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
}
