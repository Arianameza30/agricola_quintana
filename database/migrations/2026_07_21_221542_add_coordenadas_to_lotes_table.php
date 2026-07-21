<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agregar coordenadas a los lotes.
     */
    public function up(): void
    {
        Schema::table('lotes', function (Blueprint $table) {
            $table->json('coordenadas')
                ->nullable()
                ->after('estado');
        });
    }

    /**
     * Eliminar coordenadas.
     */
    public function down(): void
    {
        Schema::table('lotes', function (Blueprint $table) {
            $table->dropColumn('coordenadas');
        });
    }
};