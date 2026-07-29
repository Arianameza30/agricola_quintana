<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agrega el estado de la cuenta a los usuarios.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table
                ->boolean('activo')
                ->default(true)
                ->after('rol');
        });
    }

    /**
     * Elimina el campo si se revierte la migración.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('activo');
        });
    }
};