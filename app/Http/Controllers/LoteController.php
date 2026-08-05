<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Hacienda;
use Illuminate\Http\Request;

class LoteController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CONFIGURAR COORDENADAS
    |--------------------------------------------------------------------------
    */

    public function configurar()
    {
        $haciendas = Hacienda::with([
            'lotes' => function ($consulta) {
                $consulta->orderBy('lote');
            },
        ])
        ->orderBy('nombre_hacienda')
        ->get();

        return view(
            'lotes.configurar',
            compact('haciendas')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CONSULTAR LOTES
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $lotes = Lote::with('hacienda')
            ->orderBy('id_hacienda')
            ->orderBy('lote')
            ->get();

        return view(
            'lotes.index',
            compact('lotes')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | GUARDAR COORDENADAS
    |--------------------------------------------------------------------------
    |
    | Las coordenadas se guardan directamente en la tabla corporativa "lote".
    |
    */

    public function guardarCoordenadas(
        Request $request
    ) {
        try {

            $request->validate([
                'hacienda_id' =>
                    'required|exists:mysql_corporativa.hacienda,id',

                'lotes' =>
                    'required|array',
            ]);

            $guardados = 0;

            foreach (
                $request->lotes
                as $nombreLote => $datosLote
            ) {
                if (
                    !isset($datosLote['puntos']) ||
                    !is_array($datosLote['puntos'])
                ) {
                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | Buscar por los nombres reales de las columnas corporativas
                |--------------------------------------------------------------------------
                */

                $lote = Lote::where(
                    'id_hacienda',
                    $request->hacienda_id
                )
                ->where(
                    'lote',
                    (int) $nombreLote
                )
                ->first();

                if (!$lote) {
                    continue;
                }

                $lote->coordenadas =
                    $datosLote['puntos'];

                $lote->save();

                $guardados++;
            }

            return response()->json([
                'success' => true,

                'message' =>
                    'Se guardaron correctamente ' .
                    $guardados .
                    ' lote(s) en la base de datos corporativa.',

                'guardados' =>
                    $guardados,
            ]);

        } catch (\Throwable $e) {

            report($e);

            return response()->json([
                'success' => false,

                'message' =>
                    'No se pudieron guardar las coordenadas.',

                'detalle' =>
                    config('app.debug')
                        ? $e->getMessage()
                        : null,

                'archivo' =>
                    config('app.debug')
                        ? $e->getFile()
                        : null,

                'linea' =>
                    config('app.debug')
                        ? $e->getLine()
                        : null,
            ], 500);
        }
    }
}