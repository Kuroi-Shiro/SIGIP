<?php

namespace App\Http\Controllers;

use App\Models\Entrega;
use App\Models\Producto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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



    public function store(Request $request): RedirectResponse
    {
        $entrega = Entrega::create([
            'usuario_id' => $request->usuario_id,
            'cliente' => $request->cliente,
            'telefono_cliente' => $request->telefono_cliente,
            'destino' => $request->destino,
            'estado' => $request->estado,
            'fecha_entrega' => $request->fecha_entrega,
            'observaciones' => $request->observaciones,
        ]);

        $productos = [];

        foreach ($request->productos ?? [] as $producto) {
            $productos[$producto['producto_id']] = [
                'cantidad' => $producto['cantidad'],
            ];
        }

        $entrega->productos()->sync($productos);

        return redirect()
            ->route('entregas.index')
            ->with('exito', 'Entrega registrada.');
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



    public function update(
        Request $request,
        Entrega $entrega
    ): RedirectResponse {
        $entrega->update([
            'cliente' => $request->cliente,
            'telefono_cliente' => $request->telefono_cliente,
            'destino' => $request->destino,
            'estado' => $request->estado,
            'fecha_entrega' => $request->fecha_entrega,
            'observaciones' => $request->observaciones,
        ]);

        $productos = [];

        foreach ($request->productos ?? [] as $producto) {
            $productos[$producto['producto_id']] = [
                'cantidad' => $producto['cantidad'],
            ];
        }

        $entrega->productos()->sync($productos);

        return redirect()
            ->route('entregas.index')
            ->with('exito', 'Entrega actualizada.');
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