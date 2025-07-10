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
        Schema::create('hotel_room_types', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('hotel_id'); // Clave foránea al hotel
            $table->string('name');
            $table->string('capacity')->nullable();
            $table->decimal('price', 10, 2); // Precio por noche
            $table->text('description')->nullable();
            $table->string('image_url')->nullable(); // Imagen del tipo de habitación
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
        Schema::dropIfExists('hotel_room_types');
    }
};  