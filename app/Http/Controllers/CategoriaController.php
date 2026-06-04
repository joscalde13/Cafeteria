<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class CategoriaController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return ['role:admin'];
    }

    // LISTADO DE CATEGORIAS
    public function index()
    {
        $categorias = Categoria::withCount('productos')->latest()->paginate(10);
        return view('categorias.index', compact('categorias'));
    }

    // FORMULARIO DE CREACION
    public function create()
    {
        return view('categorias.create');
    }

    // GUARDAR NUEVA CATEGORIA
    public function store(Request $request)
    {
        // VALIDACION DE DATOS
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre',
            'descripcion' => 'nullable|string|max:1000',
        ]);

        // PERSISTENCIA
        Categoria::create($request->only('nombre', 'descripcion'));

        return redirect()->route('categorias.index')->with('success', 'Categoría creada exitosamente.');
    }

    // DETALLE DE CATEGORIA
    public function show(Categoria $categoria)
    {
        $categoria->load('productos');
        return view('categorias.show', compact('categoria'));
    }

    // FORMULARIO DE EDICION
    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    // ACTUALIZAR CATEGORIA
    public function update(Request $request, Categoria $categoria)
    {
        // VALIDACION DE DATOS
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre,' . $categoria->id,
            'descripcion' => 'nullable|string|max:1000',
        ]);

        // PERSISTENCIA
        $categoria->update($request->only('nombre', 'descripcion'));

        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    // ELIMINAR CATEGORIA
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada exitosamente.');
    }
}
