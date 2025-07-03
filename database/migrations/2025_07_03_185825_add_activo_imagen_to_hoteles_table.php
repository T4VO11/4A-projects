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
        $table->boolean('activo')->default(true)->after('descripcion');
        $table->string('imagen_url')->nullable()->after('activo');
    });
}

    public function down(): void
{
    Schema::table('hoteles', function (Blueprint $table) {
        $table->dropColumn('activo');
        $table->dropColumn('imagen_url');
    });
}
};
