<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UsuarioController extends Controller implements HasMiddleware
{
    /**
     * Middleware: solo admin puede gestionar usuarios.
     */
    public static function middleware(): array
    {
        return ['role:admin'];
    }

    // LISTADO DE USUARIOS
    public function index()
    {
        $usuarios = User::latest()->paginate(10);
        return view('usuarios.index', compact('usuarios'));
    }

    // FORMULARIO DE CREACION
    public function create()
    {
        return view('usuarios.create');
    }

    // GUARDAR NUEVO USUARIO
    public function store(Request $request)
    {
        // VALIDACION DE DATOS
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => 'required|in:admin,employee',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    // FORMULARIO DE EDICION
    public function edit(User $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    // ACTUALIZAR USUARIO
    public function update(Request $request, User $usuario)
    {
        // VALIDACION DE DATOS
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $usuario->id,
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'role' => 'required|in:admin,employee',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    // ELIMINAR USUARIO
    public function destroy(User $usuario)
    {
        // VALIDACION: NO SE PUEDE ELIMINAR A SI MISMO
        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}
