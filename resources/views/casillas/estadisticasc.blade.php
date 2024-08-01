@extends('adminlte::page')

@section('title', 'Estadísticas de Paquetes')

@section('template_title')
    Estadísticas de Paquetería Postal
@endsection

@section('content')
    <div class="card card-dark">
        <div class="card-header">
            <h3 class="card-title">Estadísticas del Sistema Casillas Libre</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Gráfico de Estado de Paquetes por Mes -->
                <div class="col-md-3">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Casillas libres por mes</h3>
                            <h5 class="box-title">Inventario desde 01/2024</h5>
                        </div>
                        <div class="box-body">
                            <canvas id="estadisticasPorMesChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Gráfico de Paquetes por Ciudad -->
                <div class="col-md-3">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Casillas libres por tamaño</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="estadisticasPorTamanoChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box bg-info h-100">
                        <span class="info-box-icon"><i class="fas fa-envelope-open-text"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Casillas Libres</span>
                            <span class="info-box-number">{{ $totalCasillasLibres }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const estadisticasPorMes = @json($estadisticasPorMes);
            const estadisticasPorTamano = @json($estadisticasPorTamano);

            const labelsPorMes = Object.keys(estadisticasPorMes);
            const dataPorMes = Object.values(estadisticasPorMes);
            const labelsPorTamano = Object.keys(estadisticasPorTamano);
            const dataPorTamano = Object.values(estadisticasPorTamano);

            // Gráfico de barras por mes
            const ctxPorMes = document.getElementById('estadisticasPorMesChart').getContext('2d');
            const estadisticasPorMesChart = new Chart(ctxPorMes, {
                type: 'bar',
                data: {
                    labels: labelsPorMes,
                    datasets: [{
                        label: '# de Casillas',
                        data: dataPorMes,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Gráfico de pastel por tamaño
            const ctxPorTamano = document.getElementById('estadisticasPorTamanoChart').getContext('2d');
            const estadisticasPorTamanoChart = new Chart(ctxPorTamano, {
                type: 'pie',
                data: {
                    labels: labelsPorTamano,
                    datasets: [{
                        label: '# de Casillas',
                        data: dataPorTamano,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.label + ': ' + tooltipItem.raw;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@stop
