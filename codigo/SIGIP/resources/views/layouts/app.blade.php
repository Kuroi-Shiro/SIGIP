<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGIP - Spacio Muebles</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F8F7F4] text-gray-900 font-sans antialiased flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-[#0F172A] text-gray-300 flex flex-col justify-between h-full flex-shrink-0">
        <div>
            <div class="px-6 py-8 flex items-center gap-3">
                <div class="bg-[#C98A4B] text-white font-bold text-xl w-10 h-10 flex items-center justify-center rounded-lg">S</div>
                <div>
                    <h2 class="text-white font-bold text-lg leading-tight">Spacio Muebles</h2>
                    <span class="text-gray-400 text-xs">SIGIP v1.0</span>
                </div>
            </div>

            <div class="px-6 mb-6">
                <span class="bg-[#C98A4B]/20 text-[#C98A4B] text-xs font-semibold px-3 py-1 rounded-md border border-[#C98A4B]/30">Administrador</span>
            </div>

            <nav class="px-4 space-y-1">
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span class="text-sm font-medium">Dashboard</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <span class="text-sm font-medium">Productos</span>
                </a>
                <a href="{{ route('categorias.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('categorias.*') ? 'bg-white/5 border border-[#C98A4B]/50 text-white' : 'hover:bg-white/5 text-gray-300' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('categorias.*') ? 'text-[#C98A4B]' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span class="text-sm font-medium">Categorías</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="text-sm font-medium">Proveedores</span>
                </a>
            </nav>
        </div>
        <div class="p-4 space-y-2">
            <button class="flex items-center gap-3 px-4 py-2 w-full text-left text-gray-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg>
                <span class="text-sm font-medium">Colapsar</span>
            </button>
        </div>
    </aside>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        <header class="h-16 px-8 flex items-center justify-end border-b border-gray-200 bg-[#F8F7F4]">
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-[#0F172A] text-white flex items-center justify-center text-sm font-bold">JH</div>
                    <span class="text-sm font-medium text-gray-700">Jorge Hernández</span>
                </div>
            </div>
        </header>

        <!-- AQUÍ SE INYECTA INDEX.BLADE.PHP -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto">
            @yield('content')
        </main>
    </div>
</body>
</html>