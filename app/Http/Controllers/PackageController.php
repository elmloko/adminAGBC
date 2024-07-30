<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{
    public function getPackages()
    {
        return view('packages.packages');
    }

    public function getGenerados()
    {
        return view('packages.generados');
    }

    public function getVentanilla()
    {
        return view('packages.ventanilla');
    }

    public function getEstadisticaso()
    {
        // Consulta para obtener el total de paquetes registrados por mes
        $totalPackagesByMonth = DB::table('packages')
            ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total'))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Consulta para obtener el total de paquetes en estado DESPACHO por mes
        $despachoPackagesByMonth = DB::table('packages')
            ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total'))
            ->where('ESTADO', 'DESPACHO')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Consulta para obtener el total de paquetes registrados por ciudad
        $packagesByCity = DB::table('packages')
            ->select(DB::raw('CUIDAD as city, COUNT(*) as total'))
            ->groupBy('city')
            ->orderBy('total', 'desc')
            ->get();

        // Consulta para obtener el total de paquetes en estado DESPACHO por ciudad
        $despachoPackagesByCity = DB::table('packages')
            ->select(DB::raw('CUIDAD as city, COUNT(*) as total'))
            ->where('ESTADO', 'DESPACHO')
            ->groupBy('city')
            ->orderBy('total', 'desc')
            ->get();

        // Consulta para obtener el total de paquetes en estado VENTANILLA por mes
        $ventanillaPackagesByMonth = DB::table('packages')
            ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total'))
            ->where('ESTADO', 'VENTANILLA')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Consulta para obtener el total de paquetes en estado VENTANILLA por servicio
        $ventanillaByService = DB::table('packages')
            ->select('VENTANILLA as service', DB::raw('COUNT(*) as total'))
            ->where('ESTADO', 'VENTANILLA')
            ->whereIn('VENTANILLA', ['DD', 'DND', 'ECA', 'ENCOMIENDAS', 'CASILLAS'])
            ->groupBy('VENTANILLA')
            ->orderBy('total', 'desc')
            ->get();

        // Datos para el gráfico de "Ventanilla por Ciudad"
        $ventanillaByCity = DB::table('packages')
            ->select('CUIDAD as city', DB::raw('COUNT(*) as total'))
            ->where('ESTADO', 'VENTANILLA')
            ->groupBy('CUIDAD')
            ->orderBy('total', 'desc')
            ->get();

        // Consulta para obtener el total del precio de paquetes en estado ENTREGADO por mes
        $entregadoPricesByMonth = DB::table('packages')
            ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(PRECIO) as total'))
            ->where('ESTADO', 'ENTREGADO')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Consulta para obtener el total de paquetes entregados por ciudad
        $entregadoByCity = DB::table('packages')
            ->select('CUIDAD as city', DB::raw('COUNT(*) as total'))
            ->where('ESTADO', 'ENTREGADO')
            ->groupBy('city')
            ->orderBy('total', 'desc')
            ->get();

        // Consulta para obtener el total de paquetes en estado VENTANILLA por servicio y entregados
        $entregadoByService = DB::table('packages')
            ->select('VENTANILLA as service', DB::raw('COUNT(*) as total'))
            ->where('ESTADO', 'ENTREGADO')
            ->whereIn('VENTANILLA', ['DD', 'DND', 'ECA', 'ENCOMIENDAS', 'CASILLAS'])
            ->groupBy('VENTANILLA')
            ->orderBy('total', 'desc')
            ->get();

        return view('packages.estadisticaso', [
            'totalPackagesByMonth' => $totalPackagesByMonth,
            'despachoPackagesByMonth' => $despachoPackagesByMonth,
            'packagesByCity' => $packagesByCity,
            'despachoPackagesByCity' => $despachoPackagesByCity,
            'ventanillaPackagesByMonth' => $ventanillaPackagesByMonth,
            'ventanillaByService' => $ventanillaByService,
            'ventanillaByCity' => $ventanillaByCity,
            'entregadoPricesByMonth' => $entregadoPricesByMonth,
            'entregadoByCity' => $entregadoByCity,
            'entregadoByService' => $entregadoByService,
        ]);
    }
}
