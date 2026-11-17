@extends('layouts.app')

@section('titulo', 'Nuevo Producto')

@section('contenido')
<div class="max-w-3xl mx-auto bg-white border border-line rounded-xl p-6">
    <h1 class="font-display text-2xl font-semibold mb-6 pb-3 border-b border-line">Registrar nuevo producto</h1>

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

    <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="codigo" class="block text-sm font-medium text-ink mb-1">Código *</label>
                <input type="text" id="codigo" name="codigo" value="{{ old('codigo') }}" placeholder="Ej. SAL-001"
                       @class([
                           'w-full border rounded-lg px-3 py-2 text-sm outline-none transition-colors focus:border-primary',
                           'border-red-500 bg-red-50' => $errors->has('codigo'),
                           'border-line' => !$errors->has('codigo'),
                       ])>
                @error('codigo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="nombre" class="block text-sm font-medium text-ink mb-1">Nombre *</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" placeholder="Ej. Sala Esquinera Mónaco"
                       @class([
                           'w-full border rounded-lg px-3 py-2 text-sm outline-none transition-colors focus:border-primary',
                           'border-red-500 bg-red-50' => $errors->has('nombre'),
                           'border-line' => !$errors->has('nombre'),
                       ])>
                @error('nombre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="categoria_id" class="block text-sm font-medium text-ink mb-1">Categoría *</label>
                <select id="categoria_id" name="categoria_id"
                        @class([
                            'w-full border rounded-lg px-3 py-2 text-sm outline-none transition-colors focus:border-primary',
                            'border-red-500 bg-red-50' => $errors->has('categoria_id'),
                            'border-line' => !$errors->has('categoria_id'),
                        ])>
                    <option value="">Seleccionar categoría...</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" @selected(old('categoria_id') == $categoria->id)>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('categoria_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="precio" class="block text-sm font-medium text-ink mb-1">Precio *</label>
                <input type="number" step="0.01" id="precio" name="precio" value="{{ old('precio') }}" placeholder="0.00"
                       @class([
                           'w-full border rounded-lg px-3 py-2 text-sm outline-none transition-colors focus:border-primary',
                           'border-red-500 bg-red-50' => $errors->has('precio'),
                           'border-line' => !$errors->has('precio'),
                       ])>
                @error('precio') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="stock_actual" class="block text-sm font-medium text-ink mb-1">Stock Inicial *</label>
                <input type="number" id="stock_actual" name="stock_actual" value="{{ old('stock_actual', 0) }}"
                       @class([
                           'w-full border rounded-lg px-3 py-2 text-sm outline-none transition-colors focus:border-primary',
                           'border-red-500 bg-red-50' => $errors->has('stock_actual'),
                           'border-line' => !$errors->has('stock_actual'),
                       ])>
                @error('stock_actual') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="stock_minimo" class="block text-sm font-medium text-ink mb-1">Stock Mínimo *</label>
                <input type="number" id="stock_minimo" name="stock_minimo" value="{{ old('stock_minimo', 1) }}"
                       @class([
                           'w-full border rounded-lg px-3 py-2 text-sm outline-none transition-colors focus:border-primary',
                           'border-red-500 bg-red-50' => $errors->has('stock_minimo'),
                           'border-line' => !$errors->has('stock_minimo'),
                       ])>
                @error('stock_minimo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mb-4">
            <label for="descripcion" class="block text-sm font-medium text-ink mb-1">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="3" placeholder="Detalles del producto..."
                      @class([
                          'w-full border rounded-lg px-3 py-2 text-sm outline-none transition-colors focus:border-primary',
                          'border-red-500 bg-red-50' => $errors->has('descripcion'),
                          'border-line' => !$errors->has('descripcion'),
                      ])>{{ old('descripcion') }}</textarea>
            @error('descripcion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label for="imagen" class="block text-sm font-medium text-ink mb-1">Imagen (URL o archivo)</label>
            <input type="text" id="imagen" name="imagen" value="{{ old('imagen') }}" placeholder="ruta/o/url/de/imagen.jpg"
                   class="w-full border border-line rounded-lg px-3 py-2 text-sm outline-none transition-colors focus:border-primary">
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('productos.index') }}"
               class="px-4 py-2 rounded-lg text-sm font-medium border border-line text-muted hover:bg-surface transition-colors">Cancelar</a>
            <button type="submit"
                    class="px-4 py-2 rounded-lg text-sm font-medium text-white bg-sidebar hover:bg-primary transition-colors">Guardar Producto</button>
        </div>
    </form>
</div>
@endsection