@extends('layouts.app')

@section('title', 'Explora Nuestros Hoteles - Viajes Increíbles')

@section('content')
<div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
            <h2 class="font-semibold text-3xl text-gray-800 dark:text-gray-200 leading-tight mb-6 text-center">
                Hoteles para tu Próxima Aventura
            </h2>
            <p class="text-center text-lg text-gray-600 dark:text-gray-400 mb-10">
                Descubre una selección de nuestros mejores hoteles alrededor del mundo, perfectos para cualquier tipo de viaje.
            </p>

            @if($hoteles->isEmpty())
                <div class="text-center text-gray-600 dark:text-gray-400 py-8">
                    <p class="mb-4">Lo sentimos, no hay hoteles disponibles en este momento.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($hoteles as $hotel)
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition duration-300">
                            {{-- Imagen del Hotel --}}
                            @if($hotel->imagen_url)
                                <img src="{{ asset($hotel->imagen_url) }}" alt="Imagen de {{ $hotel->nombre }}" class="w-full h-48 object-cover">
                            @else
                                {{-- Imagen placeholder si no hay imagen --}}
                                <img src="https://source.unsplash.com/random/400x300/?hotel,{{ Str::slug($hotel->ciudad) }}" alt="Imagen de Hotel" class="w-full h-48 object-cover">
                            @endif
                            
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $hotel->nombre }}</h3>
                                <p class="text-gray-600 dark:text-gray-300 text-sm mb-2">
                                    <strong class="font-semibold">Ciudad:</strong> {{ $hotel->ciudad }}
                                </p>
                                <p class="text-gray-600 dark:text-gray-300 text-sm mb-2">
                                    <strong class="font-semibold">Dirección:</strong> {{ $hotel->direccion }}
                                </p>
                                <p class="text-gray-600 dark:text-gray-300 text-sm mb-2">
                                    <strong class="font-semibold">Teléfono:</strong> {{ $hotel->telefono }}
                                </p>
                                <p class="text-gray-600 dark:text-gray-300 text-sm mb-2">
                                    <strong class="font-semibold">Plazas Disponibles:</strong> {{ $hotel->plazasDisponibles }}
                                </p>
                                <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">
                                    <strong class="font-semibold">Sucursal:</strong> {{ $hotel->sucursal->nombre ?? 'N/A' }}
                                </p>
                                
                                <a href="{{ route('hoteles.show', $hotel->idHotel) }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md text-sm transition duration-300">
                                    Ver Detalles
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection