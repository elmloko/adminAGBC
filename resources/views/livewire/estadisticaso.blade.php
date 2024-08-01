<div>
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
    <div class="card card-green">
        <div class="card-header">
            <h3 class="card-title">Estadísticas del Sistema Area Ventanila</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Paquetes en Ventanilla por Mes</h3>
                            <h5 class="box-title">Inventario desde 01/2024</h5>
                        </div>
                        <div class="box-body">
                            <canvas id="ventanillaChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Ventanilla por Ciudad</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="ventanillaByCityChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Ventanilla por Servicio</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="ventanillaByServiceChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-blue">
        <div class="card-header">
            <h3 class="card-title">Estadísticas del Sistema Entregas</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Total paqueteria generado por mes expresado en Bs.</h3>
                            <h5 class="box-title">Inventario desde 01/2024</h5>
                        </div>
                        <div class="box-body">
                            <canvas id="entregadoPriceChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Paquetes Entregado por Ciudad</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="entregadoByCityChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Paquetes Entregados por Servicio</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="entregadoByServiceChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const totalPackagesByMonth = @json($totalPackagesByMonth);
                const despachoPackagesByMonth = @json($despachoPackagesByMonth);
                const packagesByCity = @json($packagesByCity);
                const despachoPackagesByCity = @json($despachoPackagesByCity);
                const ventanillaPackagesByMonth = @json($ventanillaPackagesByMonth);
                const ventanillaByService = @json($ventanillaByService);
                const ventanillaByCity = @json($ventanillaByCity);
                const entregadoPricesByMonth = @json($entregadoPricesByMonth);
                const entregadoByCity = @json($entregadoByCity);
                const entregadoByService = @json($entregadoByService);

                // Datos y etiquetas únicos por gráfico
                const labelsPackages = totalPackagesByMonth.map(item => `${item.month}/${item.year}`);
                const dataPackages = totalPackagesByMonth.map(item => item.total);

                const labelsDespachoPackages = despachoPackagesByMonth.map(item => `${item.month}/${item.year}`);
                const dataDespachoPackages = despachoPackagesByMonth.map(item => item.total);

                const labelsCityPackages = packagesByCity.map(item => item.city);
                const dataCityPackages = packagesByCity.map(item => item.total);

                const labelsDespachoCity = despachoPackagesByCity.map(item => item.city);
                const dataDespachoCity = despachoPackagesByCity.map(item => item.total);

                const labelsVentanillaPackages = ventanillaPackagesByMonth.map(item => `${item.month}/${item.year}`);
                const dataVentanillaPackages = ventanillaPackagesByMonth.map(item => item.total);

                const labelsVentanillaService = ventanillaByService.map(item => item.service);
                const dataVentanillaService = ventanillaByService.map(item => item.total);

                const labelsVentanillaCity = ventanillaByCity.map(item => item.city);
                const dataVentanillaCity = ventanillaByCity.map(item => item.total);

                const labelsEntregadoPrices = entregadoPricesByMonth.filter(item => item.total > 0).map(item =>
                    `${item.month}/${item.year}`);
                const dataEntregadoPrices = entregadoPricesByMonth.filter(item => item.total > 0).map(item => item
                    .total);

                const labelsEntregadoCity = entregadoByCity.map(item => item.city);
                const dataEntregadoCity = entregadoByCity.map(item => item.total);

                const labelsEntregadoService = entregadoByService.map(item => item.service);
                const dataEntregadoService = entregadoByService.map(item => item.total);

                const ctx1 = document.getElementById('packageChart').getContext('2d');
                new Chart(ctx1, {
                    type: 'bar',
                    data: {
                        labels: labelsPackages,
                        datasets: [{
                                label: 'Paquetes Registrados',
                                data: dataPackages,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Paquetes No Recibidos',
                                data: dataDespachoPackages,
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255, 99, 132, 1)',
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

                const ctx2 = document.getElementById('cityChart').getContext('2d');
                new Chart(ctx2, {
                    type: 'pie',
                    data: {
                        labels: labelsCityPackages,
                        datasets: [{
                            label: 'Paquetes por Ciudad',
                            data: dataCityPackages,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
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
                            title: {
                                display: true,
                                text: 'Paquetes por Ciudad'
                            },
                            datalabels: {
                                color: '#000',
                                formatter: (value, ctx) => {
                                    let sum = 0;
                                    let dataArr = ctx.chart.data.datasets[0].data;
                                    dataArr.map(data => {
                                        sum += data;
                                    });
                                    return (value * 100 / sum).toFixed(2) + "%";
                                },
                                anchor: 'end',
                                align: 'start',
                                offset: -1
                            }
                        }
                    },
                    plugins: [ChartDataLabels]
                });

                const ctx3 = document.getElementById('despachoCityChart').getContext('2d');
                new Chart(ctx3, {
                    type: 'doughnut',
                    data: {
                        labels: labelsDespachoCity,
                        datasets: [{
                            label: 'Paquetes en DESPACHO por Ciudad',
                            data: dataDespachoCity,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
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
                            title: {
                                display: true,
                                text: 'Paquetes en DESPACHO por Ciudad'
                            },
                            datalabels: {
                                color: '#000',
                                formatter: (value, ctx) => {
                                    let sum = 0;
                                    let dataArr = ctx.chart.data.datasets[0].data;
                                    dataArr.map(data => {
                                        sum += data;
                                    });
                                    return (value * 100 / sum).toFixed(2) + "%";
                                },
                                anchor: 'end',
                                align: 'start',
                                offset: -1
                            }
                        }
                    },
                    plugins: [ChartDataLabels]
                });

                const ctx4 = document.getElementById('ventanillaChart').getContext('2d');
                new Chart(ctx4, {
                    type: 'line',
                    data: {
                        labels: labelsVentanillaPackages,
                        datasets: [{
                            label: 'Paquetes en Ventanilla',
                            data: dataVentanillaPackages,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                            fill: false
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

                const ctx5 = document.getElementById('ventanillaByServiceChart').getContext('2d');
                new Chart(ctx5, {
                    type: 'pie',
                    data: {
                        labels: labelsVentanillaService,
                        datasets: [{
                            label: 'Paquetes en Ventanilla por Servicio',
                            data: dataVentanillaService,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
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
                            title: {
                                display: true,
                                text: 'Paquetes en Ventanilla por Servicio'
                            },
                            datalabels: {
                                color: '#000',
                                formatter: (value, ctx) => {
                                    let sum = 0;
                                    let dataArr = ctx.chart.data.datasets[0].data;
                                    dataArr.map(data => {
                                        sum += data;
                                    });
                                    return (value * 100 / sum).toFixed(2) + "%";
                                },
                                anchor: 'end',
                                align: 'start',
                                offset: -1
                            }
                        }
                    },
                    plugins: [ChartDataLabels]
                });

                const ctx6 = document.getElementById('ventanillaByCityChart').getContext('2d');
                new Chart(ctx6, {
                    type: 'doughnut',
                    data: {
                        labels: labelsVentanillaCity,
                        datasets: [{
                            label: 'Paquetes en Ventanilla por Ciudad',
                            data: dataVentanillaCity,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
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
                            title: {
                                display: true,
                                text: 'Paquetes en Ventanilla por Ciudad'
                            },
                            datalabels: {
                                color: '#000',
                                formatter: (value, ctx) => {
                                    let sum = 0;
                                    let dataArr = ctx.chart.data.datasets[0].data;
                                    dataArr.map(data => {
                                        sum += data;
                                    });
                                    return (value * 100 / sum).toFixed(2) + "%";
                                },
                                anchor: 'end',
                                align: 'start',
                                offset: -1
                            }
                        }
                    },
                    plugins: [ChartDataLabels]
                });

                // Gráfico de precio de paquetes entregados por mes
                const ctx = document.getElementById('entregadoPriceChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labelsEntregadoPrices,
                        datasets: [{
                            label: 'Precio Total de Paquetes Entregados',
                            data: dataEntregadoPrices,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                            fill: true
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

                // Gráfico de paquetes entregados por ciudad
                const ctxCity = document.getElementById('entregadoByCityChart').getContext('2d');
                new Chart(ctxCity, {
                    type: 'doughnut',
                    data: {
                        labels: labelsEntregadoCity,
                        datasets: [{
                            label: 'Paquetes Entregados por Ciudad',
                            data: dataEntregadoCity,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
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
                            title: {
                                display: true,
                                text: 'Paquetes Entregados por Ciudad'
                            },
                            datalabels: {
                                color: '#000',
                                formatter: (value, ctx) => {
                                    let sum = 0;
                                    let dataArr = ctx.chart.data.datasets[0].data;
                                    dataArr.map(data => {
                                        sum += data;
                                    });
                                    return (value * 100 / sum).toFixed(2) + "%";
                                },
                                anchor: 'end',
                                align: 'start',
                                offset: -1
                            }
                        }
                    },
                    plugins: [ChartDataLabels]
                });

                // Gráfico de paquetes entregados por servicio
                const ctxService = document.getElementById('entregadoByServiceChart').getContext('2d');
                new Chart(ctxService, {
                    type: 'pie',
                    data: {
                        labels: labelsEntregadoService,
                        datasets: [{
                            label: 'Paquetes Entregados por Servicio',
                            data: dataEntregadoService,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
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
                            title: {
                                display: true,
                                text: 'Paquetes Entregados por Servicio'
                            },
                            datalabels: {
                                color: '#000',
                                formatter: (value, ctx) => {
                                    let sum = 0;
                                    let dataArr = ctx.chart.data.datasets[0].data;
                                    dataArr.map(data => {
                                        sum += data;
                                    });
                                    return (value * 100 / sum).toFixed(2) + "%";
                                },
                                anchor: 'end',
                                align: 'start',
                                offset: -1
                            }
                        }
                    },
                    plugins: [ChartDataLabels]
                });
            });
        </script>
    @endpush
</div>
