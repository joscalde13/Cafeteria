<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Impuesto;
use App\Models\Producto;
use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
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
        $productosMasVendidos = Producto::select('productos.id', 'productos.nombre', 'productos.stock', \Illuminate\Support\Facades\DB::raw('COALESCE(SUM(detalle_ventas.cantidad), 0) as total_vendido'))
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

        // Recordatorios de impuestos próximos
        $impuestosProximos = Impuesto::where('activo', true)
            ->whereNotNull('recordatorio_pago')
            ->where('recordatorio_pago', '<=', Carbon::today()->addDays(7))
            ->get();

        return view('dashboard', compact(
            'fechaGuatemala',
            'ventasHoy',
            'ventasMes',
            'totalProductos',
            'totalCategorias',
            'productosMasVendidos',
            'ventasRecientes',
            'ventasSemana',
            'impuestosProximos'
        ));
    }
}
