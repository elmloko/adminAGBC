@extends('adminlte::page')
@section('title', 'Paquetes Ordinarios')
@section('template_title')
    Casillas Postales
@endsection

@section('content')
    @livewire('correspondencia')
    @include('footer')
@endsection