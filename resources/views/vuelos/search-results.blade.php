@extends('layouts.app')

@section('title', 'Resultados de Búsqueda de Vuelos')

@section('content')
<div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
            <h2 class="font-semibold text-3xl text-gray-800 dark:text-gray-200 leading-tight mb-6 text-center">
                Vuelos Encontrados para {{ $request->origen }} &rarr; {{ $request->destino }}
                @if($request->fecha_regreso)
                    <br>({{ $request->fecha_salida }} - {{ $request->fecha_regreso }})
                @else
                    <br>({{ $request->fecha_salida }})
                @endif
            </h2>

            <div class="text-center mb-6">
                <a href="{{ route('vuelos.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Volver a la búsqueda</a>
            </div>

            @if($foundFlights->isEmpty())
                <div class="text-center text-gray-600 dark:text-gray-400 py-8">
                    <p class="mb-4">Lo sentimos, no encontramos vuelos que coincidan con tu búsqueda.</p>
                    <p>Intenta con otras fechas u orígenes/destinos.</p>
                </div>
            @else
                @if($alternativeDates)
                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-6" role="alert">
                        <strong class="font-bold">¡Nota!</strong>
                        <span class="block sm:inline">No encontramos vuelos exactos para tu fecha. Aquí hay resultados para los próximos 3 días.</span>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($foundFlights as $flight)
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md p-6 flex flex-col justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                                    {{ $flight->origen }} &rarr; {{ $flight->destino }}
                                </h3>
                                <p class="text-gray-700 dark:text-gray-300 mb-1">
                                    <strong class="font-semibold">Fecha:</strong> {{ $flight->fecha->format('d/m/Y') }}
                                </p>
                                <p class="text-gray-700 dark:text-gray-300 mb-1">
                                    <strong class="font-semibold">Hora:</strong> {{ $flight->hora->format('H:i') }}
                                </p>
                                <p class="text-gray-700 dark:text-gray-300 mb-1">
                                    <strong class="font-semibold">Pensión Incluida:</strong> {{ $flight->pension ?? 'Ninguna' }}
                                </p>
                                <p class="text-gray-700 dark:text-gray-300 mb-1">
                                    <strong class="font-semibold">Plazas disponibles:</strong> {{ $flight->plazasTotales - $flight->plazasTurista }}
                                </p>
                                <p class="text-lg font-bold text-blue-600 dark:text-blue-400 mt-3">
                                    Precio Estimado: ${{ number_format($flight->estimated_price, 2) }}
                                    <span class="text-sm font-normal text-gray-600 dark:text-gray-400"> (para {{ $numPasajeros }} pers.)</span>
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    *El precio final puede variar según pensión y hotel.
                                </p>
                            </div>
                            <div class="mt-4 text-right">
                                {{-- ¡CAMBIO AQUÍ! Ahora el formulario va a la ruta de confirmación --}}
                                @auth
                                <form action="{{ route('vuelos.confirmPurchase', $flight->idVueloPK) }}" method="GET" class="inline-block">
                                    <input type="hidden" name="pasajeros" value="{{ $numPasajeros }}">
                                    <input type="hidden" name="fecha_viaje" value="{{ $request->fecha_salida }}">
                                    <input type="hidden" name="estimated_price" value="{{ $flight->estimated_price }}">
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
                                        Comprar este Vuelo
                                    </button>
                                </form>
                                @else
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <a href="{{ route('login') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Inicia sesión</a> para comprar este vuelo.
                                </p>
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection