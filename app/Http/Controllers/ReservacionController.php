<?php

namespace App\Http\Controllers;

use App\Models\Reservacion;
use App\Models\User;
use App\Models\Sucursal;
use App\Models\Hotel;
use App\Models\Vuelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth; 

class ReservacionController extends Controller
{
    const BASE_PRICE_PER_PERSON = 100;
    const HOTEL_ADDON_PRICE = 500;
    const VUELO_ADDON_PRICE = 300;

    const PENSION_SURCHARGE = [
        'Completa' => 50,
        'Media' => 30,
        'Solo Desayuno' => 10,
        null => 0 // Para "Ninguna" o nulo
    ];

    public function index()
    {

        if (Auth::user()->role === 'admin') {
            $reservaciones = Reservacion::with('usuario', 'sucursal', 'hotel', 'vuelo')->get();
        } else {
            $reservaciones = Reservacion::where('idUsuarioFK', Auth::id())
                                      ->with('usuario', 'sucursal', 'hotel', 'vuelo')
                                      ->get();
        }
        
        return view('reservaciones.admin-index', compact('reservaciones'));
    }

    public function create(Request $request) 
    {
        $this->authorize('create', Reservacion::class);
        $usuarios = User::all();
        $sucursales = Sucursal::all();
        $hoteles = Hotel::all();
        $vuelos = Vuelo::all();

        $prefillVueloId = $request->query('vuelo_id');
        $prefillPasajeros = $request->query('pasajeros');
        $prefillFechaViaje = $request->query('fecha_viaje');
        $prefillTotalCotizacion = $request->query('estimated_price'); 

        return view('reservaciones.create', compact(
            'usuarios', 'sucursales', 'hoteles', 'vuelos',
            'prefillVueloId', 'prefillPasajeros', 'prefillFechaViaje', 'prefillTotalCotizacion'
        ));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Reservacion::class); 

        $validator = Validator::make($request->all(), [
            'fechaViaje' => 'required|date|after_or_equal:today',
            'numeroPersonas' => 'required|integer|min:1',
            'pensionElegida' => 'nullable|string|in:Completa,Media,Solo Desayuno',
            'idUsuarioFK' => 'required|exists:users,id', 
            'idSucursalFK' => 'nullable|uuid|exists:sucursales,idSucursal',
            'idHotelFK' => 'nullable|uuid|exists:hoteles,idHotel',
            'idVueloFK' => 'nullable|uuid|exists:vuelos,idVueloPK',
        ], [
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        if (Auth::user()->role !== 'admin') {
            $request->merge(['idUsuarioFK' => Auth::id()]);
        }


        $totalCotizacion = $this->calculateCotizacion(
            $request->input('numeroPersonas'),
            $request->input('pensionElegida'),
            $request->input('idHotelFK'),
            $request->input('idVueloFK')
        );

        $data = $request->except('totalCotizacion'); 
        $data['totalCotizacion'] = $totalCotizacion; 

        Reservacion::create($data); 

        return redirect()->route('reservaciones.index')->with('success', 'Reservación creada exitosamente.');
    }


    public function show($id) 
    {
        $reservacion = Reservacion::find($id);

        if (!$reservacion) {
            return redirect()->route('reservaciones.index')->with('error', 'Reservación no encontrada.');
        }
        $this->authorize('view', $reservacion);
        $reservacion->load('usuario', 'sucursal', 'hotel', 'vuelo');
        return view('reservaciones.show', compact('reservacion'));
    }


    public function edit($id) 
    {
        $reservacion = Reservacion::find($id);

        if (!$reservacion) {
            return redirect()->route('reservaciones.index')->with('error', 'Reservación no encontrada para editar.');
        }

        $this->authorize('update', $reservacion);
        $usuarios = User::all();
        $sucursales = Sucursal::all();
        $hoteles = Hotel::all();
        $vuelos = Vuelo::all();
        return view('reservaciones.edit', compact('reservacion', 'usuarios', 'sucursales', 'hoteles', 'vuelos'));
    }


    public function update(Request $request, $id) 
    {
        $reservacion = Reservacion::find($id);

        if (!$reservacion) {
            return redirect()->route('reservaciones.index')->with('error', 'Reservación no encontrada para actualizar.');
        }

        $this->authorize('update', $reservacion);

        $validator = Validator::make($request->all(), [
            'fechaViaje' => 'required|date|after_or_equal:today',
            'numeroPersonas' => 'required|integer|min:1',
            'pensionElegida' => 'nullable|string|in:Completa,Media,Solo Desayuno',
            'idUsuarioFK' => 'required|exists:users,id',
            'idSucursalFK' => 'nullable|uuid|exists:sucursales,idSucursal',
            'idHotelFK' => 'nullable|uuid|exists:hoteles,idHotel',
            'idVueloFK' => 'nullable|uuid|exists:vuelos,idVueloPK',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        
        if (Auth::user()->role !== 'admin') {
            $request->merge(['idUsuarioFK' => Auth::id()]);
        }

        $totalCotizacion = $this->calculateCotizacion(
            $request->input('numeroPersonas'),
            $request->input('pensionElegida'),
            $request->input('idHotelFK'),
            $request->input('idVueloFK')
        );
        $data = $request->except('totalCotizacion');
        $data['totalCotizacion'] = $totalCotizacion;

        $reservacion->update($data);
        return redirect()->route('reservaciones.index')->with('success', 'Reservación actualizada exitosamente.');
    }


    public function destroy($id) 
    {
        $reservacion = Reservacion::find($id);

        if (!$reservacion) {
            return redirect()->route('reservaciones.index')->with('error', 'Reservación no encontrada para ocultar.');
        }

        $this->authorize('delete', $reservacion);
        
        $reservacion->delete(); 
        
        return redirect()->route('reservaciones.index')->with('success', 'Reservación eliminada exitosamente.');
    }


    public function trashed()
    {
        $this->authorize('viewAny', Reservacion::class); 

        if (Auth::user()->role === 'admin') {
            $reservaciones = Reservacion::onlyTrashed()->with('usuario', 'sucursal', 'hotel', 'vuelo')->get();
        } else {
            $reservaciones = Reservacion::onlyTrashed()
                                      ->where('idUsuarioFK', Auth::id())
                                      ->with('usuario', 'sucursal', 'hotel', 'vuelo')
                                      ->get();
        }

        return view('reservaciones.trashed-index', compact('reservaciones')); 
    }


    public function restore($id)
    {
        $reservacion = Reservacion::withTrashed()->find($id);

        if (!$reservacion) {
            return redirect()->route('reservaciones.trashed')->with('error', 'Reservación oculta no encontrada para restaurar.');
        }

        $this->authorize('restore', $reservacion);

        $reservacion->restore(); 

        return redirect()->route('reservaciones.trashed')->with('success', 'Reservación restaurada exitosamente.');
    }

    private function calculateCotizacion(
        int $numeroPersonas,
        ?string $pensionElegida,
        ?string $idHotelFK,
        ?string $idVueloFK
    ): float {
        $total = 0.0;

        // 1. Calcular precio base por número de personas
        $total += $numeroPersonas * self::BASE_PRICE_PER_PERSON;

        // 2. Añadir recargo por pensión
        $total += $numeroPersonas * (self::PENSION_SURCHARGE[$pensionElegida] ?? 0);

        // 3. Añadir precio por hotel (si seleccionado)
        if (!empty($idHotelFK)) {
            $total += self::HOTEL_ADDON_PRICE;
        }

        // 4. Añadir precio por vuelo (si seleccionado)
        if (!empty($idVueloFK)) {
            $total += self::VUELO_ADDON_PRICE;
        }

        return round($total, 2);
    }
}