<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casillas Postales</title>
    <style>
        /* Estilos para la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            line-height: 1;
        }

        thead {
            background-color: #f2f2f2;
        }

        /* Estilos para la página en formato horizontal */
        @page {
            size: landscape;
        }

        /* Estilos para la imagen y el título */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            line-height: 0.5;
        }

        .title {
            text-align: center;
        }

        .firma {
            text-align: center;
            margin-top: 20px;
            line-height: 0;
        }

        .date {
            line-height: 0.5;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo">
            <img src="{{ public_path('images/images.png') }}" alt="" width="150" height="50">
        </div>
        <div class="title">
            <h2>REPORTES CASILLAS POSTALES</h2>
            <h3>AGENCIA BOLIVIANA DE CORREOS</h3>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>Nro. Casilla</th>
                <th>Cliente</th>
                <th>Tamaño</th>
                <th>Nro. Sección</th>
                <th>Nro. Llaves</th>
                <th>Estado</th>
                <th>Fecha de Fin de Alquiler</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($packages as $package)
                <tr>
                    <td>{{ $package['casilla']['nombre'] }}</td>
                    <td>{{ $package['alquiler']['cliente']['nombre'] ?? 'N/A'}}</td>
                    <td>{{ $package['casilla']['categoria_id'] }}</td>
                    <td>{{ $package['casilla']['seccione_id'] }}</td>
                    <td>{{ $package['casilla']['llaves_id'] }}</td>
                    <td>{{ $package['casilla']['estado'] }}</td>
                    <td>{{ $package['casilla']['updated_at'] ?? ['fin_fecha'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
