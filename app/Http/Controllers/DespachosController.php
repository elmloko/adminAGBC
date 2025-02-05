<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DespachosController extends Controller
{
    public function getEstadisticasdespachos()
    {
        return view('despachos.estadisticas');
    }
}
