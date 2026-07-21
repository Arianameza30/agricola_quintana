<?php

namespace App\Http\Controllers;

use App\Models\Recorrido;
use App\Models\DetalleRecorrido;
use App\Models\Hacienda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

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
        | Si existe el recorrido
        |--------------------------------------------------------------------------
        */

        if ($recorrido) {

            return response()->json([
                'existe' => true,
                'recorrido' => $recorrido,
                'detalles' => $recorrido->detalles
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Si NO existe el recorrido
        |--------------------------------------------------------------------------
        */

        $lotes = Hacienda::findOrFail($request->hacienda_id)
            ->lotes()
            ->orderBy('nombre')
            ->get();

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
        $request->validate([
            'hacienda_id' => 'required|exists:haciendas,id',
            'semana' => 'required|integer|min:1|max:53',
            'anio' => 'required|integer',
            'fecha' => 'required|date',
            'detalles' => 'required|array',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Buscar si ya existe el recorrido
        |--------------------------------------------------------------------------
        */

        $recorrido = Recorrido::where('hacienda_id', $request->hacienda_id)
            ->where('semana', $request->semana)
            ->where('anio', $request->anio)
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Crear recorrido si no existe
        |--------------------------------------------------------------------------
        */

        if (!$recorrido) {

            $fechaInicio = Carbon::parse($request->fecha)
                ->startOfWeek(Carbon::MONDAY);

            $fechaFin = Carbon::parse($request->fecha)
                ->endOfWeek(Carbon::SUNDAY);

            $recorrido = Recorrido::create([

                'hacienda_id' => $request->hacienda_id,

                'user_id' => Auth::id(),

                'semana' => $request->semana,

                'anio' => $request->anio,

                'fecha_inicio' => $fechaInicio,

                'fecha_fin' => $fechaFin,

                'mapa' => null,

            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Guardar detalles de cada lote
        |--------------------------------------------------------------------------
        */

        foreach ($request->detalles as $detalle) {

            DetalleRecorrido::updateOrCreate(

                [
                    'recorrido_id' => $recorrido->id,

                    'lote_id' => $detalle['lote_id'],
                ],

                [
                    'lunes' => $detalle['lunes'] ?? null,

                    'martes' => $detalle['martes'] ?? null,

                    'miercoles' => $detalle['miercoles'] ?? null,

                    'jueves' => $detalle['jueves'] ?? null,

                    'viernes' => $detalle['viernes'] ?? null,

                    'sabado' => $detalle['sabado'] ?? null,
                ]

            );

        }

        /*
        |--------------------------------------------------------------------------
        | Respuesta
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' => true,

            'message' => 'Recorrido guardado correctamente.',

            'recorrido_id' => $recorrido->id,

        ]);
    }

    /**
     * Generar PDF
     */
    public function pdf($id)
    {
        //
    }
}