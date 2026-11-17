@extends('layouts.app')

@section('titulo', 'Productos')

@section('contenido')
<div class="flex flex-col gap-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="font-display text-2xl font-semibold mb-1">Productos</h1>
                <p class="text-sm text-muted">
                    {{ $productos->total() }} {{ $productos->total() === 1 ? 'activo' : 'activos' }}
                    · {{ $archivados->count() }} {{ $archivados->count() === 1 ? 'archivado' : 'archivados' }}
                </p>
            </div>
            <a href="{{ route('productos.create') }}"
            class="px-4 py-2 rounded-lg text-sm font-medium text-white bg-sidebar hover:bg-primary transition-colors">
                + Nuevo producto
            </a>
        </div>
        <div class="bg-white border border-line rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left text-xs font-medium text-muted uppercase bg-surface/30 border-b border-line">
                        <th class="py-3 px-4">Código</th>
                        <th class="py-3 px-4">Producto</th>
                        <th class="py-3 px-4">Categoría</th>
                        <th class="py-3 px-4">Precio</th>
                        <th class="py-3 px-4">Stock</th>
                        <th class="py-3 px-4">Estado</th>
                        <th class="py-3 px-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    @forelse ($productos as $producto)
                        <tr class="hover:bg-surface/30 transition-colors">
                                <td class="py-3 px-4 font-mono text-xs text-muted">{{ $producto->codigo }}</td>
                                <td class="py-3 px-4 font-medium text-ink">
                                    <a href="{{ route('productos.show', $producto) }}" class="hover:text-primary transition-colors">
                                        {{ $producto->nombre }}
                                    </a>
                                </td>
                                <td class="py-3 px-4 text-muted">{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
                                <td class="py-3 px-4 font-mono text-xs">${{ number_format($producto->precio, 2) }}</td>
                                <td class="py-3 px-4 font-mono text-xs">
                                    <span @class([
                                        'font-semibold',
                                        'text-danger' => $producto->stock_actual <= $producto->stock_minimo,
                                        'text-ink' => $producto->stock_actual > $producto->stock_minimo,
                                    ])>{{ $producto->stock_actual }}</span>
                                    <span class="text-muted/60">/ {{ $producto->stock_minimo }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-xs px-2 py-0.5 rounded-full font-medium bg-success/10 text-success">Activo</span>
                                </td>
                                <td class="py-3 px-4 text-right flex justify-end gap-3 font-medium text-xs">
                                    <a href="{{ route('productos.show', $producto) }}" class="text-info hover:underline">Ver</a>
                                    <a href="{{ route('productos.edit', $producto) }}" class="text-primary hover:underline">Editar</a>
                                    <form action="{{ route('productos.archivar', $producto) }}" method="POST" class="inline"
                                        onsubmit="return confirm('¿Archivar este producto?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-muted hover:text-ink hover:underline">Archivar</button>
                                    </form>
                                </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-sm text-center text-muted">
                                No hay productos activos.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($productos->hasPages())
            <div class="p-4 border-t border-line">
                {{ $productos->links() }}
            </div>
        @endif
    </div>

    @if($archivados->isNotEmpty())
        <div>
            <div class="text-sm font-medium text-muted mb-3">Archivados ({{ $archivados->count() }})</div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($archivados as $producto)
                    <div class="rounded-xl p-5 border border-dashed border-line bg-surface/50 flex justify-between items-center">
                        <div>
                            <div class="font-medium text-sm text-muted">{{ $producto->nombre }}</div>
                            <p class="text-xs text-muted/60 font-mono mt-0.5">{{ $producto->codigo }}</p>
                        </div>
                        <form action="{{ route('productos.restaurar', $producto) }}" method="POST"
                              onsubmit="return confirm('¿Restaurar este producto?');">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-xs px-2.5 py-1 rounded-lg border border-line text-muted hover:border-success hover:text-success transition-colors">
                                Restaurar
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection