<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - SIGIP</title>

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

<body class="bg-surface font-sans text-ink min-h-screen flex justify-center px-4">
    <div class="w-full max-w-sm pt-6 sm:pt-10">

        <div class="text-center mb-9">
            <div class="w-12 h-12 mx-auto rounded-xl bg-sidebar text-white font-display font-bold text-2xl flex items-center justify-center">
                S
            </div>
            <h1 class="mt-3 text-lg font-semibold text-ink">Spacio Muebles · SIGIP</h1>
        </div>

        <div class="mb-8">
            <h2 class="font-display text-2xl font-semibold text-ink">Iniciar sesión</h2>
            <p class="text-sm text-muted mt-1">Ingresa tus credenciales para continuar</p>
        </div>

        @if ($errors->any())
            <div class="bg-danger/10 border border-danger/30 text-danger px-4 py-3 rounded-lg mb-4">
                <p class="font-semibold text-sm">Error de autenticación</p>
                <p class="text-xs mt-1">{{ $errors->first() }}</p>
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-ink mb-1.5">
                    Correo electrónico
                </label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full bg-white border border-line rounded-lg px-4 py-3 text-sm text-ink placeholder:text-muted/70 focus:outline-none focus:border-sidebar focus:ring-1 focus:ring-sidebar transition"
                    placeholder="usuario@spacio.mx">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-ink mb-1.5">
                    Contraseña
                </label>
                <input type="password" id="password" name="password" required
                    class="w-full bg-white border border-line rounded-lg px-4 py-3 text-sm text-ink placeholder:text-muted/70 focus:outline-none focus:border-sidebar focus:ring-1 focus:ring-sidebar transition"
                    placeholder="••••••••">
            </div>

            <label class="flex items-center text-sm text-muted">
                <input type="checkbox" id="remember" name="remember" value="1"
                    class="rounded border-line text-sidebar focus:ring-sidebar">
                <span class="ml-2">Recordar sesión</span>
            </label>

            <button type="submit"
                class="w-full bg-sidebar hover:bg-[#263838] text-white font-semibold py-3 rounded-lg text-sm transition-colors">
                Entrar al sistema
            </button>
        </form>

        <div class="mt-6">
            <p class="text-xs text-muted text-center mb-3">Acceso rápido para prototipo:</p>

            <div class="grid grid-cols-2 gap-2">
                <button type="button" onclick="credencialesAdmin()"
                    class="border border-line hover:border-muted bg-transparent text-ink font-medium py-2.5 rounded-lg text-sm transition-colors">
                    Admin demo
                </button>

                <button type="button" onclick="credencialesUsuario()"
                    class="border border-line hover:border-muted bg-transparent text-ink font-medium py-2.5 rounded-lg text-sm transition-colors">
                    Empleado demo
                </button>
            </div>
        </div>
    </div>

    <script>
        // Credenciales reales creadas por UsuarioSeeder
        const adminPrueba   = { email: 'admin@sigip.com',   password: 'password1237' };
        const usuarioPrueba = { email: 'usuario@sigip.com', password: 'password1237' };

        function llenarCredenciales(cuenta) {
            document.getElementById('email').value = cuenta.email;
            document.getElementById('password').value = cuenta.password;
        }

        function credencialesAdmin()   { llenarCredenciales(adminPrueba); }
        function credencialesUsuario() { llenarCredenciales(usuarioPrueba); }
    </script>
</body>
</html>