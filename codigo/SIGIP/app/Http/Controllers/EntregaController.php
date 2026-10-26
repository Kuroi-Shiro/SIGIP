<?php

namespace App\Http\Controllers;

use App\Models\Entrega;
use App\Models\Producto;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\ActualizarEntregaRequest;
use App\Http\Requests\GuardarEntregaRequest;
use Illuminate\Support\Facades\DB;

class EntregaController extends Controller
{
    public function index(): View
    {
        $entregas = Entrega::with(['usuario', 'productos'])
            ->orderByDesc('fecha_entrega')
            ->paginate(10);

        return view('entregas.index', compact('entregas'));
    }



    public function create(): View
    {
        $productos = Producto::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('entregas.create', compact('productos'));
    }



    public function store(GuardarEntregaRequest $request): RedirectResponse
    {
        $datos = $request->validated();

        $productosSolicitud = $datos['productos'];
        unset($datos['productos']);

        DB::transaction(function () use ($datos, $productosSolicitud) {
            $entrega = Entrega::create($datos);

            $productos = [];

            foreach ($productosSolicitud as $producto) {
                $productos[$producto['producto_id']] = [
                    'cantidad' => $producto['cantidad'],
                ];
            }

            $entrega->productos()->sync($productos);
        });

        return redirect()
            ->route('entregas.index')
            ->with('exito', 'Entrega registrada correctamente.');
    }



    public function show(Entrega $entrega): View
    {
        $entrega->load(['usuario', 'productos']);

        return view('entregas.show', compact('entrega'));
    }



    public function edit(Entrega $entrega): View
    {
        $entrega->load('productos');

        $productos = Producto::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view(
            'entregas.edit',
            compact('entrega', 'productos')
        );
    }



    public function update( ActualizarEntregaRequest $request, Entrega $entrega): RedirectResponse 
    {
        $datos = $request->validated();

        $productosSolicitud = $datos['productos'];
        unset($datos['productos']);

        DB::transaction(function () use (
            $datos,
            $productosSolicitud,
            $entrega
        ) {
            $entrega->update($datos);

            $productos = [];

            foreach ($productosSolicitud as $producto) {
                $productos[$producto['producto_id']] = [
                    'cantidad' => $producto['cantidad'],
                ];
            }

            $entrega->productos()->sync($productos);
        });

        return redirect()
            ->route('entregas.index')
            ->with('exito', 'Entrega actualizada correctamente.');
    }



    public function destroy(Entrega $entrega): RedirectResponse
    {
        $entrega->productos()->detach();

        $entrega->delete();

        return redirect()
            ->route('entregas.index')
            ->with('exito', 'Entrega eliminada.');
    }
}