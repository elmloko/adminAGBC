<?php

namespace App\Http\Controllers;

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
        return view('packages.estadisticaso');
    }
    public function getPackagesDD()
    {
        return view('packages.packagesdd');
    }

    public function getGeneradosDD()
    {
        return view('packages.generadosdd');
    }

    public function getVentanillaDD()
    {
        return view('packages.ventanilladd');
    }

    public function getEstadisticasoDD()
    {
        return view('packages.estadisticasodd');
    }
    public function getPackagesDND()
    {
        return view('packages.packagesdnd');
    }

    public function getGeneradosDND()
    {
        return view('packages.generadosdnd');
    }

    public function getVentanillaDND()
    {
        return view('packages.ventanilladnd');
    }

    public function getEstadisticasoDND()
    {
        return view('packages.estadisticasodnd');
    }
    public function getPackagesECA()
    {
        return view('packages.packageseca');
    }

    public function getGeneradosECA()
    {
        return view('packages.generadoseca');
    }

    public function getVentanillaECA()
    {
        return view('packages.ventanillaeca');
    }

    public function getEstadisticasoECA()
    {
        return view('packages.estadisticasoeca');
    }
    public function getPackagesENCOMIENDAS()
    {
        return view('packages.packagesdnd');
    }

    public function getGeneradosENCOMIENDAS()
    {
        return view('packages.generadosencomiendas');
    }

    public function getVentanillaENCOMIENDAS()
    {
        return view('packages.ventanillaencomiendas');
    }

    public function getEstadisticasoENCOMIENDAS()
    {
        return view('packages.estadisticasoencomiendas');
    }
    public function getPackagesCASILLAS()
    {
        return view('packages.packagescasillas');
    }

    public function getGeneradosCASILLAS()
    {
        return view('packages.generadoscasillas');
    }

    public function getVentanillaCASILLAS()
    {
        return view('packages.ventanillacasillas');
    }

    public function getEstadisticasoCASILLAS()
    {
        return view('packages.estadisticasocasillas');
    }
}
