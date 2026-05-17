<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ImpuestoMensualController extends Controller
{
    public function index(Request $request)
    {
        $meses = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        ];

        $mesSeleccionado = $request->input('mes', Carbon::now('America/Guatemala')->month);
        $anioSeleccionado = $request->input('anio', Carbon::now('America/Guatemala')->year);

        $ventas = Venta::with('user')
            ->whereMonth('fecha', $mesSeleccionado)
            ->whereYear('fecha', $anioSeleccionado)
            ->orderBy('fecha', 'desc')
            ->get();

        $totalVentas = $ventas->sum('total');
        $impuesto = $totalVentas * 0.05;
        $ganancia = $totalVentas - $impuesto;

        // Obtener años disponibles para el selector
        $aniosDisponibles = Venta::selectRaw('DISTINCT YEAR(fecha) as anio')
            ->orderBy('anio', 'desc')
            ->pluck('anio')
            ->toArray();

        if (empty($aniosDisponibles)) {
            $aniosDisponibles = [Carbon::now('America/Guatemala')->year];
        }

        return view('impuestos-mensuales.index', compact(
            'meses',
            'mesSeleccionado',
            'anioSeleccionado',
            'ventas',
            'totalVentas',
            'impuesto',
            'ganancia',
            'aniosDisponibles'
        ));
    }

    public function pdf(Request $request)
    {
        $meses = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        ];

        $mesSeleccionado = $request->input('mes', Carbon::now('America/Guatemala')->month);
        $anioSeleccionado = $request->input('anio', Carbon::now('America/Guatemala')->year);

        $ventas = Venta::with('user')
            ->whereMonth('fecha', $mesSeleccionado)
            ->whereYear('fecha', $anioSeleccionado)
            ->orderBy('fecha', 'desc')
            ->get();

        $totalVentas = $ventas->sum('total');
        $impuesto = $totalVentas * 0.05;
        $ganancia = $totalVentas - $impuesto;

        $nombreMes = $meses[$mesSeleccionado];
        $fechaGeneracion = Carbon::now('America/Guatemala')->format('d/m/Y H:i');

        $pdf = Pdf::loadView('impuestos-mensuales.pdf', compact(
            'ventas',
            'totalVentas',
            'impuesto',
            'ganancia',
            'nombreMes',
            'anioSeleccionado',
            'fechaGeneracion'
        ));

        return $pdf->download("impuesto-mensual-{$nombreMes}-{$anioSeleccionado}.pdf");
    }
}
