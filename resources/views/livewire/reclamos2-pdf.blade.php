<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Informaciones</title>
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
            <!-- Asegúrate de que la ruta a la imagen sea correcta -->
            <img src="{{ public_path('images/images.png') }}" alt="Logo" width="150" height="50">
        </div>
        <div class="title">
            <h2>REPORTE DE INFORMACIONES</h2>
            <h3>AGENCIA BOLIVIANA DE CORREOS</h3>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>Correlativo</th>
                <th>Nombre Completo</th>
                <th>Telefono</th>
                <th>CI.</th>
                <th>Email</th>
                <th>Descripcion de la Queja</th>
                <th>Funcionario</th>
                <th>Tipo</th>
                <th>Estado</th>
                <th>Ciudad</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($informaciones as $info)
                <tr>
                    <td>{{ $info['correlativo'] }}</td>
                    <td>{{ $info['cliente'] }}</td>
                    <td>{{ $info['telf'] }}</td>
                    <td>{{ $info['ci'] }}</td>
                    <td>{{ $info['email'] }}</td>
                    <td>{{ $info['queja'] }}</td>
                    <td>{{ $info['funcionario'] }}</td>
                    <td>{{ $info['tipo'] }}</td>
                    <td>{{ $info['estado'] }}</td>
                    <td>{{ $info['ciudad'] }}</td>
                    <td>{{ $info['created_at'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
