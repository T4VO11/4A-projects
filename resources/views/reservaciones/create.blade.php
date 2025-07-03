@extends('layouts.app')

@section('title', 'Crear Nueva Reservación')

@section('content')
<div class="container mx-auto px-4 mt-8">
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-8 max-w-lg mx-auto">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">Crear Nueva Reservación</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">¡Ups!</strong>
                <span class="block sm:inline">Hubo algunos problemas con tu entrada.</span>
                <ul class="mt-3 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('reservaciones.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="idUsuarioFK" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Usuario:</label>
                @if(Auth::user()->role === 'admin')
                    <select name="idUsuarioFK" id="idUsuarioFK" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
                        <option value="">Selecciona un usuario</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}"
                                {{ old('idUsuarioFK', Auth::id()) == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }} ({{ $usuario->email }})
                            </option>
                        @endforeach
                    </select>
                @else
                    {{-- Si no es admin, el usuario es automáticamente el logueado --}}
                    <input type="hidden" name="idUsuarioFK" value="{{ Auth::id() }}">
                    <p class="py-2 px-3 text-gray-700 dark:text-gray-200 border rounded bg-gray-100 dark:bg-gray-700">{{ Auth::user()->name }}</p>
                @endif
            </div>

            <div class="mb-4">
                <label for="fechaViaje" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Fecha de Viaje:</label>
                <input type="date" name="fechaViaje" id="fechaViaje" value="{{ old('fechaViaje', $prefillFechaViaje) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
            </div>

            <div class="mb-4">
                <label for="numeroPersonas" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Número de Personas:</label>
                <input type="number" name="numeroPersonas" id="numeroPersonas" value="{{ old('numeroPersonas', $prefillPasajeros) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required min="1">
            </div>

            <div class="mb-4">
                <label for="pensionElegida" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Pensión Elegida (Opcional):</label>
                <select name="pensionElegida" id="pensionElegida" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                    <option value="">Ninguna</option>
                    <option value="Completa" {{ old('pensionElegida') == 'Completa' ? 'selected' : '' }}>Completa</option>
                    <option value="Media" {{ old('pensionElegida') == 'Media' ? 'selected' : '' }}>Media Pensión</option>
                    <option value="Solo Desayuno" {{ old('pensionElegida') == 'Solo Desayuno' ? 'selected' : '' }}>Solo Desayuno</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="idSucursalFK" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Sucursal (Opcional):</label>
                <select name="idSucursalFK" id="idSucursalFK" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                    <option value="">Ninguna</option>
                    @foreach($sucursales as $sucursal)
                        <option value="{{ $sucursal->idSucursal }}"
                            {{ old('idSucursalFK') == $sucursal->idSucursal ? 'selected' : '' }}>
                            {{ $sucursal->nombre }} ({{ $sucursal->direccion }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="idHotelFK" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Hotel (Opcional):</label>
                <select name="idHotelFK" id="idHotelFK" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                    <option value="">Ninguno</option>
                    @foreach($hoteles as $hotel)
                        <option value="{{ $hotel->idHotel }}"
                            {{ old('idHotelFK') == $hotel->idHotel ? 'selected' : '' }}>
                            {{ $hotel->nombre }} ({{ $hotel->ciudad }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label for="idVueloFK" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Vuelo (Opcional):</label>
                <select name="idVueloFK" id="idVueloFK" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                    <option value="">Ninguno</option>
                    @foreach($vuelos as $vuelo)
                        <option value="{{ $vuelo->idVueloPK }}"
                            {{ old('idVueloFK', $prefillVueloId) == $vuelo->idVueloPK ? 'selected' : '' }}>
                            {{ $vuelo->origen }} a {{ $vuelo->destino }} ({{ $vuelo->fecha->format('d/m/Y') }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label for="totalCotizacion" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Total Cotización:</label>
                <input type="text" name="totalCotizacion" id="totalCotizacion" 
                       value="{{ old('totalCotizacion', $prefillTotalCotizacion ?? '0.00') }}" 
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 font-bold" 
                       readonly>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-300">
                    Guardar Reservación
                </button>
                <a href="{{ route('reservaciones.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Precios base hardcodeados (deben coincidir con el backend)
        const BASE_PRICE_PER_PERSON = 100;
        const HOTEL_ADDON_PRICE = 500;
        const VUELO_ADDON_PRICE = 300;

        const PENSION_SURCHARGE = {
            'Completa': 50,
            'Media': 30,
            'Solo Desayuno': 10,
            '': 0 // Para "Ninguna"
        };

        const numeroPersonasInput = document.getElementById('numeroPersonas');
        const pensionElegidaSelect = document.getElementById('pensionElegida');
        const idHotelFKSelect = document.getElementById('idHotelFK');
        const idVueloFKSelect = document.getElementById('idVueloFK');
        const totalCotizacionInput = document.getElementById('totalCotizacion');

        function calculateTotalCotizacion() {
            let total = 0;

            const numeroPersonas = parseInt(numeroPersonasInput.value) || 0;
            const pensionElegida = pensionElegidaSelect.value;
            const hotelSeleccionado = idHotelFKSelect.value;
            const vueloSeleccionado = idVueloFKSelect.value;

            total += numeroPersonas * BASE_PRICE_PER_PERSON;
            total += numeroPersonas * (PENSION_SURCHARGE[pensionElegida] || 0);

            if (hotelSeleccionado) {
                total += HOTEL_ADDON_PRICE;
            }
            if (vueloSeleccionado) {
                total += VUELO_ADDON_PRICE;
            }

            totalCotizacionInput.value = total.toFixed(2);
        }

        // Añadir listeners para los cambios en los campos relevantes
        numeroPersonasInput.addEventListener('input', calculateTotalCotizacion);
        pensionElegidaSelect.addEventListener('change', calculateTotalCotizacion);
        idHotelFKSelect.addEventListener('change', calculateTotalCotizacion);
        idVueloFKSelect.addEventListener('change', calculateTotalCotizacion);

        // Calcular la cotización inicial al cargar la página (útil con old() values y prefill)
        // Solo recalcula si no viene un precio estimado pre-llenado para evitar doble cálculo
        // o si los campos cambian después del pre-llenado.
        const initialPrefillTotal = parseFloat(totalCotizacionInput.value);
        if (isNaN(initialPrefillTotal) || initialPrefillTotal === 0) {
            calculateTotalCotizacion(); // Solo si no hay un precio inicial o es 0
        }
    });
</script>
@endsection