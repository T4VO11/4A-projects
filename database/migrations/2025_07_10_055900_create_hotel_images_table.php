<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hotel_images', function (Blueprint $table) {
            $table->uuid('id')->primary(); // ID único para cada imagen
            $table->uuid('hotel_id'); // Clave foránea al hotel
            $table->string('image_url'); // Ruta de la imagen
            $table->integer('order')->nullable(); // Orden de la imagen en la galería
            $table->timestamps();

            // Definir la clave foránea
            $table->foreign('hotel_id')->references('idHotel')->on('hoteles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_images');
    }
};