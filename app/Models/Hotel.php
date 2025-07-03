<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; 

class Hotel extends Model
{
    use HasFactory;

    protected $table = 'hoteles';
    protected $primaryKey = 'idHotel';
    public $incrementing = false; 
    protected $keyType = 'string'; 

    protected $fillable = [
        'nombre',
        'direccion',
        'ciudad',
        'telefono',
        'plazasDisponibles',
        'descripcion',
        'idSucursalFK',
        'imagen_url',
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
        return $this->hasMany(Reservacion::class, 'idHotelFK', 'idHotel');
    }
}