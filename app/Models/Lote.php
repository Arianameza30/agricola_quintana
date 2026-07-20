<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    protected $fillable = [
        'hacienda_id',
        'nombre',
        'has_prod',
        'estado',
    ];

    public function hacienda()
    {
        return $this->belongsTo(Hacienda::class);
    }

    public function detallesRecorrido()
{
    return $this->hasMany(DetalleRecorrido::class);
}
}