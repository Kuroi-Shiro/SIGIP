<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProveedorController extends Controller
{
    public function index(): View
    {
        $proveedores = Proveedor::withCount('productos')
            ->orderBy('nombre')
            ->paginate(10);


        return view('proveedores.index', compact('proveedores'));
    }



    public function create(): View
    {
        $productos = Producto::where('activo', true)
            ->orderBy('nombre')
            ->get();

            
        return view('proveedores.create', compact('productos'));
    }



    public function store(Request $request): RedirectResponse
    {
        $proveedor = Proveedor::create([
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'direccion' => $request->direccion,
            'activo' => true,
        ]);

        if ($request->filled('producto_ids')) {
            $proveedor->productos()->sync($request->producto_ids);
        }

        return redirect()
            ->route('proveedores.index')
            ->with('exito', 'Proveedor registrado.');
    }



    public function show(Proveedor $proveedor): View
    {
        $proveedor->load('productos');

        return view('proveedores.show', compact('proveedor'));
    }



    public function edit(Proveedor $proveedor): View
    {
        $proveedor->load('productos');

        $productos = Producto::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view(
            'proveedores.edit',
            compact('proveedor', 'productos')
        );
    }



    public function update(
        Request $request,
        Proveedor $proveedor
    ): RedirectResponse {
        $proveedor->update([
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'direccion' => $request->direccion,
        ]);

        if ($request->has('producto_ids')) {
            $proveedor->productos()->sync($request->producto_ids ?? []);
        }

        return redirect()
            ->route('proveedores.index')
            ->with('exito', 'Proveedor actualizado.');
    }



    public function destroy(Proveedor $proveedor): RedirectResponse
    {
        $proveedor->productos()->detach();

        $proveedor->delete();

        return redirect()
            ->route('proveedores.index')
            ->with('exito', 'Proveedor eliminado.');
    }
}