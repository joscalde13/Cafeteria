<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class ProveedorController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return ['role:admin'];
    }

    // LISTADO DE PROVEEDORES
    public function index()
    {
        $proveedores = Proveedor::withCount('compras')->latest()->paginate(10);
        return view('proveedores.index', compact('proveedores'));
    }

    // FORMULARIO DE CREACION
    public function create()
    {
        return view('proveedores.create');
    }

    // GUARDAR NUEVO PROVEEDOR
    public function store(Request $request)
    {
        // VALIDACION DE DATOS
        $request->validate([
            'nombre' => 'required|string|max:255',
            'contacto' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'direccion' => 'nullable|string|max:500',
        ]);

        // PERSISTENCIA
        Proveedor::create($request->only('nombre', 'contacto', 'telefono', 'email', 'direccion'));

        return redirect()->route('proveedores.index')->with('success', 'Proveedor creado exitosamente.');
    }

    // DETALLE DE PROVEEDOR
    public function show(Proveedor $proveedore)
    {
        $proveedore->load('compras');
        return view('proveedores.show', compact('proveedore'));
    }

    // FORMULARIO DE EDICION
    public function edit(Proveedor $proveedore)
    {
        return view('proveedores.edit', compact('proveedore'));
    }

    // ACTUALIZAR PROVEEDOR
    public function update(Request $request, Proveedor $proveedore)
    {
        // VALIDACION DE DATOS
        $request->validate([
            'nombre' => 'required|string|max:255',
            'contacto' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'direccion' => 'nullable|string|max:500',
        ]);

        // PERSISTENCIA
        $proveedore->update($request->only('nombre', 'contacto', 'telefono', 'email', 'direccion'));

        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado exitosamente.');
    }

    // ELIMINAR PROVEEDOR
    public function destroy(Proveedor $proveedore)
    {
        $proveedore->delete();
        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado exitosamente.');
    }
}
