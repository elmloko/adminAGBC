<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Estadisticasoeca extends Component
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
    public $packagesCarteroVsRetorno;
    public $packagesCarteroRetornoByDay;
    public $packagesByUserCartero;
    public $countCarteroDD;
    public $countRetornoDD;
    public $packagesEntregadoRepartidoByDay;
    public $packagesEntregadoRepartidoTotal;
    public $packagesEntregadoRepartidoByMonthPrice;
    public $countEntregado;
    public $countRepartido;


    public function mount()
    {
        // Consulta existente para paquetes por día
        $this->packagesByDay = DB::table('packages')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total'))
            ->where('VENTANILLA', 'ECA')
            ->whereIn('ESTADO', ['CLASIFICACION', 'DESPACHO'])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Consulta para el Donut Chart de distribución por estado
        $this->packagesByEstado = DB::table('packages')
            ->select('ESTADO', DB::raw('COUNT(*) as total'))
            ->where('VENTANILLA', 'ECA')
            ->whereIn('ESTADO', ['CLASIFICACION', 'DESPACHO'])
            ->groupBy('ESTADO')
            ->get();

        // Nueva consulta para el gráfico de barras por país
        $this->packagesByCountry = DB::table('packages')
            ->select('PAIS', DB::raw('COUNT(*) as total'))
            ->where('VENTANILLA', 'ECA')
            ->whereIn('ESTADO', ['CLASIFICACION', 'DESPACHO'])
            ->groupBy('PAIS')
            ->orderBy('total', 'desc')
            ->get();

        // Nueva consulta para el conteo de paquetes en CLASIFICACION
        $this->countClasificacion = DB::table('packages')
            ->where('VENTANILLA', 'ECA')
            ->where('ESTADO', 'CLASIFICACION')
            ->count();

        // Nueva consulta para el conteo de paquetes en DESPACHO
        $this->countDespacho = DB::table('packages')
            ->where('VENTANILLA', 'ECA')
            ->where('ESTADO', 'DESPACHO')
            ->count();

        // Consulta para paquetes por día donde ESTADO == 'VENTANILLA' y VENTANILLA == 'DD'
        $this->packagesVentanillaByDay = DB::table('packages')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total'))
            ->where('VENTANILLA', 'ECA')
            ->where('ESTADO', 'VENTANILLA')
            ->where('created_at', '>=', Carbon::now()->subDays(120))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Nueva consulta para paquetes agrupados por ADUANA
        $this->packagesByAduana = DB::table('packages')
            ->select('ADUANA', DB::raw('COUNT(*) as total'))
            ->where('VENTANILLA', 'ECA')
            ->where('ESTADO', 'VENTANILLA')
            ->groupBy('ADUANA')
            ->get();
        $this->packagesByTipo = DB::table('packages')
            ->select('TIPO', DB::raw('COUNT(*) as total'))
            ->where('VENTANILLA', 'ECA')
            ->where('ESTADO', 'VENTANILLA')
            ->groupBy('TIPO')
            ->get();
        $this->countVentanillaDD = DB::table('packages')
            ->where('VENTANILLA', 'ECA')
            ->where('ESTADO', 'VENTANILLA')
            ->count();
        $this->packagesCarteroVsRetorno = DB::table('packages')
            ->select('ESTADO', DB::raw('COUNT(*) as total'))
            ->where('VENTANILLA', 'ECA')
            ->whereIn('ESTADO', ['CARTERO', 'RETORNO'])
            ->groupBy('ESTADO')
            ->get();
        $this->packagesCarteroRetornoByDay = DB::table('packages')
            ->select(DB::raw('DATE(created_at) as date'), 'ESTADO', DB::raw('COUNT(*) as total'))
            ->where('VENTANILLA', 'ECA')
            ->whereIn('ESTADO', ['CARTERO', 'RETORNO'])
            ->groupBy('date', 'ESTADO')
            ->orderBy('date', 'asc')
            ->get();
        $this->packagesByUserCartero = DB::table('packages')
            ->select('usercartero', DB::raw('COUNT(*) as total'))
            ->where('VENTANILLA', 'ECA')
            ->whereIn('ESTADO', ['CARTERO', 'RETORNO'])
            ->groupBy('usercartero')
            ->orderBy('total', 'desc')
            ->get();
        $this->countCarteroDD = DB::table('packages')
            ->where('VENTANILLA', 'ECA')
            ->where('ESTADO', 'CARTERO')
            ->count();

        // Conteo de paquetes con ESTADO == 'RETORNO' y VENTANILLA == 'DD'
        $this->countRetornoDD = DB::table('packages')
            ->where('VENTANILLA', 'ECA')
            ->where('ESTADO', 'RETORNO')
            ->count();
        $this->packagesEntregadoRepartidoByDay = DB::table('packages')
            ->select(DB::raw('DATE(created_at) as date'), 'ESTADO', DB::raw('COUNT(*) as total'))
            ->where('VENTANILLA', 'ECA')
            ->whereIn('ESTADO', ['ENTREGADO', 'REPARTIDO'])
            ->where('created_at', '>=', Carbon::now()->subDays(120))
            ->groupBy('date', 'ESTADO')
            ->orderBy('date', 'asc')
            ->get();
        $this->packagesEntregadoRepartidoTotal = DB::table('packages')
            ->select('ESTADO', DB::raw('COUNT(*) as total'))
            ->where('VENTANILLA', 'ECA')
            ->whereIn('ESTADO', ['ENTREGADO', 'REPARTIDO'])
            ->groupBy('ESTADO')
            ->get();
        $this->packagesEntregadoRepartidoByMonthPrice = DB::table('packages')
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), 'PRECIO', DB::raw('COUNT(*) as total'), DB::raw('SUM(CASE WHEN PRECIO = 5 THEN 5 ELSE 10 END) * COUNT(*) as total_value'))
            ->where('VENTANILLA', 'ECA')
            ->whereIn('ESTADO', ['ENTREGADO', 'REPARTIDO'])
            ->whereNotNull('PRECIO')
            ->groupBy('month', 'PRECIO')
            ->orderBy('month', 'asc')
            ->get();
        // Contador para los paquetes con ESTADO = ENTREGADO
        $this->countEntregado = DB::table('packages')
            ->where('VENTANILLA', 'ECA')
            ->where('ESTADO', 'ENTREGADO')
            ->count();

        // Contador para los paquetes con ESTADO = REPARTIDO
        $this->countRepartido = DB::table('packages')
            ->where('VENTANILLA', 'ECA')
            ->where('ESTADO', 'REPARTIDO')
            ->count();
    }

    public function render()
    {
        return view('livewire.estadisticasoeca');
    }
}
