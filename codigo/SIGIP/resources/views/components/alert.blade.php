@props(['tipo' => 'exito'])

@php
    $configuracion = [
        'exito' => [
            'clases' => 'bg-green-50 border-green-500 text-green-800',
            'icono' => '✓',
            'titulo' => 'Operación exitosa'
        ],
        'error' => [
            'clases' => 'bg-red-50 border-red-500 text-red-800',
            'icono' => '✕',
            'titulo' => 'Atención'
        ],
        'advertencia' => [
            'clases' => 'bg-yellow-50 border-yellow-500 text-yellow-800',
            'icono' => '⚠',
            'titulo' => 'Advertencia'
        ],
        'info' => [
            'clases' => 'bg-blue-50 border-blue-500 text-blue-800',
            'icono' => 'ℹ',
            'titulo' => 'Información'
        ],
    ];

    $estilo = $configuracion[$tipo] ?? $configuracion['exito'];
@endphp

<div {{ $attributes->merge(['class' => "p-4 border-l-4 rounded-r-lg mb-4 shadow-sm {$estilo['clases']}"]) }} role="alert">
    <div class="flex items-start">
        <span class="font-bold mr-3 text-lg">{{ $estilo['icono'] }}</span>
        <div>
            <p class="font-semibold text-sm">{{ $estilo['titulo'] }}</p>
            <div class="text-sm mt-0.5">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>