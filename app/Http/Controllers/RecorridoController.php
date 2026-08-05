<?php

namespace App\Http\Controllers;

use App\Models\Recorrido;
use App\Models\DetalleRecorrido;
use App\Models\Hacienda;
use App\Models\Lote;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RecorridoController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | MOSTRAR MÓDULO DE RECORRIDOS
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $haciendas = Hacienda::with([
            'lotes' => function ($consulta) {
                $consulta->orderBy('lote');
            },
        ])
        ->orderBy('nombre_hacienda')
        ->get();

        return view(
            'recorridos.index',
            compact('haciendas')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ABRIR RECORRIDO
    |--------------------------------------------------------------------------
    */

    public function abrir(Request $request)
    {
        $request->validate([
            'hacienda_id' =>
                'required|exists:mysql_corporativa.hacienda,id',

            'semana' =>
                'required|integer|min:1|max:53',

            'anio' =>
                'required|integer|min:2000|max:2100',
        ]);

        $recorrido = Recorrido::with([
            'detalles.lote',
        ])
        ->where(
            'hacienda_id',
            $request->hacienda_id
        )
        ->where(
            'semana',
            $request->semana
        )
        ->where(
            'anio',
            $request->anio
        )
        ->first();

        if ($recorrido) {

            /*
            |--------------------------------------------------------------------------
            | Normalizar configuración del mapa
            |--------------------------------------------------------------------------
            */

            if (
                is_string($recorrido->mapa) &&
                $recorrido->mapa !== ''
            ) {
                $mapa = json_decode(
                    $recorrido->mapa,
                    true
                );

                if (
                    json_last_error() ===
                    JSON_ERROR_NONE
                ) {
                    $recorrido->mapa =
                        $mapa;
                }
            }

            if (!is_array($recorrido->mapa)) {
                $recorrido->mapa = [];
            }

            return response()->json([
                'existe' => true,

                'recorrido' =>
                    $recorrido,

                'detalles' =>
                    $recorrido->detalles,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Semana nueva
        |--------------------------------------------------------------------------
        */

        $hacienda = Hacienda::findOrFail(
            $request->hacienda_id
        );

        $lotes = $hacienda
            ->lotes()
            ->orderBy('lote')
            ->get();

        return response()->json([
            'existe' => false,

            'lotes' =>
                $lotes,

            'recorrido' => [
                'mapa' => [],
            ],
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | GUARDAR RECORRIDO
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $datos = $request->validate([
            'hacienda_id' =>
                'required|exists:mysql_corporativa.hacienda,id',

            'semana' =>
                'required|integer|min:1|max:53',

            'anio' =>
                'required|integer|min:2000|max:2100',

            'fecha' =>
                'required|date',

            /*
            |--------------------------------------------------------------------------
            | Estado del mapa
            |--------------------------------------------------------------------------
            */

            'mapa' =>
                'nullable|array',

            'mapa.version' =>
                'nullable|integer|min:1|max:20',

            'mapa.lotes_pintados' =>
                'nullable|array',

            'mapa.lotes_rayados' =>
                'nullable|array',

            'mapa.zonas_pintadas' =>
                'nullable|array',

            'mapa.zonas_rayadas' =>
                'nullable|array',

            'mapa.opacidad_lote' =>
                'nullable|numeric|min:0|max:100',

            'mapa.canvas_rayado_zona' =>
                'nullable|string',

            'mapa.canvas_dibujo' =>
                'nullable|string',

            /*
            |--------------------------------------------------------------------------
            | Matriz semanal
            |--------------------------------------------------------------------------
            */

            'detalles' =>
                'required|array',

            'detalles.*.lote_id' =>
                'required|exists:mysql_corporativa.lote,id',

            'detalles.*.lunes' =>
                'nullable|numeric|min:0',

            'detalles.*.martes' =>
                'nullable|numeric|min:0',

            'detalles.*.miercoles' =>
                'nullable|numeric|min:0',

            'detalles.*.jueves' =>
                'nullable|numeric|min:0',

            'detalles.*.viernes' =>
                'nullable|numeric|min:0',

            'detalles.*.sabado' =>
                'nullable|numeric|min:0',
        ]);

        try {

            /*
            |--------------------------------------------------------------------------
            | La transacción se ejecuta en la conexión principal
            |--------------------------------------------------------------------------
            |
            | Recorridos y detalles continúan almacenándose físicamente en:
            |
            | - m_recorridos
            | - m_detalle_recorridos
            |
            */

            $recorrido = DB::connection('mysql')
                ->transaction(
                    function () use ($datos) {

                        $fecha = Carbon::parse(
                            $datos['fecha']
                        );

                        $configuracionMapa =
                            $datos['mapa'] ?? [];

                        $recorrido =
                            Recorrido::updateOrCreate(
                                [
                                    'hacienda_id' =>
                                        $datos['hacienda_id'],

                                    'semana' =>
                                        $datos['semana'],

                                    'anio' =>
                                        $datos['anio'],
                                ],
                                [
                                    'user_id' =>
                                        Auth::id(),

                                    'fecha_inicio' =>
                                        $fecha
                                            ->copy()
                                            ->startOfWeek(
                                                Carbon::MONDAY
                                            ),

                                    'fecha_fin' =>
                                        $fecha
                                            ->copy()
                                            ->endOfWeek(
                                                Carbon::SUNDAY
                                            ),

                                    'mapa' =>
                                        json_encode(
                                            $configuracionMapa,
                                            JSON_UNESCAPED_UNICODE |
                                            JSON_UNESCAPED_SLASHES
                                        ),
                                ]
                            );

                        foreach (
                            $datos['detalles']
                            as $detalle
                        ) {
                            /*
                            |--------------------------------------------------------------------------
                            | Verificar que el lote pertenezca a la hacienda
                            |--------------------------------------------------------------------------
                            */

                            $pertenece =
                                Lote::where(
                                    'id',
                                    $detalle['lote_id']
                                )
                                ->where(
                                    'id_hacienda',
                                    $datos['hacienda_id']
                                )
                                ->exists();

                            if (!$pertenece) {
                                continue;
                            }

                            DetalleRecorrido::updateOrCreate(
                                [
                                    'recorrido_id' =>
                                        $recorrido->id,

                                    'lote_id' =>
                                        $detalle['lote_id'],
                                ],
                                [
                                    'lunes' =>
                                        $detalle['lunes']
                                        ?? null,

                                    'martes' =>
                                        $detalle['martes']
                                        ?? null,

                                    'miercoles' =>
                                        $detalle['miercoles']
                                        ?? null,

                                    'jueves' =>
                                        $detalle['jueves']
                                        ?? null,

                                    'viernes' =>
                                        $detalle['viernes']
                                        ?? null,

                                    'sabado' =>
                                        $detalle['sabado']
                                        ?? null,
                                ]
                            );
                        }

                        return $recorrido;
                    }
                );

            return response()->json([
                'success' => true,

                'message' =>
                    'Matriz y mapa semanal guardados correctamente.',

                'recorrido_id' =>
                    $recorrido->id,
            ]);

        } catch (\Throwable $e) {

            report($e);

            return response()->json([
                'success' => false,

                'message' =>
                    'No se pudo guardar el recorrido.',

                'detalle' =>
                    config('app.debug')
                        ? $e->getMessage()
                        : null,
            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | GENERAR PDF
    |--------------------------------------------------------------------------
    */

    public function generarPdf(Request $request)
    {
        $datos = $request->validate([
            'hacienda_id' =>
                'required|exists:mysql_corporativa.hacienda,id',

            'hacienda' =>
                'required|string|max:150',

            'semana' =>
                'required|integer|min:1|max:53',

            'anio' =>
                'required|integer|min:2000|max:2100',

            'fecha' =>
                'required|date',

            'usuario' =>
                'nullable|string|max:150',

            'imagen_mapa' =>
                'required|string',

            'configuracion_mapa' =>
                'nullable|array',

            'detalles' =>
                'required|array',

            'detalles.*.nombre' =>
                'nullable|string|max:100',

            'detalles.*.has_prod' =>
                'nullable|numeric',

            'detalles.*.lunes' =>
                'nullable|numeric',

            'detalles.*.martes' =>
                'nullable|numeric',

            'detalles.*.miercoles' =>
                'nullable|numeric',

            'detalles.*.jueves' =>
                'nullable|numeric',

            'detalles.*.viernes' =>
                'nullable|numeric',

            'detalles.*.sabado' =>
                'nullable|numeric',

            'detalles.*.total_semana' =>
                'nullable|numeric',

            'detalles.*.porcentaje' =>
                'nullable|string|max:30',

            'total_has' =>
                'nullable|numeric',

            'total_semana' =>
                'nullable|numeric',

            'porcentaje_general' =>
                'nullable|numeric',
        ]);

        if (
            !preg_match(
                '/^data:image\/(png|jpeg|jpg);base64,/',
                $datos['imagen_mapa']
            )
        ) {
            return response()->json([
                'message' =>
                    'La imagen del mapa no es válida.',
            ], 422);
        }

        try {

            $fecha = Carbon::parse(
                $datos['fecha']
            );

            /*
            |--------------------------------------------------------------------------
            | Recalcular los valores con las hectáreas oficiales
            |--------------------------------------------------------------------------
            */

            $detallesPdf = collect(
                $datos['detalles']
            )
            ->map(function (
                array $detalle
            ) use ($datos) {

                $hasProd =
                    Lote::obtenerHectareasOficiales(
                        $datos['hacienda_id'],
                        $detalle['nombre'] ?? null,
                        $detalle['has_prod'] ?? 0
                    );

                $totalSemana =
                    (float) (
                        $detalle['lunes'] ?? 0
                    ) +
                    (float) (
                        $detalle['martes'] ?? 0
                    ) +
                    (float) (
                        $detalle['miercoles'] ?? 0
                    ) +
                    (float) (
                        $detalle['jueves'] ?? 0
                    ) +
                    (float) (
                        $detalle['viernes'] ?? 0
                    ) +
                    (float) (
                        $detalle['sabado'] ?? 0
                    );

                $porcentaje =
                    $hasProd > 0
                        ? round(
                            (
                                $totalSemana /
                                $hasProd
                            ) * 100,
                            2
                        )
                        : 0;

                $detalle['has_prod'] =
                    $hasProd;

                $detalle['total_semana'] =
                    $totalSemana;

                $detalle['porcentaje'] =
                    number_format(
                        $porcentaje,
                        2
                    ) . '%';

                return $detalle;
            });

            $totalHas =
                (float) $detallesPdf->sum(
                    'has_prod'
                );

            $totalSemana =
                (float) $detallesPdf->sum(
                    'total_semana'
                );

            $porcentajeGeneral =
                $totalHas > 0
                    ? round(
                        (
                            $totalSemana /
                            $totalHas
                        ) * 100,
                        2
                    )
                    : 0;

            $pdf = Pdf::loadView(
                'recorridos.pdf',
                [
                    'hacienda' =>
                        $datos['hacienda'],

                    'semana' =>
                        $datos['semana'],

                    'anio' =>
                        $datos['anio'],

                    'fechaInicio' =>
                        $fecha
                            ->copy()
                            ->startOfWeek(
                                Carbon::MONDAY
                            ),

                    'fechaFin' =>
                        $fecha
                            ->copy()
                            ->endOfWeek(
                                Carbon::SUNDAY
                            ),

                    'usuario' =>
                        $datos['usuario']
                        ?? Auth::user()?->name,

                    'imagenMapa' =>
                        $datos['imagen_mapa'],

                    'detalles' =>
                        $detallesPdf,

                    'totalHas' =>
                        $totalHas,

                    'totalSemana' =>
                        $totalSemana,

                    'porcentajeGeneral' =>
                        $porcentajeGeneral,
                ]
            )
            ->setPaper(
                'a4',
                'landscape'
            )
            ->setOptions([
                'isRemoteEnabled' =>
                    true,

                'isHtml5ParserEnabled' =>
                    true,

                'defaultFont' =>
                    'DejaVu Sans',
            ]);

            $nombre = str(
                $datos['hacienda']
            )
            ->lower()
            ->ascii()
            ->replaceMatches(
                '/[^a-z0-9]+/',
                '_'
            )
            ->trim('_');

            return $pdf->download(
                'recorrido_' .
                $nombre .
                '_semana_' .
                $datos['semana'] .
                '.pdf'
            );

        } catch (\Throwable $e) {

            report($e);

            return response()->json([
                'message' =>
                    'No se pudo generar el PDF.',

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


    /*
    |--------------------------------------------------------------------------
    | PDF HISTÓRICO
    |--------------------------------------------------------------------------
    */

    public function pdf($id)
    {
        //
    }
}