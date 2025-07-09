@extends('layouts.app')

@section('title', 'Ofertas Especiales - Viajes Increíbles')

@section('content')
<div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
            <h2 class="font-semibold text-3xl text-gray-800 dark:text-gray-200 leading-tight mb-6 text-center">
                ¡Nuestras Ofertas y Promociones!
            </h2>
            <p class="text-center text-lg text-gray-600 dark:text-gray-400 mb-10">
                Aprovecha nuestras promociones exclusivas y viaja al destino de tus sueños con precios increíbles.
            </p>

            @if(empty($ofertas))
                <div class="text-center text-gray-600 dark:text-gray-400 py-8">
                    <p class="mb-4">Lo sentimos, no hay ofertas especiales disponibles en este momento. ¡Vuelve pronto!</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($ofertas as $oferta)
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition duration-300">
                            @if($oferta['imagen_url'])
                                <img src="{{ $oferta['imagen_url'] }}" alt="Imagen de {{ $oferta['titulo'] }}" class="w-full h-48 object-cover">
                            @else
                                <img src="https://source.unsplash.com/random/400x300/?travel,offer" alt="Oferta Especial" class="w-full h-48 object-cover">
                            @endif
                            
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $oferta['titulo'] }}</h3>
                                <p class="text-gray-600 dark:text-gray-300 text-sm mb-2">
                                    {{ $oferta['descripcion'] }}
                                </p>
                                @if($oferta['precio_desde'])
                                    <p class="text-xl font-bold text-green-600 dark:text-green-400 mt-3 mb-2">
                                        Desde: ${{ number_format($oferta['precio_desde'], 2) }}
                                    </p>
                                @endif
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Vigencia: {{ $oferta['vigencia'] }}
                                </p>
                                
                                <div class="mt-4 text-right">
                                    {{-- ¡¡¡LÓGICA PARA LOS BOTONES DE LA OFERTA!!! --}}
                                    @if(isset($oferta['paypal_payment_link']) && $oferta['paypal_payment_link'])
                                        {{-- Botón que va directo a PayPal --}}
                                        <a href="{{ $oferta['paypal_payment_link'] }}" target="_blank" rel="noopener noreferrer" 
                                           class="inline-block bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded-lg shadow-md text-sm transition duration-300">
                                            Pagar con PayPal
                                        </a>
                                    @elseif(isset($oferta['vuelo_id_asociado']) && $oferta['vuelo_id_asociado'])
                                        {{-- Botón que va a los detalles de la oferta dentro de la app (con vuelo asociado) --}}
                                        <a href="{{ route('ofertas.showDetails', ['offerId' => $oferta['id']]) }}" 
                                           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md text-sm transition duration-300">
                                            ¡Reservar Ahora!
                                        </a>
                                    @else
                                        {{-- Botón que va a la búsqueda general de vuelos (sin vuelo asociado directo) --}}
                                        <form action="{{ route('vuelos.index') }}" method="GET" class="inline-block">
                                            @if(isset($oferta['origen_prefill']) && $oferta['origen_prefill'])
                                                <input type="hidden" name="origen" value="{{ $oferta['origen_prefill'] }}">
                                            @endif
                                            @if(isset($oferta['destino_prefill']) && $oferta['destino_prefill'])
                                                <input type="hidden" name="destino" value="{{ $oferta['destino_prefill'] }}">
                                            @endif
                                            @if(isset($oferta['fecha_prefill']) && $oferta['fecha_prefill'])
                                                <input type="hidden" name="fecha_salida" value="{{ $oferta['fecha_prefill'] }}">
                                            @endif
                                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md text-sm transition duration-300">
                                                Ver Oferta
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection