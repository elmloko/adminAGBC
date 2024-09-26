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
                        <select wire:model="dias" class="form-control mr-2">
                            <option value="">Todos los Días</option>
                            <option value="0-7">0 a 7 días</option>
                            <option value="8-15">8 a 15 días</option>
                            <option value="16+">16 días o más</option>
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
                                <th>TELEFONO</th>
                                <th>PESO</th>
                                <th>ESTADO</th>
                                <th>ENTREGADO</th>
                                <th>TIEMPO DE ENTREGA</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($packages as $package)
                                <tr>
                                    <td>{{ $package['CODIGO'] }}</td>
                                    <td>{{ $package['DESTINATARIO'] }}</td>
                                    <td>{{ $package['TELEFONO'] }}</td>
                                    <td>{{ $package['PESO'] }}</td>
                                    <td>{{ $package['ESTADO'] }}</td>
                                    <td>{{ $package['deleted_at'] }}</td>
                                    <td>
                                        @if ($package['tiempo_entrega'] <= 7)
                                            <span style="color: green;">{{ $package['tiempo_entrega'] }} días</span>
                                        @elseif ($package['tiempo_entrega'] > 7 && $package['tiempo_entrega'] <= 15)
                                            <span style="color: yellow;">{{ $package['tiempo_entrega'] }} días</span>
                                        @else
                                            <span style="color: red;">{{ $package['tiempo_entrega'] }} días</span>
                                        @endif
                                    </td>
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
