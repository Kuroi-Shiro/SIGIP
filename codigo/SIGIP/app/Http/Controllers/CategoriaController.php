<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarCategoriaRequest;
use App\Http\Requests\GuardarCategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoriaController extends Controller
{
    public function index(): View
    {
        $categorias = Categoria::withCount('productos')
            ->where('activo', true)
            ->orderBy('nombre')
            ->paginate(10);

        return view('categorias.index', compact('categorias'));
    }


    public function create(): View
    {
        return view('categorias.create');

    }


    public function store(GuardarCategoriaRequest $request): RedirectResponse
    {

        Categoria::create([
            ...$request->validated(),
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

    public function update(

        ActualizarCategoriaRequest $request,
        Categoria $categoria

    ): RedirectResponse {
        $categoria->update($request->validated());

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



    public function archivar(Categoria $categoria): RedirectResponse
    {
        if (!$categoria->activo) {
            return redirect()
                ->route('categorias.index')
                ->with('error', 'La categoría ya se encuentra archivada.');
        }

        $categoria->update([
            'activo' => false,
        ]);

        return redirect()
            ->route('categorias.index')
            ->with('exito', 'Categoría archivada.');
    }
}