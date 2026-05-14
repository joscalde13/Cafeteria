<?php

namespace App\Http\Controllers;

use App\Models\Impuesto;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class ImpuestoController extends Controller implements HasMiddleware
{
    /**
     * Middleware: solo admin puede gestionar impuestos.
     */
    public static function middleware(): array
    {
        return ['role:admin'];
    }

    public function index()
    {
        $impuestos = Impuesto::latest()->paginate(10);
        return view('impuestos.index', compact('impuestos'));
    }

    public function create()
    {
        return view('impuestos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'porcentaje' => 'required|numeric|min:0|max:100',
            'activo' => 'sometimes|boolean',
            'recordatorio_pago' => 'nullable|date',
        ]);

        Impuesto::create([
            'nombre' => $request->nombre,
            'porcentaje' => $request->porcentaje,
            'activo' => $request->has('activo'),
            'recordatorio_pago' => $request->recordatorio_pago,
        ]);

        return redirect()->route('impuestos.index')->with('success', 'Impuesto creado exitosamente.');
    }

    public function edit(Impuesto $impuesto)
    {
        return view('impuestos.edit', compact('impuesto'));
    }

    public function update(Request $request, Impuesto $impuesto)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'porcentaje' => 'required|numeric|min:0|max:100',
            'activo' => 'sometimes|boolean',
            'recordatorio_pago' => 'nullable|date',
        ]);

        $impuesto->update([
            'nombre' => $request->nombre,
            'porcentaje' => $request->porcentaje,
            'activo' => $request->has('activo'),
            'recordatorio_pago' => $request->recordatorio_pago,
        ]);

        return redirect()->route('impuestos.index')->with('success', 'Impuesto actualizado exitosamente.');
    }

    public function destroy(Impuesto $impuesto)
    {
        $impuesto->delete();
        return redirect()->route('impuestos.index')->with('success', 'Impuesto eliminado exitosamente.');
    }
}
