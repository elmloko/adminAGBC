<div>
    <!-- Estadísticas del Sistema Area Clasificacion -->
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
                <!-- Paqueteria Registrada / No Recibidos (Gráfico Column) -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Paqueteria Registrada / No Recibidos</h3>
                            <h5 class="box-title">Inventario desde 01/2024</h5>
                        </div>
                        <div class="box-body">
                            <div id="packageChart" style="width: 100%; height: 500px;"></div>
                        </div>
                    </div>
                </div>
                <!-- Paquetes Registrada por Ciudad (Gráfico Pie) -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Paquetes Registrada por Ciudad</h3>
                        </div>
                        <div class="box-body">
                            <div id="cityChart" style="width: 100%; height: 500px;"></div>
                        </div>
                    </div>
                </div>
                <!-- Paquetes No Recibidos por Ciudad (Gráfico Doughnut) -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Paquetes No Recibidos por Ciudad</h3>
                        </div>
                        <div class="box-body">
                            <div id="despachoCityChart" style="width: 100%; height: 500px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas del Sistema Area Ventanila -->
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
                <!-- Paquetes en Ventanilla por Mes (Gráfico Line) -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Paquetes en Ventanilla por Mes</h3>
                            <h5 class="box-title">Inventario desde 01/2024</h5>
                        </div>
                        <div class="box-body">
                            <div id="ventanillaChart" style="width: 100%; height: 500px;"></div>
                        </div>
                    </div>
                </div>
                <!-- Ventanilla por Ciudad (Gráfico Doughnut) -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Ventanilla por Ciudad</h3>
                        </div>
                        <div class="box-body">
                            <div id="ventanillaByCityChart" style="width: 100%; height: 500px;"></div>
                        </div>
                    </div>
                </div>
                <!-- Ventanilla por Servicio (Gráfico Pie) -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Ventanilla por Servicio</h3>
                        </div>
                        <div class="box-body">
                            <div id="ventanillaByServiceChart" style="width: 100%; height: 500px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas del Sistema Entregas -->
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
                <!-- Total paqueteria generado por mes expresado en Bs. (Gráfico Line) -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Total paqueteria generado por mes expresado en Bs.</h3>
                            <h5 class="box-title">Inventario desde 01/2024</h5>
                        </div>
                        <div class="box-body">
                            <div id="entregadoPriceChart" style="width: 100%; height: 500px;"></div>
                        </div>
                    </div>
                </div>
                <!-- Paquetes Entregado por Ciudad (Gráfico Doughnut) -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Paquetes Entregado por Ciudad</h3>
                        </div>
                        <div class="box-body">
                            <div id="entregadoByCityChart" style="width: 100%; height: 500px;"></div>
                        </div>
                    </div>
                </div>
                <!-- Paquetes Entregados por Servicio (Gráfico Pie) -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Paquetes Entregados por Servicio</h3>
                        </div>
                        <div class="box-body">
                            <div id="entregadoByServiceChart" style="width: 100%; height: 500px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <!-- Incluir Highcharts y el módulo de exportación -->
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <!-- (Opcional) Para exportación sin conexión -->
        <script src="https://code.highcharts.com/modules/offline-exporting.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Se asumen las variables pasadas desde el servidor (por ejemplo, desde Laravel)
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

                // Preparar arrays de etiquetas y datos
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

                const labelsEntregadoPrices = entregadoPricesByMonth
                    .filter(item => item.total > 0)
                    .map(item => `${item.month}/${item.year}`);
                const dataEntregadoPrices = entregadoPricesByMonth
                    .filter(item => item.total > 0)
                    .map(item => item.total);

                const labelsEntregadoCity = entregadoByCity.map(item => item.city);
                const dataEntregadoCity = entregadoByCity.map(item => item.total);

                const labelsEntregadoService = entregadoByService.map(item => item.service);
                const dataEntregadoService = entregadoByService.map(item => item.total);

                // Para gráficos de pastel/doughnut en Highcharts se requiere un arreglo de objetos { name, y }
                const pieCityPackagesData = labelsCityPackages.map((label, index) => ({
                    name: label,
                    y: dataCityPackages[index]
                }));
                const pieDespachoCityData = labelsDespachoCity.map((label, index) => ({
                    name: label,
                    y: dataDespachoCity[index]
                }));
                const pieVentanillaServiceData = labelsVentanillaService.map((label, index) => ({
                    name: label,
                    y: dataVentanillaService[index]
                }));
                const pieVentanillaCityData = labelsVentanillaCity.map((label, index) => ({
                    name: label,
                    y: dataVentanillaCity[index]
                }));
                const pieEntregadoCityData = labelsEntregadoCity.map((label, index) => ({
                    name: label,
                    y: dataEntregadoCity[index]
                }));
                const pieEntregadoServiceData = labelsEntregadoService.map((label, index) => ({
                    name: label,
                    y: dataEntregadoService[index]
                }));

                // Función de configuración común para la exportación
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

                // 1. Gráfico Column: Paqueteria Registrada / No Recibidos
                Highcharts.chart('packageChart', {
                    chart: { type: 'column' },
                    title: { text: 'Paqueteria Registrada / No Recibidos' },
                    subtitle: { text: 'Inventario desde 01/2024' },
                    xAxis: { categories: labelsPackages, crosshair: true },
                    yAxis: { min: 0, title: { text: 'Cantidad' } },
                    tooltip: { shared: true },
                    plotOptions: { column: { dataLabels: { enabled: true } } },
                    series: [{
                        name: 'Paquetes Registrados',
                        data: dataPackages,
                        color: 'rgba(54, 162, 235, 1)'
                    }, {
                        name: 'Paquetes No Recibidos',
                        data: dataDespachoPackages,
                        color: 'rgba(255, 99, 132, 1)'
                    }],
                    exporting: exportingOptions
                });

                // 2. Gráfico Pie: Paquetes por Ciudad
                Highcharts.chart('cityChart', {
                    chart: { type: 'pie' },
                    title: { text: 'Paquetes por Ciudad' },
                    // tooltip: { pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>' },
                    accessibility: { point: { valueSuffix: '%' } },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '{point.name}: {point.percentage:.2f} %'
                            }
                        }
                    },
                    series: [{
                        name: 'Paquetes',
                        colorByPoint: true,
                        data: pieCityPackagesData
                    }],
                    exporting: exportingOptions
                });

                // 3. Gráfico Doughnut: Paquetes en DESPACHO por Ciudad
                Highcharts.chart('despachoCityChart', {
                    chart: { type: 'pie' },
                    title: { text: 'Paquetes en DESPACHO por Ciudad' },
                    plotOptions: {
                        pie: {
                            innerSize: '50%',
                            dataLabels: {
                                enabled: true,
                                format: '{point.name}: {point.percentage:.2f} %'
                            }
                        }
                    },
                    series: [{
                        name: 'Paquetes',
                        data: pieDespachoCityData,
                        colorByPoint: true
                    }],
                    exporting: exportingOptions
                });

                // 4. Gráfico Line: Paquetes en Ventanilla por Mes
                Highcharts.chart('ventanillaChart', {
                    chart: { type: 'line' },
                    title: { text: 'Paquetes en Ventanilla por Mes' },
                    subtitle: { text: 'Inventario desde 01/2024' },
                    xAxis: { categories: labelsVentanillaPackages },
                    yAxis: { title: { text: 'Cantidad' } },
                    tooltip: { shared: true },
                    series: [{
                        name: 'Paquetes en Ventanilla',
                        data: dataVentanillaPackages,
                        color: 'rgba(75, 192, 192, 1)'
                    }],
                    exporting: exportingOptions
                });

                // 5. Gráfico Pie: Ventanilla por Servicio
                Highcharts.chart('ventanillaByServiceChart', {
                    chart: { type: 'pie' },
                    title: { text: 'Paquetes en Ventanilla por Servicio' },
                    // tooltip: { pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>' },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '{point.name}: {point.percentage:.2f} %'
                            }
                        }
                    },
                    series: [{
                        name: 'Paquetes',
                        colorByPoint: true,
                        data: pieVentanillaServiceData
                    }],
                    exporting: exportingOptions
                });

                // 6. Gráfico Doughnut: Ventanilla por Ciudad
                Highcharts.chart('ventanillaByCityChart', {
                    chart: { type: 'pie' },
                    title: { text: 'Paquetes en Ventanilla por Ciudad' },
                    plotOptions: {
                        pie: {
                            innerSize: '50%',
                            dataLabels: {
                                enabled: true,
                                format: '{point.name}: {point.percentage:.2f} %'
                            }
                        }
                    },
                    series: [{
                        name: 'Paquetes',
                        data: pieVentanillaCityData,
                        colorByPoint: true
                    }],
                    exporting: exportingOptions
                });

                // 7. Gráfico Line: Precio Total de Paquetes Entregados por Mes
                Highcharts.chart('entregadoPriceChart', {
                    chart: { type: 'line' },
                    title: { text: 'Precio Total de Paquetes Entregados' },
                    subtitle: { text: 'Inventario desde 01/2024' },
                    xAxis: { categories: labelsEntregadoPrices },
                    yAxis: { title: { text: 'Precio en Bs.' } },
                    tooltip: { shared: true },
                    series: [{
                        name: 'Precio Total',
                        data: dataEntregadoPrices,
                        color: 'rgba(75, 192, 192, 1)'
                    }],
                    exporting: exportingOptions
                });

                // 8. Gráfico Doughnut: Paquetes Entregados por Ciudad
                Highcharts.chart('entregadoByCityChart', {
                    chart: { type: 'pie' },
                    title: { text: 'Paquetes Entregados por Ciudad' },
                    plotOptions: {
                        pie: {
                            innerSize: '50%',
                            dataLabels: {
                                enabled: true,
                                format: '{point.name}: {point.percentage:.2f} %'
                            }
                        }
                    },
                    series: [{
                        name: 'Paquetes',
                        data: pieEntregadoCityData,
                        colorByPoint: true
                    }],
                    exporting: exportingOptions
                });

                // 9. Gráfico Pie: Paquetes Entregados por Servicio
                Highcharts.chart('entregadoByServiceChart', {
                    chart: { type: 'pie' },
                    title: { text: 'Paquetes Entregados por Servicio' },
                    // tooltip: { pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>' },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '{point.name}: {point.percentage:.2f} %'
                            }
                        }
                    },
                    series: [{
                        name: 'Paquetes',
                        data: pieEntregadoServiceData,
                        colorByPoint: true
                    }],
                    exporting: exportingOptions
                });
            });
        </script>
    @endpush
</div>
