@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 py-6">

    <!-- ========================================================= -->
    <!-- CABECERA -->
    <!-- ========================================================= -->

    <div class="bg-green-800 rounded-xl shadow-lg p-6 text-white">

        <h1 class="text-3xl md:text-4xl font-bold">
            Configuración de Lotes
        </h1>

        <p class="text-green-200 mt-1">
            Agrícola Quintana
        </p>


        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-8">

            <!-- ================================================= -->
            <!-- HACIENDA -->
            <!-- ================================================= -->

            <div>

                <label class="block mb-2 font-semibold">
                    Hacienda
                </label>

                <select
                    id="hacienda"
                    class="w-full rounded-lg border border-gray-300 bg-white text-black px-3 py-2"
                >

                    <option value="">
                        Seleccione una hacienda
                    </option>

                    @foreach($haciendas as $hacienda)

                        <option value="{{ $hacienda->id }}">
                            {{ strtoupper($hacienda->nombre) }}
                        </option>

                    @endforeach

                </select>

            </div>


            <!-- ================================================= -->
            <!-- LOTE -->
            <!-- ================================================= -->

            <div>

                <label class="block mb-2 font-semibold">
                    Lote a configurar
                </label>

                <select
                    id="loteSeleccionado"
                    class="w-full rounded-lg border border-gray-300 bg-white text-black px-3 py-2"
                >

                    <option value="">
                        Seleccione un lote
                    </option>

                    <option value="LOTE 1">
                        LOTE 1
                    </option>

                    <option value="LOTE 2">
                        LOTE 2
                    </option>

                    <option value="LOTE 3">
                        LOTE 3
                    </option>

                    <option value="LOTE 4">
                        LOTE 4
                    </option>

                    <option value="LOTE 5">
                        LOTE 5
                    </option>

                    <option value="LOTE 6">
                        LOTE 6
                    </option>

                    <option value="LOTE 7">
                        LOTE 7
                    </option>

                    <option value="LOTE 8">
                        LOTE 8
                    </option>

                    <option value="LOTE 9">
                        LOTE 9
                    </option>

                    <option value="LOTE 10">
                        LOTE 10
                    </option>

                    <option value="LOTE 11">
                        LOTE 11
                    </option>

                    <option value="LOTE 12">
                        LOTE 12
                    </option>

                    <option value="LOTE 13">
                        LOTE 13
                    </option>

                    <option value="LOTE 14">
                        LOTE 14
                    </option>

                    <option value="LOTE 15">
                        LOTE 15
                    </option>

                    <option value="LOTE 16">
                        LOTE 16
                    </option>

                </select>

            </div>

        </div>

    </div>


    <!-- ========================================================= -->
    <!-- CONFIGURADOR -->
    <!-- ========================================================= -->

    <div class="bg-white rounded-xl shadow-lg mt-8 overflow-hidden">


        <!-- ===================================================== -->
        <!-- CABECERA -->
        <!-- ===================================================== -->

        <div class="bg-green-800 text-white px-5 py-3">

            <h2 class="font-semibold">
                Configurador de Coordenadas de Lotes
            </h2>

        </div>


        <!-- ===================================================== -->
        <!-- INSTRUCCIONES -->
        <!-- ===================================================== -->

        <div class="p-5 bg-green-50 border-b border-green-200">

            <div class="text-gray-700">

                <p class="font-bold text-green-800 mb-2">
                    ¿Cómo configurar un lote?
                </p>

                <ol class="list-decimal ml-5 space-y-1 text-sm">

                    <li>
                        Selecciona una hacienda.
                    </li>

                    <li>
                        Selecciona el lote que quieres configurar.
                    </li>

                    <li>
                        Haz clic en cada esquina del lote sobre el mapa.
                    </li>

                    <li>
                        Marca todos los puntos necesarios para rodear completamente el lote.
                    </li>

                    <li>
                        Haz clic en <strong>"Cerrar polígono"</strong>.
                    </li>

                    <li>
                        Si la forma está correcta, pulsa <strong>"Guardar lote"</strong>.
                    </li>

                </ol>

            </div>

        </div>


        <!-- ===================================================== -->
        <!-- HERRAMIENTAS -->
        <!-- ===================================================== -->

        <div class="p-4 bg-gray-50 border-b">

            <div class="flex flex-wrap items-center gap-3">


                <!-- INICIAR CONFIGURACIÓN -->

                <button
                    id="btnIniciarConfiguracion"
                    type="button"
                    class="bg-green-700 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-800"
                >
                    📍 Iniciar configuración
                </button>


                <!-- DESHACER PUNTO -->

                <button
                    id="btnDeshacerPunto"
                    type="button"
                    class="bg-gray-700 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-800"
                >
                    ↩️ Deshacer punto
                </button>


                <!-- CERRAR POLÍGONO -->

                <button
                    id="btnCerrarPoligono"
                    type="button"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700"
                >
                    🔷 Cerrar polígono
                </button>


                <!-- GUARDAR -->

                <button
                    id="btnGuardarLote"
                    type="button"
                    class="bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-purple-700"
                >
                    💾 Guardar lote
                </button>


                <!-- LIMPIAR ACTUAL -->

                <button
                    id="btnLimpiarActual"
                    type="button"
                    class="bg-yellow-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-yellow-600"
                >
                    🧹 Limpiar actual
                </button>


                <!-- BORRAR TODO -->

                <button
                    id="btnLimpiarTodo"
                    type="button"
                    class="bg-red-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-700"
                >
                    🗑️ Borrar configuración
                </button>


                <!-- EXPORTAR -->

                <button
                    id="btnExportar"
                    type="button"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-indigo-700"
                >
                    📥 Exportar coordenadas
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


        <!-- ===================================================== -->
        <!-- INFORMACIÓN -->
        <!-- ===================================================== -->

        <div class="p-4">

            <div
                id="estadoConfiguracion"
                class="bg-gray-100 border border-gray-300 rounded-lg px-4 py-3 text-gray-700"
            >

                Seleccione una hacienda y un lote para comenzar.

            </div>

        </div>


        <!-- ===================================================== -->
        <!-- MAPA -->
        <!-- ===================================================== -->

        <div class="p-4 sm:p-6">

            <div
                id="contenedorMapa"
                class="relative mx-auto w-full max-w-6xl border border-gray-300 rounded-lg overflow-hidden bg-white"
            >

                <!-- IMAGEN -->

                <img
                    id="mapa"
                    src=""
                    class="block w-full h-auto select-none"
                    draggable="false"
                    alt="Mapa de Hacienda"
                >


                <!-- CANVAS -->

                <canvas
                    id="canvasMapa"
                    class="absolute inset-0 w-full h-full"
                ></canvas>

            </div>

        </div>


        <!-- ===================================================== -->
        <!-- LOTES CONFIGURADOS -->
        <!-- ===================================================== -->

        <div class="p-4 sm:p-6 border-t">

            <h3 class="text-xl font-bold text-green-800 mb-4">
                Lotes configurados
            </h3>


            <div
                id="listaLotesConfigurados"
                class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3"
            >

                <div class="text-gray-500 text-sm">
                    Todavía no hay lotes configurados.
                </div>

            </div>

        </div>


        <!-- ===================================================== -->
        <!-- COORDENADAS -->
        <!-- ===================================================== -->

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


