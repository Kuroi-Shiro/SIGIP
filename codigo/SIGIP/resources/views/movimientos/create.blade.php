@extends('layouts.app')

@section('titulo', 'Nuevo Movimiento')

@section('contenido')
<div class="max-w-3xl mx-auto bg-white border border-line rounded-xl p-6">
     <h1 class="font-display text-2xl font-semibold mb-6 pb-3 border-b border-line">Registrar nuevo movimiento</h1>

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

    <form action="{{ route('movimientos.store') }}" method="POST" novalidate>
        @csrf

        {{-- El usuario que registra el movimiento es el que tiene la sesión iniciada --}}
        <input type="hidden" name="usuario_id" value="{{ old('usuario_id', auth()->id()) }}">

        @include('movimientos._campos', ['movimiento' => null])

        <div class="flex justify-end gap-3">
            <a href="{{ route('movimientos.index') }}"
               class="px-4 py-2 rounded-lg text-sm font-medium border border-line text-muted hover:bg-surface transition-colors">Cancelar</a>
            <button type="submit"
                    class="px-4 py-2 rounded-lg text-sm font-medium text-white bg-sidebar hover:bg-primary transition-colors">Guardar Movimiento</button>
        </div>
    </form>
</div>
@endsection