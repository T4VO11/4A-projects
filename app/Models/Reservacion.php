<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\User; 

class Reservacion extends Model
{
    use HasFactory;

    protected $table = 'reservaciones';
    protected $primaryKey = 'idReservacionPK';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'fechaViaje',
        'numeroPersonas',
        'pensionElegida',
        'totalCotizacion',
        'idUsuarioFK',
        'idSucursalFK',
        'idHotelFK',
        'idVueloFK',
    ];

    protected $casts = [
        'fechaViaje' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'idUsuarioFK', 'id');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'idSucursalFK', 'idSucursal');
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'idHotelFK', 'idHotel');
    }
    
    public function vuelo()
    {
        return $this->belongsTo(Vuelo::class, 'idVueloFK', 'idVueloPK');
    }
}