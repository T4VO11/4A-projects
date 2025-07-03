@extends('layouts.app')

@section('title', 'Lista de Vuelos')

@section('content')
<div class="container mx-auto px-4 mt-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Vuelos</h1>
        {{-- CAMBIO AQUÍ: Usamos 'create' para el botón de crear --}}
        @can('create', App\Models\Vuelo::class)
            <a href="{{ route('vuelos.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
                Crear Nuevo Vuelo
            </a>
        @endcan
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">ID</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Fecha</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Origen</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Destino</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Sucursal</th>
                    {{-- CAMBIO AQUÍ: Usamos 'create' para el encabezado de Acciones --}}
                    @can('create', App\Models\Vuelo::class)
                        <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($vuelos as $vuelo)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-200">{{ $vuelo->idVueloPK }}</td>
                    <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-200">{{ $vuelo->fecha->format('d/m/Y') }}</td>
                    <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-200">{{ $vuelo->hora->format('H:i') }}</td>
                    <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-200">{{ $vuelo->origen }}</td>
                    <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-200">{{ $vuelo->destino }}</td>
                    <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-200">{{ $vuelo->sucursal->nombre ?? 'N/A' }}</td>
                    {{-- Las acciones de la fila sí necesitan la instancia del modelo --}}
                    @can('update', $vuelo)
                        <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                            <div class="flex space-x-2">
                                <a href="{{ route('vuelos.show', $vuelo->idVueloPK) }}" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-200">Ver</a>
                                <a href="{{ route('vuelos.edit', $vuelo->idVueloPK) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200">Editar</a>
                                <form action="{{ route('vuelos.destroy', $vuelo->idVueloPK) }}" method="POST" onsubmit="return confirm('¿Estás seguro de querer eliminar este vuelo?');">
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
</div>
@endsection