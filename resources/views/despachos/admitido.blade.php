@extends('adminlte::page')

@section('title', 'Estadísticas de Gestion de Sacas Postales')

@section('template_title')
    Estadísticas de Gestion de Sacas Postales
@endsection

@section('content')
    @livewire('admitido')
    @include('footer')
@stop
