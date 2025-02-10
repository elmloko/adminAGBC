<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReclamosController extends Controller
{
    public function getEstadisticasr()
    {
        return view('reclamos.estadisticasr');
    }
    public function getInformaciones()
    {
        return view('reclamos.informaciones');
    }
    public function getQuejas()
    {
        return view('reclamos.quejas');
    }
    public function getReclamos()
    {
        return view('reclamos.reclamos');
    }
    public function getSugerencias()
    {
        return view('reclamos.sugerencias');
    }
}
