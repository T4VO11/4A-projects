<?php

namespace App\Providers;

use App\Models\Sucursal; 
use App\Policies\SucursalPolicy; 

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Sucursal::class => SucursalPolicy::class,
        Hotel::class => HotelPolicy::class,
        Vuelo::class => VueloPolicy::class,
        Reservacion::class => ReservacionPolicy::class,
    ];
    public function boot(): void
    {

    }
}