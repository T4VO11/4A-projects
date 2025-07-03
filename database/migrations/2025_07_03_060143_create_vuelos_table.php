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
        Schema::create('vuelos', function (Blueprint $table) {
            $table->uuid('idVueloPK')->primary(); 
            $table->date('fecha');
            $table->time('hora');
            $table->string('origen');
            $table->string('destino');
            $table->integer('plazasTotales');
            $table->integer('plazasTurista');
            $table->string('pension')->nullable();
            

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
        Schema::dropIfExists('vuelos');
    }
};