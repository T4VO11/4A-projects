<?php

namespace App\Http\Controllers;

use App\Models\Vuelo;
use App\Models\Sucursal; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ReservacionController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage; 

class VueloController extends Controller
{

    public function index(Request $request) 
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            $vuelos = Vuelo::with('sucursal')->get();
            return view('vuelos.admin-index', compact('vuelos'));
        }
        else {
            $origenes = Vuelo::select('origen')->distinct()->pluck('origen')->sort();
            $destinos = Vuelo::select('destino')->distinct()->pluck('destino')->sort();
            
            $query = Vuelo::query()->with('sucursal');
            $alternativeDates = false;
            $numPasajeros = $request->input('pasajeros', 1); // Por defecto 1 pasajero si no hay búsqueda

            if ($request->filled(['origen', 'destino', 'fecha_salida'])) {
                $fechaSalida = Carbon::parse($request->input('fecha_salida'));
                $origen = $request->input('origen');
                $destino = $request->input('destino');

                $queryExacta = $query->clone()
                    ->where('origen', 'LIKE', '%' . $origen . '%')
                    ->where('destino', 'LIKE', '%' . $destino . '%')
                    ->where('fecha', $fechaSalida->toDateString())
                    ->whereRaw('(plazasTotales - plazasTurista) >= ?', [$numPasajeros]);

                $vuelosFiltrados = $queryExacta->get();

                if ($vuelosFiltrados->isEmpty()) {
                    $alternativeDates = true;
                    $fechaFinRango = $fechaSalida->copy()->addDays(3);

                    $queryAlternativa = $query->clone()
                        ->where('origen', 'LIKE', '%' . $origen . '%')
                        ->where('destino', 'LIKE', '%' . $destino . '%')
                        ->whereBetween('fecha', [$fechaSalida->toDateString(), $fechaFinRango->toDateString()])
                        ->whereRaw('(plazasTotales - plazasTurista) >= ?', [$numPasajeros])
                        ->orderBy('fecha');
                    
                    $vuelosFiltrados = $queryAlternativa->get();
                }
                $vuelos = $vuelosFiltrados; 
            } else {
                $vuelos = $query->get();
            }

            $basePricePerPerson = ReservacionController::BASE_PRICE_PER_PERSON;
            $vueloAddonPrice = ReservacionController::VUELO_ADDON_PRICE;

            foreach ($vuelos as $flight) {
                $flight->estimated_price = ($basePricePerPerson * $numPasajeros) + $vueloAddonPrice;
            }

            return view('vuelos.user-search', compact('origenes', 'destinos', 'vuelos', 'request', 'numPasajeros', 'alternativeDates'));
        }
    }

    public function create()
    {
        $this->authorize('create', Vuelo::class);
        $sucursales = Sucursal::all();
        return view('vuelos.create', compact('sucursales'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Vuelo::class); 

        $validator = Validator::make($request->all(), [
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required|date_format:H:i',
            'origen' => 'required|string|max:255',
            'destino' => 'required|string|max:255',
            'plazasTotales' => 'required|integer|min:1',
            'plazasTurista' => 'required|integer|min:0|lte:plazasTotales',
            'pension' => 'nullable|string|in:Completa,Media,Solo Desayuno',
            'idSucursalFK' => 'required|uuid|exists:sucursales,idSucursal',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        Vuelo::create($request->all());
        return redirect()->route('vuelos.index')->with('success', 'Vuelo creado exitosamente.');
    }

    public function show(Vuelo $vuelo)
    {
        $vuelo->load('sucursal');
        return view('vuelos.show', compact('vuelo'));
    }

    public function edit(Vuelo $vuelo)
    {
        $this->authorize('update', $vuelo);
        $sucursales = Sucursal::all();
        return view('vuelos.edit', compact('vuelo', 'sucursales'));
    }

    public function update(Request $request, Vuelo $vuelo)
    {
        $this->authorize('update', $vuelo);

        $validator = Validator::make($request->all(), [
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required|date_format:H:i',
            'origen' => 'required|string|max:255',
            'destino' => 'required|string|max:255',
            'plazasTotales' => 'required|integer|min:1',
            'plazasTurista' => 'required|integer|min:0|lte:plazasTotales',
            'pension' => 'nullable|string|in:Completa,Media,Solo Desayuno',
            'idSucursalFK' => 'required|uuid|exists:sucursales,idSucursal',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $vuelo->update($request->all());
        return redirect()->route('vuelos.index')->with('success', 'Vuelo actualizado exitosamente.');
    }

    public function destroy(Vuelo $vuelo)
    {
        $this->authorize('delete', $vuelo);
        $vuelo->delete();
        return redirect()->route('vuelos.index')->with('success', 'Vuelo eliminado exitosamente.');
    }
    public function confirmPurchase(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Por favor, inicia sesión para continuar con la compra.');
        }

        $flight = Vuelo::find($id); 

        if (!$flight) {
            return redirect()->route('vuelos.index')->with('error', 'Vuelo no encontrado o no disponible.');
        }

        $user = Auth::user(); 

        $numPasajeros = $request->query('pasajeros');
        $fechaViaje = $request->query('fecha_viaje');
        $estimatedPrice = $request->query('estimated_price');

        if (empty($numPasajeros) || empty($fechaViaje) || empty($estimatedPrice)) {
            return redirect()->route('vuelos.index')->with('error', 'Faltan detalles de la búsqueda para confirmar la compra.');
        }

        return view('vuelos.confirm-purchase', compact('flight', 'user', 'numPasajeros', 'fechaViaje', 'estimatedPrice'));
    }

}