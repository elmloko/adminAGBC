@extends('adminlte::page')

@section('title', 'Estadísticas de Paquetes UDD')

@section('template_title')
    Estadísticas de Paquetería UDD
@endsection

@section('content')
    <!-- Tarjeta contenedora de todos los gráficos -->
    <div class="card card-blue">
        <div class="card-header">
            <h4 class="card-title">Estadísticas de Paquetería UDD</h4>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <!-- Gráficos en una sola columna -->
            <div class="row">
                <!-- Gráfico de Paquetes por Mes -->
                <div class="col-md-4">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Estadísticas de Paquetes por Mes</h4>
                        </div>
                        <div class="box-body">
                            <canvas id="estadisticasPorMesChart" width="400" height="400"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Gráfico de Paquetes por Tipo -->
                <div class="col-md-4">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Estadísticas de Paquetes por Tipo</h4>
                        </div>
                        <div class="box-body">
                            <canvas id="estadisticasPorTipoChart" width="400" height="100"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Gráfico de Paquetes por País -->
                <div class="col-md-4">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Estadísticas de Paquetes por País</h4>
                        </div>
                        <div class="box-body">
                            <canvas id="estadisticasPorPaisChart" width="400" height="400"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Gráfico de Paquetes por Estado -->
                <div class="col-md-4">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Estadísticas de Paquetes por Estado</h4>
                        </div>
                        <div class="box-body">
                            <canvas id="estadisticasPorEstadoChart" width="400" height="100"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Gráfico de Paquetes por Peso -->
                <div class="col-md-4">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Estadísticas de Paquetes por Peso</h4>
                        </div>
                        <div class="box-body">
                            <canvas id="estadisticasPorPesoChart" width="400" height="400"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const estadisticasPorMes = @json($estadisticasPorMes);
            const estadisticasPorTipo = @json($estadisticasPorTipo);
            const estadisticasPorPais = @json($estadisticasPorPais);
            const estadisticasPorEstado = @json($estadisticasPorEstado);
            const estadisticasPorPeso = @json($estadisticasPorPeso);

            // Estadísticas por Mes
            const labelsPorMes = Object.keys(estadisticasPorMes);
            const dataPorMes = Object.values(estadisticasPorMes);

            const ctxPorMes = document.getElementById('estadisticasPorMesChart').getContext('2d');
            const estadisticasPorMesChart = new Chart(ctxPorMes, {
                type: 'line',
                data: {
                    labels: labelsPorMes,
                    datasets: [{
                        label: 'Paquetes',
                        data: dataPorMes,
                        backgroundColor: 'rgba(54, 162, 245, 0.2)',
                        borderColor: 'rgba(54, 162, 245, 1)',
                        fill: false,
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });

            // Estadísticas por Tipo
            const labelsPorTipo = Object.keys(estadisticasPorTipo);
            const dataPorTipo = Object.values(estadisticasPorTipo);

            const ctxPorTipo = document.getElementById('estadisticasPorTipoChart').getContext('2d');
            const estadisticasPorTipoChart = new Chart(ctxPorTipo, {
                type: 'pie',
                data: {
                    labels: labelsPorTipo,
                    datasets: [{
                        data: dataPorTipo,
                        backgroundColor: [
                            'rgba(255, 99, 142, 0.6)',
                            'rgba(54, 162, 245, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(154, 102, 255, 0.6)',
                            'rgba(255, 159, 64, 0.6)'
                        ]
                    }]
                },
                options: {
                    responsive: true
                }
            });

            // Estadísticas por País
            const labelsPorPais = Object.keys(estadisticasPorPais);
            const dataPorPais = Object.values(estadisticasPorPais);

            const ctxPorPais = document.getElementById('estadisticasPorPaisChart').getContext('2d');
            const estadisticasPorPaisChart = new Chart(ctxPorPais, {
                type: 'bar',
                data: {
                    labels: labelsPorPais,
                    datasets: [{
                        label: 'Paquetes',
                        data: dataPorPais,
                        backgroundColor: 'rgba(255, 206, 86, 0.6)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    indexAxis: 'y',
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });

            // Estadísticas por Estado
            const labelsPorEstado = Object.keys(estadisticasPorEstado);
            const dataPorEstado = Object.values(estadisticasPorEstado);

            const ctxPorEstado = document.getElementById('estadisticasPorEstadoChart').getContext('2d');
            const estadisticasPorEstadoChart = new Chart(ctxPorEstado, {
                type: 'doughnut',
                data: {
                    labels: labelsPorEstado,
                    datasets: [{
                        data: dataPorEstado,
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(154, 102, 255, 0.6)',
                            'rgba(255, 159, 64, 0.6)',
                            'rgba(255, 99, 142, 0.6)'
                        ]
                    }]
                },
                options: {
                    responsive: true
                }
            });

            // Estadísticas por Peso
            const labelsPorPeso = Object.keys(estadisticasPorPeso);
            const dataPorPeso = Object.values(estadisticasPorPeso);

            const ctxPorPeso = document.getElementById('estadisticasPorPesoChart').getContext('2d');
            const estadisticasPorPesoChart = new Chart(ctxPorPeso, {
                type: 'bar',
                data: {
                    labels: labelsPorPeso,
                    datasets: [{
                        label: 'Paquetes',
                        data: dataPorPeso,
                        backgroundColor: 'rgba(255, 99, 142, 0.6)',
                        borderColor: 'rgba(255,99,142,1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
