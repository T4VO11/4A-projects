@extends('layouts.app')

@section('title', 'Crear Nueva Sucursal')

@section('content')
<div class="container mx-auto px-4 mt-8">
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-8 max-w-lg mx-auto">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">Crear Nueva Sucursal</h1>

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

        {{-- ¡IMPORTANTE! Añadir enctype="multipart/form-data" para la subida de archivos --}}
        <form action="{{ route('sucursales.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="nombre" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Nombre:</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
            </div>

            <div class="mb-4">
                <label for="direccion" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Dirección:</label>
                <input type="text" name="direccion" id="direccion" value="{{ old('direccion') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
            </div>

            <div class="mb-4">
                <label for="telefono" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Teléfono:</label>
                <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
            </div>

            {{-- Campo para subir la imagen --}}
            <div class="mb-6">
                <label for="imagen" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Imagen de la Sucursal (Opcional):</label>
                <input type="file" name="imagen" id="imagen" class="block w-full text-sm text-gray-900 dark:text-gray-100
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-blue-50 dark:file:bg-blue-900 file:text-blue-700 dark:file:text-blue-300
                    hover:file:bg-blue-100 dark:hover:file:bg-blue-800"/>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Archivos JPG, PNG, GIF, SVG (máx. 2MB)</p>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-300">
                    Guardar Sucursal
                </button>
                <a href="{{ route('sucursales.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection