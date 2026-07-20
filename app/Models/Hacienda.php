<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hacienda extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
    ];

    public function lotes()
    {
        return $this->hasMany(Lote::class);
    }

    public function recorridos()
{
    return $this->hasMany(Recorrido::class);
}
}