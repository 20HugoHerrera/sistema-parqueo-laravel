<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .sidebar-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }
        .sidebar-user {
            display: flex;
            align-items: center;
            padding: 0.5rem 0;
            color: white;
            text-decoration: none;
        }
        .nav-link.active {
            background-color: #495057;
            border-radius: 0.375rem;
        }
        .main-container {
            display: flex;
            min-height: 100vh;
        }
        .content-wrapper {
            flex-grow: 1;
        }
        .navbar-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 8px;
        }
    </style>
</head>
<body class="font-sans antialiased">

<!-- Navbar superior -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm w-100 position-fixed" style="z-index: 1000;">
    <div class="container-fluid justify-content-between">
        <span class="navbar-brand mb-0 h1">{{ config('app.name', 'Laravel') }}</span>

        <!-- Usuario siempre visible -->
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ Auth::user()->avatar ?? 'https://via.placeholder.com/32' }}" alt="avatar" class="navbar-avatar">
                <span>{{ Auth::user()->name ?? 'Usuario' }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownUser">
                <li>
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="fas fa-user me-2"></i> Perfil
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-2"></i> Cerrar sesión
                    </a>
                </li>
            </ul>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </div>
</nav>

<div class="main-container" style="padding-top: 56px;">
    <!-- Sidebar -->
    <nav class="bg-dark text-white flex-shrink-0 p-3" style="width: 250px;">
        <!-- Solo avatar/nombre (sin dropdown ni logout) -->
        <div class="sidebar-user mb-3">
            <img src="{{ Auth::user()->avatar ?? 'https://via.placeholder.com/50' }}" alt="avatar" class="sidebar-avatar">
            <div>
                <div>{{ Auth::user()->name ?? 'Usuario' }}</div>
            </div>
        </div>
        <hr>

        <!-- Rutas -->
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home me-2"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('vehiculos.index') }}" class="nav-link text-white {{ request()->routeIs('vehiculos.*') ? 'active' : '' }}">
                    <i class="fas fa-car me-2"></i> Vehículos
                </a>
            </li>
            <li>
                <a href="{{ route('entradas.index') }}" class="nav-link text-white {{ request()->routeIs('entradas.*') ? 'active' : '' }}">
                    <i class="fas fa-sign-in-alt me-2"></i> Entradas
                </a>
            </li>
            <li>
                <a href="{{ route('salidas.index') }}" class="nav-link text-white {{ request()->routeIs('salidas.*') ? 'active' : '' }}">
                    <i class="fas fa-sign-out-alt me-2"></i> Salidas
                </a>
            </li>
            <li>
                <a href="{{ route('espacios.index') }}" class="nav-link text-white {{ request()->routeIs('espacios.*') ? 'active' : '' }}">
                    <i class="fas fa-parking me-2"></i> Espacios
                </a>
            </li>
            <li>
                <a href="#" class="nav-link text-white">
                    <i class="fas fa-users me-2"></i> Usuarios
                </a>
            </li>
        </ul>
    </nav>

    <!-- Contenido principal -->
    <div class="content-wrapper bg-light">
        @isset($header)
            <header class="bg-white shadow-sm p-3 mb-4">
                <div class="container">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="p-4">
            @yield('content')
        </main>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
