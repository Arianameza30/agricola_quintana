<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hacienda extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Conexión y tabla corporativa
    |--------------------------------------------------------------------------
    */

    protected $connection = 'mysql_corporativa';

    protected $table = 'hacienda';

    protected $fillable = [
        'nombre_hacienda',
        'nombre',
        'descripcion',
        'estado',
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Atributos virtuales incluidos al convertir a JSON
    |--------------------------------------------------------------------------
    |
    | El JavaScript existente utiliza "nombre", aunque la columna física
    | corporativa se llama "nombre_hacienda".
    |
    */

    protected $appends = [
        'nombre',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function lotes()
    {
        return $this->hasMany(
            Lote::class,
            'id_hacienda',
            'id'
        );
    }

    public function recorridos()
    {
        return $this->hasMany(
            Recorrido::class,
            'hacienda_id',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Compatibilidad con el atributo "nombre"
    |--------------------------------------------------------------------------
    */

    public function getNombreAttribute(): string
    {
        return (string) (
            $this->attributes['nombre_hacienda']
            ?? ''
        );
    }

    public function setNombreAttribute(
        string $valor
    ): void {
        $this->attributes['nombre_hacienda'] =
            trim($valor);
    }
}