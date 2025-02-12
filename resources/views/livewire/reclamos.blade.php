<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card mt-3">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h4 id="card_title">
                            {{ __('Informaciones') }}
                        </h4>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filtros -->
                    <div class="d-flex align-items-center mb-3">
                        <input type="text" wire:model="search"
                            placeholder="Buscar por destinatario, código o correlativo..." class="form-control mr-2">
                        <input type="date" wire:model="date" class="form-control mr-2">
                        <select wire:model="ciudad" class="form-control mr-2">
                            <option value="">Todas las ciudades</option>
                            <option value="LA PAZ">LA PAZ</option>
                            <option value="COCHABAMBA">COCHABAMBA</option>
                            <option value="SANTA CRUZ">SANTA CRUZ</option>
                            <option value="TARIJA">TARIJA</option>
                            <option value="ORURO">ORURO</option>
                            <option value="POTOSI">POTOSI</option>
                            <option value="BENI">BENI</option>
                            <option value="PANDO">PANDO</option>
                            <option value="SUCRE">SUCRE</option>
                            <!-- Agrega más opciones según corresponda -->
                        </select>
                        <select wire:model="tipo_envio" class="form-control mr-2">
                            <option value="">Todas los envios</option>
                            <option value="LOCAL">LOCAL</option>
                            <option value="INTERNACIONAL">INTERNACIONAL</option>
                            <option value="NACIONAL">NACIONAL</option>
                        </select>
                        <button wire:click="generateExcel" class="btn btn-success mr-2">Generar Excel</button>
                        <button wire:click="generatePDF" class="btn btn-danger mr-2">Generar PDF</button>
                        <button wire:click="applyFilters" class="btn btn-primary">Buscar</button>
                    </div>

                    <!-- Mensaje de sesión (si existe) -->
                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    <!-- Tabla de resultados -->
                    <div class="table-responsive">
                        <div class="d-flex justify-content-center mb-2">
                            Se encontraron {{ $informaciones->total() }} registros en total
                        </div>
                        <table class="table table-striped table-hover">
                            <thead class="thead">
                                <tr>
                                    <th>Correlativo</th>
                                    <th>Remitente</th>
                                    <th>Email del Remitente</th>
                                    <th>Origen</th>
                                    <th>Destinatario</th>
                                    <th>Email del Destinatario</th>
                                    <th>Destino</th>
                                    <th>Codigo de Rastreo</th>
                                    <th>Fecha Envio</th>
                                    <th>Contenido</th>
                                    <th>Ciudad</th>
                                    <th>Estado</th>
                                    <th>Descripcion del Reclamo</th>
                                    <th>Días Transcurridos</th>
                                    <th>Fecha Reclamo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($informaciones as $info)
                                    <tr>
                                        <td>{{ $info['correlativo'] }}</td>
                                        <td>{{ $info['remitente'] }}</td>
                                        <td>{{ $info['email_r'] }}</td>
                                        <td>{{ $info['origen'] }}</td>
                                        <td>{{ $info['destinatario'] }}</td>
                                        <td>{{ $info['email_d'] }}</td>
                                        <td>{{ $info['destino'] }}</td>
                                        <td>{{ $info['codigo'] }}</td>
                                        <td>{{ $info['fecha_envio'] }}</td>
                                        <td>{{ $info['contenido'] }}</td>
                                        <td>{{ $info['ciudad'] }}</td>
                                        <td>{{ $info['estado'] }}</td>
                                        <td>{{ $info['reclamo'] }}</td>
                                        <td>
                                            <span style="color: {{ $info['color'] }}; font-weight: bold;">
                                                {{ $info['tiempo_transcurrido'] }} {{ $info['unidad_tiempo'] }}
                                            </span>
                                        </td>
                                        <td>{{ $info['created_at'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="d-flex justify-content-center">
                        {{ $informaciones->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
