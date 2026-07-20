<?php

namespace App\Http\Controllers;

use App\Models\Recorrido;
use App\Models\DetalleRecorrido;
use App\Models\Hacienda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecorridoController extends Controller
{
    /**
     * Mostrar pantalla principal
     */
    public function index(Request $request)
    {
        $haciendas = Hacienda::orderBy('nombre')->get();

        return view('recorridos.index', compact('haciendas'));
    }

    /**
     * Abrir una semana
     */
    public function abrir(Request $request)
    {
        dd('ENTRO');

        $request->validate([
            'hacienda_id' => 'required|exists:haciendas,id',
            'semana' => 'required|integer|min:1|max:53',
            'anio' => 'required|integer'
        ]);

        /*
        |--------------------------------------------------------------------------
        | Buscar recorrido existente
        |--------------------------------------------------------------------------
        */

        $recorrido = Recorrido::with([
            'detalles.lote'
        ])
        ->where('hacienda_id', $request->hacienda_id)
        ->where('semana', $request->semana)
        ->where('anio', $request->anio)
        ->first();

        /*
        |--------------------------------------------------------------------------
        | Si existe devolverlo
        |--------------------------------------------------------------------------
        */

        if ($recorrido) {

            return response()->json([
                'existe' => true,
                'recorrido' => $recorrido
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Si NO existe devolver los lotes
        |--------------------------------------------------------------------------
        */

        $lotes = Hacienda::find($request->hacienda_id)
            ->lotes()
            ->orderBy('nombre')
            ->get();

        dd($request->hacienda_id, $lotes);

        return response()->json([
            'existe' => false,
            'lotes' => $lotes
        ]);
    }

    /**
     * Guardar recorrido
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Generar PDF
     */
    public function pdf($id)
    {
        //
    }
}

