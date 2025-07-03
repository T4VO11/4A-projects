@extends('layouts.app')

@section('title', 'Gestión de Sucursales') {{-- Ajustado el título para Admin --}}

@section('content')
<div class="container mx-auto px-4 mt-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Gestión de Sucursales</h1>
        <div class="flex space-x-4"> {{-- Contenedor para múltiples botones --}}
            {{-- Botón "Crear Nueva Sucursal" --}}
    @can('create', App\Models\Sucursal::class)
        <a href="{{ route('sucursales.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
            Crear Nueva Sucursal
        </a>
    @endcan
    {{-- ¡¡¡ASEGÚRATE DE QUE ESTE HREF ESTÉ BIEN!!! --}}
    @can('create', App\Models\Sucursal::class)
        <a href="{{ route('sucursales.trashed') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
            Ver Sucursales 
        </a>
    @endcan
        </div>
    </div>

    @if($sucursales->isEmpty())
        <p class="text-center text-gray-600 dark:text-gray-400">No hay sucursales registradas.</p>
    @else
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                            ID
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                            Nombre
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                            Dirección
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                            Teléfono
                        </th>
                        {{-- ¡NUEVA COLUMNA! Imagen --}}
                        <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                            Imagen
                        </th>
                        {{-- Solo muestra la columna Acciones si el usuario es administrador (usando 'create') --}}
                        @can('create', App\Models\Sucursal::class)
                            <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                Acciones
                            </th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sucursales as $sucursal)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-200">
                            {{ $sucursal->idSucursal }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-200">
                            {{ $sucursal->nombre }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-200">
                            {{ $sucursal->direccion }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-200">
                            {{ $sucursal->telefono }}
                        </td>
                        {{-- ¡NUEVA CELDA! Mostrar imagen --}}
                        <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-200">
                            @if($sucursal->imagen_url)
                                <img src="{{ asset($sucursal->imagen_url) }}" alt="Imagen" class="w-16 h-16 object-cover rounded-md">
                            @else
                                N/A
                            @endif
                        </td>
                        {{-- Solo muestra las acciones si el usuario es administrador --}}
                        @can('update', $sucursal) {{-- 'update' o 'delete' son buenas para este grupo de acciones --}}
                            <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                                <div class="flex space-x-2">
                                    <a href="{{ route('sucursales.show', $sucursal->idSucursal) }}" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-200">Ver</a>
                                    <a href="{{ route('sucursales.edit', $sucursal->idSucursal) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200">Editar</a>
                                    <form action="{{ route('sucursales.destroy', $sucursal->idSucursal) }}" method="POST" onsubmit="return confirm('¿Estás seguro de querer eliminar esta sucursal?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        @endcan
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection