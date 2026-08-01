<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Lote extends Model
{
    protected $fillable = [
        'hacienda_id',
        'nombre',
        'has_prod',
        'estado',
        'coordenadas',
    ];

    protected $casts = [
        'coordenadas' => 'array',
        'estado' => 'boolean',
    ];

    /**
     * Caché temporal de hectáreas oficiales durante una petición.
     *
     * @var array<string, float|null>
     */
    protected static array $cacheHectareasOficiales = [];

    /**
     * Caché de equivalencias entre haciendas locales y corporativas.
     *
     * @var array<int|string, int|null>
     */
    protected static array $cacheHaciendasOficiales = [];


    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function hacienda()
    {
        return $this->belongsTo(
            Hacienda::class
        );
    }

    public function detallesRecorrido()
    {
        return $this->hasMany(
            DetalleRecorrido::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Obtener ID de hacienda corporativa
    |--------------------------------------------------------------------------
    |
    | Los IDs de las haciendas locales y corporativas no coinciden:
    |
    | m_haciendas
    | 1 = DOMENICA
    | 2 = MARIA MARIA
    |
    | hacienda
    | 1 = MARIA-MARIA
    | 2 = DOMENICA
    |
    | Por eso se relacionan mediante el nombre normalizado.
    |
    */

    public static function obtenerIdHaciendaOficial(
        int|string|null $haciendaIdLocal
    ): ?int {
        if ($haciendaIdLocal === null) {
            return null;
        }

        if (
            array_key_exists(
                $haciendaIdLocal,
                static::$cacheHaciendasOficiales
            )
        ) {
            return static::$cacheHaciendasOficiales[
                $haciendaIdLocal
            ];
        }

        $registro = DB::selectOne(
            "
                SELECT
                    h.id AS id_hacienda_oficial
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

        $idHaciendaOficial =
            isset($registro->id_hacienda_oficial)
                ? (int) $registro->id_hacienda_oficial
                : null;

        static::$cacheHaciendasOficiales[
            $haciendaIdLocal
        ] = $idHaciendaOficial;

        return $idHaciendaOficial;
    }


    /*
    |--------------------------------------------------------------------------
    | Obtener hectáreas productivas oficiales
    |--------------------------------------------------------------------------
    |
    | Busca el registro más reciente de la tabla corporativa "hectareas",
    | utilizando la hacienda oficial y el número del lote.
    |
    | Si todavía no existe información corporativa, usa temporalmente el
    | valor guardado en m_lotes como respaldo.
    |
    */

    public static function obtenerHectareasOficiales(
        int|string|null $haciendaIdLocal,
        int|string|null $nombreLote,
        float|int|string|null $valorRespaldo = 0
    ): float {
        if (
            $haciendaIdLocal === null ||
            $nombreLote === null ||
            trim((string) $nombreLote) === ''
        ) {
            return (float) (
                $valorRespaldo ?? 0
            );
        }

        $idHaciendaOficial =
            static::obtenerIdHaciendaOficial(
                $haciendaIdLocal
            );

        if ($idHaciendaOficial === null) {
            return (float) (
                $valorRespaldo ?? 0
            );
        }

        $nombreLoteNormalizado =
            trim(
                (string) $nombreLote
            );

        $clave =
            $idHaciendaOficial .
            '|' .
            $nombreLoteNormalizado;

        if (
            array_key_exists(
                $clave,
                static::$cacheHectareasOficiales
            )
        ) {
            return (float) (
                static::$cacheHectareasOficiales[$clave]
                ?? $valorRespaldo
                ?? 0
            );
        }

        $registro = DB::selectOne(
            "
                SELECT
                    hectareas
                FROM hectareas
                WHERE id_hacienda = ?
                  AND lote = ?
                ORDER BY
                    fecha DESC,
                    anio DESC,
                    semana DESC
                LIMIT 1
            ",
            [
                $idHaciendaOficial,
                $nombreLoteNormalizado,
            ]
        );

        $valor =
            $registro?->hectareas;

        static::$cacheHectareasOficiales[
            $clave
        ] =
            $valor !== null
                ? (float) $valor
                : null;

        return (float) (
            $valor
            ?? $valorRespaldo
            ?? 0
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Accesor de hectáreas productivas
    |--------------------------------------------------------------------------
    |
    | Mantiene el nombre "has_prod" para no romper las vistas, recorridos,
    | cálculos ni el PDF existente.
    |
    */

    public function getHasProdAttribute(
        $valorGuardado
    ): float {
        return static::obtenerHectareasOficiales(
            $this->hacienda_id,
            $this->nombre,
            $valorGuardado
        );
    }
}