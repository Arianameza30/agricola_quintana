<?php

namespace App\Http\Controllers;

use App\Models\Hacienda;

class HaciendaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTADO DE HACIENDAS
    |--------------------------------------------------------------------------
    |
    | El módulo es únicamente de consulta.
    | Los nombres se obtienen desde la tabla corporativa "hacienda".
    |
    */

    public function index()
    {
        $haciendas = Hacienda::orderBy('id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Contar los lotes de cada hacienda
        |--------------------------------------------------------------------------
        |
        | Se asigna explícitamente el conteo para garantizar que la vista reciba
        | correctamente 16 lotes para Domenica y 12 para María María.
        |
        */

        $haciendas->each(function (Hacienda $hacienda): void {

            $hacienda->setAttribute(
                'lotes_count',
                $hacienda->lotes()->count()
            );

        });

        return view(
            'haciendas.index',
            compact('haciendas')
        );
    }
}