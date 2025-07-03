@extends('layouts.app')

@section('title', 'Buscar y Explorar Vuelos - Viajes Increíbles')

@section('content')
<div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
            <h2 class="font-semibold text-3xl text-gray-800 dark:text-gray-200 leading-tight mb-6 text-center">
                Encuentra tu Próximo Vuelo
            </h2>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">¡Ups!</strong>
                    <span class="block sm:inline">Hubo algunos problemas con tu búsqueda.</span>
                    <ul class="mt-3 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FORMULARIO DE BÚSQUEDA --}}
            <form action="{{ route('vuelos.index') }}" method="GET" class="space-y-6 mb-10"> {{-- ¡CAMBIO AQUÍ EL ACTION! --}}
                {{-- Toggle de Tipo de Viaje (Ida y Vuelta / Solo Ida) --}}
                <div class="flex items-center space-x-4 mb-6">
                    <label class="inline-flex items-center">
                        <input type="radio" name="tipo_viaje" value="ida_vuelta" class="form-radio text-blue-600 dark:text-blue-400" {{ old('tipo_viaje', $request->tipo_viaje ?? 'ida_vuelta') == 'ida_vuelta' ? 'checked' : '' }}>
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Ida y Vuelta</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="tipo_viaje" value="solo_ida" class="form-radio text-blue-600 dark:text-blue-400" {{ old('tipo_viaje', $request->tipo_viaje ?? '') == 'solo_ida' ? 'checked' : '' }}>
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Solo Ida</span>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="origen" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Origen</label>
                        <select name="origen" id="origen" {{ $request->filled('origen') ? 'required' : '' }} {{-- Hazlo requerido solo si ya hay búsqueda --}}
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                            <option value="">Selecciona un origen</option>
                            @foreach($origenes as $origenOption)
                                <option value="{{ $origenOption }}" {{ old('origen', $request->origen) == $origenOption ? 'selected' : '' }}>{{ $origenOption }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="destino" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Destino</label>
                        <select name="destino" id="destino" {{ $request->filled('destino') ? 'required' : '' }} {{-- Hazlo requerido solo si ya hay búsqueda --}}
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                            <option value="">Selecciona un destino</option>
                            @foreach($destinos as $destinoOption)
                                <option value="{{ $destinoOption }}" {{ old('destino', $request->destino) == $destinoOption ? 'selected' : '' }}>{{ $destinoOption }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="fecha_salida" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fecha de Salida</label>
                        <input type="date" name="fecha_salida" id="fecha_salida" value="{{ old('fecha_salida', $request->fecha_salida) }}" {{ $request->filled('fecha_salida') ? 'required' : '' }} {{-- Hazlo requerido solo si ya hay búsqueda --}}
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                    </div>
                    <div id="fecha_regreso_container">
                        <label for="fecha_regreso" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fecha de Regreso (Opcional)</label>
                        <input type="date" name="fecha_regreso" id="fecha_regreso" value="{{ old('fecha_regreso', $request->fecha_regreso) }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                    </div>
                </div>

                <div>
                    <label for="pasajeros" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pasajeros</label>
                    <input type="number" name="pasajeros" id="pasajeros" value="{{ old('pasajeros', $request->pasajeros ?? 1) }}" required min="1"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                </div>

                <div class="text-center mt-8">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-full shadow-lg transform hover:scale-105 transition duration-300 ease-in-out">
                        Buscar Vuelos
                    </button>
                    {{-- Botón para limpiar filtros --}}
                    @if($request->filled(['origen', 'destino', 'fecha_salida']))
                        <a href="{{ route('vuelos.index') }}" class="inline-block align-baseline font-bold text-sm text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 ml-4">Limpiar Búsqueda</a>
                    @endif
                </div>
            </form>

            {{-- SECCIÓN DE VUELOS ENCONTRADOS / DISPONIBLES --}}
            <h3 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight mb-6 text-center border-t pt-8 mt-8">
                @if($request->filled(['origen', 'destino', 'fecha_salida']))
                    Vuelos Filtrados
                @else
                    Todos los Vuelos Disponibles
                @endif
            </h3>

            @if($vuelos->isEmpty())
                <div class="text-center text-gray-600 dark:text-gray-400 py-8">
                    <p class="mb-4">Lo sentimos, no encontramos vuelos que coincidan con tu búsqueda.</p>
                    <p>Intenta con otras fechas u orígenes/destinos o <a href="{{ route('vuelos.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline">limpia la búsqueda</a>.</p>
                </div>
            @else
                {{-- Mensaje si los resultados son de fechas alternativas --}}
                @if($alternativeDates)
                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-6" role="alert">
                        <strong class="font-bold">¡Nota!</strong>
                        <span class="block sm:inline">No encontramos vuelos exactos para tu fecha. Aquí hay resultados para los próximos 3 días.</span>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($vuelos as $flight)
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
                                @auth
                                <form action="{{ route('vuelos.confirmPurchase', $flight->idVueloPK) }}" method="GET" class="inline-block">
                                    <input type="hidden" name="pasajeros" value="{{ $numPasajeros }}">
                                    <input type="hidden" name="fecha_viaje" value="{{ $flight->fecha->toDateString() }}"> {{-- Usar la fecha del vuelo, no la de la búsqueda --}}
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tipoViajeRadios = document.querySelectorAll('input[name="tipo_viaje"]');
        const fechaRegresoContainer = document.getElementById('fecha_regreso_container');
        const fechaRegresoInput = document.getElementById('fecha_regreso');
        const fechaSalidaInput = document.getElementById('fecha_salida');

        function toggleFechaRegreso() {
            if (document.querySelector('input[name="tipo_viaje"]:checked').value === 'solo_ida') {
                fechaRegresoContainer.style.display = 'none';
                fechaRegresoInput.removeAttribute('required');
                fechaRegresoInput.value = ''; 
            } else {
                fechaRegresoContainer.style.display = 'block';
                fechaRegresoInput.setAttribute('required', 'required');
            }
            setFechaRegresoMinDate();
        }

        function setFechaRegresoMinDate() {
            if (fechaSalidaInput.value) {
                fechaRegresoInput.min = fechaSalidaInput.value;
                if (fechaRegresoInput.value && fechaRegresoInput.value < fechaSalidaInput.value) {
                    fechaRegresoInput.value = fechaSalidaInput.value;
                }
            } else {
                fechaRegresoInput.removeAttribute('min');
            }
        }

        tipoViajeRadios.forEach(radio => {
            radio.addEventListener('change', toggleFechaRegreso);
        });

        fechaSalidaInput.addEventListener('change', setFechaRegresoMinDate);

        // Asegurarse de que la fecha de salida mínima sea hoy
        const today = new Date().toISOString().split('T')[0];
        fechaSalidaInput.min = today;
        // Si el campo de fecha de salida está vacío al cargar, forzar el mínimo hoy
        if (!fechaSalidaInput.value) {
             fechaSalidaInput.value = today; // Opcional: pre-seleccionar hoy
        }

        // Ejecutar al cargar la página para establecer el estado inicial
        toggleFechaRegreso();
        setFechaRegresoMinDate();
    });
</script>
@endsection