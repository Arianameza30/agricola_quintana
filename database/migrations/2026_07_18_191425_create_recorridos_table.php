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
        Schema::create('recorridos', function (Blueprint $table) {

            $table->id();

            // Hacienda
            $table->foreignId('hacienda_id')
                ->constrained()
                ->onDelete('cascade');

            // Usuario que registra
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            // Semana del año (1-53)
            $table->unsignedTinyInteger('semana');

            // Año
            $table->year('anio');

            // Rango de fechas
            $table->date('fecha_inicio');

            $table->date('fecha_fin');

            /*
             Estado gráfico del mapa.

             Aquí se almacenará el JSON con el color,
             tipo de pintado, porcentaje parcial, etc.
            */

            $table->json('mapa')->nullable();

            $table->timestamps();

            // Una sola vez por hacienda, semana y año
            $table->unique([
                'hacienda_id',
                'semana',
                'anio'
            ]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recorridos');
    }
};