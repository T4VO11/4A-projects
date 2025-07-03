@extends('layouts.app')

@section('title', 'Nuestras Sucursales - Viajes Increíbles')

@section('content')
<div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
            <h2 class="font-semibold text-3xl text-gray-800 dark:text-gray-200 leading-tight mb-6 text-center">
                Descubre Nuestras Sucursales
            </h2>
            <p class="text-center text-lg text-gray-600 dark:text-gray-400 mb-10">
                Encuentra tu sucursal más cercana y déjanos ayudarte a planificar tu próxima aventura.
            </p>

            @if($sucursales->isEmpty())
                <div class="text-center text-gray-600 dark:text-gray-400 py-8">
                    <p class="mb-4">Actualmente no hay sucursales registradas. ¡Vuelve pronto!</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($sucursales as $sucursal)
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition duration-300">
                            @if($sucursal->imagen_url)
                                <img src="{{ asset($sucursal->imagen_url) }}" alt="Imagen de {{ $sucursal->nombre }}" class="w-full h-48 object-cover">
                            @else
                                <img src="https://source.unsplash.com/random/400x300/?office,travel" alt="Imagen de Sucursal" class="w-full h-48 object-cover">
                            @endif

                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $sucursal->nombre }}</h3>
                                <p class="text-gray-600 dark:text-gray-300 text-sm mb-2">
                                    <strong class="font-semibold">Dirección:</strong> {{ $sucursal->direccion }}
                                </p>
                                <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">
                                    <strong class="font-semibold">Teléfono:</strong> {{ $sucursal->telefono }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection