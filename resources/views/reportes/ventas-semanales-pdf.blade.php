<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ventas Semanales - {{ $inicioSemana }} a {{ $finSemana }}</title>
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
        }

        .summary-item {
            display: table-cell;
            width: 50%;
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

        table.sales td.text-center {
            text-align: center;
        }

        .totals {
            width: 250px;
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

        .totals .total-row {
            border-top: 2px solid #1a1a1a;
        }

        .totals .total-row .value {
            color: #059669;
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
        <h2>Reporte de Ventas Semanales</h2>
        <p>{{ \Carbon\Carbon::parse($inicioSemana)->format('d/m/Y') }} —
            {{ \Carbon\Carbon::parse($finSemana)->format('d/m/Y') }}</p>
    </div>

    <div class="summary">
        <div class="summary-item">
            <div class="label">Productos Vendidos</div>
            <div class="value blue">{{ $ventasSemanales->count() }}</div>
        </div>
        <div class="summary-item">
            <div class="label">Total de la Semana</div>
            <div class="value green">Q{{ number_format($totalSemanal, 2) }}</div>
        </div>
    </div>

    <table class="sales">
        <thead>
            <tr>
                <th>Producto</th>
                <th style="text-align: center;">Cantidad</th>
                <th style="text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ventasSemanales as $item)
                <tr>
                    <td>{{ $item->producto }}</td>
                    <td class="text-center">{{ $item->cantidad }}</td>
                    <td class="text-end">Q{{ number_format($item->total, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center; padding: 20px; color: #888;">
                        No hay ventas registradas en esta semana.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr class="total-row">
                <td class="label">Total Semanal:</td>
                <td class="value">Q{{ number_format($totalSemanal, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Generado el: {{ $fechaGeneracion }} | Sistema Administrativo Cafetería
    </div>
</body>

</html>