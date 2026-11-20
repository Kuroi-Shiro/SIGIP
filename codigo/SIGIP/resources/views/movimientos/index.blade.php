@extends('layouts.app')

@section('titulo', 'Movimientos')

@section('contenido')
@php

    $badgesTipo = [
        'entrada' => 'bg-success/10 text-success',
        'salida'  => 'bg-danger/10 text-danger',
    ];
@endphp
<div class="flex flex-col gap-6">
    <div class="flex items-start justify-between">
        <div>
            <h1 class="font-display text-2xl font-semibold mb-1">Movimientos</h1>
            <p class="text-sm text-muted">
                {{ $movimientos->total() }} {{ $movimientos->total() === 1 ? 'movimiento registrado' : 'movimientos registrados' }}
            </p>
        </div>
        <a href="{{ route('movimientos.create') }}"
           class="px-4 py-2 rounded-lg text-sm font-medium text-white bg-sidebar hover:bg-primary transition-colors">
            + Nuevo movimiento
        </a>
    </div>

    {{-- Errores de cancelar/validaciones que regresan a esta página --}}
    @if($errors->any())
        <x-alert tipo="error">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </x-alert>
    @endif

    <div class="bg-white border border-line rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left text-xs font-medium text-muted uppercase bg-surface/30 border-b border-line">
                        <th class="py-3 px-4">#</th>
                        <th class="py-3 px-4">Fecha</th>
                        <th class="py-3 px-4">Producto</th>
                        <th class="py-3 px-4">Tipo</th>
                        <th class="py-3 px-4">Cantidad</th>
                        <th class="py-3 px-4">Registrado por</th>
                        <th class="py-3 px-4">Estado</th>
                        <th class="py-3 px-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    @forelse ($movimientos as $movimiento)
                        <tr @class(['hover:bg-surface/30 transition-colors', 'opacity-60' => $movimiento->estado === 'cancelado'])>
                            <td class="py-3 px-4 font-mono text-xs text-muted">{{ $movimiento->id }}</td>
                            <td class="py-3 px-4 font-mono text-xs">{{ $movimiento->fecha_movimiento->format('d/m/Y H:i') }}</td>
                            <td class="py-3 px-4 font-medium text-ink">

                                <a href="{{ route('movimientos.show', $movimiento) }}" class="hover:text-primary transition-colors">
                                    {{ $movimiento->producto->nombre ?? 'Producto eliminado' }}
                                </a>
                                <p class="text-xs font-mono text-muted/70">{{ $movimiento->producto->codigo ?? '' }}</p>
                            </td>
                            <td class="py-3 px-4">
                                <span class="text-xs px-2 py-0.5 rounded-full font-medium {{ $badgesTipo[$movimiento->tipo] ?? '' }}">
                                    {{ ucfirst($movimiento->tipo) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 font-mono text-xs font-semibold">
                                {{ $movimiento->tipo === 'entrada' ? '+' : '−' }}{{ $movimiento->cantidad }}
                            </td>
                            <td class="py-3 px-4 text-muted">{{ $movimiento->usuario->nombre ?? 'Sin usuario' }}</td>
                            <td class="py-3 px-4">
                                @if($movimiento->estado === 'activo')
                                    <span class="text-xs px-2 py-0.5 rounded-full font-medium bg-success/10 text-success">Activo</span>
                                @else
                                    <span class="text-xs px-2 py-0.5 rounded-full font-medium bg-muted/15 text-muted">Cancelado</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right flex justify-end gap-3 font-medium text-xs">
                                <a href="{{ route('movimientos.show', $movimiento) }}" class="text-info hover:underline">Ver</a>
                                @if($movimiento->estado === 'activo')
                                    <a href="{{ route('movimientos.edit', $movimiento) }}" class="text-primary hover:underline">Editar</a>
                                    <form action="{{ route('movimientos.cancelar', $movimiento) }}" method="POST" class="inline"
                                          onsubmit="return confirm('¿Cancelar este movimiento? Se revertirá el cambio en el stock.');">
                                           @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-muted hover:text-danger hover:underline">Cancelar</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-sm text-center text-muted">
                                No hay movimientos registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($movimientos->hasPages())
            <div class="p-4 border-t border-line">
                {{ $movimientos->links() }}
            </div>
        @endif
    </div>
</div>
@endsection