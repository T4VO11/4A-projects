@extends('layouts.app')

@section('title', 'Confirmar Compra de Vuelo')

@section('content')
<div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
            <h2 class="font-semibold text-3xl text-gray-800 dark:text-gray-200 leading-tight mb-6 text-center">
                Confirmar Compra de Vuelo
            </h2>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">¡Ups!</strong>
                    <span class="block sm:inline">Hubo algunos problemas con tu información.</span>
                    <ul class="mt-3 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Sección de Detalles del Vuelo --}}
                <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-6 shadow-md">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 border-b pb-2">Detalles del Vuelo</h3>
                    <p class="text-gray-700 dark:text-gray-300 mb-2">
                        <strong class="font-semibold">Ruta:</strong> {{ $flight->origen }} &rarr; {{ $flight->destino }}
                    </p>
                    <p class="text-gray-700 dark:text-gray-300 mb-2">
                        <strong class="font-semibold">Fecha:</strong> {{ \Carbon\Carbon::parse($fechaViaje)->format('d/m/Y') }}
                    </p>
                    <p class="text-gray-700 dark:text-gray-300 mb-2">
                        <strong class="font-semibold">Hora de Salida:</strong> {{ $flight->hora->format('H:i') }}
                    </p>
                    <p class="text-gray-700 dark:text-gray-300 mb-2">
                        <strong class="font-semibold">Plazas disponibles:</strong> {{ $flight->plazasTotales - $flight->plazasTurista }}
                    </p>
                    
                    {{-- Campo editable: Número de Pasajeros --}}
                    <div class="mb-2">
                        <label for="numPasajerosInput" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-1">Número de Pasajeros:</label>
                        <input type="number" name="numeroPersonas" id="numPasajerosInput" value="{{ old('numeroPersonas', $numPasajeros) }}" min="1" max="{{ $flight->plazasTotales - $flight->plazasTurista }}" required
                               class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Máx. {{ $flight->plazasTotales - $flight->plazasTurista }} disponibles.</p>
                    </div>

                    {{-- Campo editable: Pensión Incluida --}}
                    <div class="mb-2">
                        <label for="pensionElegidaSelect" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-1">Pensión Elegida:</label>
                        <select name="pensionElegida" id="pensionElegidaSelect" 
                                class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                            <option value="">Ninguna</option>
                            <option value="Completa" {{ old('pensionElegida', $flight->pension) == 'Completa' ? 'selected' : '' }}>Completa</option>
                            <option value="Media" {{ old('pensionElegida', $flight->pension) == 'Media' ? 'selected' : '' }}>Media Pensión</option>
                            <option value="Solo Desayuno" {{ old('pensionElegida', $flight->pension) == 'Solo Desayuno' ? 'selected' : '' }}>Solo Desayuno</option>
                        </select>
                    </div>

                    <p class="text-2xl font-bold text-blue-600 dark:text-blue-400 mt-4">
                        Total a Pagar: $<span id="totalCotizacionDisplay">{{ number_format($estimatedPrice, 2) }}</span>
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                        *El precio final puede variar con opciones adicionales.
                    </p>
                </div>

                {{-- Sección de Datos del Usuario --}}
                <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-6 shadow-md">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 border-b pb-2">Tus Datos Personales</h3>
                    <p class="text-gray-700 dark:text-gray-300 mb-2">
                        <strong>Nombre:</strong> {{ $user->name }}
                    </p>
                    <p class="text-gray-700 dark:text-gray-300 mb-2">
                        <strong>Email:</strong> {{ $user->email }}
                    </p>

                    {{-- Formulario que envía a ReservacionController@store --}}
                    <form action="{{ route('reservaciones.store') }}" method="POST" class="mt-4 space-y-4">
                        @csrf
                        {{-- Campos Ocultos para pasar los detalles del vuelo y búsqueda --}}
                        <input type="hidden" name="idVueloFK" value="{{ $flight->idVueloPK }}">
                        <input type="hidden" name="fechaViaje" value="{{ $fechaViaje }}">
                        <input type="hidden" name="idUsuarioFK" value="{{ $user->id }}">
                        
                        {{-- totalCotizacion hidden input actualizado por JS --}}
                        <input type="hidden" name="totalCotizacion" id="totalCotizacionHiddenInput" value="{{ $estimatedPrice }}"> 
                        
                        {{-- Los campos de pasajeros y pensión ahora son editables, no ocultos --}}
                        
                        {{-- Campos de Perfil Adicionales (editable si vacío, read-only si lleno) --}}
                        <div>
                            <label for="apellidoPat" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-1">Apellido Paterno:</label>
                            <input type="text" name="apellidoPat" id="apellidoPat" value="{{ old('apellidoPat', $user->apellidoPat) }}" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
                                @if($user->apellidoPat) readonly @endif>
                            @if(!$user->apellidoPat) <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Necesario para la reservación.</p> @endif
                        </div>
                        <div>
                            <label for="apellidoMat" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-1">Apellido Materno:</label>
                            <input type="text" name="apellidoMat" id="apellidoMat" value="{{ old('apellidoMat', $user->apellidoMat) }}" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
                                @if($user->apellidoMat) readonly @endif>
                            @if(!$user->apellidoMat) <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Necesario para la reservación.</p> @endif
                        </div>
                        <div>
                            <label for="direccion" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-1">Dirección:</label>
                            <input type="text" name="direccion" id="direccion" value="{{ old('direccion', $user->direccion) }}" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
                                @if($user->direccion) readonly @endif>
                            @if(!$user->direccion) <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Necesaria para la reservación.</p> @endif
                        </div>
                        <div>
                            <label for="telefono" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-1">Teléfono:</label>
                            <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $user->telefono) }}" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
                                @if($user->telefono) readonly @endif>
                            @if(!$user->telefono) <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Necesario para la reservación.</p> @endif
                        </div>

                        {{-- Botón Final de Confirmación (Aquí irían las opciones de pago) --}}
                        <div class="text-center mt-6">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Selecciona tu método de pago:</p>
