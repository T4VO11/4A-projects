@extends('layouts.app')

@section('title', 'Lista de Reservaciones')

@section('content')
<div class="container mx-auto px-4 mt-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Reservaciones</h1>
        @can('create', App\Models\Reservacion::class) {{-- Cualquier usuario autenticado puede crear --}}
            <a href="{{ route('reservaciones.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
                Crear Nueva Reservación
            </a>
        @endcan
    </div>

    {{-- ... (Tabla de reservaciones) ... --}}
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">ID</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Usuario</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Fecha Viaje</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider"># Personas</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Hotel / Vuelo</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Total</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reservaciones as $reservacion)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-200">{{ $reservacion->idReservacionPK }}</td>
                    <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-200">{{ $reservacion->usuario->name ?? 'N/A' }}</td>
                    <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-200">{{ $reservacion->fechaViaje->format('d/m/Y') }}</td>
                    <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-200">{{ $reservacion->numeroPersonas }}</td>
                    <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-200">
                        @if($reservacion->hotel) {{ $reservacion->hotel->nombre }} (Hotel) @endif
                        @if($reservacion->vuelo) @if($reservacion->hotel) / @endif {{ $reservacion->vuelo->origen }} - {{ $reservacion->vuelo->destino }} (Vuelo) @endif
                        @if(!$reservacion->hotel && !$reservacion->vuelo) N/A @endif
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-200">${{ number_format($reservacion->totalCotizacion, 2) }}</td>
                    <td class="px-5 py-5 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                        <div class="flex space-x-2">
                            @can('view', $reservacion)
                                <a href="{{ route('reservaciones.show', $reservacion->idReservacionPK) }}" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-200">Ver</a>
                            @endcan
                            @can('update', $reservacion)
                                <a href="{{ route('reservaciones.edit', $reservacion->idReservacionPK) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200">Editar</a>
                            @endcan
                            @can('delete', $reservacion)
                                <form action="{{ route('reservaciones.destroy', $reservacion->idReservacionPK) }}" method="POST" onsubmit="return confirm('¿Estás seguro de querer eliminar esta reservación?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200">Eliminar</button>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection