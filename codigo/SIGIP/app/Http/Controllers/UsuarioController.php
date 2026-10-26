<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UsuarioController extends Controller
{
    public function index(): View
    {
        $usuarios = Usuario::orderBy('nombre')
            ->paginate(10);

        return view('usuarios.index', compact('usuarios'));
    }



    public function create(): View
    {
        return view('usuarios.create');
    }



    public function store(Request $request): RedirectResponse
    {
        Usuario::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
            'activo' => true,
        ]);

        return redirect()
            ->route('usuarios.index')
            ->with('exito', 'Usuario registrado.');
    }



    public function show(Usuario $usuario): View
    {
        return view('usuarios.show', compact('usuario'));
    }
    


    public function edit(Usuario $usuario): View
    {
        return view('usuarios.edit', compact('usuario'));
    }



    public function update(
        Request $request,
        Usuario $usuario
    ): RedirectResponse {
        $datos = [
            'nombre' => $request->nombre,
            'email' => $request->email,
            'rol' => $request->rol,
        ];

        if ($request->filled('password')) {
            $datos['password'] = Hash::make($request->password);
        }

        $usuario->update($datos);

        return redirect()
            ->route('usuarios.index')
            ->with('exito', 'Usuario actualizado.');
    }



    public function destroy(Usuario $usuario): RedirectResponse
    {
        $usuario->delete();

        return redirect()
            ->route('usuarios.index')
            ->with('exito', 'Usuario eliminado.');
    }
}