<a href="https://www.paypal.com/ncp/payment/3M3XDBXS2BD74"
   target="_blank"
   rel="noopener noreferrer"
   class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-4 py-2 rounded">
   💳 Pagar con PayPal
</a>
                            </button>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-4">
                                Al confirmar, aceptas nuestros términos y condiciones.
                            </p>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center mt-8">
                <a href="{{ route('vuelos.index') }}" class="inline-block text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-semibold">
                    Volver a la búsqueda
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const BASE_PRICE_PER_PERSON = {{ App\Http\Controllers\ReservacionController::BASE_PRICE_PER_PERSON }};
        const HOTEL_ADDON_PRICE = {{ App\Http\Controllers\ReservacionController::HOTEL_ADDON_PRICE }};
        const VUELO_ADDON_PRICE = {{ App\Http\Controllers\ReservacionController::VUELO_ADDON_PRICE }};

        const PENSION_SURCHARGE = {
            'Completa': {{ App\Http\Controllers\ReservacionController::PENSION_SURCHARGE['Completa'] ?? 0 }},
            'Media': {{ App\Http\Controllers\ReservacionController::PENSION_SURCHARGE['Media'] ?? 0 }},
            'Solo Desayuno': {{ App\Http\Controllers\ReservacionController::PENSION_SURCHARGE['Solo Desayuno'] ?? 0 }},
            '': 0 
        };

        const numPasajerosInput = document.getElementById('numPasajerosInput');
        const pensionElegidaSelect = document.getElementById('pensionElegidaSelect');
        const totalCotizacionDisplay = document.getElementById('totalCotizacionDisplay');
        const totalCotizacionHiddenInput = document.getElementById('totalCotizacionHiddenInput');

        const initialNumPasajeros = parseInt(numPasajerosInput.value) || 0;
        const initialVueloSelected = '{{ $flight->idVueloPK }}'; 
        const initialHotelSelected = ''; 
        
        function calculateAndDisplayCotizacion() {
            let total = 0;

            const numeroPersonas = parseInt(numPasajerosInput.value) || 0;
            const pensionElegida = pensionElegidaSelect.value;
            const vueloSeleccionado = initialVueloSelected; 

            total += numeroPersonas * BASE_PRICE_PER_PERSON;

            total += numeroPersonas * (PENSION_SURCHARGE[pensionElegida] || 0);

            if (vueloSeleccionado) {
                total += VUELO_ADDON_PRICE;
            }

            totalCotizacionDisplay.textContent = total.toFixed(2);
            totalCotizacionHiddenInput.value = total.toFixed(2);
        }

        numPasajerosInput.addEventListener('input', calculateAndDisplayCotizacion);
        pensionElegidaSelect.addEventListener('change', calculateAndDisplayCotizacion);

        calculateAndDisplayCotizacion();
    });
</script>
@endsection