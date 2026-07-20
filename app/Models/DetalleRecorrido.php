<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleRecorrido extends Model
{
    protected $fillable = [

        'recorrido_id',

        'lote_id',

        'lunes',

        'martes',

        'miercoles',

        'jueves',

        'viernes',

        'sabado'

    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function recorrido()
    {
        return $this->belongsTo(Recorrido::class);
    }

    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Cálculos
    |--------------------------------------------------------------------------
    */

    public function getTotalSemanaAttribute()
    {
        return
            ($this->lunes ?? 0) +
            ($this->martes ?? 0) +
            ($this->miercoles ?? 0) +
            ($this->jueves ?? 0) +
            ($this->viernes ?? 0) +
            ($this->sabado ?? 0);
    }

    public function getPorcentajeAttribute()
    {
        if (!$this->lote || $this->lote->has_prod == 0) {
            return 0;
        }

        return round(
            ($this->total_semana / $this->lote->has_prod) * 100,
            2
        );
    }
}
