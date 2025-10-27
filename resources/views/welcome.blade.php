<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Sistema Parqueo ITCA-FEPade') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans flex flex-col min-h-screen">

    <!-- Navbar Fija -->
    <nav class="fixed top-0 left-0 w-full bg-white dark:bg-gray-800 shadow-md z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="text-2xl font-bold text-red-600 tracking-wide">
                {{ config('app.name', 'Sistema Parqueo ITCA-FEPade') }}
            </div>
            <div class="flex items-center space-x-6">
                @if(Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-700 dark:text-gray-200 font-medium hover:text-red-600 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 dark:text-gray-200 font-medium hover:text-red-600 transition">Login</a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero con Imagen o Ilustración -->
    <section class="pt-24 bg-gradient-to-r from-red-50 to-white dark:from-gray-900 dark:to-gray-800">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center px-6 py-16 gap-12">
            
            <!-- Texto Hero -->
            <div class="flex-1 text-center md:text-left">
                <h1 class="text-5xl md:text-6xl font-extrabold text-red-600 mb-6 leading-tight">
                    Sistema de Parqueo
                </h1>
                <p class="text-gray-700 dark:text-gray-300 text-lg mb-8 max-w-lg">
                    Controla entradas, salidas y espacios de manera rápida y eficiente. Optimiza la gestión de parqueos para ITCA-FEPADE.
                </p>
                <div class="flex justify-center md:justify-start gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-8 py-3 bg-red-600 text-white font-semibold rounded-lg shadow-lg hover:bg-red-700 transition transform hover:-translate-y-1">
                            Ir al Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-8 py-3 bg-red-600 text-white font-semibold rounded-lg shadow-lg hover:bg-red-700 transition transform hover:-translate-y-1">
                            Iniciar Sesión
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Ilustración Hero -->
            <div class="flex-1">
                <img src="https://cdn-icons-png.flaticon.com/512/684/684908.png" alt="Parqueo Ilustración" class="w-full max-w-md mx-auto">
            </div>
        </div>
    </section>

    <!-- Sección de Cards Informativos -->
    <section class="max-w-7xl mx-auto px-6 py-16 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 text-center hover:scale-105 transform transition">
            <h3 class="text-xl font-bold text-red-600 mb-4">Gestión de Entradas</h3>
            <p class="text-gray-600 dark:text-gray-300">Registra las entradas de vehículos de manera rápida y segura.</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 text-center hover:scale-105 transform transition">
            <h3 class="text-xl font-bold text-red-600 mb-4">Control de Salidas</h3>
            <p class="text-gray-600 dark:text-gray-300">Mantén un control exacto de los vehículos que salen del parqueo.</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 text-center hover:scale-105 transform transition">
            <h3 class="text-xl font-bold text-red-600 mb-4">Espacios Disponibles</h3>
            <p class="text-gray-600 dark:text-gray-300">Visualiza en tiempo real los espacios disponibles en el parqueo.</p>
        </div>
    </section>

    <!-- Footer Minimalista -->
    <footer class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 p-6 text-center mt-auto border-t border-gray-200 dark:border-gray-700">
        <p>&copy; {{ date('Y') }} ITCA-FEPADE. Todos los derechos reservados.</p>
        <p class="text-sm mt-1">Desarrollado con ❤️ por el equipo de TI</p>
    </footer>

</body>
</html>
