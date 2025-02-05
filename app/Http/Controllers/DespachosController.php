<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DespachosController extends Controller
{
    public function getEstadisticasdespachos()
    {
        return view('despachos.estadisticas');
    }
    public function getApertura()
    {
        return view('despachos.apertura');
    }
    public function getCerrado()
    {
        return view('despachos.cerrado');
    }
    public function getExpedicion()
    {
        return view('despachos.expedicion');
    }
    public function getObservado()
    {
        return view('despachos.observado');
    }
    public function getAdmitido()
    {
        return view('despachos.admitido');
    }
}
