@extends('layouts.app')

@section('title', 'Detalles de Hotel')

@section('content')
<div class="container mx-auto px-4 mt-8">
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-8 max-w-lg mx-auto">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">Detalles de Hotel</h1>

        <div class="mb-4">
            <p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold">ID:</strong> {{ $hotel->idHotel }}</p>
        </div>
        <div class="mb-4">
            <p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold">Nombre:</strong> {{ $hotel->nombre }}</p>
        </div>
        <div class="mb-4">
            <p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold">Dirección:</strong> {{ $hotel->direccion }}</p>
        </div>
        <div class="mb-4">
            <p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold">Ciudad:</strong> {{ $hotel->ciudad }}</p>
        </div>
        <div class="mb-4">
            <p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold">Teléfono:</strong> {{ $hotel->telefono }}</p>
        </div>
        <div class="mb-4">
            <p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold">Plazas Disponibles:</strong> {{ $hotel->plazasDisponibles }}</p>
        </div>
        <div class="mb-4">
            <p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold">Descripción:</strong> {{ $hotel->descripcion ?? 'N/A' }}</p>
        </div>
        <div class="mb-6">
            <p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold">Sucursal:</strong> {{ $hotel->sucursal->nombre ?? 'N/A' }}</p>
        </div>

        <div class="flex justify-center">
            <a href="{{ route('hoteles.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-300">
                Volver a la lista
            </a>
            @can('update', $hotel)
                <a href="{{ route('hoteles.edit', $hotel->idHotel) }}" class="ml-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-300">
                    Editar
                </a>
            @endcan
        </div>
    </div>
</div>
@endsection