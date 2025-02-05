<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\DespachosExport;

class Apertura extends Component
{
    public $aperturas = [];
    public $search = '';
    public $date = '';
    public $categoria = '';

    public function mount()
    {
        $this->fetchData();
    }

    public function fetchData()
    {
        $response = Http::withOptions([
            'verify' => false, // Ignorar la verificación SSL
        ])->get('https://correos.gob.bo:8005/api/apertura');
        
        if ($response->successful()) {
            $data = $response->json();
            if ($data['success'] && isset($data['data'])) {
                $this->aperturas = array_map(function ($item) {
                    return [
                        'oforigen' => $item['oforigen'],
                        'ofdestino' => $item['ofdestino'],
                        'identificador' => $item['identificador'],
                        'created_at' => date('Y-m-d H:i:s', strtotime($item['created_at'])),
                        'peso_total' => array_sum(array_column($item['sacas'], 'peso')),
                        'paquetes_total' => array_reduce($item['sacas'], function ($carry, $saca) {
                            return $carry + array_reduce($saca['contenidos'], function ($subcarry, $contenido) {
                                return $subcarry + 
                                    ($contenido['nropaquetesro'] ?? 0) + 
                                    ($contenido['nropaquetesbl'] ?? 0) + 
                                    ($contenido['nropaquetesof'] ?? 0) + 
                                    ($contenido['nropaquetesii'] ?? 0) + 
                                    ($contenido['nropaqueteset'] ?? 0) + 
                                    ($contenido['nropaquetessu'] ?? 0) + 
                                    ($contenido['nropaquetessn'] ?? 0) + 
                                    ($contenido['nropaquetesems'] ?? 0) + 
                                    ($contenido['nropaquetescp'] ?? 0) + 
                                    ($contenido['nropaquetesco'] ?? 0) + 
                                    ($contenido['sacasm'] ?? 0) + 
                                    ($contenido['lcao'] ?? 0);
                            }, 0);
                        }, 0),
                    ];
                }, $data['data']);
            }
        }
    }

    public function applyFilters()
    {
        $this->fetchData();
        
        if ($this->search) {
            $this->aperturas = array_filter($this->aperturas, function ($apertura) {
                return stripos($apertura['identificador'], $this->search) !== false;
            });
        }
        
        if ($this->date) {
            $this->aperturas = array_filter($this->aperturas, function ($apertura) {
                return $apertura['created_at'] === $this->date;
            });
        }
        
        if ($this->categoria) {
            $this->aperturas = array_filter($this->aperturas, function ($apertura) {
                return $apertura['oforigen'] === $this->categoria;
            });
        }
    }

    public function generateExcel()
    {
        return Excel::download(new DespachosExport($this->aperturas), 'Despachos Aperturas.xlsx');
    }

    public function generatePDF()
    {
        $pdf = Pdf::loadView('livewire.despachos-pdf', ['aperturas' => $this->aperturas]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'Despachos Aperturas.pdf');
    }

    public function render()
    {
        return view('livewire.apertura', [
            'aperturas' => $this->aperturas
        ]);
    }
}
