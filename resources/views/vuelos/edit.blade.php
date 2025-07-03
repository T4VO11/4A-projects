@extends('layouts.app')

@section('title', 'Editar Vuelo')

@section('content')
<div class="container mx-auto px-4 mt-8">
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-8 max-w-lg mx-auto">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">Editar Vuelo</h1>

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

        <form action="{{ route('vuelos.update', $vuelo->idVueloPK) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="fecha" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Fecha:</label>
                <input type="date" name="fecha" id="fecha" value="{{ old('fecha', $vuelo->fecha->format('Y-m-d')) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
            </div>

            <div class="mb-4">
                <label for="hora" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Hora:</label>
                <input type="time" name="hora" id="hora" value="{{ old('hora', $vuelo->hora->format('H:i')) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
            </div>

            <div class="mb-4">
                <label for="origen" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Origen:</label>
                <input type="text" name="origen" id="origen" value="{{ old('origen', $vuelo->origen) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
            </div>

            <div class="mb-4">
                <label for="destino" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Destino:</label>
                <input type="text" name="destino" id="destino" value="{{ old('destino', $vuelo->destino) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
            </div>

            <div class="mb-4">
                <label for="plazasTotales" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Plazas Totales:</label>
                <input type="number" name="plazasTotales" id="plazasTotales" value="{{ old('plazasTotales', $vuelo->plazasTotales) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required min="1">
            </div>

            <div class="mb-4">
                <label for="plazasTurista" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Plazas Turista:</label>
                <input type="number" name="plazasTurista" id="plazasTurista" value="{{ old('plazasTurista', $vuelo->plazasTurista) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required min="0">
            </div>

            <div class="mb-4">
                <label for="pension" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Pensión (Opcional):</label>
                <select name="pension" id="pension" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                    <option value="">Ninguna</option>
                    <option value="Completa" {{ old('pension', $vuelo->pension) == 'Completa' ? 'selected' : '' }}>Completa</option>
                    <option value="Media" {{ old('pension', $vuelo->pension) == 'Media' ? 'selected' : '' }}>Media Pensión</option>
                    <option value="Solo Desayuno" {{ old('pension', $vuelo->pension) == 'Solo Desayuno' ? 'selected' : '' }}>Solo Desayuno</option>
                </select>
            </div>

            <div class="mb-6">
                <label for="idSucursalFK" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Sucursal:</label>
                <select name="idSucursalFK" id="idSucursalFK" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
                    <option value="">Selecciona una sucursal</option>
                    @foreach($sucursales as $sucursal)
                        <option value="{{ $sucursal->idSucursal }}"
                            {{ old('idSucursalFK', $vuelo->idSucursalFK) == $sucursal->idSucursal ? 'selected' : '' }}>
                            {{ $sucursal->nombre }} ({{ $sucursal->direccion }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-300">
                    Actualizar Vuelo
                </button>
                <a href="{{ route('vuelos.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection