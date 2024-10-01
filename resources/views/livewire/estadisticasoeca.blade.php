<div>
    <div class="card card-dark">
        <div class="card-header">
            <h3 class="card-title">Estadísticas de Paquetes Ordinarios para Ventanilla ECA del Área Clasificacion</h3>
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
                            <h3 class="box-title">Paquetería Registrada</h3>
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
                            <h3 class="box-title">Paquetes por Registrados / Despachados</h3>
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
                            <h3 class="box-title">Paquetes Registrados por País</h3>
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
                            <span class="info-box-text">Paquetes en Clasificación Registrados</span>
                            <span class="info-box-number">{{ $countClasificacion }}</span>
                        </div>
                    </div>
                </div>

                <!-- Conteo de paquetes en DESPACHO -->
                <div class="col-md-6">
                    <div class="info-box bg-warning">
                        <span class="info-box-icon"><i class="fas fa-truck-loading"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Paquetes Registrados y Despachados</span>
                            <span class="info-box-number">{{ $countDespacho }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-dark">
        <div class="card-header">
            <h3 class="card-title">Estadísticas de Paquetes Ordinarios para Ventanilla ECA del Área Ventanilla</h3>
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
                            <h3 class="box-title">Paquetes en Ventanilla ECA por Día</h3>
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
                            <h3 class="box-title">Paquetes por Clasificacion de Aduana</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="packagesByAduanaChart" width="300" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Paquetes por Clasificacion de Tipo</h3>
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
                            <span class="info-box-text">Paquetes en Ventanilla ECA</span>
                            <span class="info-box-number">{{ $countVentanillaDD }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-dark">
        <div class="card-header">
            <h3 class="card-title">Estadísticas de Paquetes Ordinarios para Ventanilla ECA del Área Carteros</h3>
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
                            <h3 class="box-title">Paquetes con CARTERO vs RETORNADOS por dia</h3>
                            <h5 class="box-title">Inventario desde 01/2024</h5>
                        </div>
                        <div class="box-body">
                            <canvas id="packagesCarteroRetornoByDayChart" width="200" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Paquetes CARTERO / RETORNADOS</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="packagesCarteroVsRetornoChart" width="200" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Ranking de Paqueteria llevada por Carteros</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="packagesByUserCarteroChart" width="200" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-box bg-primary">
                        <span class="info-box-icon"><i class="fas fa-mail-bulk"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Paquetes con CARTERO</span>
                            <span class="info-box-number">{{ $countCarteroDD }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="info-box bg-danger">
                        <span class="info-box-icon"><i class="fas fa-undo-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Paquetes en RETORNADOS</span>
                            <span class="info-box-number">{{ $countRetornoDD }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-dark">
        <div class="card-header">
            <h3 class="card-title">Estadísticas de Paquetes Ordinarios para Ventanilla ECA ENTREGADOS</h3>
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
                            <h3 class="box-title">Paquetes Entregados en Ventanilla vs Entregados con Carteros los ultimos 120 días</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="packagesEntregadoRepartidoByDayChart" width="200" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Paquetes Entregados en Ventanilla/Entregados con Carteros</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="packagesEntregadoRepartidoTotalChart" width="200" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Paquetes Entregados en Ventanilla y Entregados con Carteros por Precio y Mes</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="packagesEntregadoRepartidoByMonthPriceChart" width="200" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-box bg-success">
                        <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Paquetes ENTREGADO EN VENTANILLA</span>
                            <span class="info-box-number">{{ $countEntregado }}</span>
                        </div>
                    </div>
                </div>
            
                <!-- Contador para paquetes REPARTIDO -->
                <div class="col-md-6">
                    <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-truck"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Paquetes ENTREGADOS POR CARTEROS</span>
                            <span class="info-box-number">{{ $countRepartido }}</span>
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
                const packagesCarteroVsRetorno = @json($packagesCarteroVsRetorno);
                const packagesCarteroRetornoByDay = @json($packagesCarteroRetornoByDay);
                const packagesByUserCartero = @json($packagesByUserCartero);

                // Gráfico de Barras por Día
                const labelsDay = packagesByDay.map(item => item.date);
                const dataDay = packagesByDay.map(item => item.total);

                const ctxDay = document.getElementById('packagesByDayChart').getContext('2d');
                new Chart(ctxDay, {
                    type: 'bar',
                    data: {
                        labels: labelsDay,
                        datasets: [{
                            label: 'Paquetes ECA por Día',
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
                                text: 'Cantidad de Paquetes ECA por Día'
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
                            label: 'Paquetes en Ventanilla ECA por Día',
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
                                text: 'Paquetes en Ventanilla ECA por Día'
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
                const labelsCarteroVsRetorno = packagesCarteroVsRetorno.map(item => item.ESTADO);
                const dataCarteroVsRetorno = packagesCarteroVsRetorno.map(item => item.total);

                const ctxCarteroVsRetorno = document.getElementById('packagesCarteroVsRetornoChart').getContext('2d');
                new Chart(ctxCarteroVsRetorno, {
                    type: 'doughnut', // Changed from 'bar' to 'doughnut'
                    data: {
                        labels: labelsCarteroVsRetorno,
                        datasets: [{
                            data: dataCarteroVsRetorno,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.7)', // CARTERO
                                'rgba(54, 162, 235, 0.7)' // RETORNO
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)', // CARTERO
                                'rgba(54, 162, 235, 1)' // RETORNO
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
                                text: 'Paquetes CARTERO vs RETORNADO'
                            }
                        }
                    }
                });
                // Prepare the data for the CARTERO and RETORNO datasets
                const dates = [...new Set(packagesCarteroRetornoByDay.map(item => item.date))];

                const carteroData = dates.map(date => {
                    const item = packagesCarteroRetornoByDay.find(i => i.date === date && i.ESTADO ===
                        'CARTERO');
                    return item ? item.total : 0;
                });

                const retornoData = dates.map(date => {
                    const item = packagesCarteroRetornoByDay.find(i => i.date === date && i.ESTADO ===
                        'RETORNO');
                    return item ? item.total : 0;
                });

                // Initialize the new chart
                const ctxCarteroRetornoByDay = document.getElementById('packagesCarteroRetornoByDayChart').getContext(
                    '2d');
                new Chart(ctxCarteroRetornoByDay, {
                    type: 'bar',
                    data: {
                        labels: dates,
                        datasets: [{
                                label: 'CARTERO',
                                data: carteroData,
                                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'RETORNO',
                                data: retornoData,
                                backgroundColor: 'rgba(255, 99, 132, 0.7)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        scales: {
                            x: {
                                stacked: true
                            },
                            y: {
                                beginAtZero: true,
                                stacked: true,
                                precision: 0
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Paquetes CARTERO y RETORNADO por Día'
                            }
                        }
                    }
                });
                const labelsUserCartero = packagesByUserCartero.map(item => item.usercartero);
                const dataUserCartero = packagesByUserCartero.map(item => item.total);

                const ctxUserCartero = document.getElementById('packagesByUserCarteroChart').getContext('2d');
                new Chart(ctxUserCartero, {
                    type: 'bar',
                    data: {
                        labels: labelsUserCartero,
                        datasets: [{
                            label: 'Cantidad de Paquetes',
                            data: dataUserCartero,
                            backgroundColor: 'rgba(75, 192, 192, 0.7)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        indexAxis: 'y', // Orient the chart horizontally
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
                                text: 'Paquetes por Cartero'
                            }
                        }
                    }
                });
                const packagesEntregadoRepartidoByDay = @json($packagesEntregadoRepartidoByDay);

                // Preparar los datos para los conjuntos ENTREGADO y REPARTIDO
                const datesEntregadoRepartido = [...new Set(packagesEntregadoRepartidoByDay.map(item => item.date))];

                const entregadoData = datesEntregadoRepartido.map(date => {
                    const item = packagesEntregadoRepartidoByDay.find(i => i.date === date && i.ESTADO ===
                        'ENTREGADO');
                    return item ? item.total : 0;
                });

                const repartidoData = datesEntregadoRepartido.map(date => {
                    const item = packagesEntregadoRepartidoByDay.find(i => i.date === date && i.ESTADO ===
                        'REPARTIDO');
                    return item ? item.total : 0;
                });

                // Inicializar el nuevo gráfico
                const ctxEntregadoRepartidoByDay = document.getElementById('packagesEntregadoRepartidoByDayChart')
                    .getContext('2d');
                new Chart(ctxEntregadoRepartidoByDay, {
                    type: 'bar',
                    data: {
                        labels: datesEntregadoRepartido,
                        datasets: [{
                                label: 'ENTREGADO',
                                data: entregadoData,
                                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'REPARTIDO',
                                data: repartidoData,
                                backgroundColor: 'rgba(255, 99, 132, 0.7)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        scales: {
                            x: {
                                stacked: true
                            },
                            y: {
                                beginAtZero: true,
                                stacked: true,
                                precision: 0
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Paquetes ENTREGADO y REPARTIDO por Día'
                            }
                        }
                    }
                });
                // Donut Chart para Paquetes ENTREGADO y REPARTIDO
                const packagesEntregadoRepartidoTotal = @json($packagesEntregadoRepartidoTotal);

                const labelsEntregadoRepartido = packagesEntregadoRepartidoTotal.map(item => item.ESTADO);
                const dataEntregadoRepartido = packagesEntregadoRepartidoTotal.map(item => item.total);

                const ctxEntregadoRepartidoTotal = document.getElementById('packagesEntregadoRepartidoTotalChart')
                    .getContext('2d');
                new Chart(ctxEntregadoRepartidoTotal, {
                    type: 'doughnut',
                    data: {
                        labels: labelsEntregadoRepartido,
                        datasets: [{
                            data: dataEntregadoRepartido,
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.7)', // ENTREGADO
                                'rgba(255, 99, 132, 0.7)' // REPARTIDO
                            ],
                            borderColor: [
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 99, 132, 1)'
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
                                text: 'Distribución de Paquetes ENTREGADO vs REPARTIDO'
                            }
                        }
                    }
                });
                // Datos para el gráfico de paquetes por mes y precio
                const packagesEntregadoRepartidoByMonthPrice = @json($packagesEntregadoRepartidoByMonthPrice);

                const months = [...new Set(packagesEntregadoRepartidoByMonthPrice.map(item => item.month))];
                const priceLabels = [...new Set(packagesEntregadoRepartidoByMonthPrice.map(item => item.PRECIO))];

                // Preparar los datos para cada precio
                const datasets = priceLabels.map(price => {
                    return {
                        label: `Precio ${price} Bs`,
                        data: months.map(month => {
                            const item = packagesEntregadoRepartidoByMonthPrice.find(i => i.month ===
                                month && i.PRECIO === price);
                            return item ? item.total_value : 0; // Usar total_value
                        }),
                        backgroundColor: `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.7)`,
                        borderColor: `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 1)`,
                        borderWidth: 1
                    };
                });

                // Crear el gráfico de barras
                const ctxMonthPrice = document.getElementById('packagesEntregadoRepartidoByMonthPriceChart').getContext(
                    '2d');
                new Chart(ctxMonthPrice, {
                    type: 'line',
                    data: {
                        labels: months,
                        datasets: datasets
                    },
                    options: {
                        scales: {
                            x: {
                                beginAtZero: true,
                            },
                            y: {
                                beginAtZero: true,
                                precision: 0
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Paquetes Entregados y Repartidos por Precio y Mes'
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
</div>
