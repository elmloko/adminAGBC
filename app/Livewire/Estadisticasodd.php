<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Estadisticasodd extends Component
{
    public $packagesByDay;
    public $packagesByEstado;
    public $packagesByCountry;
    public $countClasificacion;
    public $countDespacho;
    public $packagesVentanillaByDay;
    public $packagesByAduana;
    public $packagesByTipo;
    public $countVentanillaDD;

    public function mount()
    {
        // Consulta existente para paquetes por día
        $this->packagesByDay = DB::table('packages')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total'))
            ->where('VENTANILLA', 'DD')
            ->whereIn('ESTADO', ['CLASIFICACION', 'DESPACHO'])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Consulta para el Donut Chart de distribución por estado
        $this->packagesByEstado = DB::table('packages')
            ->select('ESTADO', DB::raw('COUNT(*) as total'))
            ->where('VENTANILLA', 'DD')
            ->whereIn('ESTADO', ['CLASIFICACION', 'DESPACHO'])
            ->groupBy('ESTADO')
            ->get();

        // Nueva consulta para el gráfico de barras por país
        $this->packagesByCountry = DB::table('packages')
            ->select('PAIS', DB::raw('COUNT(*) as total'))
            ->where('VENTANILLA', 'DD')
            ->whereIn('ESTADO', ['CLASIFICACION', 'DESPACHO'])
            ->groupBy('PAIS')
            ->orderBy('total', 'desc')
            ->get();

        // Nueva consulta para el conteo de paquetes en CLASIFICACION
        $this->countClasificacion = DB::table('packages')
            ->where('VENTANILLA', 'DD')
            ->where('ESTADO', 'CLASIFICACION')
            ->count();

        // Nueva consulta para el conteo de paquetes en DESPACHO
        $this->countDespacho = DB::table('packages')
            ->where('VENTANILLA', 'DD')
            ->where('ESTADO', 'DESPACHO')
            ->count();

        // Consulta para paquetes por día donde ESTADO == 'VENTANILLA' y VENTANILLA == 'DD'
        $this->packagesVentanillaByDay = DB::table('packages')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total'))
            ->where('VENTANILLA', 'DD')
            ->where('ESTADO', 'VENTANILLA')
            ->where('created_at', '>=', Carbon::now()->subDays(60))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Nueva consulta para paquetes agrupados por ADUANA
        $this->packagesByAduana = DB::table('packages')
            ->select('ADUANA', DB::raw('COUNT(*) as total'))
            ->where('VENTANILLA', 'DD')
            ->where('ESTADO', 'VENTANILLA')
            ->groupBy('ADUANA')
            ->get();
        $this->packagesByTipo = DB::table('packages')
            ->select('TIPO', DB::raw('COUNT(*) as total'))
            ->where('VENTANILLA', 'DD')
            ->where('ESTADO', 'VENTANILLA')
            ->groupBy('TIPO')
            ->get();
        $this->countVentanillaDD = DB::table('packages')
            ->where('VENTANILLA', 'DD')
            ->where('ESTADO', 'VENTANILLA')
            ->count();
    }

    public function render()
    {
        return view('livewire.estadisticasodd');
    }
}
