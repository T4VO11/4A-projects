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
        Schema::create('reservaciones', function (Blueprint $table) {
            $table->uuid('idReservacionPK')->primary(); 
            $table->date('fechaViaje');
            $table->integer('numeroPersonas');
            $table->string('pensionElegida')->nullable();
            $table->decimal('totalCotizacion', 10, 2);


            $table->unsignedBigInteger('idUsuarioFK');
            $table->foreign('idUsuarioFK')->references('id')->on('users')->onDelete('cascade');
            
            $table->uuid('idSucursalFK')->nullable();
            $table->foreign('idSucursalFK')->references('idSucursal')->on('sucursales')->onDelete('set null');

            $table->uuid('idHotelFK')->nullable();
            $table->foreign('idHotelFK')->references('idHotel')->on('hoteles')->onDelete('set null');
            
            $table->uuid('idVueloFK')->nullable();
            $table->foreign('idVueloFK')->references('idVueloPK')->on('vuelos')->onDelete('set null');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservaciones');
    }
};