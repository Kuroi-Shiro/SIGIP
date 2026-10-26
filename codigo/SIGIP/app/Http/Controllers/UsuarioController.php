<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Http\Requests\ActualizarUsuarioRequest;
use App\Http\Requests\GuardarUsuarioRequest;

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



    public function store(GuardarUsuarioRequest $request): RedirectResponse
    {
        $datos = $request->validated();

        unset($datos['password_confirmation']);

        $datos['password'] = Hash::make($datos['password']);
        $datos['activo'] = true;

        Usuario::create($datos);

        return redirect()
            ->route('usuarios.index')
            ->with('exito', 'Usuario registrado correctamente.');
    }



    public function show(Usuario $usuario): View
    {
        return view('usuarios.show', compact('usuario'));
    }
    


    public function edit(Usuario $usuario): View
    {
        return view('usuarios.edit', compact('usuario'));
    }



    public function update( ActualizarUsuarioRequest $request, Usuario $usuario): RedirectResponse 
    {
        $datos = $request->validated();

        unset($datos['password_confirmation']);

        if (!empty($datos['password'])) {
            $datos['password'] = Hash::make($datos['password']);
        } else {
            unset($datos['password']);
        }

        $usuario->update($datos);

        return redirect()
            ->route('usuarios.index')
            ->with('exito', 'Usuario actualizado correctamente.');
    }



    public function destroy(Usuario $usuario): RedirectResponse
    {
        $usuario->delete();

        return redirect()
            ->route('usuarios.index')
            ->with('exito', 'Usuario eliminado.');
    }



    public function archivar(Usuario $usuario): RedirectResponse
    {
        if (!$usuario->activo) {
            return redirect()
                ->route('usuarios.index')
                ->with('error', 'El usuario ya se encuentra archivado.');
        }

        $usuario->update([
            'activo' => false,
        ]);

        return redirect()
            ->route('usuarios.index')
            ->with('exito', 'Usuario archivado.');
    }
}