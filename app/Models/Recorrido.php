<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recorrido extends Model
{
    protected $fillable = [
        'hacienda_id',
        'user_id',
        'semana',
        'anio',
        'fecha_inicio',
        'fecha_fin',
        'mapa'
    ];

    protected $casts = [
        'mapa' => 'array',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function hacienda()
    {
        return $this->belongsTo(Hacienda::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleRecorrido::class);
    }
}