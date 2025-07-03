@extends('layouts.app')

@section('title', 'Mi Panel de Control - Viajes Increíbles')

@section('content')
<div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
            <h2 class="font-semibold text-3xl text-gray-800 dark:text-gray-200 leading-tight mb-6">
                ¡Bienvenido de nuevo, {{ $user->name }}!
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                {{-- Card de Información Personal --}}
                <div class="bg-blue-100 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold text-blue-800 dark:text-blue-200 mb-3">Tu Perfil</h3>
                    <p class="text-gray-700 dark:text-gray-300">
                        <strong>Email:</strong> {{ $user->email }}<br>
                        @if($user->apellidoPat) <strong>Nombre Completo:</strong> {{ $user->name }} {{ $user->apellidoPat }} {{ $user->apellidoMat ?? '' }}<br> @endif
                        @if($user->direccion) <strong>Dirección:</strong> {{ $user->direccion }}<br> @endif
                        @if($user->telefono) <strong>Teléfono:</strong> {{ $user->telefono }}<br> @endif
                        <strong>Tu Rol:</strong> <span class="capitalize">{{ $user->role }}</span>
                    </p>
                    <div class="mt-4 text-right">
                        <a href="{{ route('profile.edit') }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm">Gestionar Perfil</a>
                    </div>
                </div>

                {{-- Card de Información General de la Agencia --}}
                <div class="bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold text-green-800 dark:text-green-200 mb-3">Sobre Viajes Increíbles</h3>
                    <p class="text-gray-700 dark:text-gray-300 mb-3">
                        Tu puerta al mundo. En Viajes Increíbles, convertimos tus sueños de viaje en realidad con destinos exóticos y experiencias inolvidables.
                    </p>
                    <p class="text-gray-700 dark:text-gray-300 text-sm">
                        Contamos con un equipo de expertos listos para ayudarte a planificar tu próxima aventura, garantizando la mejor calidad y precios.
                    </p>
                </div>

                {{-- Card de Acción Rápida o Estadísticas (Ejemplo) --}}
                <div class="bg-purple-100 dark:bg-purple-900 border border-purple-200 dark:border-purple-700 rounded-lg shadow-md p-6 flex flex-col justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-purple-800 dark:text-purple-200 mb-3">Explora y Reserva</h3>
                        <p class="text-gray-700 dark:text-gray-300 mb-4">
                            Encuentra tu próximo destino o gestiona tus reservas.
                        </p>
                    </div>
                    <div class="text-right">
                        <a href="{{ route('vuelos.index') }}" class="text-purple-600 dark:text-purple-400 hover:underline text-sm block">Buscar Vuelos</a>
                        <a href="{{ route('hoteles.index') }}" class="text-purple-600 dark:text-purple-400 hover:underline text-sm block mt-1">Buscar Hoteles</a>
                        <a href="{{ route('reservaciones.create') }}" class="text-purple-600 dark:text-purple-400 hover:underline text-sm block mt-1">Hacer una Nueva Reservación</a>
                    </div>
                </div>
            </div>

            {{-- Sección: Mis Próximas Reservaciones --}}
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 lg:p-8 mb-10">
                <h3 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight mb-4">
                    Mis Próximas Reservaciones
                </h3>

                @if($upcomingReservations->isEmpty())
                    <div class="text-center text-gray-600 dark:text-gray-400 py-8">
                        <p class="mb-4">No tienes reservaciones próximas. ¡Es hora de planificar una aventura!</p>
                        <a href="{{ route('reservaciones.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
                            Reservar Ahora
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        Fecha Viaje
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        Tipo
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        Detalles
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        Total
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($upcomingReservations as $reservation)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-200">
                                        {{ $reservation->fechaViaje->format('d/m/Y') }}
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-200">
                                        @if($reservation->hotel) Hotel @endif
                                        @if($reservation->vuelo) @if($reservation->hotel) & @endif Vuelo @endif
                                        @if(!$reservation->hotel && !$reservation->vuelo) Otro @endif
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-200">
                                        @if($reservation->hotel) {{ $reservation->hotel->nombre }} ({{ $reservation->hotel->ciudad }})<br> @endif
                                        @if($reservation->vuelo) {{ $reservation->vuelo->origen }} &rarr; {{ $reservation->vuelo->destino }} @endif
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-200">
                                        ${{ number_format($reservation->totalCotizacion, 2) }}
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                                        <a href="{{ route('reservaciones.show', $reservation->idReservacionPK) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200">Ver Detalles</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            {{-- Sección de Inspiración de Viajes --}}
            <div class="bg-gray-100 dark:bg-gray-800 shadow-md rounded-lg p-6 lg:p-8">
                <h3 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight mb-4 text-center">
                    Inspiración para tu Próxima Aventura
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="flex flex-col items-center">
                        <img src="{{ asset('img/playas.jpg') }}" alt="Playa" class="rounded-lg shadow-md mb-2 w-full h-32 object-cover">
                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Playas Paradisiacas</p>
                    </div>
                    <div class="flex flex-col items-center">
                        <img src="{{ asset('img/montañas.jpg') }}" alt="Montañas" class="rounded-lg shadow-md mb-2 w-full h-32 object-cover">
                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Aventuras en la Montaña</p>
                    </div>
                    <div class="flex flex-col items-center">
                        <img src="{{ asset('img/ciudad.jpg') }}" alt="Ciudad" class="rounded-lg shadow-md mb-2 w-full h-32 object-cover">
                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Explora Ciudades</p>
                    </div>
                    <div class="flex flex-col items-center">
                        <img src="{{ asset('img/naturaleza.jpg') }}" alt="Naturaleza" class="rounded-lg shadow-md mb-2 w-full h-32 object-cover">
                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Contacto con la Naturaleza</p>
                    </div>
                </div>
                <div class="text-center mt-8">
                    <a href="{{ route('hoteles.index') }}" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-105 transition duration-300 ease-in-out">
                        Ver Ofertas Especiales
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection