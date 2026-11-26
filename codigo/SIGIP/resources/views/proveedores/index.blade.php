@extends('layouts.app')

@section('titulo', 'Proveedores')

@section('contenido')
<div class="flex flex-col gap-6">
    <div class="flex items-start justify-between">
        <div>
            <h1 class="font-display text-2xl font-semibold mb-1">Proveedores</h1>
            <p class="text-sm text-muted">
                {{ $proveedores->total() }} {{ $proveedores->total() === 1 ? 'proveedor activo' : 'proveedores activos' }}
            </p>
        </div>
        <a href="{{ route('proveedores.create') }}"
           class="px-4 py-2 rounded-lg text-sm font-medium text-white bg-sidebar hover:bg-primary transition-colors">
            + Nuevo proveedor
        </a>
    </div>

    <div class="bg-white border border-line rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left text-xs font-medium text-muted uppercase bg-surface/30 border-b border-line">
                        <th class="py-3 px-4">Proveedor</th>
                        <th class="py-3 px-4">Teléfono</th>
                        <th class="py-3 px-4">Correo</th>
                        <th class="py-3 px-4">Dirección</th>
                        <th class="py-3 px-4">Productos</th>
                        <th class="py-3 px-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    @forelse ($proveedores as $proveedor)
                        <tr class="hover:bg-surface/30 transition-colors">
                            <td class="py-3 px-4 font-medium text-ink">
                                <a href="{{ route('proveedores.show', $proveedor) }}" class="hover:text-primary transition-colors">
                                    {{ $proveedor->nombre }}

                                </a>
                            </td>
                            <td class="py-3 px-4 font-mono text-xs text-muted">{{ $proveedor->telefono ?: '—' }}</td>
                            <td class="py-3 px-4 text-muted">{{ $proveedor->email ?: '—' }}</td>
                            <td class="py-3 px-4 text-muted">{{ $proveedor->direccion ?: '—' }}</td>
                            <td class="py-3 px-4 font-mono text-xs">{{ $proveedor->productos_count }}</td>
                            <td class="py-3 px-4 text-right flex justify-end gap-3 font-medium text-xs">
                                <a href="{{ route('proveedores.show', $proveedor) }}" class="text-info hover:underline">Ver</a>
                                <a href="{{ route('proveedores.edit', $proveedor) }}" class="text-primary hover:underline">Editar</a>
                                <form action="{{ route('proveedores.archivar', $proveedor) }}" method="POST" class="inline"
                                      onsubmit="return confirm('¿Archivar este proveedor?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-muted hover:text-ink hover:underline">Archivar</button>

                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-sm text-center text-muted">
                                No hay proveedores activos.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($proveedores->hasPages())
            <div class="p-4 border-t border-line">
                {{ $proveedores->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
