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
        Schema::create('hoteles', function (Blueprint $table) {
            $table->uuid('idHotel')->primary(); 
            $table->string('nombre');
            $table->string('direccion');
            $table->string('ciudad');
            $table->string('telefono');
            $table->integer('plazasDisponibles');
            $table->string('descripcion')->nullable();
            

            $table->uuid('idSucursalFK');
            $table->foreign('idSucursalFK')->references('idSucursal')->on('sucursales')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoteles');
    }
};