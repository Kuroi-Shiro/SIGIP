@extends('layouts.app')

@section('content')
<div class="p-8 w-full min-h-screen">
    
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Categorías</h1>
        <a href="{{ route('categorias.create') }}" class="bg-[#4F7C6A] hover:bg-[#3A5D4F] text-white font-semibold py-2 px-4 rounded-xl shadow-sm transition duration-300 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Nueva Categoría
        </a>
    </div>

    @if(session('exito'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-xl mb-6 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('exito') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        @if($categorias->isEmpty())
            <div class="col-span-full text-center py-12 text-gray-500 bg-white rounded-2xl border border-dashed border-gray-300">
                No hay categorías activas registradas.
            </div>
        @else
            @foreach($categorias as $categoria)
                <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 flex flex-col h-full">
                    
                    <div class="flex justify-between items-start mb-2">
                        <a href="{{ route('categorias.show', $categoria) }}" class="text-lg font-bold text-[#0F172A] hover:text-[#4F7C6A] transition-colors">
                            {{ $categoria->nombre }}
                        </a>
                        <span class="bg-emerald-50 text-emerald-600 border border-emerald-100 text-xs font-semibold px-3 py-1 rounded-full">
                            Activa
                        </span>
                    </div>

                    <p class="text-sm text-gray-500 flex-grow mb-4">
                        {{ $categoria->descripcion ?? 'Sin descripción' }}
                    </p>
                    
                    <hr class="mb-4 border-gray-100">

                    <div class="flex justify-between items-center mt-auto">
                        <p class="text-sm text-gray-500">
                            <span class="font-bold text-gray-900">{{ $categoria->productos_count }}</span> productos
                        </p>
                        
                        <div class="flex gap-2">
                            <a href="{{ route('categorias.edit', $categoria) }}" class="p-1.5 text-gray-400 hover:text-[#C98A4B] transition-colors" title="Editar">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('categorias.archivar', $categoria) }}" method="POST" onsubmit="return confirm('¿Archivar esta categoría?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="border border-gray-300 hover:border-gray-400 text-gray-600 bg-white hover:bg-gray-50 transition-colors duration-200 px-4 py-1.5 rounded-lg text-sm font-medium">
                                    Archivar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    @if($categorias->hasPages())
        <div class="mt-4">
            {{ $categorias->links() }}
        </div>
    @endif
</div>
@endsection