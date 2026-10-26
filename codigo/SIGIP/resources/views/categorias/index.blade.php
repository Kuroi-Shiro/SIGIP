@extends('layouts.app')

@section('titulo', 'Categorías')

@section('contenido')
<div class="flex flex-col gap-6">

    <div class="flex items-start justify-between">
        <div>
            <h1 class="font-display text-2xl font-semibold mb-1">Categorías</h1>
            <p class="text-sm text-muted">
                {{ $categorias->total() }} {{ $categorias->total() === 1 ? 'categoría activa' : 'categorías activas' }}
            </p>
        </div>
        <a href="{{ route('categorias.create') }}"
           class="px-4 py-2 rounded-lg text-sm font-medium text-white bg-sidebar hover:bg-primary transition-colors">
            + Nueva categoría
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($categorias as $categoria)
            <div class="bg-white border border-line hover:border-primary transition-colors rounded-xl p-5 flex flex-col">
                <div class="flex items-start justify-between mb-3">
                    <div>
                        <a href="{{ route('categorias.show', $categoria) }}" class="font-semibold text-sm hover:text-primary transition-colors">
                            {{ $categoria->nombre }}
                        </a>
                        <p class="text-xs text-muted mt-0.5">{{ $categoria->descripcion ?: 'Sin descripción' }}</p>
                    </div>
                    <span class="text-xs px-2 py-0.5 rounded-full font-medium flex-shrink-0 ml-2 bg-success/10 text-success">Activa</span>
                </div>

                <div class="mt-auto flex flex-wrap items-center justify-between gap-2 pt-3 border-t border-line">
                    <p class="text-xs text-muted">
                        <span class="font-mono font-semibold text-ink">{{ $categoria->productos_count }}</span>
                        {{ $categoria->productos_count === 1 ? 'producto' : 'productos' }}
                    </p>

                    <div class="flex items-center gap-3 text-xs font-medium">
                        <a href="{{ route('categorias.show', $categoria) }}" class="text-info hover:underline">Ver</a>
                        <a href="{{ route('categorias.edit', $categoria) }}" class="text-primary hover:underline">Editar</a>

                        <form action="{{ route('categorias.archivar', $categoria) }}" method="POST" class="inline"
                              onsubmit="return confirm('¿Archivar esta categoría?');">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-muted hover:text-ink hover:underline">Archivar</button>
                        </form>

                        <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" class="inline"
                              onsubmit="return confirm('¿Eliminar esta categoría?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-danger hover:underline">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 text-sm text-muted bg-white rounded-xl border border-dashed border-line">
                No hay categorías activas registradas.
            </div>
        @endforelse
    </div>

    <div>
        {{ $categorias->links() }}
    </div>
</div>
@endsection