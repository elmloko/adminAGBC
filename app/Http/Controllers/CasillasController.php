<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
        return view('casillas.Vencidas');
    }
}