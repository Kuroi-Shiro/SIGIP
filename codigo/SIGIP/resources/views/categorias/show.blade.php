@extends('layouts.app')

@section('content')
<div class="p-8 w-full min-h-screen">
    <div class="max-w-4xl mx-auto">
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center">
                <a href="{{ route('categorias.index') }}" class="text-gray-500 hover:text-[#0F172A] transition-colors mr-4 bg-white p-2 rounded-lg border border-gray-200 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $categoria->nombre }}</h1>
                    <p class="text-sm text-gray-500">Detalles de la categoría</p>
                </div>
            </div>
            <a href="{{ route('categorias.edit', $categoria) }}" class="bg-[#C98A4B] hover:opacity-90 text-white font-semibold py-2 px-4 rounded-xl shadow-sm transition flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Editar
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Tarjeta de Info -->
            <div class="lg:col-span-1 bg-white rounded-2xl p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 self-start">
                <h3 class="text-lg font-bold text-[#0F172A] mb-4">Información General</h3>
                <div class="mb-4">
                    <span class="block text-sm text-gray-500 font-medium mb-1">Estado</span>
                    @if($categoria->activo)
                        <span class="bg-emerald-50 text-emerald-600 border border-emerald-100 text-xs font-semibold px-3 py-1 rounded-full">Activa</span>
                    @else
                        <span class="bg-gray-100 text-gray-600 border border-gray-200 text-xs font-semibold px-3 py-1 rounded-full">Archivada</span>
                    @endif
                </div>
                <div>
                    <span class="block text-sm text-gray-500 font-medium mb-1">Descripción</span>
                    <p class="text-sm text-gray-800">{{ $categoria->descripcion ?? 'Sin descripción proporcionada.' }}</p>
                </div>
            </div>

            <!-- Lista de Productos -->
            <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100">
                <h3 class="text-lg font-bold text-[#0F172A] mb-4 border-b border-gray-100 pb-3 flex justify-between items-center">
                    Productos asociados
                    <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs">{{ $categoria->productos->count() }}</span>
                </h3>
                
                @if($categoria->productos->count() > 0)
                    <ul class="divide-y divide-gray-100">
                        @foreach($categoria->productos as $producto)
                            <li class="py-3 flex justify-between items-center hover:bg-gray-50 px-2 rounded-lg transition-colors">
                                <!-- Asumiendo que producto tiene un campo 'nombre' -->
                                <span class="text-sm font-medium text-gray-800">{{ $producto->nombre ?? 'Producto #'.$producto->id }}</span>
                                <a href="#" class="text-[#5F7D8C] hover:text-[#0F172A] text-sm font-medium">Ver</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-center py-8 text-gray-500 text-sm">
                        No hay productos asignados a esta categoría todavía.
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection