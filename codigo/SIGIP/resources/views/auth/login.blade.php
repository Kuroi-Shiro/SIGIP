<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - TechStore</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">
    <div class="max-w-md w-full bg-white rounded-lg shadow-md p-8">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">TechStore Backoffice</h1>
            <p class="text-sm text-gray-600 mt-1">Ingresa tus credenciales para acceder</p>
        </div>

        @if(session('status'))
            <x-alert tipo="info">{{ session('status') }}</x-alert>
        @endif

        @if($errors->any())
            <x-alert tipo="error">
                <p class="font-semibold mb-1">Error de autenticación:</p>
                <ul class="list-disc list-inside text-xs space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4" novalidate>
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                    @class([
                        'w-full border rounded-lg p-2.5 text-sm transition-colors focus:outline-none focus:ring-2',
                        'border-red-500 bg-red-50 focus:ring-red-200' => $errors->has('email'),
                        'border-gray-300 focus:ring-indigo-200' => !$errors->has('email')
                    ]) placeholder="ejemplo@techstore.com">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                <input type="password" id="password" name="password" required
                    @class([
                        'w-full border rounded-lg p-2.5 text-sm transition-colors focus:outline-none focus:ring-2',
                        'border-red-500 bg-red-50 focus:ring-red-200' => $errors->has('password'),
                        'border-gray-300 focus:ring-indigo-200' => !$errors->has('password')
                    ]) placeholder="••••••••">
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center text-sm text-gray-600">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <span class="ml-2">Recordar sesión</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors shadow">
                Iniciar sesión
            </button>
        </form>
    </div>
</body>
</html>