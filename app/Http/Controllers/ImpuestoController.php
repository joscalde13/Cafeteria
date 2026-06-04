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

    // LISTADO DE IMPUESTOS
    public function index()
    {
        $impuestos = Impuesto::latest()->paginate(10);
        return view('impuestos.index', compact('impuestos'));
    }

    // FORMULARIO DE CREACION
    public function create()
    {
        return view('impuestos.create');
    }

    // GUARDAR NUEVO IMPUESTO
    public function store(Request $request)
    {
        // VALIDACION DE DATOS
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

    // FORMULARIO DE EDICION
    public function edit(Impuesto $impuesto)
    {
        return view('impuestos.edit', compact('impuesto'));
    }

    // ACTUALIZAR IMPUESTO
    public function update(Request $request, Impuesto $impuesto)
    {
        // VALIDACION DE DATOS
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

    // ELIMINAR IMPUESTO
    public function destroy(Impuesto $impuesto)
    {
        $impuesto->delete();
        return redirect()->route('impuestos.index')->with('success', 'Impuesto eliminado exitosamente.');
    }
}
