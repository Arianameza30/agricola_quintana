<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Ejecutar la migración.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'usuario')) {
            Schema::table('users', function (Blueprint $table) {
                $table
                    ->string('usuario', 100)
                    ->nullable()
                    ->unique()
                    ->after('name');
            });
        }

        $usuarios = DB::table('users')
            ->select('id', 'name', 'email', 'usuario')
            ->orderBy('id')
            ->get();

        foreach ($usuarios as $usuario) {
            if (! empty($usuario->usuario)) {
                continue;
            }

            $parteCorreo = Str::before(
                (string) $usuario->email,
                '@'
            );

            $usuarioBase = Str::lower(
                Str::slug($parteCorreo, '_')
            );

            if ($usuarioBase === '') {
                $usuarioBase = Str::lower(
                    Str::slug((string) $usuario->name, '_')
                );
            }

            if ($usuarioBase === '') {
                $usuarioBase = 'usuario_'.$usuario->id;
            }

            $usuarioFinal = $usuarioBase;
            $contador = 1;

            while (
                DB::table('users')
                    ->where('usuario', $usuarioFinal)
                    ->exists()
            ) {
                $usuarioFinal = $usuarioBase.'_'.$contador;
                $contador++;
            }

            DB::table('users')
                ->where('id', $usuario->id)
                ->update([
                    'usuario' => $usuarioFinal,
                ]);
        }
    }

    /**
     * Revertir la migración.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'usuario')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropUnique('users_usuario_unique');
                $table->dropColumn('usuario');
            });
        }
    }
};