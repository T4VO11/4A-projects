<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Para UUIDs

class HotelImage extends Model
{
    use HasFactory;

    protected $table = 'hotel_images';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'hotel_id',
        'image_url',
        'order',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }

    /**
     * Relación: Una imagen pertenece a un hotel.
     */
    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id', 'idHotel');
    }
}