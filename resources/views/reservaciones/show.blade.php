@extends('layouts.app')

@section('title', 'Detalles de Reservación')

@section('content')
<div class="container mx-auto px-4 mt-8">
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-8 max-w-lg mx-auto">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">Detalles de Reservación</h1>

        <div class="mb-4"><p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold">ID:</strong> {{ $reservacion->idReservacionPK }}</p></div>
        <div class="mb-4"><p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold">Usuario:</strong> {{ $reservacion->usuario->name ?? 'N/A' }}</p></div>
        <div class="mb-4"><p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold">Fecha de Viaje:</strong> {{ $reservacion->fechaViaje->format('d/m/Y') }}</p></div>
        <div class="mb-4"><p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold">Número de Personas:</strong> {{ $reservacion->numeroPersonas }}</p></div>
        <div class="mb-4"><p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold">Pensión Elegida:</strong> {{ $reservacion->pensionElegida ?? 'N/A' }}</p></div>
        <div class="mb-4"><p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold">Total Cotización:</strong> ${{ number_format($reservacion->totalCotizacion, 2) }}</p></div>
        <div class="mb-4"><p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold">Sucursal:</strong> {{ $reservacion->sucursal->nombre ?? 'N/A' }}</p></div>
        <div class="mb-4"><p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold">Hotel:</strong> {{ $reservacion->hotel->nombre ?? 'N/A' }}</p></div>
        <div class="mb-6"><p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold">Vuelo:</strong> {{ $reservacion->vuelo ? $reservacion->vuelo->origen . ' a ' . $reservacion->vuelo->destino : 'N/A' }}</p></div>

        <div class="flex justify-center">
            <a href="{{ route('reservaciones.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-300">
                Volver a la lista
            </a>
            @can('update', $reservacion)
                <a href="{{ route('reservaciones.edit', $reservacion->idReservacionPK) }}" class="ml-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-300">
                    Editar
                </a>
            @endcan
        </div>
    </div>
</div>
@endsection