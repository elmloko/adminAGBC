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
                                    <th>Direccion</th>
                                    <th>Pais</th>
                                    <th>CI.</th>
                                    <th>Email</th>
                                    <th>Telefono</th>
                                    <th>Descripcion</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($informaciones as $info)
                                    <tr>
                                        <td>{{ $info['id'] }}</td>
                                        <td>{{ $info['correlativo'] }}</td>
                                        <td>{{ $info['fullName'] }}</td>
                                        <td>{{ $info['address'] }}</td>
                                        <td>{{ $info['country'] }}</td>
                                        <td>{{ $info['identityCard'] }}</td>
                                        <td>{{ $info['codepostal'] }}</td>
                                        <td>{{ $info['email'] }}</td>
                                        <td>{{ $info['phone'] }}</td>
                                        <td>{{ $info['description'] }}</td>
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
