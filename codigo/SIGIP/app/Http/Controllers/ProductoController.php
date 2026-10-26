<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Http\Requests\ActualizarProductoRequest;
use App\Http\Requests\GuardarProductoRequest;

class ProductoController extends Controller
{
    public function index(): View
    {
        $productos = Producto::with('categoria')
            ->where('activo', true)
            ->orderBy('nombre')
            ->paginate(10);

        return view('productos.index', compact('productos'));
    }



    public function create(): View
    {
        $categorias = Categoria::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('productos.create', compact('categorias'));
    }



    public function store(GuardarProductoRequest $request): RedirectResponse
    {
        $datos = $request->validated();

        if ($request->hasFile('imagen')) {
            $datos['imagen'] = $request->file('imagen')
                ->store('productos', 'public');
        }

        $datos['activo'] = true;

        Producto::create($datos);

        return redirect()
            ->route('productos.index')
            ->with('exito', 'Producto registrado correctamente.');
    }



    public function show(Producto $producto): View
    {
        $producto->load(['categoria', 'proveedores']);

        return view('productos.show', compact('producto'));
    }



    public function edit(Producto $producto): View
    {
        $categorias = Categoria::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('productos.edit', compact('producto', 'categorias'));
    }



    public function update( ActualizarProductoRequest $request, Producto $producto): RedirectResponse {
        $datos = $request->validated();

        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }

            $datos['imagen'] = $request->file('imagen')
                ->store('productos', 'public');
        } else {
            unset($datos['imagen']);
        }

        $producto->update($datos);

        return redirect()
            ->route('productos.index')
            ->with('exito', 'Producto actualizado correctamente.');
    }



    public function destroy(Producto $producto): RedirectResponse
    {
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        return redirect()
            ->route('productos.index')
            ->with('exito', 'Producto eliminado.');
    }



    public function archivar(Producto $producto): RedirectResponse
    {
        if (!$producto->activo) {
            return redirect()
                ->route('productos.index')
                ->with('error', 'El producto ya se encuentra archivado.');
        }

        $producto->update([
            'activo' => false,
        ]);

        return redirect()
            ->route('productos.index')
            ->with('exito', 'Producto archivado.');
    }
}