<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            {{ __('Casillas Alquiladas') }}
                        </span>
                    </div>
                    <div style="display: flex; align-items: center;">
                        <input type="text" wire:model="search" placeholder="Buscar por nombre..." class="form-control mr-2">
                        <button wire:click="searchPackages" class="btn btn-primary mr-2">Buscar</button>
                        <input type="date" wire:model="date" class="form-control mr-2">
                        <select wire:model="categoria" class="form-control mr-2">
                            <option value="">Todos los Tamaños</option>
                            <option value="1">PEQUEÑA</option>
                            <option value="2">MEDIANA</option>
                            <option value="3">GABETA</option>
                            <option value="4">CAJON</option>
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
                                <th>Nro. Casilla</th>
                                <th>Cliente</th>
                                <th>Tamaño</th>
                                <th>Nro. Sección</th>
                                <th>Nro. Llave</th>
                                <th>Estado</th>
                                <th>Fecha de Apertura del Alquiler</th>
                                <th>Fecha de Fin de Alquiler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($packages as $package)
                                <tr>
                                    <td>{{ $package['casilla']['nombre'] ?? 'N/A' }}</td>
                                    <td>{{ $package['alquiler']['cliente']['nombre'] ?? 'N/A' }}</td>
                                    <td>{{ $package['casilla']['categoria_id'] ?? 'N/A' }}</td>
                                    <td>{{ $package['casilla']['seccione_id'] ?? 'N/A' }}</td>
                                    <td>{{ $package['casilla']['llaves_id'] ?? 'N/A' }}</td>
                                    <td>{{ $package['casilla']['estado'] ?? 'N/A' }}</td>
                                    <td>{{ $package['alquiler']['apertura'] ?? 'N/A' }}</td>
                                    <td>{{ $package['alquiler']['fin_fecha'] ?? 'N/A' }}</td>
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