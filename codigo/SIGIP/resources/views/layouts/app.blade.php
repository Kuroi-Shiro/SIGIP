<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Panel') - SIGIP</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@500;600;700&family=Outfit:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sidebar: '#1C2B2B',
                        surface: '#F5F0E8',
                        primary: '#C4753A',
                        'primary-dark': '#A5602E',
                        ink: '#2D2416',
                        muted: '#8A7F75',
                        line: '#E5DDD5',
                        success: '#3A8A5C',
                        warning: '#D4860F',
                        danger: '#C43A3A',
                        info: '#3A6AC4',
                    },
                    fontFamily: {
                        display: ['Lora', 'Georgia', 'serif'],
                        sans: ['Outfit', 'system-ui', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                },
            },
        }
    </script>
</head>

@php
    $usuario = auth()->user();
    $nombreUsuario = $usuario->nombre ?? $usuario->name ?? 'Jorge Hernández';
    $rolUsuario = $usuario->rol ?? 'Administrador';
    $iniciales = collect(explode(' ', $nombreUsuario))
        ->filter()
        ->take(2)
        ->map(fn ($parte) => mb_strtoupper(mb_substr($parte, 0, 1)))
        ->implode('');

    $alertasStockCount = \App\Models\Producto::where('activo', true)
        ->whereColumn('stock_actual', '<=', 'stock_minimo')
        ->count();

    $menu = [
        ['ruta' => 'dashboard',        'patron' => 'dashboard',     'etiqueta' => 'Dashboard',    'icono' => '▦'],
        ['ruta' => 'productos.index',  'patron' => 'productos.*',   'etiqueta' => 'Productos',    'icono' => '⊞'],
        ['ruta' => 'categorias.index', 'patron' => 'categorias.*',  'etiqueta' => 'Categorías',   'icono' => '⊟'],
        ['ruta' => 'proveedores.index','patron' => 'proveedores.*', 'etiqueta' => 'Proveedores',  'icono' => '⊡'],
        ['ruta' => 'movimientos.index','patron' => 'movimientos.*', 'etiqueta' => 'Movimientos',  'icono' => '⇅'],
        ['ruta' => 'entregas.index',   'patron' => 'entregas.*',    'etiqueta' => 'Entregas',     'icono' => '⊳'],
        ['ruta' => 'usuarios.index',   'patron' => 'usuarios.*',    'etiqueta' => 'Usuarios',     'icono' => '⊙'],
    ];
@endphp

<body class="h-screen overflow-hidden flex bg-surface font-sans text-ink antialiased">

    {{-- SIDEBAR --}}
    <aside id="sidebar" data-collapsed="false"
           class="group flex flex-col h-full flex-shrink-0 bg-sidebar w-[220px] min-w-[220px] transition-all duration-300 data-[collapsed=true]:w-16 data-[collapsed=true]:min-w-16">

        <div class="flex items-center gap-3 px-4 py-5 border-b border-white/10">
            <div class="w-8 h-8 rounded-lg bg-primary text-white font-display font-bold text-lg flex items-center justify-center flex-shrink-0">S</div>
            <div class="overflow-hidden group-data-[collapsed=true]:hidden">
                <div class="text-white font-semibold text-sm leading-tight whitespace-nowrap">Spacio Muebles</div>
                <div class="text-[0.68rem] text-white/40">SIGIP v1.0</div>
            </div>
        </div>

        <div class="px-4 py-3 group-data-[collapsed=true]:hidden">
            <span @class([
                'inline-block px-2 py-0.5 rounded text-xs font-medium',
                'bg-primary/25 text-primary' => $rolUsuario === 'Administrador',
                'bg-white/10 text-white/50' => $rolUsuario !== 'Administrador',
            ])>{{ $rolUsuario }}</span>
        </div>

        <nav class="flex-1 px-2 py-2 space-y-0.5 overflow-y-auto">
            @foreach($menu as $item)
                @php $activo = request()->routeIs($item['patron']); @endphp
                <a href="{{ Route::has($item['ruta']) ? route($item['ruta']) : '#' }}"
                   title="{{ $item['etiqueta'] }}"
                   @class([
                       'flex items-center gap-3 rounded-lg px-3 py-2.5 text-[0.85rem] border-l-[3px] transition-colors group-data-[collapsed=true]:justify-center group-data-[collapsed=true]:px-0',
                       'bg-primary/20 border-primary text-primary font-semibold' => $activo,
                       'border-transparent text-white/65 hover:bg-white/5' => !$activo,
                   ])>
                    <span class="text-base leading-none flex-shrink-0">{{ $item['icono'] }}</span>
                    <span class="whitespace-nowrap group-data-[collapsed=true]:hidden">{{ $item['etiqueta'] }}</span>
                </a>
            @endforeach
        </nav>

        <div class="px-2 pb-4 pt-2 border-t border-white/10">
            <button type="button" id="btn-colapsar"
                    class="w-full flex items-center gap-3 rounded-lg px-3 py-2.5 mb-1 text-[0.82rem] text-white/40 hover:text-white/75 transition-colors group-data-[collapsed=true]:justify-center group-data-[collapsed=true]:px-0">
                <span id="flecha-colapsar" class="text-base leading-none">←</span>
                <span class="group-data-[collapsed=true]:hidden">Colapsar</span>
            </button>
            <a href="{{ route('login') }}"
               class="w-full flex items-center gap-3 rounded-lg px-3 py-2.5 text-[0.82rem] text-white/40 hover:text-red-300 transition-colors group-data-[collapsed=true]:justify-center group-data-[collapsed=true]:px-0">
                <span class="text-base leading-none">⊗</span>
                <span class="group-data-[collapsed=true]:hidden">Cerrar sesión</span>
            </a>
        </div>
    </aside>

    {{-- CONTENIDO --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <header class="flex items-center justify-between px-6 py-3.5 flex-shrink-0 bg-white border-b border-line">
            <h2 class="text-sm font-semibold">@yield('titulo')</h2>

            <div class="flex items-center gap-3">
                @if($alertasStockCount > 0)
                    <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-danger/10 text-danger">
                        <span>⚠</span>
                        <span>{{ $alertasStockCount }} {{ $alertasStockCount === 1 ? 'alerta' : 'alertas' }} de stock</span>
                    </div>
                @endif
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-full bg-sidebar text-white text-xs font-bold flex items-center justify-center">{{ $iniciales }}</div>
                    <span class="text-xs text-muted">{{ $nombreUsuario }}</span>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6">
            @foreach(['exito', 'error', 'advertencia', 'info'] as $tipo)
                @if(session()->has($tipo))
                    <x-alert :tipo="$tipo">{{ session($tipo) }}</x-alert>
                @endif
            @endforeach

            @yield('contenido')
        </main>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const flecha = document.getElementById('flecha-colapsar');

        function aplicarColapso(colapsado) {
            sidebar.dataset.collapsed = colapsado;
            flecha.textContent = colapsado ? '→' : '←';
        }

        try { aplicarColapso(localStorage.getItem('sigip_sidebar') === 'true'); } catch (e) {}

        document.getElementById('btn-colapsar').addEventListener('click', () => {
            const colapsado = sidebar.dataset.collapsed !== 'true';
            aplicarColapso(colapsado);
            try { localStorage.setItem('sigip_sidebar', colapsado); } catch (e) {}
        });
    </script>
</body>
</html>