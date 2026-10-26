@extends('layouts.app')

@section('titulo', 'Editar categoría')

@section('contenido')
<div class="max-w-xl mx-auto bg-white border border-line rounded-xl p-6">
    <h1 class="font-display text-2xl font-semibold mb-6 pb-3 border-b border-line">Editar categoría: {{ $categoria->nombre }}</h1>

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

    <form action="{{ route('categorias.update', $categoria) }}" method="POST" novalidate>
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nombre" class="block text-sm font-medium text-ink mb-1">Nombre *</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $categoria->nombre) }}"
                   @class([
                       'w-full border rounded-lg px-3 py-2 text-sm outline-none transition-colors focus:border-primary',
                       'border-red-500 bg-red-50' => $errors->has('nombre'),
                       'border-line' => !$errors->has('nombre'),
                   ])>
            @error('nombre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label for="descripcion" class="block text-sm font-medium text-ink mb-1">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="4"
                      @class([
                          'w-full border rounded-lg px-3 py-2 text-sm outline-none transition-colors focus:border-primary',
                          'border-red-500 bg-red-50' => $errors->has('descripcion'),
                          'border-line' => !$errors->has('descripcion'),
                      ])>{{ old('descripcion', $categoria->descripcion) }}</textarea>
            @error('descripcion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('categorias.index') }}"
               class="px-4 py-2 rounded-lg text-sm font-medium border border-line text-muted hover:bg-surface transition-colors">Cancelar</a>
            <button type="submit"
                    class="px-4 py-2 rounded-lg text-sm font-medium text-white bg-sidebar hover:bg-primary transition-colors">Actualizar</button>
        </div>
    </form>
</div>
@endsection