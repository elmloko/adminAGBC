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
                        <select wire:model="tipo" class="form-control mr-2">
                            <option value="">Todos los estados</option>
                            <option value="OPERATIVO">QUEJAS OPERATIVAS</option>
                            <option value="ADMINISTRATIVO">QUEJAS ADMINISTRATIVAS</option>
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
                                    <th>ID</th>
                                    <th>Correlativo</th>
                                    <th>Nombre Completo</th>
                                    <th>Telefono</th>
                                    <th>CI.</th>
                                    <th>Email</th>
                                    <th>Descripcion de la Queja</th>
                                    <th>Funcionario</th>
                                    <th>Tipo</th>
                                    <th>Estado</th>
                                    <th>Calificacion</th>
                                    <th>Ciudad</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($informaciones as $info)
                                    <tr>
                                        <td>{{ $info['id'] }}</td>
                                        <td>{{ $info['correlativo'] }}</td>
                                        <td>{{ $info['cliente'] }}</td>
                                        <td>{{ $info['telf'] }}</td>
                                        <td>{{ $info['ci'] }}</td>
                                        <td>{{ $info['email'] }}</td>
                                        <td>{{ $info['queja'] }}</td>
                                        <td>{{ $info['funcionario'] }}</td>
                                        <td>{{ $info['tipo'] }}</td>
                                        <td>{{ $info['estado'] }}</td>
                                        <td>{{ $info['feedback'] }}</td>
                                        <td>{{ $info['ciudad'] }}</td>
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
