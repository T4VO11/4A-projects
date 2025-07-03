@extends('layouts.app')

@section('title', 'Hoteles Ocultos - Gestión')

@section('content')
<div class="container mx-auto px-4 mt-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Hoteles Ocultos</h1>
        <div class="flex space-x-4">
            <a href="{{ route('hoteles.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
                Volver a Hoteles Activos
            </a>
            {{-- Puedes añadir aquí un botón para eliminar permanentemente si implementas esa función --}}
        </div>
    </div>

    @if($hoteles->isEmpty())
        <p class="text-center text-gray-600 dark:text-gray-400">No hay hoteles ocultos.</p>
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
                            Ciudad
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                            Ocultado El
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hoteles as $hotel)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-200">
                            {{ $hotel->idHotel }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-200">
                            {{ $hotel->nombre }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-200">
                            {{ $hotel->ciudad }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-200">
                            {{ $hotel->deleted_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                            <div class="flex space-x-2">
                                {{-- Botón para Mostrar/Restaurar el hotel --}}
                                @can('restore', $hotel)
                                    <form action="{{ route('hoteles.restore', $hotel->idHotel) }}" method="POST" onsubmit="return confirm('¿Estás seguro de querer mostrar de nuevo este hotel?');">
                                        @csrf
                                        <button type="submit" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">Mostrar</button>
                                    </form>
                                @endcan

                                {{-- Opcional: Botón para eliminar permanentemente --}}
                                {{-- @can('forceDelete', $hotel)
                                    <form action="{{ route('hoteles.forceDelete', $hotel->idHotel) }}" method="POST" onsubmit="return confirm('¡ADVERTENCIA! ¿Estás seguro de querer ELIMINAR PERMANENTEMENTE este hotel? Esta acción es irreversible.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-800 hover:text-red-900 dark:text-red-600 dark:hover:text-red-500">Borrar Definitivo</button>
                                    </form>
                                @endcan --}}
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection