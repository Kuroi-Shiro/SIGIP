@extends('layouts.app')

@section('titulo', 'Detalle de categoría')

@section('contenido')
<div class="flex flex-col gap-6">

    <div class="flex items-start justify-between">
        <div>
            <h1 class="font-display text-2xl font-semibold mb-1">{{ $categoria->nombre }}</h1>
            <p class="text-sm text-muted">Detalle de la categoría</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('categorias.index') }}"
               class="px-4 py-2 rounded-lg text-sm font-medium border border-line text-muted hover:bg-white transition-colors">← Volver</a>
            <a href="{{ route('categorias.edit', $categoria) }}"
               class="px-4 py-2 rounded-lg text-sm font-medium text-white bg-sidebar hover:bg-primary transition-colors">Editar</a>

            @if($categoria->activo)
                <form action="{{ route('categorias.archivar', $categoria) }}" method="POST"
                      onsubmit="return confirm('¿Archivar esta categoría?');">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="px-4 py-2 rounded-lg text-sm font-medium border border-line text-muted hover:border-warning hover:text-warning transition-colors">Archivar</button>
                </form>
            @endif

            <form action="{{ route('categorias.destroy', $categoria) }}" method="POST"
                  onsubmit="return confirm('¿Eliminar esta categoría?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-4 py-2 rounded-lg text-sm font-medium border border-line text-muted hover:border-danger hover:text-danger transition-colors">Eliminar</button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- Información general --}}
        <div class="lg:col-span-1 bg-white border border-line rounded-xl p-5 self-start">
            <h3 class="font-semibold text-sm mb-4">Información general</h3>

            <div class="mb-4">
                <span class="block text-xs text-muted font-medium mb-1">Estado</span>
                @if($categoria->activo)
                    <span class="text-xs px-2 py-0.5 rounded-full font-medium bg-success/10 text-success">Activa</span>
                @else
                    <span class="text-xs px-2 py-0.5 rounded-full font-medium bg-muted/15 text-muted">Archivada</span>
                @endif
            </div>

            <div class="mb-4">
                <span class="block text-xs text-muted font-medium mb-1">Descripción</span>
                <p class="text-sm">{{ $categoria->descripcion ?: 'Sin descripción proporcionada.' }}</p>
            </div>

            <div>
                <span class="block text-xs text-muted font-medium mb-1">Fecha de registro</span>
                <p class="text-sm font-mono">{{ $categoria->created_at?->format('d/m/Y') }}</p>
            </div>
        </div>

        {{-- Productos asociados --}}
        <div class="lg:col-span-2 bg-white border border-line rounded-xl p-5">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-line">
                <h3 class="font-semibold text-sm">Productos asociados</h3>
                <span class="text-xs px-2 py-0.5 rounded-full font-medium bg-surface text-muted">{{ $categoria->productos->count() }}</span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs font-medium text-muted uppercase">
                            <th class="py-2 pr-4">Código</th>
                            <th class="py-2 pr-4">Producto</th>
                            <th class="py-2 pr-4">Precio</th>
                            <th class="py-2 pr-4">Stock</th>
                            <th class="py-2 pr-4">Estado</th>
                            <th class="py-2 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line">
                        @forelse($categoria->productos as $producto)
                            <tr>
                                <td class="py-3 pr-4 font-mono text-xs text-muted">{{ $producto->codigo }}</td>
                                <td class="py-3 pr-4 font-medium">{{ $producto->nombre }}</td>
                                <td class="py-3 pr-4 font-mono text-xs">${{ number_format($producto->precio, 2) }}</td>
                                <td class="py-3 pr-4 font-mono text-xs">
                                    <span @class([
                                        'font-semibold',
                                        'text-danger' => $producto->stock_actual <= $producto->stock_minimo,
                                        'text-ink' => $producto->stock_actual > $producto->stock_minimo,
                                    ])>{{ $producto->stock_actual }}</span>
                                    <span class="text-muted">/ mín. {{ $producto->stock_minimo }}</span>
                                </td>
                                <td class="py-3 pr-4">
                                    @if($producto->activo)
                                        <span class="text-xs px-2 py-0.5 rounded-full font-medium bg-success/10 text-success">Activo</span>
                                    @else
                                        <span class="text-xs px-2 py-0.5 rounded-full font-medium bg-muted/15 text-muted">Archivado</span>
                                    @endif
                                </td>
                                <td class="py-3 text-right">
                                    <a href="{{ route('productos.show', $producto) }}" class="text-info text-xs font-medium hover:underline">Ver</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-sm text-muted">
                                    No hay productos asignados a esta categoría todavía.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection