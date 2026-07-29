<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agrega la columna activo a la tabla users.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'activo')) {
            Schema::table('users', function (Blueprint $table) {
                $table
                    ->boolean('activo')
                    ->default(true)
                    ->after('rol');
            });
        }
    }

    /**
     * Elimina la columna activo.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'activo')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('activo');
            });
        }
    }
};