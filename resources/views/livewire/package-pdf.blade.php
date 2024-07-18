<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventanilla</title>
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
            <h2>REPORTES CORRESPONDENCIA ENTREGADA</h2>
            <h3>AGENCIA BOLIVIANA DE CORREOS</h3>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>CODIGO</th>
                <th>DESTINATARIO</th>
                <th>TELEFONO</th>
                <th>CIUDAD</th>
                <th>VENTANILLA</th>
                <th>PESO</th>
                <th>ESTADO</th>
                <th>REGISTRADO</th>
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
                    <td>{{ $package['created_at'] }}</td>
                    <td>{{ $package['deleted_at'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
