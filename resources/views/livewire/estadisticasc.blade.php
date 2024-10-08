@extends('adminlte::page')

@section('title', 'Estadísticas de Paquetes')

@section('template_title')
    Estadísticas de Paquetería Postal
@endsection

@section('content')
    <div class="card card-dark">
        <div class="card-header">
            <h3 class="card-title">Estadísticas del Sistema Casillas Alquiladas / Libre</h3>
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
                            <h3 class="box-title">Casillas Alquiladas / Libre por mes</h3>
                            <h5 class="box-title">Inventario desde 01/2024</h5>
                        </div>
                        <div class="box-body">
                            <canvas id="estadisticasPorMesChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Gráfico de Paquetes por Ciudad -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Casillas libres por tamaño</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="estadisticasPorTamanoChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Casillas alquiladas por tamaño</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="estadisticasOcupadasPorTamanoChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-blue">
        <div class="card-header">
            <h3 class="card-title">Estadísticas del Sistema Casillas Correspondencia / Mantenimiento</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Gráfico de Vencidas y Correspondencia -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Casillas Correspondencia / Mantenimiento</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="vencidasCorrespondenciaChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Gráfico de Casillas Correspondencia por tamaño -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Casillas Correspondencia por tamaño</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="estadisticasCorrespondenciaPorTamanoChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Gráfico de Casillas Mantenimiento por tamaño -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Casillas Mantenimiento por tamaño</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="estadisticasMantenimientoPorTamanoChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-green">
        <div class="card-header">
            <h3 class="card-title">Estadísticas del Sistema Casillas Reservadas / Vencidas</h3>
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
                            <h3 class="box-title">Casillas Reservadas y Vencidas</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="reservadasVencidasChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Gráfico de Casillas Reservadas por tamaño -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Casillas Reservadas por tamaño</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="estadisticasReservadasPorTamanoChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Gráfico de Casillas Vencidas por tamaño -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Casillas Vencidas por tamaño</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="estadisticasVencidasPorTamanoChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-yellow">
        <div class="card-header">
            <h3 class="card-title">Estadísticas del Sistema Casillas Ingresos</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Gráfico de Estado de Paquetes por Mes -->
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Total Ingresos mensuales Sistema Casillas</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="graficoIngresosMensuales" width="400" height="100"></canvas>
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
            const estadisticasPorMes = @json($estadisticasPorMes);
            const estadisticasPorTamano = @json($estadisticasPorTamano);
            const estadisticasOcupadasPorTamano = @json($estadisticasOcupadasPorTamano);
            const reservadas = @json($reservadas);
            const correspondencia = @json($correspondencia);
            const vencidas = @json($vencidas);
            const mantenimiento = @json($mantenimiento);
            const ingresosMensuales = @json($ingresosMensuales);

            const labelsPorMes = Object.keys(estadisticasPorMes);
            const dataLibresPorMes = labelsPorMes.map(mes => estadisticasPorMes[mes]['libres']);
            const dataOcupadasPorMes = labelsPorMes.map(mes => estadisticasPorMes[mes]['ocupadas']);
            const dataReservadasPorMes = labelsPorMes.map(mes => estadisticasPorMes[mes]['reservadas']);
            const dataVencidasPorMes = labelsPorMes.map(mes => estadisticasPorMes[mes]['vencidas']);
            const dataCorrespondenciaPorMes = labelsPorMes.map(mes => estadisticasPorMes[mes]['correspondencia']);
            const dataMantenimientoPorMes = labelsPorMes.map(mes => estadisticasPorMes[mes]['mantenimiento']);

            const labelsPorTamano = Object.keys(estadisticasPorTamano);
            const dataPorTamano = Object.values(estadisticasPorTamano);
            const labelsOcupadasPorTamano = Object.keys(estadisticasOcupadasPorTamano);
            const dataOcupadasPorTamano = Object.values(estadisticasOcupadasPorTamano);
            const dataReservadasPorTamano = Object.values(reservadas);
            const dataCorrespondenciaPorTamano = Object.values(correspondencia);
            const dataVencidasPorTamano = Object.values(vencidas);
            const dataMantenimientoPorTamano = Object.values(mantenimiento);

            const ctx = document.getElementById('graficoIngresosMensuales').getContext('2d');
            const labels = Object.keys(ingresosMensuales);
            const dataMulta = labels.map(mes => ingresosMensuales[mes]['multa']);
            const dataCasilla = labels.map(mes => ingresosMensuales[mes]['casilla']);
            const dataLlave = labels.map(mes => ingresosMensuales[mes]['llave']);
            const dataHabilitacion = labels.map(mes => ingresosMensuales[mes]['habilitacion']);

            const chart = new Chart(ctx, {
                type: 'line', // Cambiar a 'bar' o 'line' dependiendo de tus preferencias
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Precio Multa',
                            data: dataMulta,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Precio Casilla',
                            data: dataCasilla,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Precio Llave',
                            data: dataLlave,
                            backgroundColor: 'rgba(255, 206, 86, 0.2)',
                            borderColor: 'rgba(255, 206, 86, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Precio Habilitacion',
                            data: dataHabilitacion,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            const configPieChart = (canvasId, labels, data) => {
                const ctx = document.getElementById(canvasId).getContext('2d');
                return new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: '# de Casillas',
                            data: data,
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
            };

            // Configuración de gráficos por tamaño
            configPieChart('estadisticasPorTamanoChart', labelsPorTamano, dataPorTamano);
            configPieChart('estadisticasOcupadasPorTamanoChart', labelsOcupadasPorTamano, dataOcupadasPorTamano);
            configPieChart('estadisticasReservadasPorTamanoChart', labelsPorTamano, dataReservadasPorTamano);
            configPieChart('estadisticasCorrespondenciaPorTamanoChart', labelsPorTamano, dataCorrespondenciaPorTamano);
            configPieChart('estadisticasVencidasPorTamanoChart', labelsPorTamano, dataVencidasPorTamano);
            configPieChart('estadisticasMantenimientoPorTamanoChart', labelsPorTamano, dataMantenimientoPorTamano);

            const configBarChart = (canvasId, labels, datasets) => {
                const ctx = document.getElementById(canvasId).getContext('2d');
                return new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                                    }
                                }
                            }
                        }
                    }
                });
            };

            // Configuración del gráfico de Reservadas y Vencidas
            configBarChart('reservadasVencidasChart', labelsPorMes,
                [{
                        label: 'Casillas Reservadas',
                        data: dataReservadasPorMes,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Casillas Vencidas',
                        data: dataVencidasPorMes,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            );

            // Configuración del gráfico de Vencidas y Correspondencia
            configBarChart('vencidasCorrespondenciaChart', labelsPorMes,
                [{
                        label: 'Casillas Mantenimiento',
                        data: dataMantenimientoPorMes,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Casillas de Correspondencia',
                        data: dataCorrespondenciaPorMes,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }
                ]
            );

            // Gráfico de barras apiladas por mes
            const ctxPorMes = document.getElementById('estadisticasPorMesChart').getContext('2d');
            const estadisticasPorMesChart = new Chart(ctxPorMes, {
                type: 'bar',
                data: {
                    labels: labelsPorMes,
                    datasets: [{
                            label: 'Casillas Libres',
                            data: dataLibresPorMes,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Casillas Alquiladas',
                            data: dataOcupadasPorMes,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        },
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        x: {
                            stacked: true
                        },
                        y: {
                            stacked: true
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                                }
                            }
                        }
                    }
                }
            });

            // Gráfico de pastel por tamaño (libres)
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

            // Gráfico de pastel por tamaño (ocupadas)
            const ctxOcupadasPorTamano = document.getElementById('estadisticasOcupadasPorTamanoChart').getContext('2d');
            const estadisticasOcupadasPorTamanoChart = new Chart(ctxOcupadasPorTamano, {
                type: 'pie',
                data: {
                    labels: labelsOcupadasPorTamano,
                    datasets: [{
                        label: '# de Casillas',
                        data: dataOcupadasPorTamano,
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
