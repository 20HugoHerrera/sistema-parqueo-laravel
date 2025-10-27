<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-2">Bienvenido, {{ Auth::user()->name }}</h1>
                <p class="text-gray-500 dark:text-gray-400 mb-6">Has iniciado sesión correctamente.</p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="p-6 bg-blue-100 dark:bg-blue-900 rounded-lg shadow text-center">
                        <h3 class="text-lg font-semibold">Vehículos registrados</h3>
                        <p class="text-3xl font-bold mt-2">{{ $totalVehiculos ?? 0 }}</p>
                    </div>

                    <div class="p-6 bg-green-100 dark:bg-green-900 rounded-lg shadow text-center">
                        <h3 class="text-lg font-semibold">Espacios disponibles</h3>
                        <p class="text-3xl font-bold mt-2">{{ $espaciosDisponibles ?? 0 }}</p>
                    </div>

                    <div class="p-6 bg-yellow-100 dark:bg-yellow-900 rounded-lg shadow text-center">
                        <h3 class="text-lg font-semibold">Usuarios registrados</h3>
                        <p class="text-3xl font-bold mt-2">{{ $totalUsuarios ?? 0 }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <a href="{{ route('vehiculos.index') }}" class="block p-6 bg-gray-100 dark:bg-gray-700 rounded-lg shadow hover:scale-105 transition text-center">
                        <h3 class="font-semibold text-lg">Gestión de Vehículos</h3>
                        <p class="text-gray-500 dark:text-gray-300 mt-2">Ver y administrar vehículos</p>
                    </a>
                    <a href="{{ route('espacios.index') }}" class="block p-6 bg-gray-100 dark:bg-gray-700 rounded-lg shadow hover:scale-105 transition text-center">
                        <h3 class="font-semibold text-lg">Espacios de Parqueo</h3>
                        <p class="text-gray-500 dark:text-gray-300 mt-2">Control de disponibilidad</p>
                    </a>
                    <a href="{{ route('reportes.index') }}" class="block p-6 bg-gray-100 dark:bg-gray-700 rounded-lg shadow hover:scale-105 transition text-center">
                        <h3 class="font-semibold text-lg">Reportes</h3>
                        <p class="text-gray-500 dark:text-gray-300 mt-2">Ver estadísticas</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
