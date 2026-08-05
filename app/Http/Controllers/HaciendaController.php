<?php

namespace App\Http\Controllers;

use App\Models\Hacienda;

class HaciendaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CONSULTA DE HACIENDAS
    |--------------------------------------------------------------------------
    |
    | La información se obtiene directamente de la tabla corporativa
    | "hacienda". El módulo es solamente de consulta.
    |
    */

    public function index()
    {
        $haciendas = Hacienda::withCount(
            'lotes'
        )
        ->orderBy('nombre_hacienda')
        ->get();

        return view(
            'haciendas.index',
            compact('haciendas')
        );
    }
}