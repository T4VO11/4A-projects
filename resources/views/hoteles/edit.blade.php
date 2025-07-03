@extends('layouts.app')

@section('title', 'Editar Hotel')

@section('content')
<div class="container mx-auto px-4 mt-8">
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-8 max-w-lg mx-auto">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">Editar Hotel</h1>

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

        {{-- ¡IMPORTANTE! Añadir enctype="multipart/form-data" --}}
        <form action="{{ route('hoteles.update', $hotel->idHotel) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nombre" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Nombre:</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $hotel->nombre) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
            </div>

            <div class="mb-4">
                <label for="direccion" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Dirección:</label>
                <input type="text" name="direccion" id="direccion" value="{{ old('direccion', $hotel->direccion) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
            </div>

            <div class="mb-4">
                <label for="ciudad" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Ciudad:</label>
                <input type="text" name="ciudad" id="ciudad" value="{{ old('ciudad', $hotel->ciudad) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
            </div>

            <div class="mb-4">
                <label for="telefono" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Teléfono:</label>
                <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $hotel->telefono) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
            </div>

            <div class="mb-4">
                <label for="plazasDisponibles" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Plazas Disponibles:</label>
                <input type="number" name="plazasDisponibles" id="plazasDisponibles" value="{{ old('plazasDisponibles', $hotel->plazasDisponibles) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required min="0">
            </div>

            <div class="mb-4">
                <label for="descripcion" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Descripción (Opcional):</label>
                <textarea name="descripcion" id="descripcion" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">{{ old('descripcion', $hotel->descripcion) }}</textarea>
            </div>

            <div class="mb-6">
                <label for="idSucursalFK" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Sucursal:</label>
                <select name="idSucursalFK" id="idSucursalFK" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
                    <option value="">Selecciona una sucursal</option>
                    @foreach($sucursales as $sucursal)
                        <option value="{{ $sucursal->idSucursal }}"
                            {{ old('idSucursalFK', $hotel->idSucursalFK) == $sucursal->idSucursal ? 'selected' : '' }}>
                            {{ $sucursal->nombre }} ({{ $sucursal->direccion }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Campo para subir la imagen (con vista previa y opción de eliminar) --}}
            <div class="mb-6">
                <label for="imagen" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Imagen del Hotel (Reemplazar/Eliminar):</label>
                @if($hotel->imagen_url)
                    <div class="mb-3">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Imagen actual:</p>
                        <img src="{{ asset($hotel->imagen_url) }}" alt="Imagen de {{ $hotel->nombre }}" class="w-32 h-32 object-cover rounded-lg shadow-md mt-2">
                        <div class="mt-2">
                            <input type="checkbox" name="clear_imagen" id="clear_imagen" value="1" class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500">
                            <label for="clear_imagen" class="text-sm text-gray-700 dark:text-gray-300">Eliminar imagen actual</label>
                        </div>
                    </div>
                @endif
                <input type="file" name="imagen" id="imagen" class="block w-full text-sm text-gray-900 dark:text-gray-100
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-blue-50 dark:file:bg-blue-900 file:text-blue-700 dark:file:text-blue-300
                    hover:file:bg-blue-100 dark:hover:file:bg-blue-800"/>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Archivos JPG, PNG, GIF, SVG (máx. 2MB)</p>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-300">
                    Actualizar Hotel
                </button>
                <a href="{{ route('hoteles.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection