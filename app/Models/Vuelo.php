<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; 

class Vuelo extends Model
{
    use HasFactory;

    protected $table = 'vuelos';
    protected $primaryKey = 'idVueloPK';
    public $incrementing = false; 
    protected $keyType = 'string'; 

    protected $fillable = [
        'fecha',
        'hora',
        'origen',
        'destino',
        'plazasTotales',
        'plazasTurista',
        'pension',
        'idSucursalFK',
    ];

    protected $casts = [
        'fecha' => 'date',
        'hora' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'idSucursalFK', 'idSucursal');
    }

    public function reservaciones()
    {
        return $this->hasMany(Reservacion::class, 'idVueloFK', 'idVueloPK');
    }
}