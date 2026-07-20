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
        Schema::create('detalle_recorridos', function (Blueprint $table) {

            $table->id();

            // Recorrido al que pertenece
            $table->foreignId('recorrido_id')
                ->constrained()
                ->onDelete('cascade');

            // Lote
            $table->foreignId('lote_id')
                ->constrained()
                ->onDelete('cascade');

            // Datos de la matriz semanal

            $table->decimal('lunes', 8, 2)->nullable();

            $table->decimal('martes', 8, 2)->nullable();

            $table->decimal('miercoles', 8, 2)->nullable();

            $table->decimal('jueves', 8, 2)->nullable();

            $table->decimal('viernes', 8, 2)->nullable();

            $table->decimal('sabado', 8, 2)->nullable();

            $table->timestamps();

            // Un lote solo puede existir una vez por recorrido
            $table->unique([
                'recorrido_id',
                'lote_id'
            ]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_recorridos');
    }
};