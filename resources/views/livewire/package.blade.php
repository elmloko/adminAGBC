<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            {{ __('Administracion Permisos TrackinBO') }}
                        </span>
                    </div>
                </div>
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                <div class="card-body">
                    <div class="table-responsive">
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
                                    <th>CREACION</th>
                                    <th>ENTREGADO</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($packages as $package)
                                    <tr>
                                        <td>{{ $package['id'] }}</td>
                                        <td>{{ $package['CODIGO'] }}</td>
                                        <td>{{ $package['DESTINATARIO'] }}</td>
                                        <td>{{ $package['TELEFONO'] }}</td>
                                        <td>{{ $package['CUIDAD'] }}</td>
                                        <td>{{ $package['VENTANILLA'] }}</td>
                                        <td>{{ $package['PESO'] }}</td>
                                        <td>{{ $package['ESTADO'] }}</td>
                                        <td>{{ $package['created_at'] }}</td>
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
</div>
