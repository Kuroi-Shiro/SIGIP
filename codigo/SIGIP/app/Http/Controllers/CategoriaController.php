<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoriaController extends Controller
{
    public function index(): View
    {
        $categorias = Categoria::withCount('productos')
            ->orderBy('nombre')
            ->paginate(10);


        return view('categorias.index', compact('categorias'));
    }

    public function create(): View
    {
        return view('categorias.create');
    }


    public function store(Request $request): RedirectResponse
    {
        Categoria::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'activo' => true,

        ]);

        return redirect()
            ->route('categorias.index')
            ->with('exito', 'Categoría registrada.');
    }

    public function show(Categoria $categoria): View
    {
        $categoria->load('productos');

        return view('categorias.show', compact('categoria'));
    }


    public function edit(Categoria $categoria): View
    {
        return view('categorias.edit', compact('categoria'));
    }


    public function update(Request $request, Categoria $categoria): RedirectResponse
    {
        $categoria->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()
            ->route('categorias.index')
            ->with('exito', 'Categoría actualizada.');
    }

    
    public function destroy(Categoria $categoria): RedirectResponse
    {
        $categoria->delete();

        return redirect()
            ->route('categorias.index')
            ->with('exito', 'Categoría eliminada.');
    }
}