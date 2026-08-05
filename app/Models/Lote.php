<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Lote extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Conexión y tabla corporativa
    |--------------------------------------------------------------------------
    */

    protected $connection = 'mysql_corporativa';

    protected $table = 'lote';

    protected $fillable = [
        'id_hacienda',
        'hacienda_id',
        'lote',
        'nombre',
        'estado',
        'coordenadas',
    ];

    protected $casts = [
        'coordenadas' => 'array',
        'estado' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Atributos virtuales incluidos al convertir a JSON
    |--------------------------------------------------------------------------
    |
    | Estos nombres son los que utiliza actualmente el JavaScript del sistema.
    |
    */

    protected $appends = [
        'hacienda_id',
        'nombre',
        'has_prod',
    ];

    /**
     * Caché temporal de hectáreas oficiales.
     *
     * @var array<string, float|null>
     */
    protected static array $cacheHectareasOficiales = [];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function hacienda()
    {
        return $this->belongsTo(
            Hacienda::class,
            'id_hacienda',
            'id'
        );
    }

    public function detallesRecorrido()
    {
        return $this->hasMany(
            DetalleRecorrido::class,
            'lote_id',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Compatibilidad con "hacienda_id"
    |--------------------------------------------------------------------------
    */

    public function getHaciendaIdAttribute(): ?int
    {
        $valor =
            $this->attributes['id_hacienda']
            ?? null;

        return $valor !== null
            ? (int) $valor
            : null;
    }

    public function setHaciendaIdAttribute(
        int|string|null $valor
    ): void {
        $this->attributes['id_hacienda'] =
            $valor !== null
                ? (int) $valor
                : null;
    }

    /*
    |--------------------------------------------------------------------------
    | Compatibilidad con "nombre"
    |--------------------------------------------------------------------------
    */

    public function getNombreAttribute(): string
    {
        return (string) (
            $this->attributes['lote']
            ?? ''
        );
    }

    public function setNombreAttribute(
        int|string|null $valor
    ): void {
        $this->attributes['lote'] =
            $valor !== null &&
            trim((string) $valor) !== ''
                ? (int) $valor
                : null;
    }

    /*
    |--------------------------------------------------------------------------
    | Obtener hectáreas productivas oficiales
    |--------------------------------------------------------------------------
    */

    public static function obtenerHectareasOficiales(
        int|string|null $haciendaId,
        int|string|null $nombreLote,
        float|int|string|null $valorRespaldo = 0
    ): float {
        if (
            $haciendaId === null ||
            $nombreLote === null ||
            trim((string) $nombreLote) === ''
        ) {
            return (float) (
                $valorRespaldo ?? 0
            );
        }

        $idHacienda =
            (int) $haciendaId;

        $lote =
            trim((string) $nombreLote);

        $clave =
            $idHacienda . '|' . $lote;

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

        $registro = DB::connection(
            'mysql_corporativa'
        )
        ->table('hectareas')
        ->select('hectareas')
        ->where(
            'id_hacienda',
            $idHacienda
        )
        ->where(
            'lote',
            $lote
        )
        ->orderByDesc('fecha')
        ->orderByDesc('anio')
        ->orderByDesc('semana')
        ->first();

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
    | Atributo virtual "has_prod"
    |--------------------------------------------------------------------------
    */

    public function getHasProdAttribute(): float
    {
        return static::obtenerHectareasOficiales(
            $this->id_hacienda,
            $this->lote,
            0
        );
    }
}