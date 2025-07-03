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
        Schema::table('users', function (Blueprint $table) {
            $table->string('apellidoPat')->after('name')->nullable();
            $table->string('apellidoMat')->after('apellidoPat')->nullable();
            $table->string('direccion')->after('email')->nullable(); 
            $table->string('telefono')->after('direccion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['apellidoPat', 'apellidoMat', 'direccion', 'telefono']);
        });
    }
};