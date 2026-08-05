<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleRecorrido extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Conexión y tabla
    |--------------------------------------------------------------------------
    |
    | La conexión principal conserva el prefijo "m_", por lo que el nombre
    | lógico "detalle_recorridos" corresponde físicamente a
    | "m_detalle_recorridos".
    |
    */

    protected $connection = 'mysql';

    protected $table = 'detalle_recorridos';

    protected $fillable = [
        'recorrido_id',
        'lote_id',
        'lunes',
        'martes',
        'miercoles',
        'jueves',
        'viernes',
        'sabado',
    ];

    protected $casts = [
        'lunes' => 'decimal:2',
        'martes' => 'decimal:2',
        'miercoles' => 'decimal:2',
        'jueves' => 'decimal:2',
        'viernes' => 'decimal:2',
        'sabado' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function recorrido()
    {
        return $this->belongsTo(
            Recorrido::class,
            'recorrido_id',
            'id'
        );
    }

    public function lote()
    {
        return $this->belongsTo(
            Lote::class,
            'lote_id',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Cálculos
    |--------------------------------------------------------------------------
    */

    public function getTotalSemanaAttribute(): float
    {
        return
            (float) ($this->lunes ?? 0) +
            (float) ($this->martes ?? 0) +
            (float) ($this->miercoles ?? 0) +
            (float) ($this->jueves ?? 0) +
            (float) ($this->viernes ?? 0) +
            (float) ($this->sabado ?? 0);
    }

    public function getPorcentajeAttribute(): float
    {
        $hectareas =
            (float) (
                $this->lote?->has_prod
                ?? 0
            );

        if ($hectareas <= 0) {
            return 0;
        }

        return round(
            (
                $this->total_semana /
                $hectareas
            ) * 100,
            2
        );
    }
}