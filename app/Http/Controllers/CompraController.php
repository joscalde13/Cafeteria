<?php

namespace App\Http\Controllers;

use App\Models\Compra;
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

    // LISTADO DE COMPRAS
    public function index()
    {
        $compras = Compra::latest()->paginate(10);
        return view('compras.index', compact('compras'));
    }

    // FORMULARIO DE CREACION
    public function create()
    {
        return view('compras.create');
    }

    // GUARDAR NUEVA COMPRA
    public function store(Request $request)
    {
        // VALIDACION DE DATOS
        $data = $request->validate([
            'concepto' => 'required|string|max:255',
            'fecha' => 'required|date',
            'cantidad' => 'required|numeric|min:0.01',
            'precio_unitario' => 'required|numeric|min:0',
            'notas' => 'nullable|string|max:1000',
        ]);

        // CALCULO Y PERSISTENCIA
        $data['total'] = round(((float) $data['cantidad']) * ((float) $data['precio_unitario']), 2);
        Compra::create($data);

        return redirect()->route('compras.index')->with('success', 'Compra registrada exitosamente.');
    }

    // DETALLE DE COMPRA
    public function show(Compra $compra)
    {
        return view('compras.show', compact('compra'));
    }

    // FORMULARIO DE EDICION
    public function edit(Compra $compra)
    {
        return view('compras.edit', compact('compra'));
    }

    // ACTUALIZAR COMPRA
    public function update(Request $request, Compra $compra)
    {
        // VALIDACION DE DATOS
        $data = $request->validate([
            'concepto' => 'required|string|max:255',
            'fecha' => 'required|date',
            'cantidad' => 'required|numeric|min:0.01',
            'precio_unitario' => 'required|numeric|min:0',
            'notas' => 'nullable|string|max:1000',
        ]);

        // CALCULO Y ACTUALIZACION
        $data['total'] = round(((float) $data['cantidad']) * ((float) $data['precio_unitario']), 2);
        $compra->update($data);

        return redirect()->route('compras.index')->with('success', 'Compra actualizada exitosamente.');
    }

    // ELIMINAR COMPRA
    public function destroy(Compra $compra)
    {
        $compra->delete();
        return redirect()->route('compras.index')->with('success', 'Compra eliminada exitosamente.');
    }
}
