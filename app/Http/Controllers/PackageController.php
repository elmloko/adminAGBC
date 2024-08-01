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
        return view('packages.estadisticaso');
    }
}
