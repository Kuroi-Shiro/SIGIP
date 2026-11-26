@extends('layouts.app')

@section('titulo', 'Categorías')

@section('contenido')
<div class="flex flex-col gap-6">

    <div class="flex items-start justify-between">
        <div>
            <h1 class="font-display text-2xl font-semibold mb-1">Categorías</h1>
            <p class="text-sm text-muted">
                {{ $categorias->total() }} {{ $categorias->total() === 1 ? 'activa' : 'activas' }}
                · {{ $archivadas->count() }} {{ $archivadas->count() === 1 ? 'archivada' : 'archivadas' }}
            </p>
        </div>
        <a href="{{ route('categorias.create') }}"
           class="px-4 py-2 rounded-lg text-sm font-medium text-white bg-sidebar hover:bg-primary transition-colors">
            + Nueva categoría
        </a>
    </div>

    {{-- Activas --}}
    <div class="bg-white border border-line rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left text-xs font-medium text-muted uppercase bg-surface/30 border-b border-line">
                        <th class="py-3 px-4">Nombre</th>
                        <th class="py-3 px-4">Descripción</th>
                        <th class="py-3 px-4">Productos</th>
                        <th class="py-3 px-4">Estado</th>
                        <th class="py-3 px-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    @forelse($categorias as $categoria)
                        <tr class="hover:bg-surface/30 transition-colors">
                            <td class="py-3 px-4 font-medium text-ink">
                                <a href="{{ route('categorias.show', $categoria) }}" class="hover:text-primary transition-colors">
                                    {{ $categoria->nombre }}
                                </a>
                            </td>
                            <td class="py-3 px-4 text-muted max-w-xs truncate">
                                {{ $categoria->descripcion ?: 'Sin descripción' }}
                            </td>
                            <td class="py-3 px-4 font-mono text-xs">{{ $categoria->productos_count }}</td>
                            <td class="py-3 px-4">
                                <span class="text-xs px-2 py-0.5 rounded-full font-medium bg-success/10 text-success">Activa</span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex justify-end gap-3 font-medium text-xs">
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
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-sm text-center text-muted">
                                No hay categorías activas registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categorias->hasPages())
            <div class="p-4 border-t border-line">
                {{ $categorias->links() }}
            </div>
        @endif
    </div>

    {{-- Archivadas --}}
    @if($archivadas->isNotEmpty())
        <div>
            <div class="text-sm font-medium text-muted mb-3">Archivadas ({{ $archivadas->count() }})</div>

            <div class="border border-dashed border-line bg-surface/50 rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left text-xs font-medium text-muted uppercase border-b border-line">
                                <th class="py-3 px-4">Nombre</th>
                                <th class="py-3 px-4">Descripción</th>
                                <th class="py-3 px-4">Productos</th>
                                <th class="py-3 px-4">Estado</th>
                                <th class="py-3 px-4 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-line">
                            @foreach($archivadas as $categoria)
                                <tr>
                                    <td class="py-3 px-4 font-medium text-muted">{{ $categoria->nombre }}</td>
                                    <td class="py-3 px-4 text-muted/60 max-w-xs truncate">
                                        {{ $categoria->descripcion ?: 'Sin descripción' }}
                                    </td>
                                    <td class="py-3 px-4 font-mono text-xs text-muted">{{ $categoria->productos_count }}</td>
                                    <td class="py-3 px-4">
                                        <span class="text-xs px-2 py-0.5 rounded-full font-medium bg-muted/15 text-muted">Archivada</span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex justify-end gap-3 font-medium text-xs">
                                            <form action="{{ route('categorias.restaurar', $categoria) }}" method="POST"
                                                  onsubmit="return confirm('¿Restaurar esta categoría?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="px-2.5 py-1 rounded-lg border border-line text-muted hover:border-success hover:text-success transition-colors">
                                                    Restaurar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection