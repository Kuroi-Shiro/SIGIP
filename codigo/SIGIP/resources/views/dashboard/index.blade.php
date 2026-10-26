@extends('layouts.app')

@section('titulo', 'Dashboard')

@section('contenido')
@php
    /*
     * Si el controlador envía estas variables, se usan; si no, se muestran datos de ejemplo.
     * movimientosPorMes:       [['mes','entradas','salidas'], ...]
     * distribucionCategorias:  [['nombre','valor'], ...]
     * movimientosRecientes:    [['tipo','producto','cantidad','fecha','usuario'], ...]
     * alertasStock:            [['codigo','nombre','categoria','stock','minimo'], ...]
     */
    $productosActivos    = $productosActivos    ?? 10;
    $sinStock            = $sinStock            ?? 1;
    $stockBajo           = $stockBajo           ?? 4;
    $entregasPendientes  = $entregasPendientes  ?? 2;
    $entregasCompletadas = $entregasCompletadas ?? 1;
    $movimientosMes      = $movimientosMes      ?? 21;
    $entradasMes         = $entradasMes         ?? 14;
    $salidasMes          = $salidasMes          ?? 7;

    $movimientosPorMes = $movimientosPorMes ?? [
        ['mes' => 'Abr', 'entradas' => 8,  'salidas' => 5],
        ['mes' => 'May', 'entradas' => 12, 'salidas' => 9],
        ['mes' => 'Jun', 'entradas' => 7,  'salidas' => 11],
        ['mes' => 'Jul', 'entradas' => 15, 'salidas' => 8],
        ['mes' => 'Ago', 'entradas' => 10, 'salidas' => 13],
        ['mes' => 'Sep', 'entradas' => 14, 'salidas' => 7],
    ];

    $distribucionCategorias = $distribucionCategorias ?? [
        ['nombre' => 'Salas',     'valor' => 12],
        ['nombre' => 'Recámaras', 'valor' => 18],
        ['nombre' => 'Comedores', 'valor' => 9],
        ['nombre' => 'Oficinas',  'valor' => 7],
        ['nombre' => 'Exterior',  'valor' => 5],
    ];

    $movimientosRecientes = $movimientosRecientes ?? [
        ['tipo' => 'entrada', 'producto' => 'Sofá Esquinero Oslo',     'cantidad' => 3, 'fecha' => '28/09/2026', 'usuario' => 'Daniel Soto'],
        ['tipo' => 'salida',  'producto' => 'Mesa de Noche Flotante',  'cantidad' => 2, 'fecha' => '27/09/2026', 'usuario' => 'Omar López'],
        ['tipo' => 'entrada', 'producto' => 'Cama Matrimonial Roble',  'cantidad' => 4, 'fecha' => '25/09/2026', 'usuario' => 'Daniel Soto'],
        ['tipo' => 'salida',  'producto' => 'Silla Comedor Velvet',    'cantidad' => 6, 'fecha' => '24/09/2026', 'usuario' => 'Lucía Ramírez'],
        ['tipo' => 'salida',  'producto' => 'Sofá 3 plazas Piel',      'cantidad' => 1, 'fecha' => '22/09/2026', 'usuario' => 'Omar López'],
    ];

    $alertasStock = $alertasStock ?? [
        ['codigo' => 'RC-002', 'nombre' => 'Mesa de Noche Flotante',    'categoria' => 'Recámaras', 'stock' => 0, 'minimo' => 4],
        ['codigo' => 'SL-002', 'nombre' => 'Sillón Individual Nórdico', 'categoria' => 'Salas',     'stock' => 1, 'minimo' => 3],
        ['codigo' => 'SL-003', 'nombre' => 'Sofá 3 plazas Piel',        'categoria' => 'Salas',     'stock' => 1, 'minimo' => 2],
    ];

    $totalAlertas = $stockBajo + $sinStock;
    $mesLargo = now()->locale('es')->isoFormat('MMMM YYYY');
    $mesCorto = ucfirst(rtrim(now()->locale('es')->isoFormat('MMM'), '.'));

    $kpis = [
        ['etiqueta' => 'Productos activos',    'valor' => $productosActivos,    'detalle' => $sinStock . ' sin stock',                              'color' => 'text-ink'],
        ['etiqueta' => 'Stock bajo',           'valor' => $totalAlertas,        'detalle' => 'requieren reabastecimiento',                          'color' => 'text-danger'],
        ['etiqueta' => 'Entregas pendientes',  'valor' => $entregasPendientes,  'detalle' => $entregasCompletadas . ' completadas',                 'color' => 'text-warning'],
        ['etiqueta' => 'Movimientos (' . $mesCorto . ')', 'valor' => $movimientosMes, 'detalle' => $entradasMes . ' entradas · ' . $salidasMes . ' salidas', 'color' => 'text-primary'],
    ];

    // Gráfica de barras
    $maxBarra = max(1, collect($movimientosPorMes)->flatMap(fn ($m) => [$m['entradas'], $m['salidas']])->max());

    // Gráfica de dona (conic-gradient)
    $paleta = ['#C4753A', '#1C2B2B', '#D4860F', '#3A6AC4', '#3A8A5C', '#8A7F75'];
    $totalCategorias = max(1, collect($distribucionCategorias)->sum('valor'));
    $acumulado = 0;
    $segmentos = [];
    foreach ($distribucionCategorias as $i => $c) {
        $inicio = round($acumulado, 2);
        $acumulado += $c['valor'] / $totalCategorias * 100;
        $segmentos[] = $paleta[$i % count($paleta)] . ' ' . $inicio . '% ' . round($acumulado, 2) . '%';
    }
    $gradiente = 'conic-gradient(' . implode(', ', $segmentos) . ')';
@endphp

<div class="flex flex-col gap-6">

    <div>
        <h1 class="font-display text-2xl font-semibold mb-1">Dashboard</h1>
        <p class="text-sm text-muted">Resumen general del sistema — {{ $mesLargo }}</p>
    </div>

    {{-- KPIs --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach($kpis as $kpi)
            <div class="bg-white border border-line rounded-xl p-5 flex flex-col gap-1">
                <div class="text-xs font-medium uppercase tracking-wider text-muted">{{ $kpi['etiqueta'] }}</div>
                <div class="font-display text-3xl font-semibold mt-1 {{ $kpi['color'] }}">{{ $kpi['valor'] }}</div>
                <div class="text-xs text-muted">{{ $kpi['detalle'] }}</div>
            </div>
        @endforeach
    </div>

    {{-- Gráficas --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-4">

        {{-- Barras --}}
        <div class="lg:col-span-3 bg-white border border-line rounded-xl p-5">
            <div class="mb-4">
                <div class="font-semibold text-sm">Movimientos por mes</div>
                <div class="text-xs text-muted">Entradas vs. salidas — últimos 6 meses</div>
            </div>

            <div class="relative h-[200px]">
                @foreach([0, 25, 50, 75, 100] as $linea)
                    <div class="absolute left-0 right-0 border-t border-line/70" style="bottom: {{ $linea }}%"></div>
                @endforeach

                <div class="relative grid h-full" style="grid-template-columns: repeat({{ count($movimientosPorMes) }}, minmax(0, 1fr));">
                    @foreach($movimientosPorMes as $m)
                        <div class="flex items-end justify-center gap-1">
                            <div class="w-4 sm:w-6 bg-success rounded-t"
                                 style="height: {{ round($m['entradas'] / $maxBarra * 100) }}%"
                                 title="Entradas: {{ $m['entradas'] }}"></div>
                            <div class="w-4 sm:w-6 bg-primary rounded-t"
                                 style="height: {{ round($m['salidas'] / $maxBarra * 100) }}%"
                                 title="Salidas: {{ $m['salidas'] }}"></div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="grid mt-2" style="grid-template-columns: repeat({{ count($movimientosPorMes) }}, minmax(0, 1fr));">
                @foreach($movimientosPorMes as $m)
                    <div class="text-center text-[11px] text-muted">{{ $m['mes'] }}</div>
                @endforeach
            </div>

            <div class="flex gap-4 mt-3">
                <div class="flex items-center gap-1.5">
                    <div class="w-2.5 h-2.5 rounded-sm bg-success"></div>
                    <span class="text-xs text-muted">Entradas</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <div class="w-2.5 h-2.5 rounded-sm bg-primary"></div>
                    <span class="text-xs text-muted">Salidas</span>
                </div>
            </div>
        </div>

        {{-- Dona --}}
        <div class="lg:col-span-2 bg-white border border-line rounded-xl p-5">
            <div class="mb-4">
                <div class="font-semibold text-sm">Productos por categoría</div>
                <div class="text-xs text-muted">Distribución del catálogo</div>
            </div>

            <div class="relative w-40 h-40 mx-auto rounded-full" style="background: {{ $gradiente }}">
                <div class="absolute inset-[26px] rounded-full bg-white flex flex-col items-center justify-center">
                    <span class="font-display text-2xl font-semibold leading-none">{{ $totalCategorias }}</span>
                    <span class="text-[10px] text-muted mt-1">productos</span>
                </div>
            </div>

            <div class="space-y-1.5 mt-4">
                @foreach($distribucionCategorias as $i => $c)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full" style="background: {{ $paleta[$i % count($paleta)] }}"></div>
                            <span class="text-xs text-muted">{{ $c['nombre'] }}</span>
                        </div>
                        <span class="font-mono text-xs font-medium">{{ $c['valor'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Tablas inferiores --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

        {{-- Movimientos recientes --}}
        <div class="bg-white border border-line rounded-xl p-5">
            <div class="flex items-center justify-between mb-4">
                <div class="font-semibold text-sm">Movimientos recientes</div>
                <a href="{{ route('movimientos.index') }}" class="text-xs font-medium text-info hover:underline">Ver todos</a>
            </div>

            <div>
                @forelse($movimientosRecientes as $m)
                    <div class="flex items-center justify-between py-2.5 border-b border-line last:border-b-0">
                        <div class="flex items-center gap-3">
                            <div @class([
                                'w-7 h-7 rounded-md flex items-center justify-center text-xs font-bold',
                                'bg-success/10 text-success' => $m['tipo'] === 'entrada',
                                'bg-primary/10 text-primary' => $m['tipo'] !== 'entrada',
                            ])>{{ $m['tipo'] === 'entrada' ? '↓' : '↑' }}</div>
                            <div>
                                <div class="text-xs font-medium">{{ $m['producto'] }}</div>
                                <div class="text-xs text-muted">{{ $m['fecha'] }} · {{ $m['usuario'] }}</div>
                            </div>
                        </div>
                        <div @class([
                            'font-mono text-sm font-semibold',
                            'text-success' => $m['tipo'] === 'entrada',
                            'text-primary' => $m['tipo'] !== 'entrada',
                        ])>{{ $m['tipo'] === 'entrada' ? '+' : '-' }}{{ $m['cantidad'] }}</div>
                    </div>
                @empty
                    <div class="text-sm text-center py-4 text-muted">Sin movimientos registrados</div>
                @endforelse
            </div>
        </div>

        {{-- Alertas de stock --}}
        <div class="bg-white border border-line rounded-xl p-5">
            <div class="flex items-center justify-between mb-4">
                <div class="font-semibold text-sm">Alertas de stock</div>
                @if($totalAlertas > 0)
                    <span class="text-xs px-2 py-0.5 rounded-full font-medium bg-danger/10 text-danger">{{ $totalAlertas }} alertas</span>
                @endif
            </div>

            <div>
                @forelse($alertasStock as $p)
                    <div class="flex items-center justify-between py-2.5 border-b border-line last:border-b-0">
                        <div>
                            <div class="text-xs font-medium">{{ $p['nombre'] }}</div>
                            <div class="text-xs text-muted">{{ $p['codigo'] }} · {{ $p['categoria'] }}</div>
                        </div>
                        <div class="text-right">
                            <div @class([
                                'font-mono text-sm font-semibold',
                                'text-danger' => $p['stock'] === 0,
                                'text-warning' => $p['stock'] !== 0,
                            ])>{{ $p['stock'] === 0 ? 'Sin stock' : $p['stock'] . ' uds.' }}</div>
                            <div class="text-xs text-muted">mín: {{ $p['minimo'] }}</div>
                        </div>
                    </div>
                @empty
                    <div class="text-sm text-center py-4 text-muted">Sin alertas de stock</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection