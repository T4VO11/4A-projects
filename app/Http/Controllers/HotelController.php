<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; 

class HotelController extends Controller
{

    public function index()
    {
        $hoteles = Hotel::with('sucursal')->get();

        if (Auth::check() && Auth::user()->role === 'admin') {
            return view('hoteles.admin-index', compact('hoteles'));
        } else {
            return view('hoteles.user-view', compact('hoteles'));
        }
    }

    public function create()
    {
        $this->authorize('create', Hotel::class);
        $sucursales = Sucursal::all();
        return view('hoteles.create', compact('sucursales'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Hotel::class);

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'plazasDisponibles' => 'required|integer|min:0',
            'descripcion' => 'nullable|string',
            'idSucursalFK' => 'required|uuid|exists:sucursales,idSucursal',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        ], [
            'imagen.image' => 'El archivo debe ser una imagen.',
            'imagen.mimes' => 'La imagen debe ser de tipo jpeg, png, jpg, gif o svg.',
            'imagen.max' => 'La imagen no debe pesar más de 2MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $data = $request->except('imagen'); 

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('public/hoteles'); 
            $data['imagen_url'] = Storage::url($path); 
        } else {
            $data['imagen_url'] = null; 
        }

        Hotel::create($data);
        return redirect()->route('hoteles.index')->with('success', 'Hotel creado exitosamente.');
    }

    public function show($id)
    {
        $hotel = Hotel::find($id);

        if (!$hotel) {
            return redirect()->route('hoteles.index')->with('error', 'Hotel no encontrado.');
        }
        $hotel->load('sucursal');
        return view('hoteles.show', compact('hotel'));
    }

    public function edit($id)
    {
        $hotel = Hotel::find($id);

        if (!$hotel) {
            return redirect()->route('hoteles.index')->with('error', 'Hotel no encontrado para editar.');
        }

        $this->authorize('update', $hotel);
        $sucursales = Sucursal::all();
        return view('hoteles.edit', compact('hotel', 'sucursales'));
    }

    public function update(Request $request, $id)
    {
        $hotel = Hotel::find($id);

        if (!$hotel) {
            return redirect()->route('hoteles.index')->with('error', 'Hotel no encontrado para actualizar.');
        }

        $this->authorize('update', $hotel);

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'plazasDisponibles' => 'required|integer|min:0',
            'descripcion' => 'nullable|string',
            'idSucursalFK' => 'required|uuid|exists:sucursales,idSucursal',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        ], [
            'imagen.image' => 'El archivo debe ser una imagen.',
            'imagen.mimes' => 'La imagen debe ser de tipo jpeg, png, jpg, gif o svg.',
            'imagen.max' => 'La imagen no debe pesar más de 2MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $data = $request->except('imagen'); 

        if ($request->hasFile('imagen')) {
            if ($hotel->imagen_url) {
                Storage::delete(str_replace('/storage', 'public', $hotel->imagen_url)); 
            }
            $path = $request->file('imagen')->store('public/hoteles');
            $data['imagen_url'] = Storage::url($path);
        } elseif ($request->input('clear_imagen')) { 
            if ($hotel->imagen_url) {
                Storage::delete(str_replace('/storage', 'public', $hotel->imagen_url));
            }
            $data['imagen_url'] = null;
        }

        $hotel->update($data);
        return redirect()->route('hoteles.index')->with('success', 'Hotel actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $hotel = Hotel::find($id);

        if (!$hotel) {
            return redirect()->route('hoteles.index')->with('error', 'Hotel no encontrado para eliminar.');
        }

        $this->authorize('delete', $hotel);
        
        if ($hotel->imagen_url) {
            Storage::delete(str_replace('/storage', 'public', $hotel->imagen_url));
        }
        $hotel->delete(); 
        
        return redirect()->route('hoteles.index')->with('success', 'Hotel eliminado exitosamente.');
    }
}