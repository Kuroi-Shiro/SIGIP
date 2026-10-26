
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

<body class="bg-surface font-sans text-ink flex items-center justify-center min-h-screen p-4">
    <div class="max-w-md w-full">
        <div class="text-center mb-6">
            <div class="w-12 h-12 mx-auto mb-3 rounded-xl bg-primary text-white font-display font-bold text-2xl flex items-center justify-center shadow-sm">
                S
            </div>
            <h1 class="font-display text-3xl font-semibold text-ink">SIGIP</h1>
            <p class="text-sm text-muted mt-1">Sistema de Gestión de Inventario y Pedidos</p>
        </div>

        <div class="bg-white border border-line rounded-xl shadow-sm p-8">
            <div class="mb-6">
                <h2 class="font-display text-xl font-semibold text-ink">Iniciar sesión</h2>
                <p class="text-sm text-muted mt-1">Ingresa tus credenciales para acceder al sistema</p>
            </div>

            <div id="mensaje-error" class="hidden bg-danger/10 border border-danger/30 text-danger px-4 py-3 rounded-lg mb-4">
                <p class="font-semibold text-sm">Error de autenticación</p>
                <p id="texto-error" class="text-xs mt-1"></p>
            </div>

            <form id="form-login" class="space-y-4" onsubmit="validarLogin(event)" novalidate>
                <div>
                    <label for="email" class="block text-sm font-medium text-ink mb-1">Correo electrónico</label>
                    <input type="email" id="email" name="email" required autofocus
                        class="w-full border border-line rounded-lg px-3 py-2.5 text-sm bg-white text-ink placeholder:text-muted/60 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                        placeholder="ejemplo@sigip.com">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-ink mb-1">Contraseña</label>
                    <input type="password" id="password" name="password" required
                        class="w-full border border-line rounded-lg px-3 py-2.5 text-sm bg-white text-ink placeholder:text-muted/60 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                        placeholder="••••••••">
                </div>

                <label class="flex items-center text-sm text-muted">
                    <input type="checkbox" id="remember"
                        class="rounded border-line text-primary focus:ring-primary">
                    <span class="ml-2">Recordar sesión</span>
                </label>

                <button type="submit"
                    class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-2.5 rounded-lg text-sm transition-colors shadow-sm">
                    Iniciar sesión
                </button>
            </form>

            <div class="flex items-center gap-3 my-6">
                <div class="flex-1 border-t border-line"></div>
                <span class="text-xs text-muted">Accesos rápidos de prueba</span>
                <div class="flex-1 border-t border-line"></div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <button type="button" onclick="credencialesUsuario()"
                    class="border border-line bg-white hover:bg-surface text-ink font-medium py-2.5 rounded-lg text-sm transition-colors">
                    Usuario
                </button>

                <button type="button" onclick="credencialesAdmin()"
                    class="border border-primary/30 bg-primary/10 hover:bg-primary/20 text-primary font-semibold py-2.5 rounded-lg text-sm transition-colors">
                    Admin
                </button>
            </div>
        </div>

        <p class="text-center text-xs text-muted mt-4">Spacio Muebles · SIGIP v1.0</p>
    </div>

    <script>
        const usuarioPrueba = {
            email: 'usuario@sigip.com',
            password: 'usuario123',
            nombre: 'Usuario',
            rol: 'Empleado'
        };

        const adminPrueba = {
            email: 'admin@sigip.com',
            password: 'admin123',
            nombre: 'Administrador',
            rol: 'Administrador'
        };

        function credencialesUsuario() {
            document.getElementById('email').value = usuarioPrueba.email;
            document.getElementById('password').value = usuarioPrueba.password;
            ocultarError();
        }

        function credencialesAdmin() {
            document.getElementById('email').value = adminPrueba.email;
            document.getElementById('password').value = adminPrueba.password;
            ocultarError();
        }

        function validarLogin(event) {
            event.preventDefault();

            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const recordar = document.getElementById('remember').checked;

            ocultarError();

            if (email === '' || password === '') {
                mostrarError('Debes ingresar el correo electrónico y la contraseña.');
                return;
            }

            let usuario = null;

            if (email === adminPrueba.email && password === adminPrueba.password) {
                usuario = adminPrueba;
            } else if (email === usuarioPrueba.email && password === usuarioPrueba.password) {
                usuario = usuarioPrueba;
            } else {
                mostrarError('Correo o contraseña incorrectos.');
                return;
            }

            const almacenamiento = recordar ? localStorage : sessionStorage;
            almacenamiento.setItem('usuario_nombre', usuario.nombre);
            almacenamiento.setItem('usuario_email', usuario.email);
            almacenamiento.setItem('usuario_rol', usuario.rol);

            window.location.href = "{{ route('dashboard') }}";
        }

        function mostrarError(mensaje) {
            document.getElementById('texto-error').textContent = mensaje;
            document.getElementById('mensaje-error').classList.remove('hidden');
        }

        function ocultarError() {
            document.getElementById('mensaje-error').classList.add('hidden');
        }
    </script>
</body>
</html>
