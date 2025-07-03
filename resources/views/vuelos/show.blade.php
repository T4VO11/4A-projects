@extends('layouts.app')

@section('title', 'Detalles de Vuelo')

@section('content')
<div class="container mx-auto px-4 mt-8">
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-8 max-w-lg mx-auto">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">Detalles de Vuelo</h1>

        <div class="mb-4"><p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold">ID:</strong> {{ $vuelo->idVueloPK }}</p></div>
        <div class="mb-4"><p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold">Fecha:</strong> {{ $vuelo->fecha->format('d/m/Y') }}</p></div>
        <div class="mb-4"><p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold">Hora:</strong> {{ $vuelo->hora->format('H:i') }}</p></div>
        <div class="mb-4"><p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold">Origen:</strong> {{ $vuelo->origen }}</p></div>
        <div class="mb-4"><p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold">Destino:</strong> {{ $vuelo->destino }}</p></div>
        <div class="mb-4"><p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold">Plazas Totales:</strong> {{ $vuelo->plazasTotales }}</p></div>
        <div class="mb-4"><p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold">Plazas Turista:</strong> {{ $vuelo->plazasTurista }}</p></div>
        <div class="mb-4"><p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold">Pensión:</strong> {{ $vuelo->pension ?? 'N/A' }}</p></div>
        <div class="mb-6"><p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold">Sucursal:</strong> {{ $vuelo->sucursal->nombre ?? 'N/A' }}</p></div>

        <div class="flex justify-center">
            <a href="{{ route('vuelos.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-300">
                Volver a la lista
            </a>
            @can('update', $vuelo)
                <a href="{{ route('vuelos.edit', $vuelo->idVueloPK) }}" class="ml-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-300">
                    Editar
                </a>
            @endcan
        </div>
    </div>
</div>
@endsection