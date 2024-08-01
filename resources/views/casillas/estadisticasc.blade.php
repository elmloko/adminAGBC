@extends('adminlte::page')

@section('title', 'Estadísticas de Paquetes')

@section('template_title')
    Estadísticas de Paquetería Postal
@endsection

@section('content')
    <div class="card card-dark">
        <div class="card-header">
            <h3 class="card-title">Estadísticas del Sistema Area Clasificacion</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Gráfico de Estado de Paquetes por Mes -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Paqueteria Registrada / No Recibidos</h3>
                            <h5 class="box-title">Inventario desde 01/2024</h5>
                        </div>
                        <div class="box-body">
                            <canvas id="packageChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Gráfico de Paquetes por Ciudad -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Paquetes Registrada por Ciudad</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="cityChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Gráfico de Paquetes en Estado DESPACHO por Ciudad -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Paquetes No Recibidos por Ciudad</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="despachoCityChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script>

    </script>
@stop
