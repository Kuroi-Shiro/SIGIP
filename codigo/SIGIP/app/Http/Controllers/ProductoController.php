<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductoController extends Controller
{
    public function index(): View
    {
        $productos = Producto::with('categoria')
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



    public function store(Request $request): RedirectResponse
    {
        $datos = [
            'categoria_id' => $request->categoria_id,
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'stock_actual' => $request->stock_actual,
            'stock_minimo' => $request->stock_minimo,
            'activo' => true,
        ];

        if ($request->hasFile('imagen')) {
            $datos['imagen'] = $request->file('imagen')
                ->store('productos', 'public');
        }

        Producto::create($datos);

        return redirect()
            ->route('productos.index')
            ->with('exito', 'Producto registrado.');
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



    public function update(
        Request $request,
        Producto $producto
    ): RedirectResponse {
        $datos = [
            'categoria_id' => $request->categoria_id,
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'stock_actual' => $request->stock_actual,
            'stock_minimo' => $request->stock_minimo,
        ];

        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }

            $datos['imagen'] = $request->file('imagen')
                ->store('productos', 'public');
        }

        $producto->update($datos);

        return redirect()
            ->route('productos.index')
            ->with('exito', 'Producto actualizado.');
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
}