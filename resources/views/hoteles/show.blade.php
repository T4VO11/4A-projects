@extends('layouts.app')

@section('title', $hotel->nombre . ' - Detalles del Hotel')

@section('content')
<div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
            <div class="flex justify-between items-start mb-6">
                <h1 class="font-bold text-4xl text-gray-900 dark:text-gray-100">{{ $hotel->nombre }}</h1>
                <div class="text-right">
                    {{-- Si star_rating viene de BD, asegúrate de tener la columna. Aquí asumimos 4 si no viene --}}
                    <p class="text-xl font-bold text-gray-800 dark:text-gray-200">
                        @for ($i = 0; $i < ($hotel->star_rating ?? 4); $i++) {{-- Usar un default si no viene de BD --}}
                            ⭐
                        @endfor
                        ({{ $hotel->star_rating ?? 4 }} Estrellas)
                    </p>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $hotel->ciudad }}</p>
                </div>
            </div>

            {{-- Galería de Imágenes (Ahora lee de $hotel->images) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-8">
                {{-- Imagen principal del hotel --}}
                @if($hotel->imagen_url)
                    <img src="{{ asset($hotel->imagen_url) }}" alt="{{ $hotel->nombre }} - Principal" 
                         class="w-full h-48 object-cover rounded-lg shadow-md hover:scale-105 transition duration-300 cursor-pointer">
                @else
                    <img src="https://source.unsplash.com/random/800x600/?hotel,exterior,building" alt="Hotel Exterior" class="w-full h-48 object-cover rounded-lg shadow-md hover:scale-105 transition duration-300 cursor-pointer">
                @endif

                @foreach($hotel->images as $index => $img)
                    <img src="{{ asset($img->image_url) }}" alt="{{ $hotel->nombre }} - Foto {{ $index + 1 }}" 
                         class="w-full h-48 object-cover rounded-lg shadow-md hover:scale-105 transition duration-300 cursor-pointer">
                @endforeach
            </div>

            {{-- Resumen e Información General --}}
            <div class="mb-8">
                <p class="text-gray-700 dark:text-gray-300 text-lg leading-relaxed">{{ $hotel->descripcion }}</p>
                <div class="mt-4 text-gray-600 dark:text-gray-400">
                    <p><strong>Dirección:</strong> {{ $hotel->direccion }}</p>
                    <p><strong>Teléfono:</strong> {{ $hotel->telefono }}</p>
                    <p><strong>Sucursal:</strong> {{ $hotel->sucursal->nombre ?? 'N/A' }}</p>
                </div>
            </div>

            {{-- Información de la Propiedad (Amenidades) - ¡AÚN HARDCODEADO A MENOS QUE TENGAS UNA TABLA! --}}
            <div class="mb-8">
                <h3 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight mb-4 border-b pb-2">Información de la Propiedad</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    {{-- Aquí debes decidir cómo gestionar las amenidades. Si no hay tabla, puedes hardcodearlas aquí --}}
                    {{-- O cargar desde el controlador como hicimos en un paso previo --}}
                    @php
                        $amenities_info_static = [ // ESTO ES UN EJEMPLO, MUEVELO A UN LUGAR ADECUADO SI ES ESTATICO
                            ['nombre' => 'Alberca al aire libre', 'icon' => '🏊', 'disponible' => true],
                            ['nombre' => 'Restaurante gourmet', 'icon' => '🍽️', 'disponible' => true],
                            ['nombre' => 'Bar / Lounge', 'icon' => '🍸', 'disponible' => true],
                            ['nombre' => 'Wi-Fi gratuito', 'icon' => '📶', 'disponible' => true],
                            ['nombre' => 'Gimnasio', 'icon' => '🏋️‍♂️', 'disponible' => true],
                            ['nombre' => 'Spa y bienestar', 'icon' => '🧘‍♀️', 'disponible' => true],
                            ['nombre' => 'Estacionamiento gratuito', 'icon' => '🅿️', 'disponible' => true],
                            ['nombre' => 'Servicio a la habitación', 'icon' => '🛎️', 'disponible' => true],
                            ['nombre' => 'Centro de negocios', 'icon' => '💼', 'disponible' => false],
                        ];
                    @endphp
                    @foreach($amenities_info_static as $amenity)
                        <div class="flex items-center text-gray-700 dark:text-gray-300">
                            <span class="mr-2 text-xl">{{ $amenity['icon'] }}</span>
                            <span>{{ $amenity['nombre'] }}</span>
                            @if(!$amenity['disponible'])
                                <span class="ml-2 text-red-500 text-xs">(No disponible)</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Tipos de Habitaciones (Ahora lee de $hotel->roomTypes) --}}
            <div class="mb-8">
                <h3 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight mb-4 border-b pb-2">Tipos de Habitaciones</h3>
                @if($hotel->roomTypes->isEmpty())
                    <p class="text-gray-600 dark:text-gray-400">No hay tipos de habitación registrados para este hotel.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($hotel->roomTypes as $roomType)
                            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md overflow-hidden flex">
                                @if($roomType->image_url)
                                    <img src="{{ asset($roomType->image_url) }}" alt="{{ $roomType->name }}" class="w-1/3 h-auto object-cover">
                                @else
                                    <img src="https://source.unsplash.com/random/400x300/?hotel-room" alt="Habitación" class="w-1/3 h-auto object-cover">
                                @endif
                                <div class="p-4 flex-1">
                                    <h4 class="font-bold text-lg text-gray-900 dark:text-gray-100 mb-1">{{ $roomType->name }}</h4>
                                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-2">Capacidad: {{ $roomType->capacity }}</p>
                                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-3">{{ $roomType->description }}</p>
                                    <p class="text-xl font-bold text-blue-600 dark:text-blue-400">
                                        Precio: ${{ number_format($roomType->price, 2) }} / noche
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Botones de Acción (Volver y Reservar) --}}
            <div class="flex justify-center space-x-4 mt-8">
                <a href="{{ route('hoteles.index') }}" class="inline-block bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:shadow-outline transition duration-300">
                    Volver a Hoteles
                </a>
                <a href="{{ route('reservaciones.create') }}?hotel_id={{ $hotel->idHotel }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:shadow-outline transition duration-300">
                    Reservar Ahora
                </a>
            </div>
        </div>
    </div>
</div>
@endsection