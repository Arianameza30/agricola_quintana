<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Hacienda extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];

    /**
     * Caché temporal de nombres corporativos durante una petición.
     *
     * @var array<int|string, string|null>
     */
    protected static array $cacheNombresOficiales = [];


    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function lotes()
    {
        return $this->hasMany(
            Lote::class
        );
    }

    public function recorridos()
    {
        return $this->hasMany(
            Recorrido::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Obtener nombre corporativo
    |--------------------------------------------------------------------------
    |
    | Los IDs de m_haciendas y hacienda no coinciden:
    |
    | m_haciendas:
    | 1 = DOMENICA
    | 2 = MARIA MARIA
    |
    | hacienda:
    | 1 = MARIA-MARIA
    | 2 = DOMENICA
    |
    | Por eso la equivalencia se realiza mediante el nombre normalizado.
    |
    */

    public static function obtenerNombreOficial(
        int|string|null $haciendaIdLocal,
        ?string $nombreLocal = null
    ): ?string {
        if ($haciendaIdLocal === null) {
            return $nombreLocal;
        }

        if (
            array_key_exists(
                $haciendaIdLocal,
                static::$cacheNombresOficiales
            )
        ) {
            return static::$cacheNombresOficiales[
                $haciendaIdLocal
            ] ?? $nombreLocal;
        }

        $registro = DB::selectOne(
            "
                SELECT
                    h.nombre_hacienda
                FROM m_haciendas AS mh
                INNER JOIN hacienda AS h
                    ON (
                        REPLACE(
                            REPLACE(
                                UPPER(
                                    TRIM(
                                        h.nombre_hacienda
                                    )
                                ),
                                '-',
                                ''
                            ),
                            ' ',
                            ''
                        ) COLLATE utf8mb4_unicode_ci
                    ) =
                    (
                        REPLACE(
                            REPLACE(
                                UPPER(
                                    TRIM(
                                        mh.nombre
                                    )
                                ),
                                '-',
                                ''
                            ),
                            ' ',
                            ''
                        ) COLLATE utf8mb4_unicode_ci
                    )
                WHERE mh.id = ?
                LIMIT 1
            ",
            [
                $haciendaIdLocal,
            ]
        );

        $nombreOficial =
            isset($registro->nombre_hacienda)
                ? trim(
                    (string) $registro->nombre_hacienda
                )
                : null;

        static::$cacheNombresOficiales[
            $haciendaIdLocal
        ] = $nombreOficial;

        return $nombreOficial
            ?? $nombreLocal;
    }


    /*
    |--------------------------------------------------------------------------
    | Accesor del nombre
    |--------------------------------------------------------------------------
    |
    | Conserva el atributo "nombre" para no modificar recorridos, lotes,
    | vistas ni JavaScript. Al leerlo devuelve el nombre corporativo.
    |
    */

    public function getNombreAttribute(
        $nombreLocal
    ): string {
        return static::obtenerNombreOficial(
            $this->id,
            $nombreLocal
        ) ?? (string) $nombreLocal;
    }
}