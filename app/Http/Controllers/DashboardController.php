<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Venta;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $hoy = Carbon::today();

        // Calcular fecha actual de Guatemala manualmente para evitar problemas de locale ('es')
        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        $gt = Carbon::now('America/Guatemala');
        $fechaGuatemala = $dias[$gt->dayOfWeek] . ', ' . $gt->format('d') . ' de ' . $meses[$gt->month - 1] . ' de ' . $gt->format('Y');

        $ventasHoy = Venta::whereDate('fecha', $hoy)->sum('total');
        $ventasMes = Venta::whereMonth('fecha', $hoy->month)->whereYear('fecha', $hoy->year)->sum('total');
        $totalProductos = Producto::count();
        $totalCategorias = Categoria::count();

        // 5 Productos más vendidos en el mes actual
        $productosMasVendidos = Producto::select('productos.id', 'productos.nombre', 'productos.stock', DB::raw('COALESCE(SUM(detalle_ventas.cantidad), 0) as total_vendido'))
            ->join('detalle_ventas', 'productos.id', '=', 'detalle_ventas.producto_id')
            ->join('ventas', 'detalle_ventas.venta_id', '=', 'ventas.id')
            ->whereMonth('ventas.fecha', $hoy->month)
            ->whereYear('ventas.fecha', $hoy->year)
            ->groupBy('productos.id', 'productos.nombre', 'productos.stock')
            ->orderByDesc('total_vendido')
            ->take(5)
            ->get();

        // Últimas 5 ventas realizadas
        $ventasRecientes = Venta::with('user')->orderByDesc('created_at')->take(5)->get();

        // Ventas de los últimos 7 días para la gráfica
        $ventasSemana = [];
        for ($i = 6; $i >= 0; $i--) {
            $dia = Carbon::today()->subDays($i);
            $ventasSemana[] = [
                'fecha' => $dia->format('d/m'),
                'total' => Venta::whereDate('fecha', $dia)->sum('total'),
            ];
        }

        // Ventas semanales agrupadas por producto
        $semanaOffset = (int) $request->input('semana', 0);
        $semanaOffset = max(0, min($semanaOffset, 4)); // limitar 0-4
        [$inicioSemana, $finSemana] = $this->calcularRangoSemana($semanaOffset);

        $ventasSemanales = DB::table('detalle_ventas')
            ->join('productos', 'detalle_ventas.producto_id', '=', 'productos.id')
            ->join('ventas', 'detalle_ventas.venta_id', '=', 'ventas.id')
            ->whereBetween('ventas.fecha', [$inicioSemana, $finSemana])
            ->select(
                'productos.nombre as producto',
                DB::raw('SUM(detalle_ventas.cantidad) as cantidad'),
                DB::raw('SUM(detalle_ventas.subtotal) as total')
            )
            ->groupBy('productos.nombre')
            ->orderByDesc('total')
            ->get();

        $totalSemanal = $ventasSemanales->sum('total');

        return view('dashboard', compact(
            'fechaGuatemala',
            'ventasHoy',
            'ventasMes',
            'totalProductos',
            'totalCategorias',
            'productosMasVendidos',
            'ventasRecientes',
            'ventasSemana',
            'ventasSemanales',
            'totalSemanal',
            'semanaOffset',
            'inicioSemana',
            'finSemana'
        ));
    }

    public function ventasSemanalesPdf(Request $request)
    {
        $semanaOffset = (int) $request->input('semana', 0);
        $semanaOffset = max(0, min($semanaOffset, 4));
        [$inicioSemana, $finSemana] = $this->calcularRangoSemana($semanaOffset);

        $ventasSemanales = DB::table('detalle_ventas')
            ->join('productos', 'detalle_ventas.producto_id', '=', 'productos.id')
            ->join('ventas', 'detalle_ventas.venta_id', '=', 'ventas.id')
            ->whereBetween('ventas.fecha', [$inicioSemana, $finSemana])
            ->select(
                'productos.nombre as producto',
                DB::raw('SUM(detalle_ventas.cantidad) as cantidad'),
                DB::raw('SUM(detalle_ventas.subtotal) as total')
            )
            ->groupBy('productos.nombre')
            ->orderByDesc('total')
            ->get();

        $totalSemanal = $ventasSemanales->sum('total');
        $fechaGeneracion = Carbon::now('America/Guatemala')->format('d/m/Y H:i');

        $pdf = Pdf::loadView('reportes.ventas-semanales-pdf', compact(
            'ventasSemanales',
            'totalSemanal',
            'inicioSemana',
            'finSemana',
            'fechaGeneracion'
        ));

        $inicio = Carbon::parse($inicioSemana)->format('d-m-Y');
        $fin = Carbon::parse($finSemana)->format('d-m-Y');

        return $pdf->download("ventas-semanales-{$inicio}-a-{$fin}.pdf");
    }

    private function calcularRangoSemana(int $offset): array
    {
        $gt = Carbon::now('America/Guatemala');
        $inicioSemana = $gt->copy()->subWeeks($offset)->startOfWeek(Carbon::MONDAY)->toDateString();
        $finSemana = $gt->copy()->subWeeks($offset)->endOfWeek(Carbon::SUNDAY)->toDateString();

        return [$inicioSemana, $finSemana];
    }
}
