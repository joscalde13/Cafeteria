<?php

namespace App\Http\Controllers;

use App\Models\MovimientoInventario;
use App\Models\Producto;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index()
    {
        $movimientos = MovimientoInventario::with(['producto', 'user'])->latest()->paginate(15);
        $productos = Producto::orderBy('nombre')->get();
        return view('inventario.index', compact('movimientos', 'productos'));
    }

    public function create()
    {
        $productos = Producto::orderBy('nombre')->get();
        return view('inventario.create', compact('productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'tipo' => 'required|in:entrada,salida',
            'cantidad' => 'required|integer|min:1',
            'motivo' => 'nullable|string|max:255',
        ]);

        $producto = Producto::findOrFail($request->producto_id);

        if ($request->tipo === 'salida' && $producto->stock < $request->cantidad) {
            return back()->with('error', "Stock insuficiente. Disponible: {$producto->stock}")->withInput();
        }

        MovimientoInventario::create([
            'producto_id' => $request->producto_id,
            'tipo' => $request->tipo,
            'cantidad' => $request->cantidad,
            'motivo' => $request->motivo,
            'user_id' => auth()->id(),
        ]);

        // Update stock
        if ($request->tipo === 'entrada') {
            $producto->increment('stock', $request->cantidad);
        } else {
            $producto->decrement('stock', $request->cantidad);
        }

        return redirect()->route('inventario.index')->with('success', 'Movimiento de inventario registrado exitosamente.');
    }
}
