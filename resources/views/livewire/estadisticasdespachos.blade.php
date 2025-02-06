<div class="card card-dark">
    <div class="card-header">
        <h3 class="card-title">Estadísticas del Sistema Área Clasificación</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            @if(empty($data))
                <p class="text-center">No hay datos disponibles.</p>
            @else
                @foreach($data as $key => $chartData)
                    <div class="col-md-4">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">{{ ucfirst($key) }} por Departamento</h3>
                            </div>
                            <div class="box-body">
                                <div id="chart-{{ $key }}" style="width: 100%; height: 500px;"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

@push('js')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @foreach($data as $key => $chartData)
            console.log("Datos para {{ $key }}:", @json($chartData));
            Highcharts.chart('chart-{{ $key }}', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Distribución de Despachos en {{ ucfirst($key) }}'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y}%</b> ({point.count} despachos)'
                },
                series: [{
                    name: 'Despachos',
                    colorByPoint: true,
                    data: @json($chartData)
                }]
            });
        @endforeach
    });
</script>
@endpush
