@extends('adminlte::page')

@section('title', 'Estadísticas de Paquetes')

@section('template_title')
    Estadísticas de Paquetería Postal
@endsection

@section('content')
    <!-- Card: Casillas Alquiladas / Libre -->
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
                <!-- Gráfico: Casillas Alquiladas / Libre por mes (Stacked Column) -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Casillas Alquiladas / Libre por mes</h3>
                            <h5 class="box-title">Inventario desde 01/2024</h5>
                        </div>
                        <div class="box-body">
                            <div id="estadisticasPorMesChart" style="width: 100%; height: 200px;"></div>
                        </div>
                    </div>
                </div>
                <!-- Gráfico: Casillas libres por tamaño (Pie) -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Casillas libres por tamaño</h3>
                        </div>
                        <div class="box-body">
                            <div id="estadisticasPorTamanoChart" style="width: 100%; height: 300px;"></div>
                        </div>
                    </div>
                </div>
                <!-- Gráfico: Casillas alquiladas por tamaño (Pie) -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Casillas alquiladas por tamaño</h3>
                        </div>
                        <div class="box-body">
                            <div id="estadisticasOcupadasPorTamanoChart" style="width: 100%; height: 300px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card: Casillas Correspondencia / Mantenimiento -->
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
                <!-- Gráfico: Casillas Correspondencia / Mantenimiento (Column agrupado) -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Casillas Correspondencia / Mantenimiento</h3>
                        </div>
                        <div class="box-body">
                            <div id="vencidasCorrespondenciaChart" style="width: 100%; height: 300px;"></div>
                        </div>
                    </div>
                </div>
                <!-- Gráfico: Casillas Correspondencia por tamaño (Pie) -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Casillas Correspondencia por tamaño</h3>
                        </div>
                        <div class="box-body">
                            <div id="estadisticasCorrespondenciaPorTamanoChart" style="width: 100%; height: 300px;"></div>
                        </div>
                    </div>
                </div>
                <!-- Gráfico: Casillas Mantenimiento por tamaño (Pie) -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Casillas Mantenimiento por tamaño</h3>
                        </div>
                        <div class="box-body">
                            <div id="estadisticasMantenimientoPorTamanoChart" style="width: 100%; height: 300px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card: Casillas Reservadas / Vencidas -->
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
                <!-- Gráfico: Casillas Reservadas y Vencidas (Column agrupado) -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Casillas Reservadas y Vencidas</h3>
                        </div>
                        <div class="box-body">
                            <div id="reservadasVencidasChart" style="width: 100%; height: 300px;"></div>
                        </div>
                    </div>
                </div>
                <!-- Gráfico: Casillas Reservadas por tamaño (Pie) -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Casillas Reservadas por tamaño</h3>
                        </div>
                        <div class="box-body">
                            <div id="estadisticasReservadasPorTamanoChart" style="width: 100%; height: 300px;"></div>
                        </div>
                    </div>
                </div>
                <!-- Gráfico: Casillas Vencidas por tamaño (Pie) -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Casillas Vencidas por tamaño</h3>
                        </div>
                        <div class="box-body">
                            <div id="estadisticasVencidasPorTamanoChart" style="width: 100%; height: 300px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card: Ingresos -->
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
                <!-- Gráfico: Total Ingresos mensuales (Line) -->
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Total Ingresos mensuales Sistema Casillas</h3>
                        </div>
                        <div class="box-body">
                            <div id="graficoIngresosMensuales" style="width: 100%; height: 100px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <!-- Incluir Highcharts y módulos de exportación -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/offline-exporting.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Se reciben los datos desde el servidor (por ejemplo, en Laravel)
            const estadisticasPorMes = @json($estadisticasPorMes);
            const estadisticasPorTamano = @json($estadisticasPorTamano);
            const estadisticasOcupadasPorTamano = @json($estadisticasOcupadasPorTamano);
            const reservadas = @json($reservadas);
            const correspondencia = @json($correspondencia);
            const vencidas = @json($vencidas);
            const mantenimiento = @json($mantenimiento);
            const ingresosMensuales = @json($ingresosMensuales);

            // Configuración común para el botón de exportación
            const exportingOptions = {
                enabled: true,
                buttons: {
                    contextButton: {
                        menuItems: [
                            'printChart', 'downloadPNG', 'downloadJPEG', 'downloadPDF', 'downloadSVG'
                        ]
                    }
                }
            };

            /* ----------------------------------------------------------------
               Gráfico 1: Casillas Alquiladas / Libre por mes (Stacked Column)
            ------------------------------------------------------------------*/
            const labelsPorMes = Object.keys(estadisticasPorMes);
            const dataLibresPorMes = labelsPorMes.map(mes => estadisticasPorMes[mes]['libres']);
            const dataOcupadasPorMes = labelsPorMes.map(mes => estadisticasPorMes[mes]['ocupadas']);

            Highcharts.chart('estadisticasPorMesChart', {
                chart: { type: 'column' },
                title: { text: 'Casillas Alquiladas / Libre por mes' },
                subtitle: { text: 'Inventario desde 01/2024' },
                xAxis: { categories: labelsPorMes, crosshair: true },
                yAxis: {
                    min: 0,
                    title: { text: 'Cantidad de Casillas' },
                    stackLabels: {
                        enabled: true,
                        style: {
                            fontWeight: 'bold',
                            color: (Highcharts.defaultOptions.title.style && Highcharts.defaultOptions.title.style.color) || 'gray'
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<b>{point.x}</b><br/>',
                    pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
                },
                plotOptions: {
                    column: {
                        stacking: 'normal',
                        dataLabels: { enabled: true }
                    }
                },
                series: [{
                    name: 'Casillas Libres',
                    data: dataLibresPorMes,
                    color: 'rgba(54, 162, 235, 1)'
                }, {
                    name: 'Casillas Alquiladas',
                    data: dataOcupadasPorMes,
                    color: 'rgba(255, 99, 132, 1)'
                }],
                exporting: exportingOptions
            });

            /* ----------------------------------------------------------------
               Gráfico 2: Casillas libres por tamaño (Pie)
            ------------------------------------------------------------------*/
            const labelsPorTamano = Object.keys(estadisticasPorTamano);
            const dataPorTamano = Object.values(estadisticasPorTamano);
            const piePorTamanoData = labelsPorTamano.map((label, index) => ({
                name: label,
                y: dataPorTamano[index]
            }));
            Highcharts.chart('estadisticasPorTamanoChart', {
                chart: { type: 'pie' },
                title: { text: 'Casillas libres por tamaño' },
                tooltip: { pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>' },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: { enabled: true, format: '{point.name}: {point.percentage:.2f} %' }
                    }
                },
                series: [{
                    name: 'Casillas Libres',
                    colorByPoint: true,
                    data: piePorTamanoData
                }],
                exporting: exportingOptions
            });

            /* ----------------------------------------------------------------
               Gráfico 3: Casillas alquiladas por tamaño (Pie)
            ------------------------------------------------------------------*/
            const labelsOcupadasPorTamano = Object.keys(estadisticasOcupadasPorTamano);
            const dataOcupadasPorTamano = Object.values(estadisticasOcupadasPorTamano);
            const pieOcupadasPorTamanoData = labelsOcupadasPorTamano.map((label, index) => ({
                name: label,
                y: dataOcupadasPorTamano[index]
            }));
            Highcharts.chart('estadisticasOcupadasPorTamanoChart', {
                chart: { type: 'pie' },
                title: { text: 'Casillas alquiladas por tamaño' },
                tooltip: { pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>' },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: { enabled: true, format: '{point.name}: {point.percentage:.2f} %' }
                    }
                },
                series: [{
                    name: 'Casillas Alquiladas',
                    colorByPoint: true,
                    data: pieOcupadasPorTamanoData
                }],
                exporting: exportingOptions
            });

            /* ----------------------------------------------------------------
               Gráfico 4: Casillas Correspondencia / Mantenimiento (Column agrupado)
            ------------------------------------------------------------------*/
            // Se obtienen los datos "mantenimiento" y "correspondencia" por mes desde estadisticasPorMes
            const dataMantenimientoPorMes = labelsPorMes.map(mes => estadisticasPorMes[mes]['mantenimiento']);
            const dataCorrespondenciaPorMes = labelsPorMes.map(mes => estadisticasPorMes[mes]['correspondencia']);
            Highcharts.chart('vencidasCorrespondenciaChart', {
                chart: { type: 'column' },
                title: { text: 'Casillas Correspondencia / Mantenimiento' },
                xAxis: { categories: labelsPorMes, crosshair: true },
                yAxis: { min: 0, title: { text: 'Cantidad de Casillas' } },
                tooltip: {
                    headerFormat: '<b>{point.x}</b><br/>',
                    pointFormat: '{series.name}: {point.y}'
                },
                plotOptions: {
                    column: { dataLabels: { enabled: true } }
                },
                series: [{
                    name: 'Casillas Mantenimiento',
                    data: dataMantenimientoPorMes,
                    color: 'rgba(255, 99, 132, 1)'
                }, {
                    name: 'Casillas de Correspondencia',
                    data: dataCorrespondenciaPorMes,
                    color: 'rgba(75, 192, 192, 1)'
                }],
                exporting: exportingOptions
            });

            /* ----------------------------------------------------------------
               Gráfico 5: Casillas Correspondencia por tamaño (Pie)
            ------------------------------------------------------------------*/
            const dataCorrespondenciaPorTamano = Object.values(correspondencia);
            const pieCorrespondenciaPorTamanoData = labelsPorTamano.map((label, index) => ({
                name: label,
                y: dataCorrespondenciaPorTamano[index]
            }));
            Highcharts.chart('estadisticasCorrespondenciaPorTamanoChart', {
                chart: { type: 'pie' },
                title: { text: 'Casillas Correspondencia por tamaño' },
                tooltip: { pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>' },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: { enabled: true, format: '{point.name}: {point.percentage:.2f} %' }
                    }
                },
                series: [{
                    name: 'Casillas Correspondencia',
                    colorByPoint: true,
                    data: pieCorrespondenciaPorTamanoData
                }],
                exporting: exportingOptions
            });

            /* ----------------------------------------------------------------
               Gráfico 6: Casillas Mantenimiento por tamaño (Pie)
            ------------------------------------------------------------------*/
            const dataMantenimientoPorTamano = Object.values(mantenimiento);
            const pieMantenimientoPorTamanoData = labelsPorTamano.map((label, index) => ({
                name: label,
                y: dataMantenimientoPorTamano[index]
            }));
            Highcharts.chart('estadisticasMantenimientoPorTamanoChart', {
                chart: { type: 'pie' },
                title: { text: 'Casillas Mantenimiento por tamaño' },
                tooltip: { pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>' },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: { enabled: true, format: '{point.name}: {point.percentage:.2f} %' }
                    }
                },
                series: [{
                    name: 'Casillas Mantenimiento',
                    colorByPoint: true,
                    data: pieMantenimientoPorTamanoData
                }],
                exporting: exportingOptions
            });

            /* ----------------------------------------------------------------
               Gráfico 7: Casillas Reservadas y Vencidas (Column agrupado)
            ------------------------------------------------------------------*/
            const dataReservadasPorMes = labelsPorMes.map(mes => estadisticasPorMes[mes]['reservadas']);
            const dataVencidasPorMes = labelsPorMes.map(mes => estadisticasPorMes[mes]['vencidas']);
            Highcharts.chart('reservadasVencidasChart', {
                chart: { type: 'column' },
                title: { text: 'Casillas Reservadas y Vencidas' },
                xAxis: { categories: labelsPorMes, crosshair: true },
                yAxis: {
                    min: 0,
                    title: { text: 'Cantidad de Casillas' }
                },
                tooltip: {
                    headerFormat: '<b>{point.x}</b><br/>',
                    pointFormat: '{series.name}: {point.y}'
                },
                plotOptions: {
                    column: { dataLabels: { enabled: true } }
                },
                series: [{
                    name: 'Casillas Reservadas',
                    data: dataReservadasPorMes,
                    color: 'rgba(54, 162, 235, 1)'
                }, {
                    name: 'Casillas Vencidas',
                    data: dataVencidasPorMes,
                    color: 'rgba(255, 99, 132, 1)'
                }],
                exporting: exportingOptions
            });

            /* ----------------------------------------------------------------
               Gráfico 8: Casillas Reservadas por tamaño (Pie)
            ------------------------------------------------------------------*/
            const dataReservadasPorTamano = Object.values(reservadas);
            const pieReservadasPorTamanoData = labelsPorTamano.map((label, index) => ({
                name: label,
                y: dataReservadasPorTamano[index]
            }));
            Highcharts.chart('estadisticasReservadasPorTamanoChart', {
                chart: { type: 'pie' },
                title: { text: 'Casillas Reservadas por tamaño' },
                tooltip: { pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>' },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: { enabled: true, format: '{point.name}: {point.percentage:.2f} %' }
                    }
                },
                series: [{
                    name: 'Casillas Reservadas',
                    colorByPoint: true,
                    data: pieReservadasPorTamanoData
                }],
                exporting: exportingOptions
            });

            /* ----------------------------------------------------------------
               Gráfico 9: Casillas Vencidas por tamaño (Pie)
            ------------------------------------------------------------------*/
            const dataVencidasPorTamano = Object.values(vencidas);
            const pieVencidasPorTamanoData = labelsPorTamano.map((label, index) => ({
                name: label,
                y: dataVencidasPorTamano[index]
            }));
            Highcharts.chart('estadisticasVencidasPorTamanoChart', {
                chart: { type: 'pie' },
                title: { text: 'Casillas Vencidas por tamaño' },
                tooltip: { pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>' },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: { enabled: true, format: '{point.name}: {point.percentage:.2f} %' }
                    }
                },
                series: [{
                    name: 'Casillas Vencidas',
                    colorByPoint: true,
                    data: pieVencidasPorTamanoData
                }],
                exporting: exportingOptions
            });

            /* ----------------------------------------------------------------
               Gráfico 10: Total Ingresos mensuales Sistema Casillas (Line)
            ------------------------------------------------------------------*/
            const labelsIngresos = Object.keys(ingresosMensuales);
            const dataMulta = labelsIngresos.map(mes => ingresosMensuales[mes]['multa']);
            const dataCasilla = labelsIngresos.map(mes => ingresosMensuales[mes]['casilla']);
            const dataLlave = labelsIngresos.map(mes => ingresosMensuales[mes]['llave']);
            const dataHabilitacion = labelsIngresos.map(mes => ingresosMensuales[mes]['habilitacion']);

            Highcharts.chart('graficoIngresosMensuales', {
                chart: { type: 'line' },
                title: { text: 'Total Ingresos mensuales Sistema Casillas' },
                xAxis: { categories: labelsIngresos },
                yAxis: { title: { text: 'Monto en Bs.' } },
                tooltip: { shared: true },
                series: [{
                    name: 'Precio Multa',
                    data: dataMulta,
                    color: 'rgba(255, 99, 132, 1)'
                }, {
                    name: 'Precio Casilla',
                    data: dataCasilla,
                    color: 'rgba(54, 162, 235, 1)'
                }, {
                    name: 'Precio Llave',
                    data: dataLlave,
                    color: 'rgba(255, 206, 86, 1)'
                }, {
                    name: 'Precio Habilitacion',
                    data: dataHabilitacion,
                    color: 'rgba(75, 192, 192, 1)'
                }],
                exporting: exportingOptions
            });
        });
    </script>
@stop
