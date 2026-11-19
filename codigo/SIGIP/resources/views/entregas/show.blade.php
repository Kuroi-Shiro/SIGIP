@extends('layouts.app')

@section('titulo', 'Detalle entrega')

@section('contenido')

@php
    $badges = [
        'pendiente'  => 'bg-info/10 text-info',
        'completado' => 'bg-success/10 text-success',
        'cancelado'  => 'bg-muted/15 text-muted',
    ];
@endphp

<div class="flex flex-col gap-6">

    <div class="flex items-start justify-between">
        <div>
            <h1 class="font-display text-2xl font-semibold mb-1">Entrega #{{ $entrega->id }}</h1>
            <p class="text-sm text-muted">{{ $entrega->cliente }}</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('entregas.index') }}"
               class="px-4 py-2 rounded-lg text-sm font-medium border border-line text-muted hover:bg-white transition-colors">← Volver</a>
            <a href="{{ route('entregas.edit', $entrega) }}"
               class="px-4 py-2 rounded-lg text-sm font-medium text-white bg-sidebar hover:bg-primary transition-colors">Editar</a>

            <form action="{{ route('entregas.destroy', $entrega) }}" method="POST"
                  onsubmit="return confirm('¿Eliminar esta entrega permanentemente?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-4 py-2 rounded-lg text-sm font-medium border border-line text-muted hover:border-danger hover:text-danger transition-colors">Eliminar</button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- Productos de la entrega --}}
        <div class="lg:col-span-2 bg-white border border-line rounded-xl p-5">
            <h3 class="font-semibold text-sm mb-4 pb-3 border-b border-line">Productos entregados</h3>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs font-medium text-muted uppercase border-b border-line">
                            <th class="py-2 pr-4">Código</th>
                            <th class="py-2 pr-4">Producto</th>
                            <th class="py-2 text-right">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line">
                        @forelse($entrega->productos as $producto)
                            <tr>
                                <td class="py-2 pr-4 font-mono text-xs text-muted">{{ $producto->codigo }}</td>

                                <td class="py-2 pr-4 font-medium text-ink">
                                    <a href="{{ route('productos.show', $producto) }}" class="hover:text-primary transition-colors">
                                        {{ $producto->nombre }}
                                    </a>
                                </td>
                                <td class="py-2 text-right font-mono text-xs">{{ $producto->pivot->cantidad }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-6 text-center text-sm text-muted">Esta entrega no tiene productos.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if($entrega->productos->isNotEmpty())
                        <tfoot>
                            <tr class="border-t border-line">
                                <td colspan="2" class="py-2 pr-4 text-xs font-medium text-muted">Total de unidades</td>
                                <td class="py-2 text-right font-mono text-sm font-semibold">{{ $entrega->productos->sum('pivot.cantidad') }}</td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>

        {{-- Información general --}}
        <div class="lg:col-span-1 bg-white border border-line rounded-xl p-5 self-start">
            <h3 class="font-semibold text-sm mb-4 pb-3 border-b border-line">Información</h3>

            <div class="mb-4">
                <span class="block text-xs text-muted font-medium mb-1">Estado</span>
                <span class="text-xs px-2 py-0.5 rounded-full font-medium {{ $badges[$entrega->estado] ?? $badges['cancelado'] }}">
                    {{ ucfirst($entrega->estado) }}
                </span>
            </div>

            <div class="mb-4">
                <span class="block text-xs text-muted font-medium mb-1">Cliente</span>
                <p class="text-sm font-medium">{{ $entrega->cliente }}</p>
                <p class="text-xs font-mono text-muted">{{ $entrega->telefono_cliente }}</p>
            </div>

            <div class="mb-4">
                <span class="block text-xs text-muted font-medium mb-1">Destino</span>
                <p class="text-sm">{{ $entrega->destino }}</p>
            </div>

            <div class="mb-4">
                <span class="block text-xs text-muted font-medium mb-1">Fecha de entrega</span>
                <p class="text-sm font-mono">{{ \Carbon\Carbon::parse($entrega->fecha_entrega)->format('d/m/Y') }}</p>
            </div>

            <div class="mb-4">
                <span class="block text-xs text-muted font-medium mb-1">Registrada por</span>
                <p class="text-sm">{{ $entrega->usuario->nombre ?? $entrega->usuario->name ?? 'Sin usuario' }}</p>
            </div>

            <div class="mb-4">
                <span class="block text-xs text-muted font-medium mb-1">Observaciones</span>
                <p class="text-sm">{{ $entrega->observaciones ?: 'Sin observaciones.' }}</p>
            </div>

            <div>
                <span class="block text-xs text-muted font-medium mb-1">Última actualización</span>
                <p class="text-sm font-mono">{{ $entrega->updated_at?->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
