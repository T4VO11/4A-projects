<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- Importante para formularios --}}

    <title>@yield('title', 'Viajes Increíbles')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        .hero-background {
            background-image: url('{{ asset('img/hero-background.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .navbar-link {
            font-weight: 600; 
            color: #fff;
            padding: 0.5rem 0.75rem;
            font-size: 1rem;
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }
        .navbar-link:hover {
            color: #d1d5db; 
        }
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .animate-fade-in-down { animation: fadeInDown 1s ease-out forwards; }
        .animate-fade-in-up { animation: fadeInUp 1s ease-out forwards; }
        .animate-bounce-slow { animation: bounce 2s infinite; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        {{-- Navbar --}}
        <nav class="bg-gray-800 border-b border-gray-700 fixed top-0 w-full z-20 shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 flex justify-between items-center">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="text-white text-2xl font-bold">Viajes Increíbles</a>
                </div>
                <div class="flex items-center space-x-4">
                    {{-- Menú de navegación --}}
                    <a href="{{ route('ofertas.index') }}" class="navbar-link">Ofertas Especiales</a>
                    <a href="{{ route('sucursales.index') }}" class="navbar-link">Sucursales</a>
                    <a href="{{ route('hoteles.index') }}" class="navbar-link">Hoteles</a>
                    <a href="{{ route('vuelos.index') }}" class="navbar-link">Vuelos</a>
                    <a href="{{ route('reservaciones.index') }}" class="navbar-link">Reservaciones</a>
                    
                    {{-- Botones de Auth --}}
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="navbar-link">Dashboard</a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="navbar-link ml-4">
                                    Cerrar Sesión
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="navbar-link">Iniciar Sesión</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="navbar-link">Registrarse</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </nav>

        {{-- Main Content --}}
        <main class="py-16 mt-16"> {{-- Añade py-16 para espacio del navbar fijo --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative max-w-7xl mx-auto mb-4" role="alert">
                    <strong class="font-bold">¡Éxito!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" onclick="this.parentElement.parentElement.style.display='none';"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.697l-2.651 2.652a1.2 1.2 0 1 1-1.697-1.697L8.303 10 5.651 7.348a1.2 1.2 0 1 1 1.697-1.697L10 8.303l2.651-2.652a1.2 1.2 0 0 1 1.697 1.697L11.697 10l2.651 2.651a1.2 1.2 0 0 1 0 1.698z"/></svg>
                    </span>
                </div>
            @endif

            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="py-6 text-center text-sm text-gray-500 dark:text-gray-400 bg-gray-200 dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <p>&copy; {{ date('Y') }} Viajes Increíbles. Todos los derechos reservados.</p>
                <p class="mt-2">Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</p>
            </div>
        </footer>
    </div>
</body>
</html>