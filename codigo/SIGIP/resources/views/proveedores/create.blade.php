@extends('layouts.app')

@section('titulo', 'Nuevo Proveedor')

@section('contenido')
<div class="max-w-3xl mx-auto bg-white border border-line rounded-xl p-6">
    <h1 class="font-display text-2xl font-semibold mb-6 pb-3 border-b border-line">Registrar nuevo proveedor</h1>

    @if($errors->any())
        <x-alert tipo="error">
            <p class="font-semibold mb-1">Por favor corrige los siguientes errores:</p>
            <ul class="list-disc list-inside text-xs space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-alert>
    @endif
    <form action="{{ route('proveedores.store') }}" method="POST" novalidate>
        @csrf

        @include('proveedores._campos', ['proveedor' => null, 'productos' => $productos])

        <div class="flex justify-end gap-3">
            <a href="{{ route('proveedores.index') }}"
               class="px-4 py-2 rounded-lg text-sm font-medium border border-line text-muted hover:bg-surface transition-colors">Cancelar</a>
            <button type="submit"
                    class="px-4 py-2 rounded-lg text-sm font-medium text-white bg-sidebar hover:bg-primary transition-colors">Guardar Proveedor</button>
        </div>
    </form>
</div>
@endsection
