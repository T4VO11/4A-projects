@extends('layouts.app')

@section('title', 'Detalles de Sucursal')

@section('content')
<div class="container mx-auto px-4 mt-8">
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-8 max-w-lg mx-auto">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">Detalles de Sucursal</h1>

        <div class="mb-4">
            <p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold">ID:</strong> {{ $sucursal->idSucursal }}</p>
        </div>
        <div class="mb-4">
            <p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold">Nombre:</strong> {{ $sucursal->nombre }}</p>
        </div>
        <div class="mb-4">
            <p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold">Dirección:</strong> {{ $sucursal->direccion }}</p>
        </div>
        <div class="mb-6">
            <p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold">Teléfono:</strong> {{ $sucursal->telefono }}</p>
        </div>

        <div class="flex justify-center">
            <a href="{{ route('sucursales.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-300">
                Volver a la lista
            </a>
            {{-- Solo muestra el botón "Editar" si el usuario es administrador --}}
            @can('update', $sucursal)
                <a href="{{ route('sucursales.edit', $sucursal->idSucursal) }}" class="ml-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-300">
                    Editar
                </a>
            @endcan
        </div>
    </div>
</div>
@endsection