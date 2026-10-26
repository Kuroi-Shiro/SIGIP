<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use App\Models\Producto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class MovimientoController extends Controller
{
    public function index(): View
    {
        $movimientos = Movimiento::with(['producto', 'usuario'])
            ->orderByDesc('fecha_movimiento')
            ->paginate(10);

        return view('movimientos.index', compact('movimientos'));
    }



    public function create(): View
    {
        $productos = Producto::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('movimientos.create', compact('productos'));
    }



    public function store(Request $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $producto = Producto::lockForUpdate()
                ->findOrFail($request->producto_id);

            $cantidad = (int) $request->cantidad;

            $this->aplicarMovimiento(
                $producto,
                $request->tipo,
                $cantidad
            );

            Movimiento::create([
                'producto_id' => $producto->id,
                'usuario_id' => $request->usuario_id,
                'tipo' => $request->tipo,
                'cantidad' => $cantidad,
                'estado' => 'activo',
                'observaciones' => $request->observaciones,
                'fecha_movimiento' => $request->fecha_movimiento ?? now(),
            ]);
        });

        return redirect()
            ->route('movimientos.index')
            ->with('exito', 'Movimiento registrado correctamente.');
    }



    public function show(Movimiento $movimiento): View
    {
        $movimiento->load(['producto', 'usuario']);

        return view('movimientos.show', compact('movimiento'));
    }



    public function edit(Movimiento $movimiento): View
    {
        $productos = Producto::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view(
            'movimientos.edit',
            compact('movimiento', 'productos')
        );
    }



    public function update(
        Request $request,
        Movimiento $movimiento
    ): RedirectResponse {
        DB::transaction(function () use ($request, $movimiento) {
            if ($movimiento->estado === 'cancelado') {
                throw ValidationException::withMessages([
                    'estado' => 'No se puede modificar un movimiento cancelado.',
                ]);
            }

            $productoAnterior = Producto::lockForUpdate()
                ->findOrFail($movimiento->producto_id);

            $this->revertirMovimiento(
                $productoAnterior,
                $movimiento->tipo,
                $movimiento->cantidad
            );

            $productoNuevo = Producto::lockForUpdate()
                ->findOrFail($request->producto_id);

            $cantidadNueva = (int) $request->cantidad;

            $this->aplicarMovimiento(
                $productoNuevo,
                $request->tipo,
                $cantidadNueva
            );

            $movimiento->update([
                'producto_id' => $productoNuevo->id,
                'tipo' => $request->tipo,
                'cantidad' => $cantidadNueva,
                'observaciones' => $request->observaciones,
                'fecha_movimiento' => $request->fecha_movimiento,
            ]);
        });

        return redirect()
            ->route('movimientos.index')
            ->with('exito', 'Movimiento actualizado correctamente.');
    }



    public function cancelar(Movimiento $movimiento): RedirectResponse
    {
        DB::transaction(function () use ($movimiento) {
            if ($movimiento->estado === 'cancelado') {
                throw ValidationException::withMessages([
                    'estado' => 'El movimiento ya se encuentra cancelado.',
                ]);
            }

            $producto = Producto::lockForUpdate()
                ->findOrFail($movimiento->producto_id);

            $this->revertirMovimiento(
                $producto,
                $movimiento->tipo,
                $movimiento->cantidad
            );

            $movimiento->update([
                'estado' => 'cancelado',
            ]);
        });

        return redirect()
            ->route('movimientos.index')
            ->with('exito', 'Movimiento cancelado correctamente.');
    }



    private function aplicarMovimiento(
        Producto $producto,
        string $tipo,
        int $cantidad
    ): void {
        if ($tipo === 'entrada') {
            $producto->increment('stock_actual', $cantidad);

            return;
        }

        if ($tipo === 'salida') {
            if ($producto->stock_actual < $cantidad) {
                throw ValidationException::withMessages([
                    'cantidad' => 'Existencia insuficiente del producto.',
                ]);
            }

            $producto->decrement('stock_actual', $cantidad);
        }
    }

    

    private function revertirMovimiento(
        Producto $producto,
        string $tipo,
        int $cantidad
    ): void {
        if ($tipo === 'entrada') {
            if ($producto->stock_actual < $cantidad) {
                throw ValidationException::withMessages([
                    'cantidad' => 'No es posible realizar la operación porque la existencia quedaría negativa.',
                ]);
            }

            $producto->decrement('stock_actual', $cantidad);

            return;
        }

        if ($tipo === 'salida') {
            $producto->increment('stock_actual', $cantidad);
        }
    }
}