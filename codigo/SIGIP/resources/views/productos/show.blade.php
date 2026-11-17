@extends('layouts.app')

@section('titulo', 'detalle producto')

@section('contenido')
<div class="flex flex-col gap-6">

    <div class="flex items-start justify-between">
        <div>
            <h1 class="font-display text-2xl font-semibold mb-1">{{ $producto->nombre }}</h1>
            <p class="text-sm font-mono text-muted">Código: {{ $producto->codigo }}</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('productos.index') }}"
               class="px-4 py-2 rounded-lg text-sm font-medium border border-line text-muted hover:bg-white transition-colors">← Volver</a>
            <a href="{{ route('productos.edit', $producto) }}"
               class="px-4 py-2 rounded-lg text-sm font-medium text-white bg-sidebar hover:bg-primary transition-colors">Editar</a>
            
            <form action="{{ route('productos.destroy', $producto) }}" method="POST"
                  onsubmit="return confirm('¿Eliminar este producto permanentemente?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-4 py-2 rounded-lg text-sm font-medium border border-line text-muted hover:border-danger hover:text-danger transition-colors">Eliminar</button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        
        {{-- Tarjeta de Información General --}}
        <div class="lg:col-span-2 bg-white border border-line rounded-xl p-5">
            <h3 class="font-semibold text-sm mb-4 pb-3 border-b border-line">Información del Producto</h3>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <span class="block text-xs text-muted font-medium mb-1">Categoría</span>
                    <p class="text-sm font-medium">{{ $producto->categoria->nombre ?? 'Sin asignar' }}</p>
                </div>
                <div>
                    <span class="block text-xs text-muted font-medium mb-1">Precio Unitario</span>
                    <p class="text-sm font-mono text-ink">${{ number_format($producto->precio, 2) }}</p>
                </div>
            </div>

            <div class="mb-4">
                <span class="block text-xs text-muted font-medium mb-1">Descripción</span>
                <p class="text-sm">{{ $producto->descripcion ?: 'No hay descripción detallada.' }}</p>
            </div>
        </div>

        {{-- Tarjeta de Estado e Inventario --}}
        <div class="lg:col-span-1 bg-white border border-line rounded-xl p-5 self-start">
            <h3 class="font-semibold text-sm mb-4 pb-3 border-b border-line">Estado de Inventario</h3>

            <div class="mb-4">
                <span class="block text-xs text-muted font-medium mb-1">Estatus del sistema</span>
                @if($producto->activo)
                    <span class="text-xs px-2 py-0.5 rounded-full font-medium bg-success/10 text-success">Activo</span>
                @else
                    <span class="text-xs px-2 py-0.5 rounded-full font-medium bg-muted/15 text-muted">Archivado</span>
                @endif
            </div>

            <div class="mb-4">
                <span class="block text-xs text-muted font-medium mb-1">Stock Actual</span>
                <div class="flex items-end gap-2">
                    <span @class([
                        'text-2xl font-mono font-semibold',
                        'text-danger' => $producto->stock_actual <= $producto->stock_minimo,
                        'text-ink' => $producto->stock_actual > $producto->stock_minimo,
                    ])>
                        {{ $producto->stock_actual }}
                    </span>
                    <span class="text-sm text-muted mb-1">unidades</span>
                </div>
                @if($producto->stock_actual <= $producto->stock_minimo)
                    <p class="text-xs text-danger mt-1">Alerta: Por debajo o igual al mínimo permitido ({{ $producto->stock_minimo }}).</p>
                @endif
            </div>

            <div>
                <span class="block text-xs text-muted font-medium mb-1">Última actualización</span>
                <p class="text-sm font-mono">{{ $producto->updated_at?->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection