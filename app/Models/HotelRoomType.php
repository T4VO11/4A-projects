<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Para UUIDs

class HotelRoomType extends Model
{
    use HasFactory;

    protected $table = 'hotel_room_types';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'hotel_id',
        'name',
        'capacity',
        'price',
        'description',
        'image_url',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }

    /**
     * Relación: Un tipo de habitación pertenece a un hotel.
     */
    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id', 'idHotel');
    }
}