<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\VueloController;
use App\Http\Controllers\ReservacionController;
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\OfertasController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/google-auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});
 
Route::get('/google-auth/callback', function () {
    $user_google = Socialite::driver('google')->stateless()->user();

    $user = User::updateOrCreate([
        'google_id' => $user_google->id,
    ],[
        'name'=> $user_google->name,
        'email'=> $user_google->email,
        'role' => 'user',
    ]);

    Auth::login($user);

    return redirect('/dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/vuelos', [VueloController::class, 'index'])->name('vuelos.index');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/reservaciones', [ReservacionController::class, 'index'])->name('reservaciones.index'); 
    Route::get('/reservaciones/create', [ReservacionController::class, 'create'])->name('reservaciones.create');
    Route::post('/reservaciones', [ReservacionController::class, 'store'])->name('reservaciones.store');
    Route::get('/reservaciones/{id}', [ReservacionController::class, 'show'])->name('reservaciones.show'); 
    Route::get('/reservaciones/{id}/edit', [ReservacionController::class, 'edit'])->name('reservaciones.edit'); 
    Route::put('/reservaciones/{id}', [ReservacionController::class, 'update'])->name('reservaciones.update'); 
    Route::delete('/reservaciones/{id}', [ReservacionController::class, 'destroy'])->name('reservaciones.destroy'); 
    Route::get('/reservaciones/ocultas', [ReservacionController::class, 'trashed'])->name('reservaciones.trashed'); 
    Route::post('/reservaciones/{id}/restaurar', [ReservacionController::class, 'restore'])->name('reservaciones.restore');


    Route::get('/sucursales', [SucursalController::class, 'index'])->name('sucursales.index'); 
    Route::get('/sucursales/create', [SucursalController::class, 'create'])->name('sucursales.create');
    Route::post('/sucursales', [SucursalController::class, 'store'])->name('sucursales.store');
    Route::get('/sucursales/{id}', [SucursalController::class, 'show'])->name('sucursales.show'); 
    Route::get('/sucursales/{id}/edit', [SucursalController::class, 'edit'])->name('sucursales.edit'); 
    Route::put('/sucursales/{id}', [SucursalController::class, 'update'])->name('sucursales.update'); 
    Route::delete('/sucursales/{id}', [SucursalController::class, 'destroy'])->name('sucursales.destroy'); 
    Route::get('/sucursales/ocultas', [SucursalController::class, 'trashed'])->name('sucursales.trashed'); 
    Route::post('/sucursales/{id}/restaurar', [SucursalController::class, 'restore'])->name('sucursales.restore'); 

    Route::get('/hoteles', [HotelController::class, 'index'])->name('hoteles.index'); 
    Route::get('/hoteles/create', [HotelController::class, 'create'])->name('hoteles.create');
    Route::post('/hoteles', [HotelController::class, 'store'])->name('hoteles.store');
    Route::get('/hoteles/{id}', [HotelController::class, 'show'])->name('hoteles.show');
    Route::get('/hoteles/{id}/edit', [HotelController::class, 'edit'])->name('hoteles.edit');
    Route::put('/hoteles/{id}', [HotelController::class, 'update'])->name('hoteles.update');
    Route::delete('/hoteles/{id}', [HotelController::class, 'destroy'])->name('hoteles.destroy');

    Route::get('/vuelos/create', [VueloController::class, 'create'])->name('vuelos.create');
    Route::post('/vuelos', [VueloController::class, 'store'])->name('vuelos.store');
    Route::get('/vuelos/{id}', [VueloController::class, 'show'])->name('vuelos.show');
    Route::get('/vuelos/{id}/edit', [VueloController::class, 'edit'])->name('vuelos.edit');
    Route::put('/vuelos/{id}', [VueloController::class, 'update'])->name('vuelos.update');
    Route::delete('/vuelos/{id}', [VueloController::class, 'destroy'])->name('vuelos.destroy');

    Route::get('/vuelos/comprar/confirmar/{id}', [VueloController::class, 'confirmPurchase'])->name('vuelos.confirmPurchase');
    Route::get('/ofertas', [OfertasController::class, 'index'])->name('ofertas.index');
    Route::get('/ofertas/{offerId}', [OfertasController::class, 'showDetails'])->name('ofertas.showDetails'); // {offerId} para el ID de la oferta

});


require __DIR__.'/auth.php';