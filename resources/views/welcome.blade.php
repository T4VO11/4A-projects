<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Viajes Increíbles - Tu Agencia de Sueños</title>

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
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }
    .animate-fade-in-down {
        animation: fadeInDown 1s ease-out forwards;
    }

    .animate-fade-in-up {
        animation: fadeInUp 1s ease-out forwards;
    }

    .animate-bounce-slow {
        animation: bounce 2s infinite;
    }
</style>
    </head>
    <body class="antialiased bg-gray-50 dark:bg-gray-900">
        <div class="relative min-h-screen">
            {{-- Barra de navegación y botones de Login/Register --}}
            @if (Route::has('login'))
                <div class="fixed top-0 right-0 p-6 text-right z-20">
                    {{-- Nuevos elementos del menú con rutas con nombre --}}
                        <a href="{{ route('ofertas.index') }}" class="font-semibold text-white hover:text-gray-300 dark:text-white-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-blue-500 transition duration-300 mr-4">Ofertas Especiales  </a>
                        <a href="{{ route('sucursales.index') }}" class="font-semibold text-white hover:text-gray-300 dark:text-white-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-blue-500 transition duration-300 mr-4">Sucursales</a>
                        <a href="{{ route('hoteles.index') }}" class="font-semibold text-white hover:text-gray-300 dark:text-white-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-blue-500 transition duration-300 mr-4">Hoteles</a>
                        <a href="{{ route('vuelos.index') }}" class="font-semibold text-white hover:text-gray-300 dark:text-white-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-blue-500 transition duration-300 mr-4">Vuelos</a>
                        <a href="{{ route('reservaciones.index') }}" class="font-semibold text-white hover:text-gray-300 dark:text-white-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-blue-500 transition duration-300 mr-4">Reservaciones</a>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-white hover:text-gray-300 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 transition duration-300">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-white hover:text-gray-300 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 transition duration-300 ml-4">Iniciar Sesión</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-white hover:text-gray-300 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 transition duration-300">Registrarse</a>
                        @endif
                    @endauth
                </div>
            @endif

            {{-- Sección Hero (Encabezado con imagen de fondo) --}}
            <header class="hero-background relative flex items-center justify-center h-screen bg-gray-800 bg-opacity-70 text-white p-6">
                <div class="absolute inset-0 bg-black opacity-40"></div> {{-- Overlay para oscurecer la imagen --}}
                <div class="relative z-10 text-center max-w-4xl mx-auto">
                    <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold leading-tight mb-4 animate-fade-in-down">Descubre Tu Próxima Aventura</h1>
                    <p class="text-lg sm:text-xl md:text-2xl mb-8 opacity-90 animate-fade-in-up">Explora destinos exóticos, vive experiencias inolvidables y crea recuerdos para toda la vida.</p>
                    <a href="{{ route('ofertas.index') }}" id="scroll-down-button" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-full text-lg shadow-lg transform hover:scale-105 transition duration-300 ease-in-out">
                        Ver Ofertas Especiales
                    </a>
                    {{-- Flecha para bajar --}}
                    <div class="mt-12 text-center">
                        <a href="#destinos-populares" class="inline-block cursor-pointer text-white animate-bounce-slow" aria-label="Bajar para ver destinos">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </a>
                    </div>
                </div>
            </header>

            {{-- Sección de Destinos Populares --}}
            <section id="destinos-populares" class="py-16 bg-white dark:bg-gray-800">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-12">Destinos Populares</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {{-- Tarjeta de Destino 1 --}}
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition duration-300">
                            <img src="{{ asset('img/paris.jpg') }}" alt="París" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">París, Francia</h3>
                                <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed mb-4">La ciudad del amor y las luces, con su icónica Torre Eiffel y museos de clase mundial.</p>
                                <a href="#" class="inline-block text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-semibold">Explorar</a>
                            </div>
                        </div>
                        {{-- Tarjeta de Destino 2 --}}
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition duration-300">
                            <img src="{{ asset('img/kioto.jpg') }}" alt="Kioto" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Kioto, Japón</h3>
                                <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed mb-4">Sumérgete en la cultura ancestral con templos, jardines y la belleza de los cerezos.</p>
                                <a href="#" class="inline-block text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-semibold">Explorar</a>
                            </div>
                        </div>
                        {{-- Tarjeta de Destino 3 --}}
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition duration-300">
                            <img src="{{ asset('img/peru.jpg') }}" alt="Machu Picchu" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Machu Picchu, Perú</h3>
                                <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed mb-4">La majestuosa ciudadela inca, una maravilla del mundo que te dejará sin aliento.</p>
                                <a href="#" class="inline-block text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-semibold">Explorar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Sección de "Por qué elegirnos" --}}
            <section class="py-16 bg-gray-100 dark:bg-gray-900">
                <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-12">¿Por Qué Elegirnos?</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mx-auto text-blue-600 mb-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Experiencia Personalizada</h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">Creamos itinerarios a tu medida para que cada viaje sea único.</p>
                        </div>
                        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mx-auto text-blue-600 mb-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659L9 9.182m5.99-2.915A2.25 2.25 0 0113.5 10.5H12a2.25 2.25 0 00-2.25 2.25V15m0 0v2.25m0-2.25A1.5 1.5 0 0012 15.75a1.5 1.5 0 001.5-1.5V12a1.5 1.5 0 00-1.5-1.5H12c-.75 0-1.5.75-1.5 1.5M12 19.58v-2.25m0 0a1.5 1.5 0 011.5-1.5H12a1.5 1.5 0 00-1.5 1.5v2.25m-2.25-2.25v-.87M12 18.75a.75.75 0 00.75-.75v-2.25m-3 0v.87M12 18.75c-1.243 0-2.503-.493-3.536-1.526A4.5 4.5 0 014.5 12H3c0 2.75 1.118 5.257 2.918 7.057M12 18.75V19.5a2.25 2.25 0 002.25 2.25h2.25M4.5 12H3c0-2.75 1.118-5.257 2.918-7.057M12 12c-1.243 0-2.503-.493-3.536-1.526A4.5 4.5 0 014.5 6H3m0 0h3.375c.621 0 1.125.504 1.125 1.125V9a2.25 2.25 0 00-2.25-2.25H4.125M21 12c0 2.75-1.118 5.257-2.918 7.057M12 12c1.243 0 2.503-.493 3.536-1.526A4.5 4.5 0 0019.5 6H21m0 0h-3.375c-.621 0-1.125.504-1.125 1.125V9a2.25 2.25 0 012.25-2.25h.375M12 12v.008v-.008z" />
                            </svg>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Precios Insuperables</h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">Garantizamos las mejores tarifas y ofertas exclusivas.</p>
                        </div>
                        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mx-auto text-blue-600 mb-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9.75h19.5M2.25 12l2.5-2.5L12 17.25l8.25-6.5L21.75 12m-2.25 4.5h2.25V18a2.25 2.25 0 01-2.25 2.25H4.5A2.25 2.25 0 012.25 18v-1.5h2.25m0-9h15V7.5a2.25 2.25 0 00-2.25-2.25H4.5A2.25 2.25 0 002.25 7.5v1.5m0 0h19.5" />
                            </svg>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Soporte 24/7</h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">Siempre a tu disposición para cualquier consulta o emergencia.</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Pie de página --}}
            <footer class="py-10 text-center text-sm text-gray-500 dark:text-gray-400 bg-gray-200 dark:bg-gray-900">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <p>&copy; {{ date('Y') }} Viajes Increíbles. Todos los derechos reservados.</p>
                    <p class="mt-2">Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</p>
                </div>
            </footer>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const scrollDownButton = document.querySelector('.hero-background .animate-bounce-slow');
                const destinosSection = document.getElementById('destinos-populares');

                if (scrollDownButton && destinosSection) {
                    scrollDownButton.addEventListener('click', function(e) {
                        e.preventDefault();
                        
                        destinosSection.scrollIntoView({
                            behavior: 'smooth'
                        });
                    });
                }
            });
        </script>
    </body>
</html>