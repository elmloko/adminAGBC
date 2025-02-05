<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h4 id="card_title">
                            {{ __('Despachos Aperturados') }}
                        </h4>
                    </div>
                </div>
                <div style="display: flex; align-items: center;">
                    <input type="text" wire:model="search" placeholder="Buscar por nombre..."
                        class="form-control mr-2">
                    <input type="date" wire:model="date" class="form-control mr-2">
                    <select wire:model="categoria" class="form-control mr-2">
                        <option value="">Todos las regionales</option>
                        <option value="BOLPZ">BOLPZ - LA PAZ</option>
                        <option value="BOTJA">BOTJA - TARIJA</option>
                        <option value="BOPOI">BOPOI - POTOSI</option>
                        <option value="BOCBB">BOCBB - COCHABAMBA</option>
                        <option value="BOCIJ">BOCIJ - PANDO</option>
                        <option value="BOORU">BOORU - ORURO</option>
                        <option value="BOTDD">BOTDD - BENI</option>
                        <option value="BOSRE">BOSRE - SUCRE</option>
                        <option value="BOSRZ">BOSRZ - SANTA CRUZ</option>
                    </select>
                    <button wire:click="applyFilters" class="btn btn-primary mr-2">Buscar</button>
                </div>
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                <div class="card-body">
                    <div class="table-responsive">
                        {{-- <div class="d-flex justify-content-center">
                        Se encontraron {{ $aperturas->total() }} registros en total
                    </div> --}}
                        <table class="table table-striped table-hover">
                            <thead class="thead">
                                <tr>
                                    <th>Despacho</th>
                                    <th>Oficina Origen</th>
                                    <th>Oficina Destino</th>
                                    <th>Peso Total</th>
                                    <th>Paquetes Totales</th>
                                    <th>Fecha Apertura</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($aperturas as $apertura)
                                    <tr>
                                        <td>{{ $apertura['identificador'] }}</td>
                                        <td>{{ $apertura['oforigen'] }}</td>
                                        <td>{{ $apertura['ofdestino'] }}</td>
                                        <td>{{ $apertura['peso_total'] }} kg</td>
                                        <td>{{ $apertura['paquetes_total'] }}</td>
                                        <td>{{ $apertura['created_at'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- <div class="d-flex justify-content-center">
            {{ $aperturas->links('pagination::bootstrap-4') }}
        </div> --}}
        </div>
    </div>
