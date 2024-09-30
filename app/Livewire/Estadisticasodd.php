<?php

namespace App\Livewire;

use Livewire\Component;
use GuzzleHttp\Client;
use Carbon\Carbon;

class Estadisticasodd extends Component
{
    public $data = [];
    public $estadisticasPorMes = [];
    public $estadisticasPorTipo = [];
    public $estadisticasPorPais = [];
    public $estadisticasPorEstado = [];
    public $estadisticasPorPeso = [];

    public function mount()
    {
        $this->getDataFromApi();
    }

    public function getDataFromApi()
    {
        $client = new Client();
        $apiKey = 'eZMlItx6mQMNZjxoijEvf7K3pYvGGXMvEHmQcqvtlAPOEAPgyKDVOpyF7JP0ilbK';

        try {
            $response = $client->get('https://correos.gob.bo:8000/api/callclasiUDD', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey
                ],
                'verify' => false // Puedes eliminar esto si el certificado SSL es válido
            ]);

            $data = json_decode($response->getBody(), true);

            if (is_null($data)) {
                dd('Error en la respuesta de la API', $response->getBody()->getContents());
            }

            $this->data = $data;
            $this->processData();
        } catch (\Exception $e) {
            dd('Error al conectar con la API: ' . $e->getMessage());
        }
    }

    public function processData()
    {
        // Inicializar los arrays de estadísticas
        $this->estadisticasPorMes = [];
        $this->estadisticasPorTipo = [];
        $this->estadisticasPorPais = [];
        $this->estadisticasPorEstado = [];
        $this->estadisticasPorPeso = [];

        foreach ($this->data as $item) {
            // Estadísticas por Mes
            if (isset($item['created_at'])) {
                $mes = Carbon::parse($item['created_at'])->format('Y-m');
                if (!isset($this->estadisticasPorMes[$mes])) {
                    $this->estadisticasPorMes[$mes] = 0;
                }
                $this->estadisticasPorMes[$mes]++;
            }

            // Estadísticas por Tipo
            $tipo = $item['TIPO'] ?? 'Desconocido';
            if (!isset($this->estadisticasPorTipo[$tipo])) {
                $this->estadisticasPorTipo[$tipo] = 0;
            }
            $this->estadisticasPorTipo[$tipo]++;

            // Estadísticas por País
            $pais = $item['ISO'] ?? 'Desconocido';
            if (!isset($this->estadisticasPorPais[$pais])) {
                $this->estadisticasPorPais[$pais] = 0;
            }
            $this->estadisticasPorPais[$pais]++;

            // Estadísticas por Estado
            $estado = $item['ESTADO'] ?? 'Desconocido';
            if (!isset($this->estadisticasPorEstado[$estado])) {
                $this->estadisticasPorEstado[$estado] = 0;
            }
            $this->estadisticasPorEstado[$estado]++;

            // Estadísticas por Peso (categorizado)
            $peso = floatval(str_replace(',', '.', $item['PESO'] ?? '0'));
            $pesoCategoria = $this->categorizePeso($peso);
            if (!isset($this->estadisticasPorPeso[$pesoCategoria])) {
                $this->estadisticasPorPeso[$pesoCategoria] = 0;
            }
            $this->estadisticasPorPeso[$pesoCategoria]++;
        }
    }

    private function categorizePeso($peso)
    {
        if ($peso <= 0.5) {
            return '0-0.5 kg';
        } elseif ($peso <= 1) {
            return '0.5-1 kg';
        } elseif ($peso <= 5) {
            return '1-5 kg';
        } elseif ($peso <= 10) {
            return '5-10 kg';
        } else {
            return '>10 kg';
        }
    }

    public function render()
    {
        return view('livewire.estadisticasodd', [
            'estadisticasPorMes' => $this->estadisticasPorMes,
            'estadisticasPorTipo' => $this->estadisticasPorTipo,
            'estadisticasPorPais' => $this->estadisticasPorPais,
            'estadisticasPorEstado' => $this->estadisticasPorEstado,
            'estadisticasPorPeso' => $this->estadisticasPorPeso,
        ]);
    }
}
