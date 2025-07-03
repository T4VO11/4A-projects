<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; 
use Illuminate\Database\Eloquent\SoftDeletes;

class Sucursal extends Model
{
    use HasFactory, SoftDeletes; 

    protected $table = 'sucursales';
    protected $primaryKey = 'idSucursal';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'imagen_url',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }

    public function hoteles()
    {
        return $this->hasMany(Hotel::class, 'idSucursalFK', 'idSucursal');
    }

    public function vuelos()
    {
        return $this->hasMany(Vuelo::class, 'idSucursalFK', 'idSucursal');
    }

    public function reservaciones()
    {
        return $this->hasMany(Reservacion::class, 'idSucursalFK', 'idSucursal');
    }
}