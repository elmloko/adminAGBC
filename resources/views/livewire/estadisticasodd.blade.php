<div>
    <div class="card card-dark">
        <div class="card-header">
            <h3 class="card-title">Estadísticas de Paquetes Ordinarios para Ventanilla DD</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <!-- Gráfico de Barras por Día -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Paquetería Registrada por Día</h3>
                            <h5 class="box-title">Inventario desde 01/2024</h5>
                        </div>
                        <div class="box-body">
                            <canvas id="packagesByDayChart" width="200" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Donut Chart de Distribución por Estado -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Paquetes por Estado</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="packagesByEstadoChart" width="300" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Nuevo Gráfico de Barras por País -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Paquetes por País</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="packagesByCountryChart" width="200" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-boxes"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Paquetes en Clasificación</span>
                            <span class="info-box-number">{{ $countClasificacion }}</span>
                        </div>
                    </div>
                </div>

                <!-- Conteo de paquetes en DESPACHO -->
                <div class="col-md-6">
                    <div class="info-box bg-warning">
                        <span class="info-box-icon"><i class="fas fa-truck-loading"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Paquetes en Despacho</span>
                            <span class="info-box-number">{{ $countDespacho }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-dark">
        <div class="card-header">
            <h3 class="card-title">Estadísticas de Paquetes Ordinarios para Ventanilla DD</h3>
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
                        <h3 class="box-title">Paquetes en Ventanilla DD por Día (Últimos 10 días)</h3>
                        <h5 class="box-title">Inventario desde 01/2024</h5>
                    </div>
                    <div class="box-body">
                        <canvas id="packagesVentanillaByDayChart" width="300" height="300"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Paquetes por Aduana</h3>
                    </div>
                    <div class="box-body">
                        <canvas id="packagesByAduanaChart" width="300" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Paquetes por Tipo</h3>
                    </div>
                    <div class="box-body">
                        <canvas id="packagesByTipoChart" width="300" height="350"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="info-box bg-success">
                    <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Paquetes en Ventanilla</span>
                        <span class="info-box-number">{{ $countVentanillaDD }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const packagesByDay = @json($packagesByDay);
                const packagesByEstado = @json($packagesByEstado);
                const packagesByCountry = @json($packagesByCountry);
                const packagesVentanillaByDay = @json($packagesVentanillaByDay);
                const packagesByAduana = @json($packagesByAduana);
                const packagesByTipo = @json($packagesByTipo);

                // Gráfico de Barras por Día
                const labelsDay = packagesByDay.map(item => item.date);
                const dataDay = packagesByDay.map(item => item.total);

                const ctxDay = document.getElementById('packagesByDayChart').getContext('2d');
                new Chart(ctxDay, {
                    type: 'bar',
                    data: {
                        labels: labelsDay,
                        datasets: [{
                            label: 'Paquetes DD por Día',
                            data: dataDay,
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                precision: 0
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: 'Cantidad de Paquetes DD por Día'
                            }
                        }
                    }
                });

                // Donut Chart de Distribución por Estado
                const labelsEstado = packagesByEstado.map(item => item.ESTADO);
                const dataEstado = packagesByEstado.map(item => item.total);

                const ctxEstado = document.getElementById('packagesByEstadoChart').getContext('2d');
                new Chart(ctxEstado, {
                    type: 'doughnut',
                    data: {
                        labels: labelsEstado,
                        datasets: [{
                            data: dataEstado,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.7)', // CLASIFICACION
                                'rgba(54, 162, 235, 0.7)' // DESPACHO
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Distribución de Paquetes por Estado'
                            }
                        }
                    }
                });

                // Nuevo Gráfico de Barras por País
                const labelsCountry = packagesByCountry.map(item => item.PAIS);
                const dataCountry = packagesByCountry.map(item => item.total);

                const ctxCountry = document.getElementById('packagesByCountryChart').getContext('2d');
                new Chart(ctxCountry, {
                    type: 'bar',
                    data: {
                        labels: labelsCountry,
                        datasets: [{
                            label: 'Paquetes por País',
                            data: dataCountry,
                            backgroundColor: 'rgba(75, 192, 192, 0.7)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        indexAxis: 'y', // Orientación horizontal
                        scales: {
                            x: {
                                beginAtZero: true,
                                precision: 0
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: 'Cantidad de Paquetes por País'
                            }
                        }
                    }
                });
                const labelsVentanillaDay = packagesVentanillaByDay.map(item => item.date);
                const dataVentanillaDay = packagesVentanillaByDay.map(item => item.total);

                const ctxVentanillaDay = document.getElementById('packagesVentanillaByDayChart').getContext('2d');
                new Chart(ctxVentanillaDay, {
                    type: 'line',
                    data: {
                        labels: labelsVentanillaDay,
                        datasets: [{
                            label: 'Paquetes en Ventanilla DD por Día',
                            data: dataVentanillaDay,
                            backgroundColor: 'rgba(255, 159, 64, 0.5)',
                            borderColor: 'rgba(255, 159, 64, 1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.3
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                precision: 0
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: 'Paquetes en Ventanilla DD por Día'
                            }
                        }
                    }
                });
                const labelsAduana = packagesByAduana.map(item => item.ADUANA === 'SI' ? 'Aduana Sí' : 'Aduana No');
                const dataAduana = packagesByAduana.map(item => item.total);

                const ctxAduana = document.getElementById('packagesByAduanaChart').getContext('2d');
                new Chart(ctxAduana, {
                    type: 'doughnut',
                    data: {
                        labels: labelsAduana,
                        datasets: [{
                            data: dataAduana,
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.7)', // Aduana Sí
                                'rgba(255, 206, 86, 0.7)' // Aduana No
                            ],
                            borderColor: [
                                'rgba(75, 192, 192, 1)',
                                'rgba(255, 206, 86, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Distribución de Paquetes por Aduana'
                            }
                        }
                    }
                });
                const labelsTipo = packagesByTipo.map(item => item.TIPO);
                const dataTipo = packagesByTipo.map(item => item.total);

                const ctxTipo = document.getElementById('packagesByTipoChart').getContext('2d');
                new Chart(ctxTipo, {
                    type: 'bar',
                    data: {
                        labels: labelsTipo,
                        datasets: [{
                            label: 'Cantidad de Paquetes',
                            data: dataTipo,
                            backgroundColor: 'rgba(153, 102, 255, 0.7)',
                            borderColor: 'rgba(153, 102, 255, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                precision: 0
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: 'Distribución de Paquetes por Tipo'
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
</div>
