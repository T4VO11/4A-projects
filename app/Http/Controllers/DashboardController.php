<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Para acceder al usuario autenticado
use App\Models\Reservacion; // Para obtener las reservaciones del usuario

class DashboardController extends Controller
{
    /**
     * Muestra el dashboard personalizado para el usuario autenticado.
     */
    public function index()
    {
        $user = Auth::user(); // Obtener el usuario autenticado

        // Obtener las reservaciones futuras del usuario, ordenadas por fecha
        // Asegúrate de que las relaciones 'hotel' y 'vuelo' se carguen para mostrarlas
        $upcomingReservations = $user->reservaciones()
                                     ->where('fechaViaje', '>=', now()->toDateString()) // Solo reservaciones futuras o de hoy
                                     ->with(['hotel', 'vuelo']) // Cargar relaciones para detalles
                                     ->orderBy('fechaViaje')
                                     ->get();

        // Puedes añadir aquí otras lógicas para obtener datos relevantes de la agencia
        // Por ejemplo, count de sucursales, hoteles, etc. si quieres mostrarlos
        // $totalHoteles = \App\Models\Hotel::count();
        // $totalVuelos = \App\Models\Vuelo::count();

        return view('dashboard', compact('user', 'upcomingReservations'));
    }
}