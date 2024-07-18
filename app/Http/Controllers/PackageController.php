<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
