<?php

namespace App\Http\Controllers;

use App\Models\DetalleVenta;
use App\Models\Impuesto;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('user')->latest()->paginate(10);
        return view('ventas.index', compact('ventas'));
    }

    public function create()
    {
        $productos = Producto::where('stock', '>', 0)->orderBy('nombre')->get();
        $impuesto = Impuesto::where('activo', true)->first();
        $porcentajeImpuesto = $impuesto ? $impuesto->porcentaje : 12;

        return view('ventas.create', compact('productos', 'porcentajeImpuesto'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $subtotal = 0;
            $detalles = [];

            foreach ($request->productos as $item) {
                $producto = Producto::findOrFail($item['id']);

                if ($producto->stock < $item['cantidad']) {
                    DB::rollBack();
                    return back()->with('error', "Stock insuficiente para {$producto->nombre}. Disponible: {$producto->stock}")->withInput();
                }

                $subtotalItem = $producto->precio * $item['cantidad'];
                $subtotal += $subtotalItem;

                $detalles[] = [
                    'producto_id' => $producto->id,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $producto->precio,
                    'subtotal' => $subtotalItem,
                ];

                // Descontar stock
                $producto->decrement('stock', $item['cantidad']);
            }

            $impuesto = Impuesto::where('activo', true)->first();
            $porcentajeImpuesto = $impuesto ? $impuesto->porcentaje : 12;
            $montoImpuesto = $subtotal * ($porcentajeImpuesto / 100);
            $total = $subtotal + $montoImpuesto;

            $venta = Venta::create([
                'user_id' => auth()->id(),
                'fecha' => now()->toDateString(),
                'subtotal' => $subtotal,
                'impuesto' => $montoImpuesto,
                'total' => $total,
            ]);

            foreach ($detalles as $detalle) {
                $venta->detalles()->create($detalle);
            }

            DB::commit();

            return redirect()->route('ventas.index')->with('success', "Venta #$venta->id registrada exitosamente. Total: Q" . number_format($total, 2));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al registrar la venta: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Venta $venta)
    {
        $venta->load(['detalles.producto', 'user']);
        return view('ventas.show', compact('venta'));
    }

    public function destroy(Venta $venta)
    {
        DB::beginTransaction();
        try {
            // Restore stock
            foreach ($venta->detalles as $detalle) {
                $detalle->producto->increment('stock', $detalle->cantidad);
            }
            $venta->delete();
            DB::commit();

            return redirect()->route('ventas.index')->with('success', 'Venta eliminada y stock restaurado.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al eliminar la venta.');
        }
    }
}
