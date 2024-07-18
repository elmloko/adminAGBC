<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            {{ __('CORRESPONDENCIA ENTREGADA') }}
                        </span>
                    </div>
                    <div style="display: flex; align-items: center;">
                        <input type="text" wire:model="search" placeholder="Buscar por código o destinatario..."
                            class="form-control mr-2">
                        <button wire:click="searchPackages" class="btn btn-primary mr-2">Buscar</button>
                        <input type="date" wire:model="date" class="form-control mr-2">
                        <button wire:click="filterByDate" class="btn btn-secondary mr-2">Filtrar por Fecha</button>
                        <select wire:model="ventanilla" class="form-control mr-2">
                            <option value="">Todas las Ventanillas</option>
                            <!-- Asumiendo que las ventanillas son 'Ventanilla 1', 'Ventanilla 2', etc. -->
                            <option value="DD">DD</option>
                            <option value="DND">DND</option>
                            <option value="ENCOMIENDAS">ENCOMIENDAS</option>
                            <option value="ECA">ECA</option>
                        </select>
                        <button wire:click="filterByVentanilla" class="btn btn-secondary">Filtrar por Ventanilla</button>
                        <select wire:model="ciudad" class="form-control mr-2">
                            <option value="">Todas las Ciudades</option>
                            <!-- Asumiendo que las ciudades son 'La Paz', 'Cochabamba', etc. -->
                            <option value="LA PAZ">LA PAZ</option>
                            <option value="COCHABAMBA">COCHABAMBA</option>
                            <option value="SANTA CRUZ">SANTA CRUZ</option>
                            <option value="ORURO">ORURO</option>
                            <option value="POTOSI">POTOSI</option>
                            <option value="SUCRE">SUCRE</option>
                            <option value="BENI">BENI</option>
                            <option value="PANDO">PANDO</option>
                            <option value="TARIJA">TARIJA</option>
                            <!-- Añadir más opciones según sea necesario -->
                        </select>
                        <button wire:click="filterByCiudad" class="btn btn-secondary">Filtrar por Ciudad</button>
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
                                <th>ID</th>
                                <th>CODIGO</th>
                                <th>DESTINATARIO</th>
                                <th>TELEFONO</th>
                                <th>CIUDAD</th>
                                <th>VENTANILLA</th>
                                <th>PESO</th>
                                <th>ESTADO</th>
                                <th>ENTREGADO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($packages as $package)
                                <tr>
                                    <td>{{ $package['id'] }}</td>
                                    <td>{{ $package['CODIGO'] }}</td>
                                    <td>{{ $package['DESTINATARIO'] }}</td>
                                    <td>{{ $package['TELEFONO'] }}</td>
                                    <td>{{ $package['CUIDAD'] }}</td>
                                    <td>{{ $package['VENTANILLA'] }}</td>
                                    <td>{{ $package['PESO'] }}</td>
                                    <td>{{ $package['ESTADO'] }}</td>
                                    <td>{{ $package['deleted_at'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            {{ $packages->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
