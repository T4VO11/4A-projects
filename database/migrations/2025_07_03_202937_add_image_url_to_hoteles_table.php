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
        Schema::table('hoteles', function (Blueprint $table) {
            if (!Schema::hasColumn('hoteles', 'imagen_url')) {
                $table->string('imagen_url')->nullable()->after('descripcion'); // Colócala después de 'descripcion'
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hoteles', function (Blueprint $table) {
            $table->dropColumn('imagen_url');
        });
    }
};