<!-- ============================================================= -->
<!-- JAVASCRIPT -->
<!-- ============================================================= -->

<script>

document.addEventListener('DOMContentLoaded', function () {


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

    const contenedorMapa =
        document.getElementById('contenedorMapa');

    const estadoConfiguracion =
        document.getElementById('estadoConfiguracion');

    const coordenadasActuales =
        document.getElementById('coordenadasActuales');

    const listaLotesConfigurados =
        document.getElementById('listaLotesConfigurados');

    const btnGuardarServidor =
    document.getElementById(
        'btnGuardarServidor'
    );    

    /*
    |--------------------------------------------------------------------------
    | BOTONES
    |--------------------------------------------------------------------------
    */

    const btnIniciarConfiguracion =
        document.getElementById(
            'btnIniciarConfiguracion'
        );

    const btnDeshacerPunto =
        document.getElementById(
            'btnDeshacerPunto'
        );

    const btnCerrarPoligono =
        document.getElementById(
            'btnCerrarPoligono'
        );

    const btnGuardarLote =
        document.getElementById(
            'btnGuardarLote'
        );

    const btnLimpiarActual =
        document.getElementById(
            'btnLimpiarActual'
        );

    const btnLimpiarTodo =
        document.getElementById(
            'btnLimpiarTodo'
        );

    const btnExportar =
        document.getElementById(
            'btnExportar'
        );


    /*
    |--------------------------------------------------------------------------
    | CONTEXTO CANVAS
    |--------------------------------------------------------------------------
    */

    const ctx =
        canvasMapa.getContext('2d');


    /*
    |--------------------------------------------------------------------------
    | VARIABLES
    |--------------------------------------------------------------------------
    */

    let configurando =
        false;

    let poligonoCerrado =
        false;

    let puntosActuales =
        [];

    let configuraciones =
        {};


    /*
    |--------------------------------------------------------------------------
    | OBTENER CLAVE DE STORAGE
    |--------------------------------------------------------------------------
    */

    function obtenerClaveStorage() {

        if (!hacienda.value) {

            return null;

        }

        return 'configuracion_lotes_' +
            hacienda.value;

    }


    /*
    |--------------------------------------------------------------------------
    | GUARDAR CONFIGURACIONES
    |--------------------------------------------------------------------------
    */

    function guardarConfiguracionesStorage() {

        const clave =
            obtenerClaveStorage();


        if (!clave) {

            return;

        }


        localStorage.setItem(

            clave,

            JSON.stringify(
                configuraciones
            )

        );

    }


    /*
    |--------------------------------------------------------------------------
    | CARGAR CONFIGURACIONES
    |--------------------------------------------------------------------------
    */

    function cargarConfiguraciones() {

        configuraciones = {};


        const clave =
            obtenerClaveStorage();


        if (!clave) {

            actualizarListaLotes();

            return;

        }


        const datos =
            localStorage.getItem(
                clave
            );


        if (datos) {

            try {

                configuraciones =
                    JSON.parse(
                        datos
                    );


            } catch (error) {

                console.error(
                    'Error leyendo configuraciones:',
                    error
                );

                configuraciones = {};

            }

        }


        actualizarListaLotes();

    }


    /*
    |--------------------------------------------------------------------------
    | OBTENER NOMBRE DE HACIENDA
    |--------------------------------------------------------------------------
    */

    function obtenerNombreHacienda() {

        if (!hacienda.value) {

            return '';

        }


        return hacienda.options[
            hacienda.selectedIndex
        ]
        .text
        .trim()
        .toUpperCase();

    }


    /*
    |--------------------------------------------------------------------------
    | CAMBIAR MAPA
    |--------------------------------------------------------------------------
    */

    function cambiarMapa() {


        if (!hacienda.value) {

            mapa.src = '';


            ctx.clearRect(

                0,

                0,

                canvasMapa.width,

                canvasMapa.height

            );


            estadoConfiguracion.textContent =
                'Seleccione una hacienda para comenzar.';

            return;

        }


        const texto =
            obtenerNombreHacienda();


        /*
        |--------------------------------------------------------------------------
        | DOMENICA
        |--------------------------------------------------------------------------
        */

        if (
            texto.includes('DOMENICA')
        ) {

            mapa.src =
                "{{ asset('mapas/domenica.png') }}";

        }


        /*
        |--------------------------------------------------------------------------
        | MARIA MARIA
        |--------------------------------------------------------------------------
        */

        else if (
            texto.includes('MARIA')
        ) {

            mapa.src =
                "{{ asset('mapas/maria_maria.png') }}";

        }


        /*
        |--------------------------------------------------------------------------
        | SIN MAPA
        |--------------------------------------------------------------------------
        */

        else {

            mapa.src = '';

        }


        /*
        |--------------------------------------------------------------------------
        | CARGAR CONFIGURACIONES GUARDADAS
        |--------------------------------------------------------------------------
        */

        cargarConfiguraciones();


        /*
        |--------------------------------------------------------------------------
        | CUANDO CARGUE LA IMAGEN
        |--------------------------------------------------------------------------
        */

        mapa.onload =
            function () {

                ajustarCanvas();

                dibujarTodo();

            };

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
    | OBTENER POSICIÓN DEL MOUSE
    |--------------------------------------------------------------------------
    */

    function obtenerPosicion(event) {


        const rect =
            canvasMapa.getBoundingClientRect();


        const x =
            (
                event.clientX -
                rect.left
            )
            *
            (
                canvasMapa.width /
                rect.width
            );


        const y =
            (
                event.clientY -
                rect.top
            )
            *
            (
                canvasMapa.height /
                rect.height
            );


        return {

            x: x,

            y: y

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

                )
                .toFixed(6),


            y:
                Number(

                    (
                        punto.y /
                        canvasMapa.height
                    )
                    *
                    100

                )
                .toFixed(6)

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
                    parseFloat(
                        punto.x
                    )
                    /
                    100
                )
                *
                canvasMapa.width,


            y:

                (
                    parseFloat(
                        punto.y
                    )
                    /
                    100
                )
                *
                canvasMapa.height

        };

    }


    /*
    |--------------------------------------------------------------------------
    | DIBUJAR PUNTO
    |--------------------------------------------------------------------------
    */

    function dibujarPunto(
        punto,
        numero
    ) {


        ctx.beginPath();


        ctx.arc(

            punto.x,

            punto.y,

            6,

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
            'bold 14px Arial';


        ctx.fillText(

            numero,

            punto.x + 9,

            punto.y - 9

        );

    }


    /*
    |--------------------------------------------------------------------------
    | DIBUJAR POLÍGONO ACTUAL
    |--------------------------------------------------------------------------
    */

    function dibujarPoligonoActual() {


        if (
            puntosActuales.length === 0
        ) {

            return;

        }


        ctx.beginPath();


        ctx.moveTo(

            puntosActuales[0].x,

            puntosActuales[0].y

        );


        for (

            let i = 1;

            i < puntosActuales.length;

            i++

        ) {

            ctx.lineTo(

                puntosActuales[i].x,

                puntosActuales[i].y

            );

        }


        /*
        |--------------------------------------------------------------------------
        | CERRAR POLÍGONO
        |--------------------------------------------------------------------------
        */

        if (
            poligonoCerrado
        ) {

            ctx.closePath();


            ctx.fillStyle =
                'rgba(34, 197, 94, 0.20)';


            ctx.fill();

        }


        /*
        |--------------------------------------------------------------------------
        | LÍNEA
        |--------------------------------------------------------------------------
        */

        ctx.strokeStyle =
            '#dc2626';


        ctx.lineWidth =
            3;


        ctx.setLineDash([]);


        ctx.stroke();


        /*
        |--------------------------------------------------------------------------
        | PUNTOS
        |--------------------------------------------------------------------------
        */

        puntosActuales.forEach(

            function (
                punto,
                indice
            ) {

                dibujarPunto(

                    punto,

                    indice + 1

                );

            }

        );

    }


    /*
    |--------------------------------------------------------------------------
    | DIBUJAR CONFIGURACIONES GUARDADAS
    |--------------------------------------------------------------------------
    */

    function dibujarConfiguracionesGuardadas() {


        let indiceColor =
            0;


        const colores = [

            'rgba(34,197,94,0.20)',

            'rgba(59,130,246,0.20)',

            'rgba(249,115,22,0.20)',

            'rgba(168,85,247,0.20)',

            'rgba(236,72,153,0.20)',

            'rgba(14,165,233,0.20)',

            'rgba(234,179,8,0.20)',

            'rgba(20,184,166,0.20)'

        ];


        Object.keys(
            configuraciones
        )
        .forEach(

            function (
                nombreLote
            ) {


                const lote =
                    configuraciones[
                        nombreLote
                    ];


                if (

                    !lote ||

                    !lote.puntos ||

                    lote.puntos.length < 3

                ) {

                    return;

                }


                const puntos =
                    lote.puntos.map(

                        function (
                            punto
                        ) {

                            return convertirDesdePorcentaje(
                                punto
                            );

                        }

                    );


                ctx.beginPath();


                ctx.moveTo(

                    puntos[0].x,

                    puntos[0].y

                );


                for (

                    let i = 1;

                    i < puntos.length;

                    i++

                ) {

                    ctx.lineTo(

                        puntos[i].x,

                        puntos[i].y

                    );

                }


                ctx.closePath();


                /*
                |--------------------------------------------------------------------------
                | RELLENO
                |--------------------------------------------------------------------------
                */

                ctx.fillStyle =
                    colores[
                        indiceColor %
                        colores.length
                    ];


                ctx.fill();


                /*
                |--------------------------------------------------------------------------
                | BORDE
                |--------------------------------------------------------------------------
                */

                ctx.strokeStyle =
                    '#16a34a';


                ctx.lineWidth =
                    2;


                ctx.stroke();


                indiceColor++;

            }

        );

    }


    /*
    |--------------------------------------------------------------------------
    | DIBUJAR TODO
    |--------------------------------------------------------------------------
    */

    function dibujarTodo() {


        if (

            canvasMapa.width === 0 ||

            canvasMapa.height === 0

        ) {

            return;

        }


        ctx.clearRect(

            0,

            0,

            canvasMapa.width,

            canvasMapa.height

        );


        /*
        |--------------------------------------------------------------------------
        | PRIMERO: LOTES GUARDADOS
        |--------------------------------------------------------------------------
        */

        dibujarConfiguracionesGuardadas();


        /*
        |--------------------------------------------------------------------------
        | SEGUNDO: POLÍGONO ACTUAL
        |--------------------------------------------------------------------------
        */

        dibujarPoligonoActual();

    }


    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR COORDENADAS
    |--------------------------------------------------------------------------
    */

    function actualizarCoordenadas() {


        const coordenadas =
            puntosActuales.map(

                function (
                    punto
                ) {

                    return convertirAPorcentaje(
                        punto
                    );

                }

            );


        coordenadasActuales.textContent =
            JSON.stringify(

                coordenadas,

                null,

                4

            );

    }


    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR ESTADO
    |--------------------------------------------------------------------------
    */

    function actualizarEstado() {


        const lote =
            loteSeleccionado.value;


        if (!hacienda.value) {

            estadoConfiguracion.textContent =
                'Seleccione una hacienda.';

            return;

        }


        if (!lote) {

            estadoConfiguracion.textContent =
                'Seleccione un lote.';

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | SI NO ESTÁ CONFIGURANDO
        |--------------------------------------------------------------------------
        */

        if (!configurando) {


            if (
                configuraciones[lote]
            ) {

                estadoConfiguracion.innerHTML =

                    `
                    <strong>Hacienda:</strong>
                    ${hacienda.options[hacienda.selectedIndex].text}

                    &nbsp; | &nbsp;

                    <strong>Lote:</strong>
                    ${lote}

                    <br>

                    <span class="text-green-700">
                        ✓ Este lote ya está configurado.
                        Pulse "Iniciar configuración" para editarlo.
                    </span>
                    `;

            }

            else {

                estadoConfiguracion.innerHTML =

                    `
                    <strong>Hacienda:</strong>
                    ${hacienda.options[hacienda.selectedIndex].text}

                    &nbsp; | &nbsp;

                    <strong>Lote:</strong>
                    ${lote}

                    <br>

                    <span class="text-gray-500">
                        Pulse "Iniciar configuración" para comenzar.
                    </span>
                    `;

            }


            return;

        }


        /*
        |--------------------------------------------------------------------------
        | SI ESTÁ CONFIGURANDO
        |--------------------------------------------------------------------------
        */

        estadoConfiguracion.innerHTML =

            `
            <strong>Configurando:</strong>
            ${lote}

            &nbsp; | &nbsp;

            <strong>Puntos:</strong>
            ${puntosActuales.length}

            <br>

            <span class="text-green-700">

                ${
                    poligonoCerrado

                    ?

                    'Polígono cerrado. Puede guardarlo.'

                    :

                    'Haga clic en cada esquina del lote.'
                }

            </span>
            `;

    }


    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR LISTA DE LOTES
    |--------------------------------------------------------------------------
    */

    function actualizarListaLotes() {


        listaLotesConfigurados.innerHTML =
            '';


        const lotes =
            Object.keys(
                configuraciones
            );


        if (
            lotes.length === 0
        ) {


            listaLotesConfigurados.innerHTML =

                `
                <div class="text-gray-500 text-sm col-span-full">
                    Todavía no hay lotes configurados.
                </div>
                `;


            return;

        }


        lotes.forEach(

            function (
                lote
            ) {


                const div =
                    document.createElement(
                        'div'
                    );


                div.className =

                    `
                    bg-green-100
                    border
                    border-green-300
                    text-green-800
                    rounded-lg
                    px-3
                    py-2
                    font-semibold
                    text-center
                    `;


                div.textContent =
                    '✓ ' +
                    lote;


                listaLotesConfigurados.appendChild(
                    div
                );

            }

        );

    }


    /*
    |--------------------------------------------------------------------------
    | CAMBIO DE HACIENDA
    |--------------------------------------------------------------------------
    */

    hacienda.addEventListener(

        'change',

        function () {


            configurando =
                false;


            poligonoCerrado =
                false;


            puntosActuales =
                [];


            loteSeleccionado.value =
                '';


            actualizarCoordenadas();


            actualizarEstado();


            cambiarMapa();

        }

    );


    /*
    |--------------------------------------------------------------------------
    | CAMBIO DE LOTE
    |--------------------------------------------------------------------------
    */

    loteSeleccionado.addEventListener(

        'change',

        function () {


            /*
            |--------------------------------------------------------------------------
            | NO BORRAMOS CONFIGURACIONES GUARDADAS
            |--------------------------------------------------------------------------
            */

            configurando =
                false;


            poligonoCerrado =
                false;


            puntosActuales =
                [];


            const lote =
                loteSeleccionado.value;


            /*
            |--------------------------------------------------------------------------
            | SI EL LOTE YA ESTÁ GUARDADO
            |--------------------------------------------------------------------------
            */

            if (

                lote &&

                configuraciones[lote] &&

                configuraciones[lote].puntos

            ) {


                puntosActuales =

                    configuraciones[lote].puntos.map(

                        function (
                            punto
                        ) {

                            return convertirDesdePorcentaje(
                                punto
                            );

                        }

                    );


                /*
                |--------------------------------------------------------------------------
                | MOSTRAR EL LOTE GUARDADO
                |--------------------------------------------------------------------------
                */

                poligonoCerrado =
                    true;

            }


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


            if (!hacienda.value) {

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
                loteSeleccionado.value;


            configurando =
                true;


            /*
            |--------------------------------------------------------------------------
            | SI EL LOTE YA EXISTE
            |--------------------------------------------------------------------------
            | CARGAMOS LOS PUNTOS EXISTENTES
            |--------------------------------------------------------------------------
            */

            if (

                configuraciones[lote] &&

                configuraciones[lote].puntos

            ) {


                puntosActuales =

                    configuraciones[lote].puntos.map(

                        function (
                            punto
                        ) {

                            return convertirDesdePorcentaje(
                                punto
                            );

                        }

                    );


                /*
                |--------------------------------------------------------------------------
                | AL EDITARLO PERMITIMOS MODIFICAR LOS PUNTOS
                |--------------------------------------------------------------------------
                */

                poligonoCerrado =
                    false;

            }


            /*
            |--------------------------------------------------------------------------
            | SI ES UN LOTE NUEVO
            |--------------------------------------------------------------------------
            */

            else {


                puntosActuales =
                    [];


                poligonoCerrado =
                    false;

            }


            actualizarCoordenadas();


            actualizarEstado();


            dibujarTodo();

        }

    );


    /*
    |--------------------------------------------------------------------------
    | CLICK EN EL MAPA
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

                    'El polígono ya está cerrado. ' +
                    'Si desea modificarlo, pulse "Iniciar configuración" ' +
                    'y luego utilice "Limpiar actual".'

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


            const lote =
                loteSeleccionado.value;


            if (!hacienda.value) {

                alert(

                    'Seleccione una hacienda.'

                );

                return;

            }


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


            /*
            |--------------------------------------------------------------------------
            | CONVERTIR PUNTOS A PORCENTAJE
            |--------------------------------------------------------------------------
            */

            const puntosPorcentaje =

                puntosActuales.map(

                    function (
                        punto
                    ) {

                        return convertirAPorcentaje(
                            punto
                        );

                    }

                );


            /*
            |--------------------------------------------------------------------------
            | GUARDAR SOLAMENTE EL LOTE ACTUAL
            |--------------------------------------------------------------------------
            */

            configuraciones[lote] = {

                puntos:
                    puntosPorcentaje,

                fecha:
                    new Date()
                    .toISOString()

            };


            /*
            |--------------------------------------------------------------------------
            | GUARDAR TODOS LOS LOTES
            |--------------------------------------------------------------------------
            */

            guardarConfiguracionesStorage();


            /*
            |--------------------------------------------------------------------------
            | ACTUALIZAR LISTA
            |--------------------------------------------------------------------------
            */

            actualizarListaLotes();


            alert(

                lote +

                ' guardado correctamente.'

            );


            /*
            |--------------------------------------------------------------------------
            | FINALIZAR EDICIÓN
            |--------------------------------------------------------------------------
            */

            configurando =
                false;


            poligonoCerrado =
                true;


            actualizarEstado();


            dibujarTodo();

        }

    );


    /*
    |--------------------------------------------------------------------------
    | LIMPIAR LOTE ACTUAL
    |--------------------------------------------------------------------------
    */

    btnLimpiarActual.addEventListener(

        'click',

        function () {


            const lote =
                loteSeleccionado.value;


            if (!hacienda.value) {

                alert(

                    'Seleccione una hacienda.'

                );

                return;

            }


            if (!lote) {

                alert(

                    'Seleccione un lote.'

                );

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | CONFIRMAR
            |--------------------------------------------------------------------------
            */

            const confirmar =

                confirm(

                    '¿Desea eliminar la configuración del ' +

                    lote +

                    '?\n\n' +

                    'Los demás lotes permanecerán guardados.'

                );


            if (!confirmar) {

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | ELIMINAR SOLO ESTE LOTE
            |--------------------------------------------------------------------------
            */

            delete configuraciones[lote];


            /*
            |--------------------------------------------------------------------------
            | GUARDAR LOS DEMÁS
            |--------------------------------------------------------------------------
            */

            guardarConfiguracionesStorage();


            /*
            |--------------------------------------------------------------------------
            | LIMPIAR EDICIÓN
            |--------------------------------------------------------------------------
            */

            configurando =
                false;


            poligonoCerrado =
                false;


            puntosActuales =
                [];


            actualizarCoordenadas();


            actualizarListaLotes();


            actualizarEstado();


            dibujarTodo();

        }

    );


    /*
    |--------------------------------------------------------------------------
    | BORRAR TODA LA CONFIGURACIÓN
    |--------------------------------------------------------------------------
    */

    btnLimpiarTodo.addEventListener(

        'click',

        function () {


            if (!hacienda.value) {

                alert(

                    'Seleccione una hacienda.'

                );

                return;

            }


            const confirmar =

                confirm(

                    '¿Está seguro de borrar TODAS las coordenadas configuradas para esta hacienda?\n\n' +

                    'Esta acción eliminará todos los lotes guardados.'

                );


            if (!confirmar) {

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | BORRAR TODAS LAS CONFIGURACIONES
            |--------------------------------------------------------------------------
            */

            configuraciones =
                {};


            const clave =
                obtenerClaveStorage();


            if (clave) {

                localStorage.removeItem(
                    clave
                );

            }


            /*
            |--------------------------------------------------------------------------
            | REINICIAR
            |--------------------------------------------------------------------------
            */

            configurando =
                false;


            poligonoCerrado =
                false;


            puntosActuales =
                [];


            actualizarCoordenadas();


            actualizarListaLotes();


            actualizarEstado();


            dibujarTodo();

        }

    );


    /*
    |--------------------------------------------------------------------------
    | EXPORTAR COORDENADAS
    |--------------------------------------------------------------------------
    */

    btnExportar.addEventListener(

        'click',

        function () {


            if (

                Object.keys(
                    configuraciones
                ).length === 0

            ) {


                alert(

                    'No hay lotes configurados para exportar.'

                );


                return;

            }


            const datos =

                JSON.stringify(

                    {

                        hacienda_id:
                            hacienda.value,

                        hacienda:
                            hacienda.options[
                                hacienda.selectedIndex
                            ]
                            .text
                            .trim(),

                        lotes:
                            configuraciones

                    },

                    null,

                    4

                );


            const blob =

                new Blob(

                    [

                        datos

                    ],

                    {

                        type:
                            'application/json'

                    }

                );


            const url =

                URL.createObjectURL(
                    blob
                );


            const enlace =

                document.createElement(
                    'a'
                );


            enlace.href =
                url;


            enlace.download =

                'coordenadas_' +

                hacienda.value +

                '.json';


            document.body.appendChild(
                enlace
            );


            enlace.click();


            document.body.removeChild(
                enlace
            );


            URL.revokeObjectURL(
                url
            );

        }

    );

btnGuardarServidor.addEventListener(

    'click',

    async function () {

        if (!hacienda.value) {

            alert(
                'Seleccione una hacienda.'
            );

            return;

        }

        const lotesConfigurados =
            Object.keys(
                configuraciones
            );

        if (
            lotesConfigurados.length === 0
        ) {

            alert(
                'No hay polígonos configurados para guardar.'
            );

            return;

        }

        const confirmar = confirm(

            'Se guardarán ' +

            lotesConfigurados.length +

            ' lote(s) en la base de datos.\n\n' +

            '¿Desea continuar?'

        );

        if (!confirmar) {

            return;

        }

        const csrfToken =

            document
            .querySelector(
                'meta[name="csrf-token"]'
            )
            .getAttribute(
                'content'
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
                                    hacienda.value,

                                lotes:
                                    configuraciones

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
    | INICIALIZACIÓN
    |--------------------------------------------------------------------------
    */

    actualizarCoordenadas();


    actualizarEstado();

});

</script>

@endsection