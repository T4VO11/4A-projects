<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Asegúrate de que esta importación esté presente

use App\Models\HotelImage; // ¡Añadido! Modelo para imágenes de galería
use App\Models\HotelRoomType; // ¡Añadido! Modelo para tipos de habitación

class HotelController extends Controller
{
    /**
     * Display a listing of the resource (dynamic based on role).
     */
    public function index()
    {
        $hoteles = Hotel::with('sucursal')->get();

        if (Auth::check() && Auth::user()->role === 'admin') {
            return view('hoteles.admin-index', compact('hoteles'));
        } else {
            return view('hoteles.user-view', compact('hoteles'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Hotel::class);
        $sucursales = Sucursal::all();
        return view('hoteles.create', compact('sucursales'));
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     * Ahora carga el hotel manualmente y sus relaciones de imágenes y tipos de habitación.
     */
    public function show($id)
    {
        // Cargar el hotel y sus relaciones de imágenes de galería y tipos de habitación
        $hotel = Hotel::with(['sucursal', 'images', 'roomTypes'])->find($id);

        if (!$hotel) {
            return redirect()->route('hoteles.index')->with('error', 'Hotel no encontrado.');
        }
        
        // Asumiendo que star_rating y amenities_info no vienen de BD
        // Puedes hardcodearlos aquí o si los quieres gestionar, necesitas columnas/tablas
        $hotel->star_rating = $hotel->star_rating ?? 4; // Usar la columna si existe, sino default 4 estrellas
        $hotel->amenities_info = [
            ['nombre' => 'Alberca al aire libre', 'icon' => '🏊', 'disponible' => true],
            ['nombre' => 'Restaurante gourmet', 'icon' => '🍽️', 'disponible' => true],
            ['nombre' => 'Bar / Lounge', 'icon' => '🍸', 'disponible' => true],
            ['nombre' => 'Wi-Fi gratuito', 'icon' => '📶', 'disponible' => true],
            ['nombre' => 'Gimnasio', 'icon' => '🏋️‍♂️', 'disponible' => true],
            ['nombre' => 'Spa y bienestar', 'icon' => '🧘‍♀️', 'disponible' => true],
            ['nombre' => 'Estacionamiento gratuito', 'icon' => '🅿️', 'disponible' => true],
            ['nombre' => 'Servicio a la habitación', 'icon' => '🛎️', 'disponible' => true],
            ['nombre' => 'Centro de negocios', 'icon' => '💼', 'disponible' => false],
        ];

        return view('hoteles.show', compact('hotel'));
    }

    /**
     * Show the form for editing the specified resource.
     * Ahora recibe el ID y carga el hotel y sus relaciones.
     */
    public function edit($id)
    {
        // Cargar el hotel y sus imágenes de galería y tipos de habitación
        $hotel = Hotel::with(['images', 'roomTypes', 'sucursal'])->find($id); 

        if (!$hotel) {
            return redirect()->route('hoteles.index')->with('error', 'Hotel no encontrado para editar.');
        }

        $this->authorize('update', $hotel);
        $sucursales = Sucursal::all(); // Necesitamos las sucursales para el select

        return view('hoteles.edit', compact('hotel', 'sucursales'));
    }

    /**
     * Update the specified resource in storage.
     * Maneja la actualización de hotel, galería de imágenes y tipos de habitación.
     */
    public function update(Request $request, $id)
    {
        $hotel = Hotel::with(['images', 'roomTypes'])->find($id); // Carga el hotel con sus relaciones

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
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Imagen principal
            'new_gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Nuevas imágenes de galería
            'delete_gallery_images' => 'nullable|array', // IDs de imágenes de galería a eliminar
            'delete_gallery_images.*' => 'uuid|exists:hotel_images,id', // Validar IDs
            'new_room_name' => 'nullable|string|max:255', // Campo para nuevo tipo de habitación
            'new_room_capacity' => 'nullable|string|max:255',
            'new_room_price' => 'nullable|numeric|min:0',
            'new_room_description' => 'nullable|string',
            'new_room_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $data = $request->except(['imagen', 'new_gallery_images', 'delete_gallery_images', 
                                  'new_room_name', 'new_room_capacity', 'new_room_price', 
                                  'new_room_description', 'new_room_image']);

        // 1. Manejo de la IMAGEN PRINCIPAL (ya existente)
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

        // Actualiza los datos básicos del hotel
        $hotel->update($data);

        // 2. Manejo de IMÁGENES DE GALERÍA
        // Eliminar imágenes seleccionadas
        if ($request->has('delete_gallery_images')) {
            foreach ($request->input('delete_gallery_images') as $imageId) {
                $image = HotelImage::find($imageId);
                if ($image && $image->hotel_id === $hotel->idHotel) { // Asegurarse de que la imagen pertenece a este hotel
                    Storage::delete(str_replace('/storage', 'public', $image->image_url));
                    $image->delete();
                }
            }
        }

        // Añadir nuevas imágenes de galería
        if ($request->hasFile('new_gallery_images')) {
            foreach ($request->file('new_gallery_images') as $file) {
                $path = $file->store('public/hotel_gallery'); // Guardar en una subcarpeta
                HotelImage::create([
                    'hotel_id' => $hotel->idHotel,
                    'image_url' => Storage::url($path),
                    'order' => null, // O definir una lógica de orden
                ]);
            }
        }

        // 3. Manejo de NUEVOS TIPOS DE HABITACIÓN
        if ($request->filled('new_room_name')) { // Si se está añadiendo un nuevo tipo
            $newRoomData = [
                'hotel_id' => $hotel->idHotel,
                'name' => $request->input('new_room_name'),
                'capacity' => $request->input('new_room_capacity'),
                'price' => $request->input('new_room_price'),
                'description' => $request->input('new_room_description'),
            ];

            // Manejar imagen para el nuevo tipo de habitación
            if ($request->hasFile('new_room_image')) {
                $path = $request->file('new_room_image')->store('public/room_types');
                $newRoomData['image_url'] = Storage::url($path);
            }

            HotelRoomType::create($newRoomData);
        }
        // Nota: La edición y eliminación de tipos de habitación existentes
        // se manejarán con los métodos editRoomType y destroyRoomType que hemos definido.

        return redirect()->route('hoteles.edit', $hotel->idHotel)->with('success', 'Hotel y sus detalles actualizados exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $hotel = Hotel::find($id);

        if (!$hotel) {
            return redirect()->route('hoteles.index')->with('error', 'Hotel no encontrado para eliminar.');
        }

        $this->authorize('delete', $hotel);
        
        // Eliminar la imagen principal asociada si existe
        if ($hotel->imagen_url) {
            Storage::delete(str_replace('/storage', 'public', $hotel->imagen_url));
        }

        // Eliminar imágenes de galería asociadas
        foreach ($hotel->images as $image) {
            Storage::delete(str_replace('/storage', 'public', $image->image_url));
            $image->delete();
        }

        // Eliminar tipos de habitación asociados (si no se quieren mantener huellas)
        foreach ($hotel->roomTypes as $roomType) {
            if ($roomType->image_url) {
                Storage::delete(str_replace('/storage', 'public', $roomType->image_url));
            }
            $roomType->delete();
        }

        $hotel->delete(); // Esto realizará el borrado permanente del hotel
        
        return redirect()->route('hoteles.index')->with('success', 'Hotel eliminado exitosamente.');
    }

    /**
     * Show the form for editing a specific room type.
     */
    public function editRoomType($hotelId, $roomTypeId) // ¡¡¡ASEGÚRATE DE QUE ESTE MÉTODO ESTÉ AQUÍ!!!
    {
        // Cargar el tipo de habitación, asegurándose de que pertenece al hotel
        $hotel = Hotel::find($hotelId);
        $roomType = HotelRoomType::find($roomTypeId);

        if (!$hotel || !$roomType || $roomType->hotel_id !== $hotel->idHotel) {
            return redirect()->route('hoteles.edit', $hotelId)->with('error', 'Tipo de habitación no encontrado o no pertenece a este hotel.');
        }

        $this->authorize('update', $hotel); // Autorizar la edición de roomType si se puede editar el hotel
        // Opcional: Podrías crear una política específica para HotelRoomType si la lógica es diferente.

        return view('hoteles.edit-room-type', compact('hotel', 'roomType'));
    }

    /**
     * Update the specified room type in storage.
     */
    public function updateRoomType(Request $request, $hotelId, $roomTypeId)
    {
        $hotel = Hotel::find($hotelId);
        $roomType = HotelRoomType::find($roomTypeId);

        if (!$hotel || !$roomType || $roomType->hotel_id !== $hotel->idHotel) {
            return redirect()->route('hoteles.edit', $hotelId)->with('error', 'Tipo de habitación no encontrado o no pertenece a este hotel para actualizar.');
        }

        $this->authorize('update', $hotel); // Re-autorizar

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'capacity' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            if ($roomType->image_url) {
                Storage::delete(str_replace('/storage', 'public', $roomType->image_url));
            }
            $path = $request->file('image')->store('public/room_types'); // Guardar en public/room_types
            $data['image_url'] = Storage::url($path);
        } elseif ($request->input('clear_image')) {
            if ($roomType->image_url) {
                Storage::delete(str_replace('/storage', 'public', $roomType->image_url));
            }
            $data['image_url'] = null;
        }

        $roomType->update($data);

        return redirect()->route('hoteles.edit', $hotel->idHotel)->with('success', 'Tipo de habitación actualizado exitosamente.');
    }


    /**
     * Remove the specified room type from storage.
     */
    public function destroyRoomType($hotelId, $roomTypeId)
    {
        $hotel = Hotel::find($hotelId);
        $roomType = HotelRoomType::find($roomTypeId);

        if (!$hotel || !$roomType || $roomType->hotel_id !== $hotel->idHotel) {
            return redirect()->route('hoteles.edit', $hotelId)->with('error', 'Tipo de habitación no encontrado o no pertenece a este hotel para eliminar.');
        }

        $this->authorize('delete', $hotel); // Re-autorizar (o crear política para RoomType)

        if ($roomType->image_url) {
            Storage::delete(str_replace('/storage', 'public', $roomType->image_url));
        }
        $roomType->delete();

        return redirect()->route('hoteles.edit', $hotel->idHotel)->with('success', 'Tipo de habitación eliminado exitosamente.');
    }
}