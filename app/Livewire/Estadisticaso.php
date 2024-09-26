<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Estadisticaso extends Component
{
    public $totalPackagesByMonth;
    public $despachoPackagesByMonth;
    public $packagesByCity;
    public $despachoPackagesByCity;
    public $ventanillaPackagesByMonth;
    public $ventanillaByService;
    public $ventanillaByCity;
    public $entregadoPricesByMonth;
    public $entregadoByCity;
    public $entregadoByService;
    public function mount()
    {
        // Consulta para obtener el total de paquetes registrados por mes
        $this->totalPackagesByMonth = DB::table('packages')
            ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total'))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Consulta para obtener el total de paquetes en estado DESPACHO por mes
        $this->despachoPackagesByMonth = DB::table('packages')
            ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total'))
            ->where('ESTADO', 'DESPACHO')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Consulta para obtener el total de paquetes registrados por ciudad
        $this->packagesByCity = DB::table('packages')
            ->select(DB::raw('CUIDAD as city, COUNT(*) as total'))
            ->groupBy('city')
            ->orderBy('total', 'desc')
            ->get();

        // Consulta para obtener el total de paquetes en estado DESPACHO por ciudad
        $this->despachoPackagesByCity = DB::table('packages')
            ->select(DB::raw('CUIDAD as city, COUNT(*) as total'))
            ->where('ESTADO', 'DESPACHO')
            ->groupBy('city')
            ->orderBy('total', 'desc')
            ->get();

        // Consulta para obtener el total de paquetes en estado VENTANILLA por mes
        $this->ventanillaPackagesByMonth = DB::table('packages')
            ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total'))
            ->where('ESTADO', 'VENTANILLA')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Consulta para obtener el total de paquetes en estado VENTANILLA por servicio
        $this->ventanillaByService = DB::table('packages')
            ->select('VENTANILLA as service', DB::raw('COUNT(*) as total'))
            ->where('ESTADO', 'VENTANILLA')
            ->whereIn('VENTANILLA', ['DD', 'DND', 'ECA', 'ENCOMIENDAS', 'CASILLAS'])
            ->groupBy('VENTANILLA')
            ->orderBy('total', 'desc')
            ->get();

        // Datos para el gráfico de "Ventanilla por Ciudad"
        $this->ventanillaByCity = DB::table('packages')
            ->select('CUIDAD as city', DB::raw('COUNT(*) as total'))
            ->where('ESTADO', 'VENTANILLA')
            ->groupBy('CUIDAD')
            ->orderBy('total', 'desc')
            ->get();

        // Consulta para obtener el total del precio de paquetes en estado ENTREGADO por mes
        $this->entregadoPricesByMonth = DB::table('packages')
            ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(PRECIO) as total'))
            ->where('ESTADO', 'ENTREGADO')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Consulta para obtener el total de paquetes entregados por ciudad
        $this->entregadoByCity = DB::table('packages')
            ->select('CUIDAD as city', DB::raw('COUNT(*) as total'))
            ->where('ESTADO', 'ENTREGADO')
            ->groupBy('city')
            ->orderBy('total', 'desc')
            ->get();

        // Consulta para obtener el total de paquetes en estado VENTANILLA por servicio y entregados
        $this->entregadoByService = DB::table('packages')
            ->select('VENTANILLA as service', DB::raw('COUNT(*) as total'))
            ->where('ESTADO', 'ENTREGADO')
            ->whereIn('VENTANILLA', ['DD', 'DND', 'ECA', 'ENCOMIENDAS', 'CASILLAS'])
            ->groupBy('VENTANILLA')
            ->orderBy('total', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.estadisticaso');
    }
}
