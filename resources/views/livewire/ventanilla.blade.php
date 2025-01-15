<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            {{ __('CORRESPONDENCIA AREA DE VENTANILLA') }}
                        </span>
                    </div>
                    <div style="display: flex; align-items: center;">
                        <input type="text" wire:model="search" placeholder="Buscar por código o destinatario..."
                            class="form-control mr-2">
                        <button wire:click="searchPackages" class="btn btn-primary mr-2">Buscar</button>
                        <input type="date" wire:model="date" class="form-control mr-2">
                        <select wire:model="ventanilla" class="form-control mr-2">
                            <option value="">Seleccionar Estado</option>
                            <option value="VENTANILLA">VENTANILLA</option>
                            <option value="CARTERO">CARTERO</option>
                            <option value="REZAGO">REZAGO</option>
                        </select>
                        <select wire:model="ciudad" class="form-control mr-2">
                            <option value="">Todas las Ciudades</option>
                            <option value="LA PAZ">LA PAZ</option>
                            <option value="COCHABAMBA">COCHABAMBA</option>
                            <option value="SANTA CRUZ">SANTA CRUZ</option>
                            <option value="ORURO">ORURO</option>
                            <option value="POTOSI">POTOSI</option>
                            <option value="SUCRE">SUCRE</option>
                            <option value="BENI">BENI</option>
                            <option value="PANDO">PANDO</option>
                            <option value="TARIJA">TARIJA</option>
                        </select>
                        <button wire:click="applyFilters" class="btn btn-secondary">Aplicar Filtros</button>
                        <button wire:click="generatePDF" class="btn btn-danger">Generar PDF</button>
                        <button wire:click="generateExcel" class="btn btn-success">Generar Excel</button>

                    </div>
                </div>
            </div>
            <div wire:loading>
                <div class="overlay">
                    <i class="fas fa-2x fa-sync fa-spin justify-content-center"></i>
                </div>
            </div>
            @if (session()->has('success'))
                <div class="alert alert-success">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            <div class="card-body">
                <div class="table-responsive">
                    <div class="d-flex justify-content-center">
                        Se encontraron {{ $packages->total() }} registros en total
                    </div>
                    <table class="table table-striped table-hover">
                        <thead class="thead">
                            <tr>
                                <th>CODIGO</th>
                                <th>DESTINATARIO</th>
                                <th>CIUDAD</th>
                                <th>PESO</th>
                                <th>PROXIMO ESTADO</th>
                                <th>RECIBIDO</th>
                                <th>TIEMPO TRASCURRIDO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($packages as $package)
                                <tr>
                                    <td>{{ $package['CODIGO'] }}</td>
                                    <td>{{ $package['DESTINATARIO'] }}</td>
                                    <td>{{ $package['CUIDAD'] }}</td>
                                    <td>{{ $package['PESO'] }}</td>
                                    <td>
                                        <span
                                            style="color: {{ $package['status_color'] }}">{{ $package['next_status'] }}</span>
                                    </td>
                                    <td>{{ $package['updated_at'] }}</td>
                                    <td>
                                        <span
                                            style="color: {{ $package['status_color'] }}">{{ $package['date_difference'] }}
                                            días</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            {{ $packages->links() }}
        </div>
    </div>
</div>
