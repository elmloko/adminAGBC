@extends('adminlte::page')

@section('title', 'Estadísticas de Paquetes')

@section('template_title')
    Estadísticas de Paquetería Postal
@endsection

@section('content')
    @livewire('estadisticasocasillas')
    @include('footer')
@stop