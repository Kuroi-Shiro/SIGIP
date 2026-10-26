<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - SIGIP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>


<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">
    <div class="max-w-md w-full bg-white rounded-lg shadow-md p-8">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">SIGIP</h1>
            <p class="text-sm text-gray-600 mt-1">Ingresa tus credenciales para acceder</p>
        </div>


        <div id="mensaje-error" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
            <p class="font-semibold">Error de autenticación:</p>
            <p id="texto-error" class="text-sm mt-1"></p>
        </div>


        <form id="form-login" class="space-y-4" onsubmit="validarLogin(event)" novalidate>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
                <input type="email" id="email" name="email" required autofocus
                    class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200"
                    placeholder="ejemplo@sigip.com">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                <input type="password" id="password" name="password" required
                    class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200"
                    placeholder="••••••••">
            </div>

            <label class="flex items-center text-sm text-gray-600">
                <input type="checkbox" id="remember" class="rounded border-gray-300 text-indigo-600">
                <span class="ml-2">Recordar sesión</span>
            </label>

            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-lg text-sm shadow">
                Iniciar sesión
            </button>
        </form>


        <div class="mt-6">
            <p class="text-xs text-gray-500 text-center mb-3">Accesos rápidos de prueba</p>

            <div class="grid grid-cols-2 gap-3">
                <button type="button" onclick="credencialesUsuario()"
                    class="border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 font-medium py-2 rounded-lg text-sm">
                    Usuario
                </button>

                <button type="button" onclick="credencialesAdmin()"
                    class="border border-indigo-300 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-medium py-2 rounded-lg text-sm">
                    Admin
                </button>
            </div>
        </div>
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

            window.location.href = '/';
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