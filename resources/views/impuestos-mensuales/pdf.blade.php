<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte Impuesto Mensual - {{ $nombreMes }} {{ $anioSeleccionado }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #1a1a1a;
            padding: 30px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #1a1a1a;
            padding-bottom: 15px;
        }

        .header h1 {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .header h2 {
            font-size: 16px;
            font-weight: normal;
            color: #555;
        }

        .header p {
            font-size: 11px;
            color: #888;
            margin-top: 5px;
        }

        .summary {
            display: table;
            width: 100%;
            margin-bottom: 25px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .summary-item {
            display: table-cell;
            width: 33.33%;
            padding: 15px;
            text-align: center;
            border-right: 1px solid #ddd;
        }

        .summary-item:last-child {
            border-right: none;
        }

        .summary-item .label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #888;
            margin-bottom: 5px;
        }

        .summary-item .value {
            font-size: 18px;
            font-weight: bold;
        }

        .summary-item .value.blue {
            color: #2563eb;
        }

        .summary-item .value.red {
            color: #dc2626;
        }

        .summary-item .value.green {
            color: #059669;
        }

        table.sales {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table.sales th {
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            padding: 8px 12px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #555;
        }

        table.sales td {
            border: 1px solid #ddd;
            padding: 8px 12px;
            font-size: 11px;
        }

        table.sales tr:nth-child(even) {
            background-color: #fafafa;
        }

        table.sales td.text-end {
            text-align: right;
        }

        .totals {
            width: 300px;
            margin-left: auto;
            margin-top: 15px;
        }

        .totals table {
            width: 100%;
            border-collapse: collapse;
        }

        .totals td {
            padding: 6px 10px;
            font-size: 12px;
        }

        .totals .label {
            text-align: right;
            font-weight: 600;
            color: #555;
        }

        .totals .value {
            text-align: right;
            font-weight: bold;
        }

        .totals .tax .label {
            color: #dc2626;
        }

        .totals .tax .value {
            color: #dc2626;
        }

        .totals .profit .label {
            color: #059669;
        }

        .totals .profit .value {
            color: #059669;
        }

        .totals .total-row {
            border-top: 2px solid #1a1a1a;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #aaa;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Cafetería</h1>
        <h2>Reporte de Impuesto Mensual</h2>
        <p>{{ $nombreMes }} {{ $anioSeleccionado }}</p>
    </div>

    <div class="summary">
        <div class="summary-item">
            <div class="label">Total Ventas</div>
            <div class="value blue">Q{{ number_format($totalVentas, 2) }}</div>
        </div>
        <div class="summary-item">
            <div class="label">Impuesto (5%)</div>
            <div class="value red">Q{{ number_format($impuesto, 2) }}</div>
        </div>
        <div class="summary-item">
            <div class="label">Ganancia Final</div>
            <div class="value green">Q{{ number_format($ganancia, 2) }}</div>
        </div>
    </div>

    <table class="sales">
        <thead>
            <tr>
                <th>Fecha</th>
                <th># Venta</th>
                <th>Usuario</th>
                <th style="text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ventas as $venta)
                <tr>
                    <td>{{ $venta->fecha->format('d/m/Y') }}</td>
                    <td>#{{ $venta->id }}</td>
                    <td>{{ $venta->user->name }}</td>
                    <td class="text-end">Q{{ number_format($venta->total, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 20px; color: #888;">
                        No hay ventas registradas en este mes.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr class="total-row">
                <td class="label">Total Ventas:</td>
                <td class="value">Q{{ number_format($totalVentas, 2) }}</td>
            </tr>
            <tr class="tax">
                <td class="label">Impuesto a Pagar (5%):</td>
                <td class="value">Q{{ number_format($impuesto, 2) }}</td>
            </tr>
            <tr class="profit">
                <td class="label">Ganancia Final:</td>
                <td class="value">Q{{ number_format($ganancia, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Generado el: {{ $fechaGeneracion }} | Sistema Administrativo Cafetería
    </div>
</body>

</html>