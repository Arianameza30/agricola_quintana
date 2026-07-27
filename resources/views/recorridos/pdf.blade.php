@php

    /*
    |--------------------------------------------------------------------------
    | Logotipo incrustado para DomPDF
    |--------------------------------------------------------------------------
    */

    $logoBase64 = null;

    $rutaLogo = public_path(
        'images/logo_agricola_quintana.png'
    );

    if (
        file_exists($rutaLogo) &&
        is_readable($rutaLogo)
    ) {

        $contenidoLogo = file_get_contents($rutaLogo);

        if ($contenidoLogo !== false) {

            $logoBase64 =
                'data:image/png;base64,' .
                base64_encode($contenidoLogo);

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Palancas según la hacienda
    |--------------------------------------------------------------------------
    |
    | María María tiene 5 palancas.
    | Doménica tiene 6 palancas.
    |
    */

    $nombreHaciendaNormalizado = mb_strtolower(
        trim((string) $hacienda),
        'UTF-8'
    );

    $esDomenica =
        str_contains(
            $nombreHaciendaNormalizado,
            'domenica'
        )
        ||
        str_contains(
            $nombreHaciendaNormalizado,
            'doménica'
        );


    /*
    |--------------------------------------------------------------------------
    | Colores predefinidos de las palancas
    |--------------------------------------------------------------------------
    */

    $palancas = [

    [
        'nombre' => 'P1',
        'color' => '#A65B18',   // Café
    ],

    [
        'nombre' => 'P2',
        'color' => '#2E7D32',   // Verde
    ],

    [
        'nombre' => 'P3',
        'color' => '#FFD21F',   // Amarillo
    ],

    [
        'nombre' => 'P4',
        'color' => '#2F80ED',   // Azul
    ],

    [
        'nombre' => 'P5',
        'color' => '#E53935',   // Rojo
    ],

];


    /*
    |--------------------------------------------------------------------------
    | Doménica tiene una sexta palanca
    |--------------------------------------------------------------------------
    */

    if ($esDomenica) {

        $palancas[] = [

            'nombre' => 'P6',
            'color' => '#a855f7',

        ];

    }

@endphp

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>
        Mapa de Área Recorrida
    </title>


    <style>

        /*
        |--------------------------------------------------------------------------
        | Página
        |--------------------------------------------------------------------------
        */

        @page {

            size: A4 landscape;

            margin: 10mm 12mm;

        }


        html,
        body {

            margin: 0;

            padding: 0;

        }


        body {

            font-family: DejaVu Sans, sans-serif;

            font-size: 8px;

            color: #111827;

            background: #ffffff;

        }


        table {

            border-collapse: collapse;

        }


        /*
        |--------------------------------------------------------------------------
        | Marco exterior
        |--------------------------------------------------------------------------
        */

        .documento {

            border: 1px solid #9ca3af;

            padding: 7mm 8mm 6mm;

        }


        /*
        |--------------------------------------------------------------------------
        | Encabezado
        |--------------------------------------------------------------------------
        */

        .encabezado {

            width: 100%;

            margin-bottom: 5mm;

            table-layout: fixed;

        }


        .encabezado td {

            vertical-align: middle;

        }


        .encabezado-izquierda {

            width: 64%;

        }


        .encabezado-derecha {

            width: 36%;

            text-align: right;

        }


        .titulo-principal {

            margin: 0;

            color: #166534;

            font-size: 18px;

            font-weight: bold;

            letter-spacing: 0.3px;

        }


        .subtitulo {

            margin-top: 3px;

            color: #475569;

            font-size: 9.5px;

        }


        .logo {

            width: 170px;

            height: auto;

            max-height: 52px;

        }


        .nombre-empresa {

            color: #166534;

            font-size: 16px;

            font-weight: bold;

            text-align: right;

        }


        /*
        |--------------------------------------------------------------------------
        | Datos generales
        |--------------------------------------------------------------------------
        */

        .datos {

            width: 100%;

            margin-bottom: 5mm;

            table-layout: fixed;

        }


        .datos td {

            border: 1px solid #94a3b8;

            padding: 6px 8px;

            vertical-align: middle;

            font-size: 9px;

            line-height: 1.3;

        }


        /*
        |--------------------------------------------------------------------------
        | Matriz y mapa
        |--------------------------------------------------------------------------
        */

        .contenido {

            width: 100%;

            table-layout: fixed;

        }


        .contenido > tbody > tr > td {

            vertical-align: top;

        }


        .columna-matriz {

            width: 45%;

            padding-right: 2mm;

        }


        .columna-mapa {

            width: 55%;

            padding-left: 2mm;

        }


        .titulo-seccion {

            background: #166534;

            color: #ffffff;

            padding: 4px;

            text-align: center;

            font-size: 8.5px;

            font-weight: bold;

        }


        /*
        |--------------------------------------------------------------------------
        | Matriz
        |--------------------------------------------------------------------------
        */

        .tabla-recorrido {

            width: 100%;

            table-layout: fixed;

        }


        .tabla-recorrido th,
        .tabla-recorrido td {

            border: 1px solid #64748b;

            padding: 3px 2px;

            text-align: center;

            vertical-align: middle;

            font-size: 8px;

            line-height: 1.15;

        }


        .tabla-recorrido th {

            background: #dcfce7;

            color: #14532d;

            font-size: 8.2px;

            font-weight: bold;

        }


        .tabla-recorrido tfoot td {

            background: #f1f5f9;

            font-size: 8.2px;

            font-weight: bold;

        }


        .resumen {

            margin-top: 4px;

            border: 1px solid #94a3b8;

            background: #f8fafc;

            padding: 5px 6px;

            font-size: 8px;

            line-height: 1.2;

        }


        /*
        |--------------------------------------------------------------------------
        | Contenedor del mapa
        |--------------------------------------------------------------------------
        */

        .mapa-contenedor {

            height: 103mm;

            border: 1px solid #64748b;

            background: #ffffff;

            padding: 2mm;

            overflow: hidden;

        }


        /*
        |--------------------------------------------------------------------------
        | Tabla interna: palancas y mapa
        |--------------------------------------------------------------------------
        |
        | Se utiliza una tabla porque DomPDF trabaja mejor con tablas que con
        | flexbox o grid.
        |
        */

        .tabla-mapa {

            width: 100%;

            height: 99mm;

            table-layout: fixed;

        }


        .tabla-mapa > tbody > tr > td {

            border: none;

            padding: 0;

            vertical-align: middle;

        }


        /*
        |--------------------------------------------------------------------------
        | Columna de palancas
        |--------------------------------------------------------------------------
        */

        .columna-palancas {

            width: 14%;

            padding-right: 2mm !important;

            text-align: center;

        }


        .leyenda-palancas {

            width: 100%;

            border: 1px solid #cbd5e1;

            background: #f8fafc;

            padding: 5px 3px;

        }


        .titulo-palancas {

            margin-bottom: 7px;

            color: #14532d;

            font-size: 7.5px;

            font-weight: bold;

            text-align: center;

        }


        /*
        |--------------------------------------------------------------------------
        | Cada palanca
        |--------------------------------------------------------------------------
        */

        .tabla-palanca {

            width: 100%;

            margin-bottom: 5px;

            table-layout: fixed;

        }


        .tabla-palanca:last-child {

            margin-bottom: 0;

        }


        .tabla-palanca td {

            border: none;

            padding: 0;

            vertical-align: middle;

        }


        .celda-dibujo-palanca {

            width: 60%;

            text-align: right;

        }


        .celda-nombre-palanca {

            width: 40%;

            padding-left: 3px !important;

            color: #111827;

            font-size: 8px;

            font-weight: bold;

            text-align: left;

        }


        /*
        |--------------------------------------------------------------------------
        | Dibujo de bandera o palanca
        |--------------------------------------------------------------------------
        */

        .bandera-contenedor {

            display: inline-block;

            width: 25px;

            height: 15px;

            text-align: left;

            vertical-align: middle;

        }


        .bandera-color {

            display: inline-block;

            width: 17px;

            height: 9px;

            border: 1px solid #475569;

            vertical-align: top;

        }


        .bandera-mastil {

            display: inline-block;

            width: 2px;

            height: 15px;

            margin-left: -20px;

            background: #475569;

            vertical-align: top;

        }


        /*
        |--------------------------------------------------------------------------
        | Columna de imagen
        |--------------------------------------------------------------------------
        */

        .columna-imagen-mapa {

            width: 86%;

            text-align: center;

        }


        .mapa {

            display: block;

            width: 100%;

            height: 99mm;

        }


        /*
        |--------------------------------------------------------------------------
        | Firmas
        |--------------------------------------------------------------------------
        */

        .firmas {

            width: 100%;

            margin-top: 10mm;

            table-layout: fixed;

            page-break-inside: avoid;

        }


        .firmas td {

            width: 50%;

            padding: 0 18mm;

            text-align: center;

            vertical-align: bottom;

        }


        .linea-firma {

            border-top: 1px solid #111827;

            padding-top: 4px;

            font-size: 7.5px;

            font-weight: bold;

        }


        .hacienda-firma {

            display: block;

            margin-top: 3px;

            color: #475569;

            font-size: 6.5px;

            font-weight: normal;

        }

    </style>

</head>


<body>

    <div class="documento">


        {{-- =========================================================
             ENCABEZADO
        ========================================================== --}}

        <table class="encabezado">

            <tr>

                <td class="encabezado-izquierda">

                    <h1 class="titulo-principal">

                        MAPA DE ÁREA RECORRIDA

                    </h1>


                    <div class="subtitulo">

                        Reporte semanal de recorrido de lotes

                    </div>

                </td>


                <td class="encabezado-derecha">

                    @if ($logoBase64)

                        <img
                            src="{{ $logoBase64 }}"
                            class="logo"
                            alt="Logo de Agrícola Quintana"
                        >

                    @else

                        <div class="nombre-empresa">

                            AGRÍCOLA QUINTANA

                        </div>

                    @endif

                </td>

            </tr>

        </table>


        {{-- =========================================================
             DATOS DEL REPORTE
        ========================================================== --}}

        <table class="datos">

            <tr>

                <td style="width: 36%;">

                    <strong>Hacienda:</strong>

                    {{ strtoupper($hacienda) }}

                </td>


                <td style="width: 20%;">

                    <strong>Semana:</strong>

                    {{ $semana }}

                </td>


                <td style="width: 20%;">

                    <strong>Año:</strong>

                    {{ $anio }}

                </td>


                <td style="width: 24%;">

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


        {{-- =========================================================
             MATRIZ Y MAPA
        ========================================================== --}}

        <table class="contenido">

            <tr>


                {{-- =================================================
                     MATRIZ
                ================================================== --}}

                <td class="columna-matriz">

                    <div class="titulo-seccion">

                        MATRIZ DE ÁREA RECORRIDA

                    </div>


                    <table class="tabla-recorrido">

                        <thead>

                            <tr>

                                <th style="width: 9%;">

                                    Lote

                                </th>


                                <th style="width: 11%;">

                                    Has.

                                </th>


                                <th>L</th>

                                <th>M</th>

                                <th>X</th>

                                <th>J</th>

                                <th>V</th>

                                <th>S</th>


                                <th style="width: 12%;">

                                    Total

                                </th>


                                <th style="width: 12%;">

                                    %

                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach ($detalles as $detalle)

                                <tr>

                                    <td>

                                        {{ $detalle['nombre'] ?? '' }}

                                    </td>


                                    <td>

                                        {{ number_format(
                                            (float) (
                                                $detalle['has_prod']
                                                ?? 0
                                            ),
                                            2
                                        ) }}

                                    </td>


                                    <td>

                                        {{ $detalle['lunes'] ?? '' }}

                                    </td>


                                    <td>

                                        {{ $detalle['martes'] ?? '' }}

                                    </td>


                                    <td>

                                        {{ $detalle['miercoles'] ?? '' }}

                                    </td>


                                    <td>

                                        {{ $detalle['jueves'] ?? '' }}

                                    </td>


                                    <td>

                                        {{ $detalle['viernes'] ?? '' }}

                                    </td>


                                    <td>

                                        {{ $detalle['sabado'] ?? '' }}

                                    </td>


                                    <td>

                                        {{ number_format(
                                            (float) (
                                                $detalle['total_semana']
                                                ?? 0
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

                                <td>

                                    TOTAL

                                </td>


                                <td>

                                    {{ number_format(
                                        (float) $totalHas,
                                        2
                                    ) }}

                                </td>


                                <td colspan="6"></td>


                                <td>

                                    {{ number_format(
                                        (float) $totalSemana,
                                        2
                                    ) }}

                                </td>


                                <td>

                                    {{ number_format(
                                        (float) $porcentajeGeneral,
                                        2
                                    ) }}%

                                </td>

                            </tr>

                        </tfoot>

                    </table>


                    <div class="resumen">

                        <strong>

                            Total Has. productivas:

                        </strong>


                        {{ number_format(
                            (float) $totalHas,
                            2
                        ) }}


                        &nbsp;&nbsp;


                        <strong>

                            Total recorrido:

                        </strong>


                        {{ number_format(
                            (float) $totalSemana,
                            2
                        ) }}


                        &nbsp;&nbsp;


                        <strong>

                            Porcentaje:

                        </strong>


                        {{ number_format(
                            (float) $porcentajeGeneral,
                            2
                        ) }}%

                    </div>

                </td>


                {{-- =================================================
                     MAPA
                ================================================== --}}

                <td class="columna-mapa">

                    <div class="titulo-seccion">

                        MAPA PINTADO

                    </div>


                    <div class="mapa-contenedor">

                        <table class="tabla-mapa">

                            <tr>


                                {{-- =================================
                                     LEYENDA DE PALANCAS
                                ================================== --}}

                                <td class="columna-palancas">

                                    <div class="leyenda-palancas">

                                        <div class="titulo-palancas">

                                            PALANCAS

                                        </div>


                                        @foreach ($palancas as $palanca)

                                            <table class="tabla-palanca">

                                                <tr>

                                                    <td class="celda-dibujo-palanca">

                                                        <span class="bandera-contenedor">

                                                            <span
                                                                class="bandera-color"
                                                                style="background-color: {{ $palanca['color'] }};"
                                                            ></span>

                                                            <span
                                                                class="bandera-mastil"
                                                            ></span>

                                                        </span>

                                                    </td>


                                                    <td class="celda-nombre-palanca">

                                                        {{ $palanca['nombre'] }}

                                                    </td>

                                                </tr>

                                            </table>

                                        @endforeach

                                    </div>

                                </td>


                                {{-- =================================
                                     IMAGEN DEL MAPA
                                ================================== --}}

                                <td class="columna-imagen-mapa">

                                    <img
                                        src="{{ $imagenMapa }}"
                                        class="mapa"
                                        alt="Mapa pintado"
                                    >

                                </td>

                            </tr>

                        </table>

                    </div>

                </td>

            </tr>

        </table>


        {{-- =========================================================
             DOS FIRMAS
        ========================================================== --}}

        <table class="firmas">

            <tr>

                <td>

                    <div class="linea-firma">

                        Jefe de campo 1

                        <span class="hacienda-firma">

                            Hacienda {{ strtoupper($hacienda) }}

                        </span>

                    </div>

                </td>


                <td>

                    <div class="linea-firma">

                        Jefe de campo 2

                        <span class="hacienda-firma">

                            Hacienda {{ strtoupper($hacienda) }}

                        </span>

                    </div>

                </td>

            </tr>

        </table>


    </div>

</body>

</html>