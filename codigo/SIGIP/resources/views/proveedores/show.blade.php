@extends('layouts.app')

@section('titulo', 'Detalle proveedor')

@section('contenido')
<div class="flex flex-col gap-6">

    <div class="flex items-start justify-between">
        <div>
            <h1 class="font-display text-2xl font-semibold mb-1">{{ $proveedor->nombre }}</h1>
            <p class="text-sm text-muted">
                {{ $proveedor->productos->count() }} {{ $proveedor->productos->count() === 1 ? 'producto suministrado' : 'productos suministrados' }}
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('proveedores.index') }}"
               class="px-4 py-2 rounded-lg text-sm font-medium border border-line text-muted hover:bg-white transition-colors">← Volver</a>
            <a href="{{ route('proveedores.edit', $proveedor) }}"
               class="px-4 py-2 rounded-lg text-sm font-medium text-white bg-sidebar hover:bg-primary transition-colors">Editar</a>

            @if($proveedor->activo)
                <form action="{{ route('proveedores.archivar', $proveedor) }}" method="POST"
                      onsubmit="return confirm('¿Archivar este proveedor?');">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="px-4 py-2 rounded-lg text-sm font-medium border border-line text-muted hover:bg-white transition-colors">Archivar</button>
                </form>
            @endif

            <form action="{{ route('proveedores.destroy', $proveedor) }}" method="POST"
                  onsubmit="return confirm('¿Eliminar este proveedor permanentemente?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-4 py-2 rounded-lg text-sm font-medium border border-line text-muted hover:border-danger hover:text-danger transition-colors">Eliminar</button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- Productos que suministra --}}
        <div class="lg:col-span-2 bg-white border border-line rounded-xl p-5">
            <h3 class="font-semibold text-sm mb-4 pb-3 border-b border-line">Productos que suministra</h3>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs font-medium text-muted uppercase border-b border-line">
                            <th class="py-2 pr-4">Código</th>
                            <th class="py-2 pr-4">Producto</th>
                            <th class="py-2 pr-4">Precio</th>
                            <th class="py-2 text-right">Stock</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line">
                        @forelse($proveedor->productos as $producto)
                            <tr>
                                <td class="py-2 pr-4 font-mono text-xs text-muted">{{ $producto->codigo }}</td>
                                <td class="py-2 pr-4 font-medium text-ink">
                                    <a href="{{ route('productos.show', $producto) }}" class="hover:text-primary transition-colors">
                                        {{ $producto->nombre }}
                                    </a>
                                </td>
                                <td class="py-2 pr-4 font-mono text-xs">${{ number_format($producto->precio, 2) }}</td>
                                <td class="py-2 text-right font-mono text-xs">
                                    <span @class([
                                        'font-semibold',
                                        'text-danger' => $producto->stock_actual <= $producto->stock_minimo,
                                        'text-ink' => $producto->stock_actual > $producto->stock_minimo,
                                    ])>{{ $producto->stock_actual }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-6 text-center text-sm text-muted">Este proveedor no tiene productos asignados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Información de contacto --}}
        <div class="lg:col-span-1 bg-white border border-line rounded-xl p-5 self-start">
            <h3 class="font-semibold text-sm mb-4 pb-3 border-b border-line">Información de contacto</h3>

            <div class="mb-4">
                <span class="block text-xs text-muted font-medium mb-1">Estatus del sistema</span>
                @if($proveedor->activo)
                    <span class="text-xs px-2 py-0.5 rounded-full font-medium bg-success/10 text-success">Activo</span>
                @else
                    <span class="text-xs px-2 py-0.5 rounded-full font-medium bg-muted/15 text-muted">Archivado</span>
                @endif
            </div>

            <div class="mb-4">
                <span class="block text-xs text-muted font-medium mb-1">Teléfono</span>
                <p class="text-sm font-mono">{{ $proveedor->telefono ?: '—' }}</p>
            </div>

            <div class="mb-4">
                <span class="block text-xs text-muted font-medium mb-1">Correo electrónico</span>
                <p class="text-sm">{{ $proveedor->email ?: '—' }}</p>
            </div>

            <div class="mb-4">
                <span class="block text-xs text-muted font-medium mb-1">Dirección</span>
                <p class="text-sm">{{ $proveedor->direccion ?: '—' }}</p>
            </div>

            <div>
                <span class="block text-xs text-muted font-medium mb-1">Última actualización</span>
                <p class="text-sm font-mono">{{ $proveedor->updated_at?->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
