<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recorrido extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Conexión y tabla
    |--------------------------------------------------------------------------
    |
    | La conexión principal conserva el prefijo "m_", por lo que el nombre
    | lógico "recorridos" corresponde físicamente a "m_recorridos".
    |
    */

    protected $connection = 'mysql';

    protected $table = 'recorridos';

    protected $fillable = [
        'hacienda_id',
        'user_id',
        'semana',
        'anio',
        'fecha_inicio',
        'fecha_fin',
        'mapa',
    ];

    protected $casts = [
        'mapa' => 'array',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'semana' => 'integer',
        'anio' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function hacienda()
    {
        return $this->belongsTo(
            Hacienda::class,
            'hacienda_id',
            'id'
        );
    }

    public function usuario()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'id'
        );
    }

    public function detalles()
    {
        return $this->hasMany(
            DetalleRecorrido::class,
            'recorrido_id',
            'id'
        );
    }
}