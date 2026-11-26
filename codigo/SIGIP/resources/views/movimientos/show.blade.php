@extends('layouts.app')

@section('titulo', 'Detalle movimiento')

@section('contenido')
<div class="flex flex-col gap-6">

    <div class="flex items-start justify-between">
        <div>
            <h1 class="font-display text-2xl font-semibold mb-1">Movimiento #{{ $movimiento->id }}</h1>
            <p class="text-sm font-mono text-muted">{{ $movimiento->fecha_movimiento->format('d/m/Y H:i') }}</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('movimientos.index') }}"
               class="px-4 py-2 rounded-lg text-sm font-medium border border-line text-muted hover:bg-white transition-colors">← Volver</a>

            @if($movimiento->estado === 'activo')
                <a href="{{ route('movimientos.edit', $movimiento) }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium text-white bg-sidebar hover:bg-primary transition-colors">Editar</a>

                <form action="{{ route('movimientos.cancelar', $movimiento) }}" method="POST"
                      onsubmit="return confirm('¿Cancelar este movimiento? Se revertirá el cambio en el stock.');">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="px-4 py-2 rounded-lg text-sm font-medium border border-line text-muted hover:border-danger hover:text-danger transition-colors">Cancelar movimiento</button>
                </form>
            @endif
        </div>
    </div>

    @if($errors->any())
        <x-alert tipo="error">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </x-alert>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- Información del movimiento --}}
        <div class="lg:col-span-2 bg-white border border-line rounded-xl p-5">
            <h3 class="font-semibold text-sm mb-4 pb-3 border-b border-line">Información del Movimiento</h3>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <span class="block text-xs text-muted font-medium mb-1">Producto</span>
                    @if($movimiento->producto)
                        <a href="{{ route('productos.show', $movimiento->producto) }}" class="text-sm font-medium hover:text-primary transition-colors">
                            {{ $movimiento->producto->nombre }}
                        </a>
                        <p class="text-xs font-mono text-muted">{{ $movimiento->producto->codigo }}</p>
                    @else
                        <p class="text-sm text-muted">Producto eliminado</p>
                    @endif
                </div>
                <div>
                    <span class="block text-xs text-muted font-medium mb-1">Registrado por</span>
                    <p class="text-sm font-medium">{{ $movimiento->usuario->nombre ?? 'Sin usuario' }}</p>
                </div>
            </div>

            <div class="mb-4">
                <span class="block text-xs text-muted font-medium mb-1">Observaciones</span>
                <p class="text-sm">{{ $movimiento->observaciones ?: 'Sin observaciones.' }}</p>
            </div>
        </div>

        {{-- Tipo, cantidad y estado --}}
        <div class="lg:col-span-1 bg-white border border-line rounded-xl p-5 self-start">
            <h3 class="font-semibold text-sm mb-4 pb-3 border-b border-line">Resumen</h3>

            <div class="mb-4">
                <span class="block text-xs text-muted font-medium mb-1">Tipo</span>
                <span @class([
                    'text-xs px-2 py-0.5 rounded-full font-medium',
                    'bg-success/10 text-success' => $movimiento->tipo === 'entrada',
                    'bg-danger/10 text-danger' => $movimiento->tipo === 'salida',
                ])>{{ ucfirst($movimiento->tipo) }}</span>
            </div>

            <div class="mb-4">
                <span class="block text-xs text-muted font-medium mb-1">Cantidad</span>
                <div class="flex items-end gap-2">
                    <span @class([
                        'text-2xl font-mono font-semibold',
                        'text-success' => $movimiento->tipo === 'entrada',
                        'text-danger' => $movimiento->tipo === 'salida',
                    ])>{{ $movimiento->tipo === 'entrada' ? '+' : '−' }}{{ $movimiento->cantidad }}</span>
                    <span class="text-sm text-muted mb-1">unidades</span>
                </div>
            </div>

            <div class="mb-4">
                <span class="block text-xs text-muted font-medium mb-1">Estado</span>
                @if($movimiento->estado === 'activo')
                    <span class="text-xs px-2 py-0.5 rounded-full font-medium bg-success/10 text-success">Activo</span>
                @else
                    <span class="text-xs px-2 py-0.5 rounded-full font-medium bg-muted/15 text-muted">Cancelado</span>
                    <p class="text-xs text-muted mt-1">El stock ya fue revertido y no se puede modificar.</p>
                @endif
            </div>

            <div>
                <span class="block text-xs text-muted font-medium mb-1">Última actualización</span>
                <p class="text-sm font-mono">{{ $movimiento->updated_at?->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection