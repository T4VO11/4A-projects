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

        {{-- Formulario Principal de Edición del Hotel --}}
        <form action="{{ route('hoteles.update', $hotel->idHotel) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <h3 class="font-semibold text-xl text-gray-900 dark:text-gray-100 mb-4 border-b pb-2">Información Básica del Hotel</h3>

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

            {{-- Campo para subir la imagen PRINCIPAL del hotel --}}
            <div class="mb-6">
                <label for="imagen" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Imagen Principal del Hotel (Reemplazar/Eliminar):</label>
                @if($hotel->imagen_url)
                    <div class="mb-3">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Imagen actual:</p>
                        <img src="{{ asset($hotel->imagen_url) }}" alt="Imagen de {{ $hotel->nombre }}" class="w-32 h-32 object-cover rounded-lg shadow-md mt-2">
                        <div class="mt-2">
                            <input type="checkbox" name="clear_imagen" id="clear_imagen" value="1" class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500">
                            <label for="clear_imagen" class="text-sm text-gray-700 dark:text-gray-300">Eliminar imagen principal</label>
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

            <hr class="my-6 border-gray-300 dark:border-gray-700">

            {{-- Sección para GALERÍA DE IMÁGENES --}}
            <h3 class="font-semibold text-xl text-gray-900 dark:text-gray-100 mb-4 border-b pb-2">Galería de Imágenes</h3>

            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Imágenes Actuales de la Galería:</label>
                @if($hotel->images->isEmpty())
                    <p class="text-gray-600 dark:text-gray-400">No hay imágenes en la galería.</p>
                @else
                    <div class="grid grid-cols-3 gap-4 mb-4">
                        @foreach($hotel->images as $img)
                            <div class="relative">
                                <img src="{{ asset($img->image_url) }}" alt="Galería {{ $img->id }}" class="w-full h-24 object-cover rounded-lg shadow-md">
                                <input type="checkbox" name="delete_gallery_images[]" value="{{ $img->id }}" 
                                       class="absolute top-1 right-1 rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500">
                                <span class="absolute top-1 right-6 text-white bg-black bg-opacity-50 px-1 py-0.5 rounded text-xs">Eliminar</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            
            <div class="mb-6">
                <label for="new_gallery_images" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Añadir Nuevas Imágenes a la Galería:</label>
                <input type="file" name="new_gallery_images[]" id="new_gallery_images" multiple
                       class="block w-full text-sm text-gray-900 dark:text-gray-100
                       file:mr-4 file:py-2 file:px-4
                       file:rounded-full file:border-0
                       file:text-sm file:font-semibold
                       file:bg-blue-50 dark:file:bg-blue-900 file:text-blue-700 dark:file:text-blue-300
                       hover:file:bg-blue-100 dark:hover:file:bg-blue-800"/>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Múltiples JPG, PNG, GIF, SVG (máx. 2MB cada una)</p>
            </div>

            <hr class="my-6 border-gray-300 dark:border-gray-700">

            {{-- Sección para TIPOS DE HABITACIONES --}}
            <h3 class="font-semibold text-xl text-gray-900 dark:text-gray-100 mb-4 border-b pb-2">Tipos de Habitaciones</h3>

            {{-- Lista de Tipos de Habitación Actuales --}}
            @if($hotel->roomTypes->isEmpty())
                <p class="text-gray-600 dark:text-gray-400 mb-4">No hay tipos de habitación registrados.</p>
            @else
                <div class="space-y-4 mb-6">
                    @foreach($hotel->roomTypes as $roomType)
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 flex justify-between items-center shadow-sm">
                            <div class="flex-1">
                                <h4 class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ $roomType->name }}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-300">Capacidad: {{ $roomType->capacity }} | Precio: ${{ number_format($roomType->price, 2) }}</p>
                            </div>
                            <div class="flex space-x-2">
                                {{-- Los botones de editar/eliminar roomType requerirán JS o más rutas --}}
<a href="{{ route('hotel_room_types.edit', ['hotelId' => $hotel->idHotel, 'roomTypeId' => $roomType->id]) }}"
   class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm">
   Editar
</a>                                
                         </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Formulario para Añadir un Nuevo Tipo de Habitación --}}
            <h4 class="font-semibold text-lg text-gray-900 dark:text-gray-100 mb-3">Añadir Nuevo Tipo de Habitación</h4>
            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 shadow-sm mb-6">
                <div class="mb-3">
                    <label for="new_room_name" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-1">Nombre:</label>
                    <input type="text" name="new_room_name" id="new_room_name" class="shadow border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                </div>
                <div class="mb-3">
                    <label for="new_room_capacity" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-1">Capacidad:</label>
                    <input type="text" name="new_room_capacity" id="new_room_capacity" class="shadow border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                </div>
                <div class="mb-3">
                    <label for="new_room_price" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-1">Precio por Noche:</label>
                    <input type="number" step="0.01" name="new_room_price" id="new_room_price" class="shadow border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                </div>
                <div class="mb-3">
                    <label for="new_room_description" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-1">Descripción:</label>
                    <textarea name="new_room_description" id="new_room_description" rows="2" class="shadow border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"></textarea>
                </div>
                <div class="mb-3">
                    <label for="new_room_image" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-1">Imagen de Habitación (Opcional):</label>
                    <input type="file" name="new_room_image" id="new_room_image" 
                           class="block w-full text-sm text-gray-900 dark:text-gray-100
                           file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0
                           file:text-sm file:font-semibold file:bg-blue-50 dark:file:bg-blue-900 file:text-blue-700 dark:file:text-blue-300
                           hover:file:bg-blue-100 dark:hover:file:bg-blue-800"/>
                </div>
            </div> {{-- Fin del div de añadir nuevo tipo --}}


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