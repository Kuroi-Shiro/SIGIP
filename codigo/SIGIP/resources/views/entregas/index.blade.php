@extends('layouts.app')

@section('titulo', 'Entregas')

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
            <h1 class="font-display text-2xl font-semibold mb-1">Entregas</h1>
            <p class="text-sm text-muted">
                {{ $entregas->total() }} {{ $entregas->total() === 1 ? 'entrega registrada' : 'entregas registradas' }}
            </p>
        </div>
        <a href="{{ route('entregas.create') }}"
           class="px-4 py-2 rounded-lg text-sm font-medium text-white bg-sidebar hover:bg-primary transition-colors">
            + Nueva entrega
        </a>
    </div>


    <div class="bg-white border border-line rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left text-xs font-medium text-muted uppercase bg-surface/30 border-b border-line">
                        <th class="py-3 px-4">#</th>
                        <th class="py-3 px-4">Cliente</th>
                        <th class="py-3 px-4">Destino</th>
                        <th class="py-3 px-4">Fecha</th>
                        <th class="py-3 px-4">Productos</th>
                        <th class="py-3 px-4">Estado</th>
                        <th class="py-3 px-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    @forelse ($entregas as $entrega)
                        <tr class="hover:bg-surface/30 transition-colors">

                            <td class="py-3 px-4 font-mono text-xs text-muted">{{ $entrega->id }}</td>
                            <td class="py-3 px-4 font-medium text-ink">
                                <a href="{{ route('entregas.show', $entrega) }}" class="hover:text-primary transition-colors">
                                    {{ $entrega->cliente }}
                                </a>
                                <p class="text-xs font-mono text-muted/70">{{ $entrega->telefono_cliente }}</p>
                            </td>
                            <td class="py-3 px-4 text-muted">{{ $entrega->destino }}</td>
                            <td class="py-3 px-4 font-mono text-xs">{{ \Carbon\Carbon::parse($entrega->fecha_entrega)->format('d/m/Y') }}</td>
                            <td class="py-3 px-4 font-mono text-xs">
                                {{ $entrega->productos->count() }}
                                <span class="text-muted/60">({{ $entrega->productos->sum('pivot.cantidad') }} uds.)</span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="text-xs px-2 py-0.5 rounded-full font-medium {{ $badges[$entrega->estado] ?? $badges['cancelado'] }}">
                                    {{ ucfirst($entrega->estado) }}
                                </span>
                            </td>
                             <td class="py-3 px-4 text-right flex justify-end gap-3 font-medium text-xs">
                                <a href="{{ route('entregas.show', $entrega) }}" class="text-info hover:underline">Ver</a>
                                <a href="{{ route('entregas.edit', $entrega) }}" class="text-primary hover:underline">Editar</a>
                                <form action="{{ route('entregas.destroy', $entrega) }}" method="POST" class="inline"
                                      onsubmit="return confirm('¿Eliminar esta entrega?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-muted hover:text-danger hover:underline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                    <tr>
                            <td colspan="7" class="py-12 text-sm text-center text-muted">
                                No hay entregas registradas.
                            </td>
                        </tr>
                    @endforelse
                     </tbody>
            </table>
        </div>

        @if($entregas->hasPages())
            <div class="p-4 border-t border-line">
                {{ $entregas->links() }}
            </div>
        @endif
    </div>
</div>
@endsection