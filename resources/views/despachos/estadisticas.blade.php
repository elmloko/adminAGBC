@extends('adminlte::page')

@section('title', 'Estadísticas de Casillas Postales')

@section('template_title')
    Estadísticas de Casillas Postales
@endsection

@section('content')
    @livewire('estadisticasdespachos')
    @include('footer')
@stop
