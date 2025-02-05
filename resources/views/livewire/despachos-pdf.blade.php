<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Despachos Postales</title>
    <style>
        /* Estilos para la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
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
            <img src="{{ public_path('images/images.png') }}" alt="Logo" width="150" height="50">
        </div>
        <div class="title">
            <h2>REPORTES DESPACHOS POSTALES</h2>
            <h3>AGENCIA BOLIVIANA DE CORREOS</h3>
        </div>
    </div>
    <table>
        <thead>
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
</body>
</html>
