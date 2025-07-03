<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class SucursalController extends Controller
{

    public function index()
    {
        $sucursales = Sucursal::all();

        if (Auth::check() && Auth::user()->role === 'admin') {
            return view('sucursales.admin-index', compact('sucursales'));
        }
        else {
            return view('sucursales.user-view', compact('sucursales'));
        }
    }

    public function create()
    {
        $this->authorize('create', Sucursal::class);
        return view('sucursales.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Sucursal::class);

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
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
            $path = $request->file('imagen')->store('public/sucursales');
            $data['imagen_url'] = Storage::url($path);
        } else {
            $data['imagen_url'] = null;
        }
        
        Sucursal::create($data); 
        
        return redirect()->route('sucursales.index')->with('success', 'Sucursal creada exitosamente.');
    }

    public function show($id) 
    {
        $sucursal = Sucursal::find($id);

        if (!$sucursal) {
            return redirect()->route('sucursales.index')->with('error', 'Sucursal no encontrada.');
        }
        return view('sucursales.show', compact('sucursal'));
    }


    public function edit($id) 
    {
        $sucursal = Sucursal::find($id);

        if (!$sucursal) {
            return redirect()->route('sucursales.index')->with('error', 'Sucursal no encontrada para editar.');
        }

        $this->authorize('update', $sucursal);
        return view('sucursales.edit', compact('sucursal'));
    }


    public function update(Request $request, $id)
    {
        $sucursal = Sucursal::find($id);

        if (!$sucursal) {
            return redirect()->route('sucursales.index')->with('error', 'Sucursal no encontrada para actualizar.');
        }

        $this->authorize('update', $sucursal);

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $data = $request->except('imagen');

        if ($request->hasFile('imagen')) {
            if ($sucursal->imagen_url) {
                Storage::delete(str_replace('/storage', 'public', $sucursal->imagen_url));
            }
            $path = $request->file('imagen')->store('public/sucursales');
            $data['imagen_url'] = Storage::url($path);
        } elseif ($request->input('clear_imagen')) {
            if ($sucursal->imagen_url) {
                Storage::delete(str_replace('/storage', 'public', $sucursal->imagen_url));
            }
            $data['imagen_url'] = null;
        }

        $sucursal->update($data);

        return redirect()->route('sucursales.index')->with('success', 'Sucursal actualizada exitosamente.');
    }


    public function destroy($id) 
    {
        $sucursal = Sucursal::find($id);

        if (!$sucursal) {
            return redirect()->route('sucursales.index')->with('error', 'Sucursal no encontrada para ocultar.');
        }

        $this->authorize('delete', $sucursal);
        
        if ($sucursal->imagen_url) {
            Storage::delete(str_replace('/storage', 'public', $sucursal->imagen_url));
        }
        $sucursal->delete(); 
        
        return redirect()->route('sucursales.index')->with('success', 'Sucursal eliminada exitosamente.');
    }


public function trashed()
{

    //dd("Llegué al método trashed. Estado de autenticación: " . (Auth::check() ? 'true' : 'false') . ". Rol del usuario: " . (Auth::check() ? Auth::user()->role : 'guest'));

    $sucursales = Sucursal::onlyTrashed()->get();

    return view('sucursales.trashed-index', compact('sucursales'));
}


    public function restore($id)
    {
        $sucursal = Sucursal::withTrashed()->find($id);

        if (!$sucursal) {
            return redirect()->route('sucursales.trashed')->with('error', 'Sucursal oculta no encontrada para restaurar.');
        }

        $this->authorize('restore', $sucursal);

        $sucursal->restore(); 

        return redirect()->route('sucursales.trashed')->with('success', 'Sucursal restaurada exitosamente.');
    }
}