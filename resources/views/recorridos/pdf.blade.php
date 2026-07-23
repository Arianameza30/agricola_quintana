<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mapa de Área Recorrida</title>

    <style>
        @page {
            margin: 18px 22px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: DejaVu Sans, sans-serif;
            color: #111827;
            font-size: 9px;
        }

        table {
            border-collapse: collapse;
        }

        .encabezado,
        .datos,
        .contenido,
        .firmas {
            width: 100%;
        }

        .encabezado {
            margin-bottom: 8px;
        }

        .encabezado td {
            vertical-align: middle;
        }

        .titulo {
            margin: 0;
            color: #166534;
            font-size: 20px;
        }

        .subtitulo {
            margin-top: 3px;
            color: #475569;
            font-size: 10px;
        }

        .logo {
            width: 235px;
            max-height: 78px;
        }

        .datos {
            margin-bottom: 8px;
        }

        .datos td {
            border: 1px solid #94a3b8;
            padding: 5px 7px;
        }

        .contenido {
            table-layout: fixed;
        }

        .contenido > tbody > tr > td {
            vertical-align: top;
        }

        .matriz {
            width: 43%;
            padding-right: 6px;
        }

        .mapa-columna {
            width: 57%;
            padding-left: 6px;
        }

        .titulo-seccion {
            background: #166534;
            color: #ffffff;
            text-align: center;
            font-weight: bold;
            padding: 5px;
            font-size: 10px;
        }

        .tabla {
            width: 100%;
            table-layout: fixed;
        }

        .tabla th,
        .tabla td {
            border: 1px solid #64748b;
            padding: 3px 2px;
            text-align: center;
            font-size: 7px;
        }

        .tabla th {
            background: #dcfce7;
            color: #14532d;
        }

        .tabla tfoot td {
            background: #f1f5f9;
            font-weight: bold;
        }

        .mapa-contenedor {
            border: 1px solid #64748b;
            padding: 4px;
            text-align: center;
            background: #ffffff;
        }

        .mapa {
            width: 100%;
            max-height: 430px;
        }

        .resumen {
            margin-top: 5px;
            border: 1px solid #94a3b8;
            background: #f8fafc;
            padding: 5px;
            font-size: 8px;
        }

        .firmas {
            margin-top: 14px;
        }

        .firmas td {
            width: 33.33%;
            padding: 18px 18px 0;
            text-align: center;
        }

        .linea-firma {
            border-top: 1px solid #111827;
            padding-top: 4px;
            font-size: 8px;
        }
    </style>
</head>

<body>

    <table class="encabezado">
        <tr>
            <td style="width:62%;">
                <h1 class="titulo">
                    MAPA DE ÁREA RECORRIDA
                </h1>

                <div class="subtitulo">
                    Reporte semanal de recorrido de lotes
                </div>
            </td>

            <td style="width:38%; text-align:right;">
                <img
                    src="{{ public_path('images/logo_agricola_quintana.png') }}"
                    class="logo"
                    alt="Agrícola Quintana"
                >
            </td>
        </tr>
    </table>

    <table class="datos">
        <tr>
            <td>
                <strong>Hacienda:</strong>
                {{ strtoupper($hacienda) }}
            </td>

            <td>
                <strong>Semana:</strong>
                {{ $semana }}
            </td>

            <td>
                <strong>Año:</strong>
                {{ $anio }}
            </td>

            <td>
                <strong>Usuario:</strong>
                {{ $usuario }}
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <strong>Fecha de inicio:</strong>
                {{ $fechaInicio->format('d/m/Y') }}
            </td>

            <td colspan="2">
                <strong>Fecha de fin:</strong>
                {{ $fechaFin->format('d/m/Y') }}
            </td>
        </tr>
    </table>

    <table class="contenido">
        <tr>
            <td class="matriz">
                <div class="titulo-seccion">
                    MATRIZ DE ÁREA RECORRIDA
                </div>

                <table class="tabla">
                    <thead>
                        <tr>
                            <th style="width:9%;">Lote</th>
                            <th style="width:11%;">Has.</th>
                            <th>L</th>
                            <th>M</th>
                            <th>X</th>
                            <th>J</th>
                            <th>V</th>
                            <th>S</th>
                            <th style="width:12%;">Total</th>
                            <th style="width:12%;">%</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($detalles as $detalle)
                            <tr>
                                <td>
                                    {{ $detalle['nombre'] ?? '' }}
                                </td>

                                <td>
                                    {{ number_format(
                                        (float) (
                                            $detalle['has_prod'] ??
                                            0
                                        ),
                                        2
                                    ) }}
                                </td>

                                <td>{{ $detalle['lunes'] ?? '' }}</td>
                                <td>{{ $detalle['martes'] ?? '' }}</td>
                                <td>{{ $detalle['miercoles'] ?? '' }}</td>
                                <td>{{ $detalle['jueves'] ?? '' }}</td>
                                <td>{{ $detalle['viernes'] ?? '' }}</td>
                                <td>{{ $detalle['sabado'] ?? '' }}</td>

                                <td>
                                    {{ number_format(
                                        (float) (
                                            $detalle['total_semana'] ??
                                            0
                                        ),
                                        2
                                    ) }}
                                </td>

                                <td>
                                    {{ $detalle['porcentaje'] ?? '0.00%' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <td>TOTAL</td>

                            <td>
                                {{ number_format($totalHas, 2) }}
                            </td>

                            <td colspan="6"></td>

                            <td>
                                {{ number_format($totalSemana, 2) }}
                            </td>

                            <td>
                                {{ number_format(
                                    $porcentajeGeneral,
                                    2
                                ) }}%
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <div class="resumen">
                    <strong>Total Has. productivas:</strong>
                    {{ number_format($totalHas, 2) }}

                    &nbsp;&nbsp;

                    <strong>Total recorrido:</strong>
                    {{ number_format($totalSemana, 2) }}

                    &nbsp;&nbsp;

                    <strong>Porcentaje:</strong>
                    {{ number_format(
                        $porcentajeGeneral,
                        2
                    ) }}%
                </div>
            </td>

            <td class="mapa-columna">
                <div class="titulo-seccion">
                    MAPA PINTADO
                </div>

                <div class="mapa-contenedor">
                    <img
                        src="{{ $imagenMapa }}"
                        class="mapa"
                        alt="Mapa pintado"
                    >
                </div>
            </td>
        </tr>
    </table>

    <table class="firmas">
        <tr>
            <td>
                <div class="linea-firma">
                    Elaborado por
                </div>
            </td>

            <td>
                <div class="linea-firma">
                    Jefe de campo
                </div>
            </td>

            <td>
                <div class="linea-firma">
                    Revisado por
                </div>
            </td>
        </tr>
    </table>

</body>
</html>