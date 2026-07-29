@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-900 py-8">

    <div class="max-w-7xl mx-auto px-4 sm:px-6">

        {{-- ========================================================= --}}
        {{-- CABECERA --}}
        {{-- ========================================================= --}}

        <div class="bg-green-800 rounded-xl shadow-lg p-5 text-white">

            <h1 class="text-3xl font-bold">
                Configuración de Coordenadas
            </h1>

            <p class="mt-1">
                Agrícola Quintana
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-8">

                {{-- HACIENDA --}}

                <div>

                    <label
                        for="hacienda"
                        class="block mb-2 font-semibold"
                    >
                        Hacienda
                    </label>

                    <select
                        id="hacienda"
                        class="w-full rounded-lg border border-gray-300 bg-white text-black px-3 py-2"
                    >

                        <option value="">
                            Seleccione una hacienda
                        </option>

                        @foreach($haciendas as $haciendaItem)

                            <option value="{{ $haciendaItem->id }}">
                                {{ strtoupper($haciendaItem->nombre) }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- LOTE --}}

                <div>

                    <label
                        for="loteSeleccionado"
                        class="block mb-2 font-semibold"
                    >
                        Lote a configurar
                    </label>

                    <select
                        id="loteSeleccionado"
                        disabled
                        class="w-full rounded-lg border border-gray-300 bg-white text-black px-3 py-2 disabled:bg-gray-300"
                    >

                        <option value="">
                            Seleccione una hacienda primero
                        </option>

                    </select>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- CONFIGURADOR --}}
        {{-- ========================================================= --}}

        <div class="bg-white rounded-xl shadow-lg mt-8 overflow-hidden">

            <div class="bg-green-800 text-white px-5 py-3">

                <h2 class="font-semibold">
                    Configurador de Coordenadas de Lotes
                </h2>

            </div>


            {{-- INSTRUCCIONES --}}

            <div class="p-5 bg-green-50 border-b border-green-200">

                <p class="font-bold text-green-800 mb-2">
                    ¿Cómo configurar un lote?
                </p>

                <ol class="list-decimal ml-5 space-y-1 text-sm text-gray-700">

                    <li>
                        Selecciona una hacienda.
                    </li>

                    <li>
                        Selecciona un lote.
                    </li>

                    <li>
                        Pulsa "Iniciar configuración".
                    </li>

                    <li>
                        Haz clic sobre el mapa para marcar las esquinas.
                    </li>

                    <li>
                        Pulsa "Cerrar polígono".
                    </li>

                    <li>
                        Pulsa "Guardar lote".
                    </li>

                    <li>
                        Finalmente pulsa "Guardar polígonos en servidor".
                    </li>

                </ol>

            </div>


            {{-- ===================================================== --}}
            {{-- HERRAMIENTAS --}}
            {{-- ===================================================== --}}

            <div class="p-4 bg-gray-50 border-b">

                <div class="flex flex-wrap items-center gap-3">

                    <button
                        id="btnIniciarConfiguracion"
                        type="button"
                        class="bg-green-700 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-800"
                    >
                        📍 Iniciar configuración
                    </button>



                    <button
                        id="btnCerrarPoligono"
                        type="button"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700"
                    >
                        🔷 Cerrar polígono
                    </button>


                    <button
                        id="btnGuardarLote"
                        type="button"
                        class="bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-purple-700"
                    >
                        💾 Guardar lote
                    </button>


                    <button
                        id="btnLimpiarActual"
                        type="button"
                        class="bg-yellow-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-yellow-600"
                    >
                        🧹 Limpiar actual
                    </button>


                    <button
                        id="btnLimpiarTodo"
                        type="button"
                        class="bg-red-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-700"
                    >
                        🗑️ Borrar configuración local
                    </button>


                    <button
                        id="btnGuardarServidor"
                        type="button"
                        class="bg-green-700 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-800"
                    >
                        ☁️ Guardar polígonos en servidor
                    </button>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- ESTADO --}}
            {{-- ===================================================== --}}

            <div class="p-4">

                <div
                    id="estadoConfiguracion"
                    class="bg-gray-100 border border-gray-300 rounded-lg px-4 py-3 text-gray-700"
                >
                    Seleccione una hacienda y un lote para comenzar.
                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- MAPA --}}
            {{-- ===================================================== --}}

            <div class="p-4 sm:p-6">

                <div class="flex justify-center mb-4">
                    <button
                        id="btnDeshacerPunto"
                        type="button"
                        class="bg-slate-700 hover:bg-slate-800 text-white px-5 py-2 rounded-lg font-semibold"
                    >
                        ↩️ Deshacer
                    </button>
                </div>

                <div
                    id="contenedorMapa"
                    class="relative mx-auto w-full max-w-6xl border border-gray-300 rounded-lg overflow-hidden bg-white"
                >

                    <img
                        id="mapa"
                        src=""
                        class="block w-full h-auto select-none"
                        draggable="false"
                        alt="Mapa de Hacienda"
                    >

                    <canvas
                        id="canvasMapa"
                        class="absolute inset-0 w-full h-full"
                    ></canvas>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- LOTES CONFIGURADOS --}}
            {{-- ===================================================== --}}

            <div class="p-4 sm:p-6 border-t">

                <h3 class="text-xl font-bold text-green-800 mb-4">
                    Lotes configurados
                </h3>

                <div
                    id="listaLotesConfigurados"
                    class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3"
                >

                    <div class="text-gray-500 text-sm">
                        Seleccione una hacienda.
                    </div>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- COORDENADAS --}}
            {{-- ===================================================== --}}

            <div class="p-4 sm:p-6 border-t">

                <h3 class="text-xl font-bold text-green-800 mb-4">
                    Coordenadas del lote actual
                </h3>

                <pre
                    id="coordenadasActuales"
                    class="bg-gray-900 text-green-300 p-4 rounded-lg overflow-x-auto text-sm min-h-[100px]"
                >[]</pre>

            </div>

        </div>

    </div>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    {{--
    DATOS DE LARAVEL
    --------------------------------------------------------------------------
    IMPORTANTE: Esta es la unica forma que vamos a usar.
    No usar la directiva json de Blade, ni map, ni json_encode, ni comas manuales.
    --}}

    const haciendas = {{ Js::from($haciendas) }};


    console.log(
        'Haciendas cargadas desde Laravel:',
        haciendas
    );


    /*
    |--------------------------------------------------------------------------
    | ELEMENTOS
    |--------------------------------------------------------------------------
    */

    const hacienda =
        document.getElementById('hacienda');

    const loteSeleccionado =
        document.getElementById('loteSeleccionado');

    const mapa =
        document.getElementById('mapa');

    const canvasMapa =
        document.getElementById('canvasMapa');

    const estadoConfiguracion =
        document.getElementById('estadoConfiguracion');

    const coordenadasActuales =
        document.getElementById('coordenadasActuales');

    const listaLotesConfigurados =
        document.getElementById('listaLotesConfigurados');


    /*
    |--------------------------------------------------------------------------
    | BOTONES
    |--------------------------------------------------------------------------
    */

    const btnIniciarConfiguracion =
        document.getElementById('btnIniciarConfiguracion');

    const btnDeshacerPunto =
        document.getElementById('btnDeshacerPunto');

    const btnCerrarPoligono =
        document.getElementById('btnCerrarPoligono');

    const btnGuardarLote =
        document.getElementById('btnGuardarLote');

    const btnLimpiarActual =
        document.getElementById('btnLimpiarActual');

    const btnLimpiarTodo =
        document.getElementById('btnLimpiarTodo');

    const btnGuardarServidor =
        document.getElementById('btnGuardarServidor');


    /*
    |--------------------------------------------------------------------------
    | CANVAS
    |--------------------------------------------------------------------------
    */

    const ctx =
        canvasMapa.getContext('2d');


    /*
    |--------------------------------------------------------------------------
    | VARIABLES
    |--------------------------------------------------------------------------
    */

    let configurando = false;

    let poligonoCerrado = false;

    let puntosActuales = [];

    let configuraciones = {};

    let haciendaActual = null;


    /*
    |--------------------------------------------------------------------------
    | OBTENER HACIENDA ACTUAL
    |--------------------------------------------------------------------------
    */

    function obtenerHaciendaActual() {

        if (!hacienda.value) {

            return null;

        }

        return haciendas.find(
            function (item) {

                return String(item.id) ===
                    String(hacienda.value);

            }
        ) || null;

    }


    /*
    |--------------------------------------------------------------------------
    | OBTENER LOTE ACTUAL
    |--------------------------------------------------------------------------
    */

    function obtenerLoteActual() {

        if (!loteSeleccionado.value) {

            return null;

        }

        if (!haciendaActual) {

            return null;

        }

        return haciendaActual.lotes.find(
            function (lote) {

                return String(lote.id) ===
                    String(loteSeleccionado.value);

            }
        ) || null;

    }


    /*
    |--------------------------------------------------------------------------
    | CAMBIAR MAPA
    |--------------------------------------------------------------------------
    */

    function cambiarMapa() {

        if (!haciendaActual) {

            mapa.src = '';

            ctx.clearRect(
                0,
                0,
                canvasMapa.width,
                canvasMapa.height
            );

            return;

        }

        const nombre =
            String(
                haciendaActual.nombre
            ).toUpperCase();


        if (
            nombre.includes('DOMENICA')
        ) {

            mapa.src =
                "{{ asset('mapas/domenica.png') }}";

        }

        else if (
            nombre.includes('MARIA')
        ) {

            mapa.src =
                "{{ asset('mapas/maria_maria.png') }}";

        }

        else {

            mapa.src = '';

        }

    }


    /*
    |--------------------------------------------------------------------------
    | AJUSTAR CANVAS
    |--------------------------------------------------------------------------
    */

    function ajustarCanvas() {

        const ancho =
            mapa.clientWidth;

        const alto =
            mapa.clientHeight;

        if (
            ancho === 0 ||
            alto === 0
        ) {

            return;

        }

        canvasMapa.width =
            ancho;

        canvasMapa.height =
            alto;

        dibujarTodo();

    }


    /*
    |--------------------------------------------------------------------------
    | POSICIÓN DEL MOUSE
    |--------------------------------------------------------------------------
    */

    function obtenerPosicion(event) {

        const rect =
            canvasMapa.getBoundingClientRect();

        return {

            x:
                (
                    event.clientX -
                    rect.left
                )
                *
                (
                    canvasMapa.width /
                    rect.width
                ),

            y:
                (
                    event.clientY -
                    rect.top
                )
                *
                (
                    canvasMapa.height /
                    rect.height
                )

        };

    }


    /*
    |--------------------------------------------------------------------------
    | CONVERTIR A PORCENTAJE
    |--------------------------------------------------------------------------
    */

    function convertirAPorcentaje(punto) {

        return {

            x:
                Number(
                    (
                        punto.x /
                        canvasMapa.width
                    )
                    *
                    100
                ).toFixed(4),

            y:
                Number(
                    (
                        punto.y /
                        canvasMapa.height
                    )
                    *
                    100
                ).toFixed(4)

        };

    }


    /*
    |--------------------------------------------------------------------------
    | CONVERTIR DESDE PORCENTAJE
    |--------------------------------------------------------------------------
    */

    function convertirDesdePorcentaje(punto) {

        return {

            x:
                (
                    Number(punto.x) /
                    100
                )
                *
                canvasMapa.width,

            y:
                (
                    Number(punto.y) /
                    100
                )
                *
                canvasMapa.height

        };

    }


    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR COORDENADAS
    |--------------------------------------------------------------------------
    */

    function actualizarCoordenadas() {

        const puntosPorcentaje =
            puntosActuales.map(
                function (punto) {

                    return convertirAPorcentaje(
                        punto
                    );

                }
            );

        coordenadasActuales.textContent =
            JSON.stringify(
                puntosPorcentaje,
                null,
                2
            );

    }


    /*
    |--------------------------------------------------------------------------
    | CARGAR LOTES
    |--------------------------------------------------------------------------
    */

    function cargarLotes() {

        loteSeleccionado.innerHTML =
            '<option value="">Seleccione un lote</option>';


        if (!haciendaActual) {

            loteSeleccionado.disabled =
                true;

            return;

        }


        haciendaActual.lotes.forEach(
            function (lote) {

                const option =
                    document.createElement(
                        'option'
                    );

                option.value =
                    lote.id;

                option.textContent =
                    'LOTE ' +
                    lote.nombre;

                loteSeleccionado.appendChild(
                    option
                );

            }
        );


        loteSeleccionado.disabled =
            false;

    }


    /*
    |--------------------------------------------------------------------------
    | CARGAR CONFIGURACIONES DESDE BD
    |--------------------------------------------------------------------------
    */

    function cargarConfiguracionesDesdeBD() {

        configuraciones = {};


        if (!haciendaActual) {

            actualizarListaLotes();

            return;

        }


        haciendaActual.lotes.forEach(
            function (lote) {

                if (
                    lote.coordenadas &&
                    Array.isArray(lote.coordenadas) &&
                    lote.coordenadas.length >= 3
                ) {

                    configuraciones[lote.id] = {

                        lote_id:
                            lote.id,

                        nombre:
                            lote.nombre,

                        puntos:
                            lote.coordenadas

                    };

                }

            }
        );


        actualizarListaLotes();

    }


    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR LISTA DE LOTES
    |--------------------------------------------------------------------------
    */

    function actualizarListaLotes() {

        listaLotesConfigurados.innerHTML =
            '';


        if (!haciendaActual) {

            listaLotesConfigurados.innerHTML =
                '<div class="text-gray-500 text-sm">' +
                'Seleccione una hacienda.' +
                '</div>';

            return;

        }


        if (
            haciendaActual.lotes.length === 0
        ) {

            listaLotesConfigurados.innerHTML =
                '<div class="text-gray-500 text-sm">' +
                'Esta hacienda no tiene lotes registrados.' +
                '</div>';

            return;

        }


        haciendaActual.lotes.forEach(
            function (lote) {

                const tarjeta =
                    document.createElement(
                        'div'
                    );


                const configurado =
                    configuraciones[lote.id] &&
                    configuraciones[lote.id].puntos &&
                    configuraciones[lote.id].puntos.length >= 3;


                if (configurado) {

                    tarjeta.className =
                        'bg-green-100 ' +
                        'border border-green-300 ' +
                        'rounded-lg p-3 ' +
                        'text-center font-semibold ' +
                        'text-green-800';

                    tarjeta.textContent =
                        '✓ LOTE ' +
                        lote.nombre;

                }

                else {

                    tarjeta.className =
                        'bg-gray-100 ' +
                        'border border-gray-300 ' +
                        'rounded-lg p-3 ' +
                        'text-center font-semibold ' +
                        'text-gray-600';

                    tarjeta.textContent =
                        '○ LOTE ' +
                        lote.nombre;

                }


                tarjeta.style.cursor =
                    'pointer';


                tarjeta.addEventListener(
                    'click',
                    function () {

                        loteSeleccionado.value =
                            lote.id;

                        loteSeleccionado.dispatchEvent(
                            new Event('change')
                        );

                    }
                );


                listaLotesConfigurados.appendChild(
                    tarjeta
                );

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR ESTADO
    |--------------------------------------------------------------------------
    */

    function actualizarEstado() {

        if (!haciendaActual) {

            estadoConfiguracion.textContent =
                'Seleccione una hacienda para comenzar.';

            return;

        }


        if (!loteSeleccionado.value) {

            estadoConfiguracion.innerHTML =
                'Hacienda: <strong>' +
                haciendaActual.nombre.toUpperCase() +
                '</strong>' +
                '<br>' +
                '<span class="text-gray-600">' +
                'Seleccione un lote.' +
                '</span>';

            return;

        }


        const lote =
            obtenerLoteActual();


        if (!lote) {

            return;

        }


        if (!configurando) {

            if (
                configuraciones[lote.id]
            ) {

                estadoConfiguracion.innerHTML =
                    'Hacienda: <strong>' +
                    haciendaActual.nombre.toUpperCase() +
                    '</strong>' +
                    ' &nbsp; | &nbsp; ' +
                    'Lote: <strong>LOTE ' +
                    lote.nombre +
                    '</strong>' +
                    '<br>' +
                    '<span class="text-green-600">' +
                    '✓ Este lote tiene coordenadas guardadas en la base de datos.' +
                    '</span>';

            }

            else {

                estadoConfiguracion.innerHTML =
                    'Hacienda: <strong>' +
                    haciendaActual.nombre.toUpperCase() +
                    '</strong>' +
                    ' &nbsp; | &nbsp; ' +
                    'Lote: <strong>LOTE ' +
                    lote.nombre +
                    '</strong>' +
                    '<br>' +
                    '<span class="text-gray-600">' +
                    'Este lote todavía no tiene coordenadas configuradas.' +
                    '</span>';

            }

            return;

        }


        estadoConfiguracion.innerHTML =
            'Hacienda: <strong>' +
            haciendaActual.nombre.toUpperCase() +
            '</strong>' +
            ' &nbsp; | &nbsp; ' +
            'Lote: <strong>LOTE ' +
            lote.nombre +
            '</strong>' +
            '<br>' +
            '<span class="text-blue-600">' +
            'Configuración en progreso. ' +
            puntosActuales.length +
            ' punto(s) marcado(s).' +
            '</span>';

    }


    /*
    |--------------------------------------------------------------------------
    | DIBUJAR POLÍGONO
    |--------------------------------------------------------------------------
    */

    function dibujarPoligono(
        puntos,
        colorRelleno,
        colorLinea,
        nombre
    ) {

        if (
            !puntos ||
            puntos.length < 2
        ) {

            return;

        }


        const puntosCanvas =
            puntos.map(
                function (punto) {

                    return convertirDesdePorcentaje(
                        punto
                    );

                }
            );


        ctx.beginPath();


        puntosCanvas.forEach(
            function (
                punto,
                indice
            ) {

                if (
                    indice === 0
                ) {

                    ctx.moveTo(
                        punto.x,
                        punto.y
                    );

                }

                else {

                    ctx.lineTo(
                        punto.x,
                        punto.y
                    );

                }

            }
        );


        if (
            puntosCanvas.length >= 3
        ) {

            ctx.closePath();

        }


        ctx.fillStyle =
            colorRelleno;

        ctx.strokeStyle =
            colorLinea;

        ctx.lineWidth =
            2;

        ctx.fill();

        ctx.stroke();


        const centroX =
            puntosCanvas.reduce(
                function (
                    suma,
                    punto
                ) {

                    return suma +
                        punto.x;

                },
                0
            )
            /
            puntosCanvas.length;


        const centroY =
            puntosCanvas.reduce(
                function (
                    suma,
                    punto
                ) {

                    return suma +
                        punto.y;

                },
                0
            )
            /
            puntosCanvas.length;


        ctx.fillStyle =
            '#111827';

        ctx.font =
            'bold 15px Arial';

        ctx.textAlign =
            'center';


        ctx.fillText(
            'LOTE ' +
            nombre,
            centroX,
            centroY
        );

    }


    /*
    |--------------------------------------------------------------------------
    | DIBUJAR TODO
    |--------------------------------------------------------------------------
    */

    function dibujarTodo() {

        ctx.clearRect(
            0,
            0,
            canvasMapa.width,
            canvasMapa.height
        );


        Object.keys(
            configuraciones
        )
        .forEach(
            function (loteId) {

                const datos =
                    configuraciones[loteId];


                if (
                    !datos ||
                    !datos.puntos
                ) {

                    return;

                }


                const esActual =
                    loteSeleccionado.value &&
                    String(loteId) ===
                    String(loteSeleccionado.value);


                dibujarPoligono(
                    datos.puntos,
                    esActual
                        ? 'rgba(239, 68, 68, 0.30)'
                        : 'rgba(34, 197, 94, 0.20)',
                    esActual
                        ? '#ef4444'
                        : '#16a34a',
                    datos.nombre
                );

            }
        );


        if (
            puntosActuales.length === 0
        ) {

            return;

        }


        ctx.beginPath();


        puntosActuales.forEach(
            function (
                punto,
                indice
            ) {

                if (
                    indice === 0
                ) {

                    ctx.moveTo(
                        punto.x,
                        punto.y
                    );

                }

                else {

                    ctx.lineTo(
                        punto.x,
                        punto.y
                    );

                }

            }
        );


        if (
            poligonoCerrado &&
            puntosActuales.length >= 3
        ) {

            ctx.closePath();

            ctx.fillStyle =
                'rgba(239, 68, 68, 0.25)';

            ctx.fill();

        }


        ctx.strokeStyle =
            '#ef4444';

        ctx.lineWidth =
            3;

        ctx.stroke();


        puntosActuales.forEach(
            function (
                punto,
                indice
            ) {

                ctx.beginPath();

                ctx.arc(
                    punto.x,
                    punto.y,
                    5,
                    0,
                    Math.PI * 2
                );

                ctx.fillStyle =
                    '#ef4444';

                ctx.fill();

                ctx.strokeStyle =
                    '#ffffff';

                ctx.lineWidth =
                    2;

                ctx.stroke();


                ctx.fillStyle =
                    '#111827';

                ctx.font =
                    'bold 12px Arial';

                ctx.textAlign =
                    'center';

                ctx.fillText(
                    indice + 1,
                    punto.x,
                    punto.y - 10
                );

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | CAMBIAR HACIENDA
    |--------------------------------------------------------------------------
    */

    hacienda.addEventListener(
        'change',
        function () {

            haciendaActual =
                obtenerHaciendaActual();


            configurando =
                false;

            poligonoCerrado =
                false;

            puntosActuales =
                [];


            loteSeleccionado.value =
                '';


            cargarLotes();

            cargarConfiguracionesDesdeBD();

            cambiarMapa();


            mapa.onload =
                function () {

                    ajustarCanvas();

                    dibujarTodo();

                };


            actualizarCoordenadas();

            actualizarEstado();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | CAMBIAR LOTE
    |--------------------------------------------------------------------------
    */

    loteSeleccionado.addEventListener(
        'change',
        function () {

            configurando =
                false;

            poligonoCerrado =
                false;

            puntosActuales =
                [];


            actualizarCoordenadas();

            actualizarEstado();

            dibujarTodo();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | INICIAR CONFIGURACIÓN
    |--------------------------------------------------------------------------
    */

    btnIniciarConfiguracion.addEventListener(
        'click',
        function () {

            if (!haciendaActual) {

                alert(
                    'Seleccione una hacienda.'
                );

                return;

            }


            if (!loteSeleccionado.value) {

                alert(
                    'Seleccione un lote.'
                );

                return;

            }


            const lote =
                obtenerLoteActual();


            if (!lote) {

                return;

            }


            configurando =
                true;


            if (
                configuraciones[lote.id] &&
                configuraciones[lote.id].puntos
            ) {

                puntosActuales =
                    configuraciones[lote.id].puntos.map(
                        function (punto) {

                            return convertirDesdePorcentaje(
                                punto
                            );

                        }
                    );

            }

            else {

                puntosActuales =
                    [];

            }


            poligonoCerrado =
                false;


            actualizarCoordenadas();

            actualizarEstado();

            dibujarTodo();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | CLICK MAPA
    |--------------------------------------------------------------------------
    */

    canvasMapa.addEventListener(
        'click',
        function (event) {

            if (!configurando) {

                return;

            }


            if (poligonoCerrado) {

                return;

            }


            const posicion =
                obtenerPosicion(
                    event
                );


            puntosActuales.push(
                posicion
            );


            actualizarCoordenadas();

            actualizarEstado();

            dibujarTodo();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | DESHACER PUNTO
    |--------------------------------------------------------------------------
    */

    btnDeshacerPunto.addEventListener(
        'click',
        function () {

            if (
                puntosActuales.length === 0
            ) {

                return;

            }


            if (poligonoCerrado) {

                alert(
                    'El polígono está cerrado. ' +
                    'Utilice "Limpiar actual" o vuelva a iniciar la configuración.'
                );

                return;

            }


            puntosActuales.pop();


            actualizarCoordenadas();

            actualizarEstado();

            dibujarTodo();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | CERRAR POLÍGONO
    |--------------------------------------------------------------------------
    */

    btnCerrarPoligono.addEventListener(
        'click',
        function () {

            if (!configurando) {

                alert(
                    'Primero inicie la configuración.'
                );

                return;

            }


            if (
                puntosActuales.length < 3
            ) {

                alert(
                    'Debe marcar al menos 3 puntos.'
                );

                return;

            }


            poligonoCerrado =
                true;


            actualizarEstado();

            dibujarTodo();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | GUARDAR LOTE
    |--------------------------------------------------------------------------
    */

    btnGuardarLote.addEventListener(
        'click',
        function () {

            if (!haciendaActual) {

                alert(
                    'Seleccione una hacienda.'
                );

                return;

            }


            const lote =
                obtenerLoteActual();


            if (!lote) {

                alert(
                    'Seleccione un lote.'
                );

                return;

            }


            if (
                puntosActuales.length < 3
            ) {

                alert(
                    'El lote debe tener al menos 3 puntos.'
                );

                return;

            }


            if (!poligonoCerrado) {

                alert(
                    'Primero debe cerrar el polígono.'
                );

                return;

            }


            const puntosPorcentaje =
                puntosActuales.map(
                    function (punto) {

                        return convertirAPorcentaje(
                            punto
                        );

                    }
                );


            configuraciones[lote.id] = {

                lote_id:
                    lote.id,

                nombre:
                    lote.nombre,

                puntos:
                    puntosPorcentaje

            };


            lote.coordenadas =
                puntosPorcentaje;


            alert(
                'LOTE ' +
                lote.nombre +
                ' actualizado correctamente.'
            );


            configurando =
                false;


            poligonoCerrado =
                true;


            actualizarListaLotes();

            actualizarEstado();

            dibujarTodo();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | LIMPIAR ACTUAL
    |--------------------------------------------------------------------------
    */

    btnLimpiarActual.addEventListener(
        'click',
        function () {

            const lote =
                obtenerLoteActual();


            if (!lote) {

                alert(
                    'Seleccione un lote.'
                );

                return;

            }


            const confirmar =
                confirm(
                    '¿Desea eliminar temporalmente la configuración ' +
                    'del LOTE ' +
                    lote.nombre +
                    '?\n\n' +
                    'Esto todavía NO elimina las coordenadas de la base de datos.'
                );


            if (!confirmar) {

                return;

            }


            delete configuraciones[lote.id];


            lote.coordenadas =
                null;


            puntosActuales =
                [];


            configurando =
                false;


            poligonoCerrado =
                false;


            actualizarListaLotes();

            actualizarCoordenadas();

            actualizarEstado();

            dibujarTodo();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | LIMPIAR TODO LOCAL
    |--------------------------------------------------------------------------
    */

    btnLimpiarTodo.addEventListener(
        'click',
        function () {

            if (!haciendaActual) {

                alert(
                    'Seleccione una hacienda.'
                );

                return;

            }


            const confirmar =
                confirm(
                    'Esto eliminará temporalmente las coordenadas ' +
                    'cargadas de esta hacienda en la pantalla.\n\n' +
                    'NO se eliminarán de la base de datos hasta que se envíe un guardado.\n\n' +
                    '¿Continuar?'
                );


            if (!confirmar) {

                return;

            }


            configuraciones =
                {};


            haciendaActual.lotes.forEach(
                function (lote) {

                    lote.coordenadas =
                        null;

                }
            );


            puntosActuales =
                [];


            configurando =
                false;


            poligonoCerrado =
                false;


            actualizarListaLotes();

            actualizarCoordenadas();

            actualizarEstado();

            dibujarTodo();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | GUARDAR EN SERVIDOR
    |--------------------------------------------------------------------------
    */

    btnGuardarServidor.addEventListener(
        'click',
        async function () {

            if (!haciendaActual) {

                alert(
                    'Seleccione una hacienda.'
                );

                return;

            }


            const lotesParaGuardar =
                haciendaActual.lotes.filter(
                    function (lote) {

                        return lote.coordenadas &&
                            Array.isArray(
                                lote.coordenadas
                            ) &&
                            lote.coordenadas.length >= 3;

                    }
                );


            if (
                lotesParaGuardar.length === 0
            ) {

                alert(
                    'No hay polígonos para guardar.'
                );

                return;

            }


            const confirmar =
                confirm(
                    'Se guardarán ' +
                    lotesParaGuardar.length +
                    ' lote(s) en la base de datos.\n\n' +
                    '¿Desea continuar?'
                );


            if (!confirmar) {

                return;

            }


            const csrfElement =
                document.querySelector(
                    'meta[name="csrf-token"]'
                );


            if (!csrfElement) {

                alert(
                    'No se encontró el token CSRF.'
                );

                return;

            }


            const csrfToken =
                csrfElement.getAttribute(
                    'content'
                );


            const lotes = {};


            lotesParaGuardar.forEach(
                function (lote) {

                    lotes[lote.nombre] = {

                        puntos:
                            lote.coordenadas

                    };

                }
            );


            try {

                const respuesta =
                    await fetch(
                        "{{ route('lotes.guardar-coordenadas') }}",
                        {

                            method:
                                'POST',

                            headers: {

                                'Content-Type':
                                    'application/json',

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    csrfToken

                            },

                            body:
                                JSON.stringify({

                                    hacienda_id:
                                        haciendaActual.id,

                                    lotes:
                                        lotes

                                })

                        }
                    );


                const resultado =
                    await respuesta.json();


                if (
                    respuesta.ok &&
                    resultado.success
                ) {

                    alert(
                        '✓ ' +
                        resultado.message
                    );

                }

                else {

                    alert(
                        'Error: ' +
                        (
                            resultado.message ||
                            'No se pudieron guardar los polígonos.'
                        )
                    );

                }

            }

            catch (error) {

                console.error(
                    'Error guardando polígonos:',
                    error
                );


                alert(
                    'Ocurrió un error al conectar con el servidor.'
                );

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | REDIMENSIONAR
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'resize',
        function () {

            if (
                mapa.complete &&
                mapa.clientWidth > 0
            ) {

                ajustarCanvas();

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | INICIALIZAR
    |--------------------------------------------------------------------------
    */

    actualizarCoordenadas();

    actualizarEstado();

});

</script>

@endsection