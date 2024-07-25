@extends('adminlte::page')

@section('title', 'Estadísticas de Paquetes')

@section('template_title')
    Estadísticas de Paquetería Postal
@endsection

@section('content')
    <!-- Sección de Resumen -->
    <div class="row mb-4">
        <!-- Paquetes Ingreso -->
        <div class="col-lg-3 col-6">
            <div class="info-box bg-dark">
                <span class="info-box-icon bg-success"><i class="fas fa-box-open"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Paquetes Ingreso</span>
                    <span class="info-box-number">{{ $paquetesIngreso }}</span>
                    <span class="info-box-more">{{ $porcentajeIngreso }}% <i class="fas fa-arrow-up"></i></span>
                </div>
            </div>
        </div>
        <!-- Paquetes Entregados -->
        <div class="col-lg-3 col-6">
            <div class="info-box bg-dark">
                <span class="info-box-icon bg-success"><i class="fas fa-box"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Paquetes Entregados</span>
                    <span class="info-box-number">{{ $paquetesEntregados }}</span>
                    <span class="info-box-more">{{ $porcentajeEntregados }}% <i class="fas fa-arrow-up"></i></span>
                </div>
            </div>
        </div>
        <!-- Paquetes en Ventanilla -->
        <div class="col-lg-3 col-6">
            <div class="info-box bg-dark">
                <span class="info-box-icon bg-warning"><i class="fas fa-store-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Paquetes en Ventanilla</span>
                    <span class="info-box-number">{{ $paquetesVentanilla }}</span>
                    <span class="info-box-more">{{ $porcentajeVentanilla }}% <i class="fas fa-arrow-up"></i></span>
                </div>
            </div>
        </div>
        <!-- Ingresos Totales -->
        <div class="col-lg-3 col-6">
            <div class="info-box bg-dark">
                <span class="info-box-icon bg-success"><i class="fas fa-dollar-sign"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Ingresos Totales</span>
                    <span class="info-box-number">Bs. {{ number_format($totalIngresos, 2) }}</span>
                    <span class="info-box-more">{{ $porcentajeIngresos }}% <i class="fas fa-arrow-up"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-dark">
        <div class="card-header">
            <h3 class="card-title">Estadísticas de Sistema</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Gráfico de Estado de Paquetes por Mes -->
                <div class="col-lg-6 col-12 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Estado de los Paquetes por Mes</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="packageStatusChart"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Gráfico de Ingresos por Mes -->
                <div class="col-lg-6 col-12 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Ingresos por Mes</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="ingresosChart"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Gráfico de Paquetes por Ciudad -->
                <div class="col-lg-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Paquetes por Ciudad</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="cityChart"></canvas>
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
        document.addEventListener('DOMContentLoaded', function() {
            // Helper function to get month names from 'YYYY-MM' format
            function getMonthName(dateString) {
                const months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
                const dateParts = dateString.split("-");
                const year = dateParts[0];
                const monthIndex = parseInt(dateParts[1], 10) - 1;
                return months[monthIndex] + ' ' + year;
            }

            // Gráfico de Estado de los Paquetes por Mes
            var ctxStatus = document.getElementById('packageStatusChart').getContext('2d');
            var rawLabels = @json(array_keys($statistics));
            var labels = rawLabels.map(getMonthName);
            var entregadoData = @json(array_column($statistics, 'ENTREGADO'));
            var ventanillaData = @json(array_column($statistics, 'VENTANILLA'));
            var clasificacionData = @json(array_column($statistics, 'CLASIFICACION'));

            var packageStatusChart = new Chart(ctxStatus, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'ENTREGADO',
                            data: entregadoData,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'VENTANILLA',
                            data: ventanillaData,
                            backgroundColor: 'rgba(255, 206, 86, 0.2)',
                            borderColor: 'rgba(255, 206, 86, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'CLASIFICACION',
                            data: clasificacionData,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Gráfico de Ingresos por Mes (Área)
            var ctxIngresos = document.getElementById('ingresosChart').getContext('2d');
            var ingresosRawLabels = @json(array_keys($ingresosStatistics));
            var ingresosLabels = ingresosRawLabels.map(getMonthName);
            var ingresosValues = @json(array_values($ingresosStatistics));

            var ingresosChart = new Chart(ctxIngresos, {
                type: 'line',
                data: {
                    labels: ingresosLabels,
                    datasets: [{
                        label: 'Ingresos',
                        data: ingresosValues,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Gráfico de Paquetes por Ciudad (Pie)
            var ctxCity = document.getElementById('cityChart').getContext('2d');
            var cityLabels = @json(array_keys($cityStatistics));
            var cityValues = @json(array_values($cityStatistics));

            var cityChart = new Chart(ctxCity, {
                type: 'pie',
                data: {
                    labels: cityLabels,
                    datasets: [{
                        label: 'Paquetes por Ciudad',
                        data: cityValues,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.8)',  // La Paz
                            'rgba(54, 162, 235, 0.8)',  // Cochabamba
                            'rgba(255, 206, 86, 0.8)',  // Santa Cruz
                            'rgba(75, 192, 192, 0.8)',  // Potosí
                            'rgba(153, 102, 255, 0.8)', // Oruro
                            'rgba(255, 159, 64, 0.8)',  // Chuquisaca/Sucre
                            'rgba(199, 199, 199, 0.8)', // Tarija
                            'rgba(83, 102, 255, 0.8)',  // Beni
                            'rgba(183, 159, 64, 0.8)',  // Pando
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',    // La Paz
                            'rgba(54, 162, 235, 1)',    // Cochabamba
                            'rgba(255, 206, 86, 1)',    // Santa Cruz
                            'rgba(75, 192, 192, 1)',    // Potosí
                            'rgba(153, 102, 255, 1)',   // Oruro
                            'rgba(255, 159, 64, 1)',    // Chuquisaca/Sucre
                            'rgba(199, 199, 199, 1)',   // Tarija
                            'rgba(83, 102, 255, 1)',    // Beni
                            'rgba(183, 159, 64, 1)',    // Pando
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });
        });
    </script>
@stop
