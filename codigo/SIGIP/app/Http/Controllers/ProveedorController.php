<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ActualizarProveedorRequest;
use App\Http\Requests\GuardarProveedorRequest;
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



    public function store(GuardarProveedorRequest $request): RedirectResponse
    {
        $datos = $request->validated();

        $productos = $datos['producto_ids'];
        unset($datos['producto_ids']);

        $datos['activo'] = true;

        $proveedor = Proveedor::create($datos);

        $proveedor->productos()->sync($productos);

        return redirect()
            ->route('proveedores.index')
            ->with('exito', 'Proveedor registrado correctamente.');
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



    public function update( ActualizarProveedorRequest $request, Proveedor $proveedor ): RedirectResponse 
    {
        $datos = $request->validated();

        $productos = $datos['producto_ids'];
        unset($datos['producto_ids']);

        $proveedor->update($datos);

        $proveedor->productos()->sync($productos);

        return redirect()
            ->route('proveedores.index')
            ->with('exito', 'Proveedor actualizado correctamente.');
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