<div>
<h2>Estadísticas para el Sistema de Reclamos y Sugerencias</h2>

<!-- Tarjeta para el Gráfico de Líneas -->
<div class="card card-dark">
    <div class="card-header">
        <h3 class="card-title">Gráfico de Líneas (por fecha)</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <!-- Gráfico de Líneas -->
        <div id="line-chart-container" style="width: 100%; height: 400px;"></div>
    </div>
</div>

<!-- Tarjeta para los Gráficos de Torta -->
<div class="card card-dark">
    <div class="card-header">
        <h3 class="card-title">Gráficos de Torta (por ciudad)</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <!-- Gráficos de Torta organizados en una misma fila -->
        <div style="display: flex; flex-wrap: nowrap; gap: 20px;">
            <div style="width: 25%;">
                <h3>Información</h3>
                <div id="pie-chart-group1" style="width: 100%; height: 400px;"></div>
            </div>
            <div style="width: 25%;">
                <h3>Quejas</h3>
                <div id="pie-chart-group2" style="width: 100%; height: 400px;"></div>
            </div>
            <div style="width: 25%;">
                <h3>Sugerencias</h3>
                <div id="pie-chart-group3" style="width: 100%; height: 400px;"></div>
            </div>
            <div style="width: 25%;">
                <h3>Reclamos</h3>
                <div id="pie-chart-group4" style="width: 100%; height: 400px;"></div>
            </div>
        </div>
    </div>
</div>
</div>
@push('js')
    <!-- Incluir la librería de Highcharts y el módulo de exportación -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Gráfico de Líneas ---
            Highcharts.chart('line-chart-container', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'Estadísticas de APIs por fecha'
                },
                exporting: {
                    enabled: true,
                    buttons: {
                        contextButton: {
                            menuItems: ['downloadPNG', 'downloadJPEG', 'downloadPDF', 'downloadSVG']
                        }
                    }
                },
                xAxis: {
                    title: {
                        text: 'Fecha'
                    },
                    categories: @json($allDates)
                },
                yAxis: {
                    title: {
                        text: 'Cantidad de registros'
                    }
                },
                series: [
                    {
                        name: 'Información',
                        data: @json($seriesData1)
                    },
                    {
                        name: 'Quejas',
                        data: @json($seriesData2)
                    },
                    {
                        name: 'Sugerencias',
                        data: @json($seriesData3)
                    },
                    {
                        name: 'Reclamos',
                        data: @json($seriesData4)
                    }
                ]
            });

            // --- Gráficos de Torta por Ciudad ---
            // Grupo 1: Información
            Highcharts.chart('pie-chart-group1', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Distribución por Ciudad - Información'
                },
                exporting: {
                    enabled: true,
                    buttons: {
                        contextButton: {
                            menuItems: ['downloadPNG', 'downloadJPEG', 'downloadPDF', 'downloadSVG']
                        }
                    }
                },
                series: [{
                    name: 'Cantidad',
                    colorByPoint: true,
                    data: @json($pieData1)
                }]
            });

            // Grupo 2: Quejas
            Highcharts.chart('pie-chart-group2', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Distribución por Ciudad - Quejas'
                },
                exporting: {
                    enabled: true,
                    buttons: {
                        contextButton: {
                            menuItems: ['downloadPNG', 'downloadJPEG', 'downloadPDF', 'downloadSVG']
                        }
                    }
                },
                series: [{
                    name: 'Cantidad',
                    colorByPoint: true,
                    data: @json($pieData2)
                }]
            });

            // Grupo 3: Sugerencias
            Highcharts.chart('pie-chart-group3', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Distribución por Ciudad - Sugerencias'
                },
                exporting: {
                    enabled: true,
                    buttons: {
                        contextButton: {
                            menuItems: ['downloadPNG', 'downloadJPEG', 'downloadPDF', 'downloadSVG']
                        }
                    }
                },
                series: [{
                    name: 'Cantidad',
                    colorByPoint: true,
                    data: @json($pieData3)
                }]
            });

            // Grupo 4: Reclamos
            Highcharts.chart('pie-chart-group4', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Distribución por Ciudad - Reclamos'
                },
                exporting: {
                    enabled: true,
                    buttons: {
                        contextButton: {
                            menuItems: ['downloadPNG', 'downloadJPEG', 'downloadPDF', 'downloadSVG']
                        }
                    }
                },
                series: [{
                    name: 'Cantidad',
                    colorByPoint: true,
                    data: @json($pieData4)
                }]
            });
        });
    </script>
@endpush
