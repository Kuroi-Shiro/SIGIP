@extends('layouts.app')

@section('content')
<div class="p-8 w-full min-h-screen">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center mb-8">
            <a href="{{ route('categorias.index') }}" class="text-gray-500 hover:text-[#0F172A] transition-colors mr-4 bg-white p-2 rounded-lg border border-gray-200 shadow-sm" title="Volver">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Editar Categoría</h1>
                <p class="text-sm text-gray-500">{{ $categoria->nombre }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-8 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100">
            <form action="{{ route('categorias.update', $categoria) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-6">
                    <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-2">Nombre <span class="text-red-500">*</span></label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $categoria->nombre) }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-[#C98A4B] focus:ring-[#C98A4B] p-3 border @error('nombre') border-red-500 @enderror" required>
                    @error('nombre')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-8">
                    <label for="descripcion" class="block text-sm font-semibold text-gray-700 mb-2">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="4" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-[#C98A4B] focus:ring-[#C98A4B] p-3 border @error('descripcion') border-red-500 @enderror">{{ old('descripcion', $categoria->descripcion) }}</textarea>
                    @error('descripcion')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('categorias.index') }}" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50">Cancelar</a>
                    <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-[#C98A4B] rounded-xl hover:opacity-90 flex items-center">
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection