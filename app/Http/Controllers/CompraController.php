<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class CompraController extends Controller implements HasMiddleware
{
    /**
     * Middleware: solo admin puede gestionar compras.
     */
    public static function middleware(): array
    {
        return ['role:admin'];
    }

    public function index()
    {
        $compras = Compra::with('proveedor')->latest()->paginate(10);
        return view('compras.index', compact('compras'));
    }

    public function create()
    {
        $proveedores = Proveedor::orderBy('nombre')->get();
        return view('compras.create', compact('proveedores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha' => 'required|date',
            'total' => 'required|numeric|min:0',
            'notas' => 'nullable|string|max:1000',
        ]);

        Compra::create($request->only('proveedor_id', 'fecha', 'total', 'notas'));

        return redirect()->route('compras.index')->with('success', 'Compra registrada exitosamente.');
    }

    public function show(Compra $compra)
    {
        $compra->load('proveedor');
        return view('compras.show', compact('compra'));
    }

    public function edit(Compra $compra)
    {
        $proveedores = Proveedor::orderBy('nombre')->get();
        return view('compras.edit', compact('compra', 'proveedores'));
    }

    public function update(Request $request, Compra $compra)
    {
        $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha' => 'required|date',
            'total' => 'required|numeric|min:0',
            'notas' => 'nullable|string|max:1000',
        ]);

        $compra->update($request->only('proveedor_id', 'fecha', 'total', 'notas'));

        return redirect()->route('compras.index')->with('success', 'Compra actualizada exitosamente.');
    }

    public function destroy(Compra $compra)
    {
        $compra->delete();
        return redirect()->route('compras.index')->with('success', 'Compra eliminada exitosamente.');
    }
}
