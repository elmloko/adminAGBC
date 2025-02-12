<div>
    <h2>Gráfico de Líneas (por fecha)</h2>
    <div id="line-chart-container" style="width: 100%; height: 400px;"></div>

    <h2>Gráficos de Torta (por ciudad)</h2>
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

@push('js')
    <!-- Incluir la librería de Highcharts -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- Gráfico de Líneas ---
            Highcharts.chart('line-chart-container', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'Estadísticas de APIs por fecha'
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
                series: [{
                    name: 'Cantidad',
                    colorByPoint: true,
                    data: @json($pieData4)
                }]
            });
        });
    </script>
@endpush
