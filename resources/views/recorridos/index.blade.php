@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 py-6">

{{-- ========================================================= --}}{{-- CABECERA --}}{{-- ========================================================= --}}

<div class="bg-green-800 rounded-xl shadow-lg p-6 text-white">

<h1 class="text-3xl md:text-4xl font-bold">
    Registro de Área Recorrida
</h1>

<p class="text-green-200 mt-1">
    Agrícola Quintana
</p>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mt-8">

    <div>
        <label for="hacienda" class="block mb-2 font-semibold">
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

    <div>
        <label for="semana" class="block mb-2 font-semibold">
            Semana
        </label>

        <select
            id="semana"
            class="w-full rounded-lg border border-gray-300 bg-white text-black px-3 py-2"
        >
            <option value="">
                Seleccione semana
            </option>

            @for($i = 1; $i <= 53; $i++)
                <option value="{{ $i }}">
                    Semana {{ $i }}
                </option>
            @endfor
        </select>
    </div>

    <div>
        <label for="fecha" class="block mb-2 font-semibold">
            Fecha
        </label>

        <input
            id="fecha"
            type="date"
            value="{{ date('Y-m-d') }}"
            class="w-full rounded-lg border border-gray-300 bg-white text-black px-3 py-2"
        >
    </div>

    <div>
        <label class="block mb-2 font-semibold">
            Usuario
        </label>

        <input
            readonly
            value="{{ auth()->user()->name }}"
            class="w-full rounded-lg border border-gray-300 bg-gray-200 text-black px-3 py-2"
        >
    </div>

</div>

<div class="mt-6">
    <button
        id="btnAbrir"
        type="button"
        class="bg-white text-green-800 px-6 py-3 rounded-lg font-bold hover:bg-green-100 transition"
    >
        Abrir Semana
    </button>
</div>

</div>

{{-- ========================================================= --}}{{-- MAPA --}}{{-- ========================================================= --}}

<div class="bg-white rounded-xl shadow-lg mt-8 overflow-hidden">

<div class="bg-green-800 text-white px-5 py-3">
    <h2 class="font-semibold">
        Mapa de Hacienda
    </h2>
</div>

<div class="border-b bg-gray-50 p-3 sm:p-4">

    {{-- ========================================================= --}}
    {{-- CONFIGURACIÓN DE PINCEL Y RAYADO --}}
    {{-- ========================================================= --}}

    <input id="opacidadLote" type="hidden" value="55">
    <input id="opacidadPincel" type="hidden" value="55">
    <input id="opacidadRayado" type="hidden" value="100">

    <details class="mt-3 rounded-xl border border-gray-200 bg-white">

        <summary class="flex cursor-pointer list-none items-center justify-between gap-3 px-3 py-3 text-sm font-bold text-gray-800">

            <span>
                ⚙️ Configuración de pincel y rayado
            </span>

            <span class="text-xs font-normal text-gray-500">
                Mostrar / ocultar
            </span>

        </summary>

        <div class="border-t border-gray-100 p-3">

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

                <div>

                    <div class="mb-2 flex items-center justify-between gap-3">

                        <label for="tamanoPincel" class="text-sm font-semibold text-gray-700">
                            Tamaño del pincel
                        </label>

                        <span id="textoTamanoPincel" class="min-w-[45px] text-right text-sm font-bold text-green-800">
                            8 px
                        </span>

                    </div>

                    <input
                        id="tamanoPincel"
                        type="range"
                        min="2"
                        max="40"
                        value="8"
                        class="w-full cursor-pointer accent-green-700"
                    >

                </div>

                <div>

                    <label class="mb-2 block text-sm font-semibold text-gray-700" for="direccionRayado">
                        Dirección del rayado
                    </label>

                    <select
                        id="direccionRayado"
                        class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-black"
                    >
                        <option value="-45">Diagonal /</option>
                        <option value="45">Diagonal \</option>
                        <option value="0">Vertical |</option>
                        <option value="90">Horizontal —</option>
                    </select>

                </div>

                <div>

                    <div class="mb-2 flex items-center justify-between gap-3">

                        <label class="text-sm font-semibold text-gray-700" for="separacionRayado">
                            Separación
                        </label>

                        <span id="textoSeparacionRayado" class="text-sm font-bold text-green-800">
                            9 px
                        </span>

                    </div>

                    <input
                        id="separacionRayado"
                        type="range"
                        min="6"
                        max="40"
                        value="9"
                        class="w-full cursor-pointer accent-green-700"
                    >

                </div>

                <div>

                    <div class="mb-2 flex items-center justify-between gap-3">

                        <label class="text-sm font-semibold text-gray-700" for="grosorRayado">
                            Grosor
                        </label>

                        <span id="textoGrosorRayado" class="text-sm font-bold text-green-800">
                            2 px
                        </span>

                    </div>

                    <input
                        id="grosorRayado"
                        type="range"
                        min="1"
                        max="10"
                        value="2"
                        class="w-full cursor-pointer accent-green-700"
                    >

                </div>

            </div>

        </div>

    </details>


    {{-- ========================================================= --}}
    {{-- PALANCAS COMPACTAS JUSTO ENCIMA DEL MAPA --}}
    {{-- ========================================================= --}}

    <div class="mt-3 rounded-xl border border-green-100 bg-white p-3">

        <div class="flex items-center justify-between gap-3">

            <div>

                <h3 class="text-sm font-bold text-gray-800 sm:text-base">
                    Palancas
                </h3>

                <p id="textoPalancas" class="text-[11px] leading-tight text-gray-500 sm:text-xs">
                    Seleccione una hacienda para mostrar sus palancas.
                </p>

            </div>

            {{--
                Se mantienen estos elementos ocultos para conservar
                exactamente la lógica JavaScript existente.
            --}}
            <div id="palancaSeleccionada" class="hidden">
                <span id="muestraColorPalanca"></span>
                <strong id="nombrePalancaSeleccionada"></strong>
            </div>

        </div>

        <div
            id="contenedorPalancas"
            class="mt-2 grid grid-cols-3 gap-2 sm:grid-cols-4 md:grid-cols-6"
        >

            <div class="col-span-full rounded-lg border border-dashed border-gray-300 px-3 py-3 text-center text-xs text-gray-500">
                Primero seleccione una hacienda.
            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- HERRAMIENTAS DEBAJO DE LAS PALANCAS --}}
        {{-- ========================================================= --}}

        <div class="mt-4 rounded-xl border border-gray-200 bg-gray-50 p-3">

            <div class="mb-2 flex items-center justify-between gap-3">

                <h3 class="text-sm font-bold text-gray-800 sm:text-base">
                    Herramientas
                </h3>

                <span class="text-xs text-gray-500">
                    Toque una opción
                </span>

            </div>

            <div class="grid grid-cols-2 gap-2 sm:grid-cols-3 lg:grid-cols-4">

                <button id="btnPintarLote" type="button"
                    class="boton-herramienta inline-flex min-h-[42px] items-center justify-center gap-2 rounded-lg border-2 border-transparent bg-blue-600 px-3 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                    <span class="text-base leading-none">🎨</span>
                    <span>Lote</span>
                </button>

                <button id="btnRayarLote" type="button"
                    class="boton-herramienta inline-flex min-h-[42px] items-center justify-center gap-2 rounded-lg border-2 border-transparent bg-pink-600 px-3 py-2 text-sm font-semibold text-white hover:bg-pink-700">
                    <span class="text-base leading-none">▨</span>
                    <span>Rayar lote</span>
                </button>

                <button id="btnRayarZona" type="button"
                    class="boton-herramienta inline-flex min-h-[42px] items-center justify-center gap-2 rounded-lg border-2 border-transparent bg-fuchsia-600 px-3 py-2 text-sm font-semibold text-white hover:bg-fuchsia-700">
                    <span class="text-base leading-none">✂️</span>
                    <span>Rayar zona</span>
                </button>

                <button id="btnPincel" type="button"
                    class="boton-herramienta inline-flex min-h-[42px] items-center justify-center gap-2 rounded-lg border-2 border-transparent bg-green-700 px-3 py-2 text-sm font-semibold text-white hover:bg-green-800">
                    <span class="text-base leading-none">🖌️</span>
                    <span>Pincel</span>
                </button>

                <button id="btnBorrador" type="button"
                    class="boton-herramienta inline-flex min-h-[42px] items-center justify-center gap-2 rounded-lg border-2 border-transparent bg-yellow-500 px-3 py-2 text-sm font-semibold text-white hover:bg-yellow-600">
                    <span class="text-base leading-none">🧹</span>
                    <span>Borrar</span>
                </button>

                <button id="btnLimpiarMapa" type="button"
                    class="inline-flex min-h-[42px] items-center justify-center gap-2 rounded-lg bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-700">
                    <span class="text-base leading-none">🗑️</span>
                    <span>Limpiar</span>
                </button>

                <button id="btnDeshacer" type="button"
                    class="inline-flex min-h-[42px] items-center justify-center gap-2 rounded-lg bg-gray-600 px-3 py-2 text-sm font-semibold text-white hover:bg-gray-700">
                    <span class="text-base leading-none">↩️</span>
                    <span>Deshacer</span>
                </button>

            </div>

        </div>


    </div>


    <div
        id="mensajeHerramienta"
        class="mt-3 rounded-lg bg-white px-3 py-2 text-xs leading-relaxed text-gray-600 sm:text-sm"
    >
        Seleccione una hacienda. Después use “Pintar Lote” y haga clic dentro del lote.
    </div>

</div>

<div class="p-4 sm:p-6">

    <div
        id="contenedorMapa"
        class="relative mx-auto w-full max-w-6xl overflow-hidden border rounded-lg bg-white"
        style="line-height:0; touch-action:pinch-zoom;"
    >
        <div
            id="superficieMapa"
            class="relative w-full origin-top-left"
            
        >
        {{-- IMAGEN BASE DEL MAPA --}}
        <img
            id="mapa"
            src=""
            class="relative block w-full h-auto select-none"
            style="z-index:1;"
            draggable="false"
            alt="Mapa de Hacienda"
        >

        {{-- RELLENO COMPLETO Y RAYADOS DE LOTES --}}
        <canvas
            id="canvasLotes"
            class="absolute inset-0 w-full h-full"
            style="z-index:2; pointer-events:none;"
        ></canvas>

        {{-- RAYADO PARCIAL REALIZADO CON EL DEDO --}}
        <canvas
            id="canvasRayadoZona"
            class="absolute inset-0 w-full h-full"
            style="z-index:3; pointer-events:none;"
        ></canvas>

        {{-- PINCEL Y BORRADOR --}}
        <canvas
            id="canvasDibujo"
            class="absolute inset-0 w-full h-full"
            style="z-index:4; touch-action:pinch-zoom; opacity:0.55;"
        ></canvas>

        {{--
            COPIA SUPERIOR DEL MAPA.

            Se coloca encima de los canvas usando multiply.
            Así las letras, nombres, bordes y divisiones negras
            permanecen visibles aunque se pinte con el pincel.
        --}}
        <img
            id="mapaSuperior"
            src=""
            class="absolute inset-0 block w-full h-full select-none pointer-events-none"
            style="
                z-index:5;
                object-fit:fill;
                mix-blend-mode:multiply;
            "
            draggable="false"
            alt=""
            aria-hidden="true"
        >

        {{-- Vista previa de los puntos de la zona parcial. --}}
        <canvas
            id="canvasZona"
            class="absolute inset-0 w-full h-full pointer-events-none"
            style="z-index:6;"
        ></canvas>
        </div>
    </div>

</div>

</div>

{{-- ========================================================= --}}{{-- MATRIZ --}}{{-- ========================================================= --}}

<div
    id="contenedorMatriz"
    class="hidden bg-white rounded-xl shadow-lg mt-8 p-4 sm:p-6 overflow-hidden"
></div>

</div>

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | DATOS ENTREGADOS POR LARAVEL
    |--------------------------------------------------------------------------
    */

    const haciendas = {!! $haciendas->toJson(
        JSON_HEX_TAG |
        JSON_HEX_APOS |
        JSON_HEX_AMP |
        JSON_HEX_QUOT
    ) !!};


    /*
    |--------------------------------------------------------------------------
    | ELEMENTOS
    |--------------------------------------------------------------------------
    */

    const hacienda = document.getElementById('hacienda');
    const semana = document.getElementById('semana');
    const fecha = document.getElementById('fecha');
    const mapa = document.getElementById('mapa');
    const contenedorMapa = document.getElementById('contenedorMapa');
    const superficieMapa = document.getElementById('superficieMapa');
    const mapaSuperior = document.getElementById('mapaSuperior');
    const canvasLotes = document.getElementById('canvasLotes');
    const canvasRayadoZona = document.getElementById('canvasRayadoZona');
    const canvasDibujo = document.getElementById('canvasDibujo');
    const canvasZona = document.getElementById('canvasZona');
    const btnAbrir = document.getElementById('btnAbrir');
    const matriz = document.getElementById('contenedorMatriz');

    const contenedorPalancas =
        document.getElementById('contenedorPalancas');

    const textoPalancas =
        document.getElementById('textoPalancas');

    const palancaSeleccionada =
        document.getElementById('palancaSeleccionada');

    const muestraColorPalanca =
        document.getElementById('muestraColorPalanca');

    const nombrePalancaSeleccionada =
        document.getElementById('nombrePalancaSeleccionada');

    const opacidadLote =
        document.getElementById('opacidadLote');

    const opacidadPincel =
        document.getElementById('opacidadPincel');

    const tamanoPincel =
        document.getElementById('tamanoPincel');

    const textoTamanoPincel =
        document.getElementById('textoTamanoPincel');

    const direccionRayado = document.getElementById('direccionRayado');
    const separacionRayado = document.getElementById('separacionRayado');
    const textoSeparacionRayado = document.getElementById('textoSeparacionRayado');
    const grosorRayado = document.getElementById('grosorRayado');
    const textoGrosorRayado = document.getElementById('textoGrosorRayado');
    const opacidadRayado = document.getElementById('opacidadRayado');

    const btnPintarLote = document.getElementById('btnPintarLote');
    const btnRayarLote = document.getElementById('btnRayarLote');
    const btnRayarZona = document.getElementById('btnRayarZona');
    const btnPincel = document.getElementById('btnPincel');
    const btnBorrador = document.getElementById('btnBorrador');
    const btnDeshacer = document.getElementById('btnDeshacer');
    const btnLimpiarMapa = document.getElementById('btnLimpiarMapa');
    const mensajeHerramienta = document.getElementById('mensajeHerramienta');

    const ctxLotes = canvasLotes.getContext('2d');
    const ctxRayadoZona = canvasRayadoZona.getContext('2d');
    const ctxDibujo = canvasDibujo.getContext('2d');
    const ctxZona = canvasZona.getContext('2d');


    /*
    |--------------------------------------------------------------------------
    | ESTADO
    |--------------------------------------------------------------------------
    */

    let haciendaActual = null;
    let lotesActuales = {};

    let herramientaActual = 'pintarLote';

    /*
    |--------------------------------------------------------------------------
    | PALANCA Y COLOR ACTUALES
    |--------------------------------------------------------------------------
    |
    | El color se sigue utilizando internamente igual que antes.
    | La única diferencia es que ahora se selecciona mediante una palanca.
    |
    */

    let colorActual = '#FF0000';
    let palancaActual = null;


    /*
    |--------------------------------------------------------------------------
    | COLORES ESTABLECIDOS POR HACIENDA
    |--------------------------------------------------------------------------
    */

    const palancasPorHacienda = {

        maria: [
            {
                codigo: 'P1',
                nombre: 'Café',
                color: '#8B4513'
            },
            {
                codigo: 'P2',
                nombre: 'Verde',
                color: '#2E7D32'
            },
            {
                codigo: 'P3',
                nombre: 'Amarillo',
                color: '#FFD700'
            },
            {
                codigo: 'P4',
                nombre: 'Azul',
                color: '#1E88E5'
            },
            {
                codigo: 'P5',
                nombre: 'Rojo',
                color: '#E53935'
            }
        ],

        domenica: [
            {
                codigo: 'P1',
                nombre: 'Naranja',
                color: '#FF8C00'
            },
            {
                codigo: 'P2',
                nombre: 'Rojo',
                color: '#E53935'
            },
            {
                codigo: 'P3',
                nombre: 'Verde',
                color: '#2E7D32'
            },
            {
                codigo: 'P4',
                nombre: 'Azul',
                color: '#1E88E5'
            },
            {
                codigo: 'P5',
                nombre: 'Café',
                color: '#8B4513'
            },
            {
                codigo: 'P6',
                nombre: 'Morado',
                color: '#8000FF'
            }
        ]
    };

    let dibujando = false;
    let inicioX = 0;
    let inicioY = 0;
    let ultimoX = 0;
    let ultimoY = 0;

    let historialAcciones = [];
    let coloresLotes = {};
    let rayadosLotes = {};
    let zonasPintadas = [];
    let zonasRayadas = [];
    let puntosZonaActual = [];
    let loteZonaActual = null;
    let tipoZonaParcial = null;

    /*
    | El primer clic del pincel selecciona un lote.
    | Todo el trazo permanece recortado dentro de ese polígono
    | hasta que se suelta el mouse o el dedo.
    */
    let lotePincelActual = null;
    let loteRayadoZonaActual = null;

    /*
    | Control táctil: dos dedos quedan reservados para el zoom nativo
    | de la página. Un dedo se utiliza únicamente para la herramienta.
    */
    let toquePendiente = null;
    let gestoMultitactilActivo = false;
    const UMBRAL_MOVIMIENTO_TOQUE = 6;


    /*
    |--------------------------------------------------------------------------
    | OBTENER HACIENDA
    |--------------------------------------------------------------------------
    */

    function buscarHaciendaSeleccionada() {
        return haciendas.find(function (item) {
            return String(item.id) === String(hacienda.value);
        }) || null;
    }



    /*
    |--------------------------------------------------------------------------
    | IDENTIFICAR EL GRUPO DE PALANCAS
    |--------------------------------------------------------------------------
    */

    function obtenerGrupoPalancas() {

        if (!haciendaActual) {
            return null;
        }

        const nombre =
            String(
                haciendaActual.nombre || ''
            )
            .trim()
            .toUpperCase();

        if (nombre.includes('DOMENICA')) {
            return 'domenica';
        }

        if (nombre.includes('MARIA')) {
            return 'maria';
        }

        return null;
    }


    /*
    |--------------------------------------------------------------------------
    | MARCAR VISUALMENTE LA PALANCA ACTIVA
    |--------------------------------------------------------------------------
    */

    function actualizarPalancaActiva() {

        document
            .querySelectorAll('.boton-palanca')
            .forEach(function (boton) {

                const activa =
                    boton.dataset.codigo ===
                    palancaActual;

                boton.classList.toggle(
                    'ring-4',
                    activa
                );

                boton.classList.toggle(
                    'ring-green-300',
                    activa
                );

                boton.classList.toggle(
                    'border-green-800',
                    activa
                );

                boton.classList.toggle(
                    'shadow-md',
                    activa
                );

                boton.setAttribute(
                    'aria-pressed',
                    activa ? 'true' : 'false'
                );
            });


        if (!palancaActual) {

            palancaSeleccionada.classList.add(
                'hidden'
            );

            palancaSeleccionada.classList.remove(
                'flex'
            );

            return;
        }


        palancaSeleccionada.classList.remove(
            'hidden'
        );

        palancaSeleccionada.classList.add(
            'flex'
        );

        muestraColorPalanca.style.backgroundColor =
            colorActual;

        nombrePalancaSeleccionada.textContent =
            palancaActual;
    }


    /*
    |--------------------------------------------------------------------------
    | SELECCIONAR UNA PALANCA
    |--------------------------------------------------------------------------
    */

    function seleccionarPalanca(palanca) {

        if (!palanca) {
            return;
        }

        palancaActual =
            String(palanca.codigo);

        colorActual =
            String(palanca.color);

        actualizarPalancaActiva();

        mensajeHerramienta.textContent =
            palancaActual +
            ' seleccionada (' +
            palanca.nombre +
            '). Puede usarla para pintar, rayar o dibujar con pincel.';
    }


    /*
    |--------------------------------------------------------------------------
    | DIBUJAR LAS PALANCAS DE LA HACIENDA
    |--------------------------------------------------------------------------
    */

    function renderizarPalancas() {

        const grupo =
            obtenerGrupoPalancas();

        contenedorPalancas.innerHTML = '';

        palancaActual = null;


        if (
            !grupo ||
            !Array.isArray(
                palancasPorHacienda[grupo]
            )
        ) {

            textoPalancas.textContent =
                haciendaActual
                    ? 'Esta hacienda no tiene palancas configuradas.'
                    : 'Seleccione una hacienda para mostrar sus palancas.';

            contenedorPalancas.innerHTML =
                '<div class="col-span-full rounded-lg border border-dashed border-gray-300 px-4 py-5 text-center text-sm text-gray-500">' +
                    (
                        haciendaActual
                            ? 'No hay palancas configuradas para esta hacienda.'
                            : 'Primero seleccione una hacienda.'
                    ) +
                '</div>';

            actualizarPalancaActiva();

            return;
        }


        const palancas =
            palancasPorHacienda[grupo];

        textoPalancas.textContent =
            grupo === 'domenica'
                ? 'Palancas establecidas para DOMENICA.'
                : 'Palancas establecidas para MARIA MARIA.';


        palancas.forEach(function (palanca) {

            const boton =
                document.createElement('button');

            boton.type = 'button';

            boton.className =
                'boton-palanca flex min-h-[42px] w-full items-center justify-center gap-2 rounded-lg border-2 border-gray-200 bg-white px-2 py-1.5 text-center transition hover:border-green-500 hover:shadow-sm focus:outline-none focus:ring-4 focus:ring-green-200';

            boton.dataset.codigo =
                palanca.codigo;

            boton.dataset.color =
                palanca.color;

            boton.setAttribute(
                'aria-label',
                palanca.codigo +
                ', color ' +
                palanca.nombre
            );

            boton.setAttribute(
                'aria-pressed',
                'false'
            );


            const muestra =
                document.createElement('span');

            muestra.className =
                'h-5 w-5 flex-none rounded-md border border-black/10 shadow-sm sm:h-6 sm:w-6';

            muestra.style.backgroundColor =
                palanca.color;


            const textos =
                document.createElement('span');

            textos.className =
                'min-w-0 leading-none';


            const codigo =
                document.createElement('strong');

            codigo.className =
                'block text-xs font-bold text-gray-900 sm:text-sm';

            codigo.textContent =
                palanca.codigo;


            const nombre =
                document.createElement('small');

            nombre.className =
                'hidden';

            nombre.textContent =
                palanca.nombre;


            textos.appendChild(codigo);
            textos.appendChild(nombre);

            boton.appendChild(muestra);
            boton.appendChild(textos);

            boton.addEventListener(
                'click',
                function () {
                    seleccionarPalanca(palanca);
                }
            );

            contenedorPalancas.appendChild(
                boton
            );
        });


        /*
        | Se selecciona P1 automáticamente para que el usuario pueda
        | empezar a trabajar inmediatamente después de elegir hacienda.
        */
        seleccionarPalanca(
            palancas[0]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | NORMALIZAR COORDENADAS GUARDADAS
    |--------------------------------------------------------------------------
    |
    | El configurador guardó puntos con esta forma:
    | { x: 34.5000, y: 21.3000 }
    |
    | Son porcentajes de 0 a 100. Aquí se convierten a 0–1 para
    | que el polígono se adapte al tamaño visible de la imagen.
    |
    */

    function normalizarCoordenadas(coordenadas) {

        if (!Array.isArray(coordenadas)) {
            return [];
        }

        return coordenadas
            .map(function (punto) {

                if (
                    punto &&
                    typeof punto === 'object' &&
                    !Array.isArray(punto) &&
                    punto.x !== undefined &&
                    punto.y !== undefined
                ) {
                    return [
                        Number(punto.x) / 100,
                        Number(punto.y) / 100
                    ];
                }

                if (Array.isArray(punto) && punto.length >= 2) {

                    let x = Number(punto[0]);
                    let y = Number(punto[1]);

                    if (x > 1 || y > 1) {
                        x = x / 100;
                        y = y / 100;
                    }

                    return [x, y];
                }

                return null;
            })
            .filter(function (punto) {
                return punto &&
                    Number.isFinite(punto[0]) &&
                    Number.isFinite(punto[1]);
            });
    }


    /*
    |--------------------------------------------------------------------------
    | CONSTRUIR POLÍGONOS DESDE LA BASE DE DATOS
    |--------------------------------------------------------------------------
    */

    function cargarLotesDesdeBaseDatos() {

        lotesActuales = {};

        if (!haciendaActual || !Array.isArray(haciendaActual.lotes)) {
            return;
        }

        haciendaActual.lotes.forEach(function (lote) {

            const puntos = normalizarCoordenadas(lote.coordenadas);

            if (puntos.length < 3) {
                return;
            }

            lotesActuales[String(lote.id)] = {
                id: lote.id,
                nombre: lote.nombre,
                puntos: puntos
            };
        });

        const cantidad = Object.keys(lotesActuales).length;

        if (cantidad === 0) {
            mensajeHerramienta.textContent =
                'Esta hacienda no tiene polígonos válidos guardados en la base de datos.';
        } else {
            mensajeHerramienta.textContent =
                cantidad +
                ' lote(s) cargado(s). Use “Pintar Lote” y haga clic dentro de uno.';
        }
    }


    /*
    |--------------------------------------------------------------------------
    | MAPA SEGÚN HACIENDA
    |--------------------------------------------------------------------------
    */

    function cargarImagenHacienda() {

        if (!haciendaActual) {
            mapa.removeAttribute('src');
            mapaSuperior.removeAttribute('src');
            return;
        }

        const nombre = String(haciendaActual.nombre || '').toUpperCase();

        let rutaMapa = '';

        if (nombre.includes('DOMENICA')) {
            rutaMapa = "{{ asset('mapas/domenica.png') }}";
        } else if (nombre.includes('MARIA')) {
            rutaMapa = "{{ asset('mapas/maria_maria.png') }}";
        } else {
            mapa.removeAttribute('src');
            mapaSuperior.removeAttribute('src');

            mensajeHerramienta.textContent =
                'No se encontró una imagen configurada para esta hacienda.';

            return;
        }

        /*
        | Las dos imágenes usan exactamente la misma ruta:
        | una funciona como base y la otra protege visualmente
        | los textos y límites del mapa.
        */
        mapa.src = rutaMapa;
        mapaSuperior.src = rutaMapa;
    }


    /*
    |--------------------------------------------------------------------------
    | AJUSTAR CANVAS
    |--------------------------------------------------------------------------
    */

    function ajustarCanvas() {

        const ancho = mapa.clientWidth;
        const alto = mapa.clientHeight;

        if (ancho <= 0 || alto <= 0) {
            return;
        }

        let imagenAnterior = null;
        let rayadoZonaAnterior = null;

        if (canvasDibujo.width > 0 && canvasDibujo.height > 0) {
            imagenAnterior = document.createElement('canvas');
            imagenAnterior.width = canvasDibujo.width;
            imagenAnterior.height = canvasDibujo.height;

            imagenAnterior
                .getContext('2d')
                .drawImage(canvasDibujo, 0, 0);
        }

        if (canvasRayadoZona.width > 0 && canvasRayadoZona.height > 0) {
            rayadoZonaAnterior = document.createElement('canvas');
            rayadoZonaAnterior.width = canvasRayadoZona.width;
            rayadoZonaAnterior.height = canvasRayadoZona.height;

            rayadoZonaAnterior
                .getContext('2d')
                .drawImage(canvasRayadoZona, 0, 0);
        }

        canvasLotes.width = ancho;
        canvasLotes.height = alto;

        canvasRayadoZona.width = ancho;
        canvasRayadoZona.height = alto;

        canvasDibujo.width = ancho;
        canvasDibujo.height = alto;

        canvasZona.width = ancho;
        canvasZona.height = alto;

        if (rayadoZonaAnterior) {
            ctxRayadoZona.drawImage(
                rayadoZonaAnterior,
                0,
                0,
                rayadoZonaAnterior.width,
                rayadoZonaAnterior.height,
                0,
                0,
                ancho,
                alto
            );
        }

        if (imagenAnterior) {
            ctxDibujo.drawImage(
                imagenAnterior,
                0,
                0,
                imagenAnterior.width,
                imagenAnterior.height,
                0,
                0,
                ancho,
                alto
            );
        }

        dibujarColoresLotes();
        dibujarVistaPreviaZona();
    }


    /*
    |--------------------------------------------------------------------------
    | DIBUJAR POLÍGONO COMPLETO
    |--------------------------------------------------------------------------
    */

    function dibujarPoligono(ctx, puntos, color, alpha) {

        if (!Array.isArray(puntos) || puntos.length < 3) {
            return;
        }

        ctx.save();
        ctx.globalAlpha = alpha;
        ctx.fillStyle = color;
        ctx.beginPath();

        puntos.forEach(function (punto, indice) {

            const x = punto[0] * canvasLotes.width;
            const y = punto[1] * canvasLotes.height;

            if (indice === 0) {
                ctx.moveTo(x, y);
            } else {
                ctx.lineTo(x, y);
            }
        });

        ctx.closePath();
        ctx.fill();
        ctx.restore();
    }


    /*
    |--------------------------------------------------------------------------
    | RAYAR UN POLÍGONO AUTOMÁTICAMENTE
    |--------------------------------------------------------------------------
    */

    function rayarPoligono(ctx, puntos, configuracion) {

    if (
        !Array.isArray(puntos) ||
        puntos.length < 3
    ) {
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Compatibilidad con semanas antiguas
    |--------------------------------------------------------------------------
    |
    | Algunos mapas guardados anteriormente contienen lotes_rayados con
    | valores null. Se crea una configuración segura para evitar intentar
    | leer propiedades como "angulo" desde null.
    |
    */

    const configuracionSegura =
        configuracion &&
        typeof configuracion === 'object' &&
        !Array.isArray(configuracion)
            ? configuracion
            : {};

    const angulo =
        Number(
            configuracionSegura.angulo ?? -45
        ) *
        Math.PI /
        180;

    const separacion =
        Math.max(
            4,
            Number(
                configuracionSegura.separacion ?? 9
            )
        );

    const grosor =
        Math.max(
            1,
            Number(
                configuracionSegura.grosor ?? 2
            )
        );

    const alpha =
        Math.min(
            1,
            Math.max(
                0.1,
                Number(
                    configuracionSegura.opacidad ?? 100
                ) / 100
            )
        );

    const color =
        configuracionSegura.color ||
        '#FF0000';

    const diagonal =
        Math.sqrt(
            canvasLotes.width ** 2 +
            canvasLotes.height ** 2
        ) * 1.5;

    ctx.save();

    /*
    |--------------------------------------------------------------------------
    | Recortar las rayas dentro del polígono
    |--------------------------------------------------------------------------
    */

    ctx.beginPath();

    puntos.forEach(function (punto, indice) {

        const x =
            punto[0] *
            canvasLotes.width;

        const y =
            punto[1] *
            canvasLotes.height;

        if (indice === 0) {
            ctx.moveTo(x, y);
        } else {
            ctx.lineTo(x, y);
        }
    });

    ctx.closePath();
    ctx.clip();

    ctx.globalAlpha = alpha;
    ctx.strokeStyle = color;
    ctx.lineWidth = grosor;
    ctx.lineCap = 'round';

    ctx.translate(
        canvasLotes.width / 2,
        canvasLotes.height / 2
    );

    ctx.rotate(angulo);

    for (
        let x = -diagonal;
        x <= diagonal;
        x += separacion
    ) {
        ctx.beginPath();
        ctx.moveTo(x, -diagonal);
        ctx.lineTo(x, diagonal);
        ctx.stroke();
    }

    ctx.restore();
}


    /*
    |--------------------------------------------------------------------------
    | RAYAR SOLO UNA ZONA PARCIAL DEL LOTE
    |--------------------------------------------------------------------------
    |
    | Se aplica un recorte doble:
    | 1. El límite real del lote.
    | 2. La zona marcada por el usuario.
    |
    */

    function pintarZonaParcial(ctx, lote, zona) {

        if (
            !lote ||
            !Array.isArray(lote.puntos) ||
            lote.puntos.length < 3 ||
            !Array.isArray(zona.puntos) ||
            zona.puntos.length < 3
        ) {
            return;
        }

        ctx.save();

        // Recorte al lote completo
        ctx.beginPath();

        lote.puntos.forEach(function (punto, indice) {

            const x = punto[0] * canvasLotes.width;
            const y = punto[1] * canvasLotes.height;

            if (indice === 0) {
                ctx.moveTo(x, y);
            } else {
                ctx.lineTo(x, y);
            }
        });

        ctx.closePath();
        ctx.clip();

        // Recorte a la zona parcial seleccionada
        ctx.beginPath();

        zona.puntos.forEach(function (punto, indice) {

            const x = punto[0] * canvasLotes.width;
            const y = punto[1] * canvasLotes.height;

            if (indice === 0) {
                ctx.moveTo(x, y);
            } else {
                ctx.lineTo(x, y);
            }
        });

        ctx.closePath();
        ctx.clip();

        ctx.globalAlpha =
            Math.min(
                1,
                Math.max(
                    0.1,
                    Number(zona.opacidad ?? 45) / 100
                )
            );

        ctx.fillStyle =
            zona.color || '#FF0000';

        ctx.fillRect(
            0,
            0,
            canvasLotes.width,
            canvasLotes.height
        );

        ctx.restore();
    }


    function rayarZonaParcial(ctx, lote, zona) {

        if (
            !lote ||
            !Array.isArray(lote.puntos) ||
            lote.puntos.length < 3 ||
            !Array.isArray(zona.puntos) ||
            zona.puntos.length < 3
        ) {
            return;
        }

        ctx.save();

        /*
        | Primer recorte: polígono completo del lote.
        */
        ctx.beginPath();

        lote.puntos.forEach(function (punto, indice) {

            const x = punto[0] * canvasLotes.width;
            const y = punto[1] * canvasLotes.height;

            if (indice === 0) {
                ctx.moveTo(x, y);
            } else {
                ctx.lineTo(x, y);
            }
        });

        ctx.closePath();
        ctx.clip();

        /*
        | Segundo recorte: zona parcial marcada.
        */
        ctx.beginPath();

        zona.puntos.forEach(function (punto, indice) {

            const x = punto[0] * canvasLotes.width;
            const y = punto[1] * canvasLotes.height;

            if (indice === 0) {
                ctx.moveTo(x, y);
            } else {
                ctx.lineTo(x, y);
            }
        });

        ctx.closePath();
        ctx.clip();

        const angulo =
            Number(zona.angulo ?? -45) *
            Math.PI /
            180;

        const separacion =
            Math.max(4, Number(zona.separacion ?? 9));

        const grosor =
            Math.max(1, Number(zona.grosor ?? 2));

        const alpha =
            Math.min(
                1,
                Math.max(
                    0.1,
                    Number(zona.opacidad ?? 100) / 100
                )
            );

        const diagonal =
            Math.sqrt(
                canvasLotes.width ** 2 +
                canvasLotes.height ** 2
            ) * 1.5;

        ctx.globalAlpha = alpha;
        ctx.strokeStyle = zona.color || '#FF0000';
        ctx.lineWidth = grosor;
        ctx.lineCap = 'round';

        ctx.translate(
            canvasLotes.width / 2,
            canvasLotes.height / 2
        );

        ctx.rotate(angulo);

        for (
            let x = -diagonal;
            x <= diagonal;
            x += separacion
        ) {
            ctx.beginPath();
            ctx.moveTo(x, -diagonal);
            ctx.lineTo(x, diagonal);
            ctx.stroke();
        }

        ctx.restore();
    }


    /*
    |--------------------------------------------------------------------------
    | VISTA PREVIA DE LA ZONA PARCIAL
    |--------------------------------------------------------------------------
    */

    function dibujarVistaPreviaZona() {

        ctxZona.clearRect(
            0,
            0,
            canvasZona.width,
            canvasZona.height
        );

        if (puntosZonaActual.length === 0) {
            return;
        }

        ctxZona.save();
        ctxZona.strokeStyle = '#dc2626';
        ctxZona.fillStyle = 'rgba(220, 38, 38, 0.18)';
        ctxZona.lineWidth = 3;
        ctxZona.setLineDash([8, 6]);
        ctxZona.beginPath();

        puntosZonaActual.forEach(function (punto, indice) {

            const x = punto[0] * canvasZona.width;
            const y = punto[1] * canvasZona.height;

            if (indice === 0) {
                ctxZona.moveTo(x, y);
            } else {
                ctxZona.lineTo(x, y);
            }
        });

        if (puntosZonaActual.length >= 3) {
            ctxZona.closePath();
            ctxZona.fill();
        }

        ctxZona.stroke();
        ctxZona.setLineDash([]);

        puntosZonaActual.forEach(function (punto, indice) {

            const x = punto[0] * canvasZona.width;
            const y = punto[1] * canvasZona.height;

            ctxZona.beginPath();
            ctxZona.arc(x, y, 3, 0, Math.PI * 2);
            ctxZona.fillStyle = '#dc2626';
            ctxZona.fill();
            ctxZona.strokeStyle = '#ffffff';
            ctxZona.lineWidth = 1;
            ctxZona.stroke();

            ctxZona.fillStyle = '#111827';
            ctxZona.font = 'bold 10px Arial';
            ctxZona.textAlign = 'center';
            ctxZona.fillText(indice + 1, x, y - 7);
        });

        ctxZona.restore();
    }


    /*
    |--------------------------------------------------------------------------
    | CANCELAR SELECCIÓN DE ZONA
    |--------------------------------------------------------------------------
    */

    function cancelarZonaParcial(mensaje = null) {

        puntosZonaActual = [];
        loteZonaActual = null;

        ctxZona.clearRect(
            0,
            0,
            canvasZona.width,
            canvasZona.height
        );

        if (mensaje) {
            mensajeHerramienta.textContent = mensaje;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | VOLVER A DIBUJAR LOS LOTES COLOREADOS
    |--------------------------------------------------------------------------
    */

    function dibujarColoresLotes() {

        ctxLotes.clearRect(
            0,
            0,
            canvasLotes.width,
            canvasLotes.height
        );

        const alpha = Number(opacidadLote.value) / 100;

        Object.keys(coloresLotes).forEach(function (loteId) {

            const lote = lotesActuales[loteId];

            if (!lote) {
                return;
            }

            dibujarPoligono(
                ctxLotes,
                lote.puntos,
                coloresLotes[loteId],
                alpha
            );
        });

        /*
        | Las rayas se dibujan después del color de fondo.
        */
        Object.keys(rayadosLotes).forEach(function (loteId) {

            const lote = lotesActuales[loteId];

            if (!lote) {
                return;
            }

            rayarPoligono(
                ctxLotes,
                lote.puntos,
                rayadosLotes[loteId]
            );
        });

        /*
        | Dibujar las zonas pintadas parcialmente.
        */
        zonasPintadas.forEach(function (zona) {

            const lote =
                lotesActuales[String(zona.lote_id)];

            if (!lote) {
                return;
            }

            pintarZonaParcial(
                ctxLotes,
                lote,
                zona
            );
        });

        /*
        | Dibujar las zonas rayadas parcialmente.
        */
        zonasRayadas.forEach(function (zona) {

            const lote =
                lotesActuales[String(zona.lote_id)];

            if (!lote) {
                return;
            }

            rayarZonaParcial(
                ctxLotes,
                lote,
                zona
            );
        });
    }


    /*
    |--------------------------------------------------------------------------
    | POSICIÓN DEL MOUSE
    |--------------------------------------------------------------------------
    */

    function obtenerPosicion(event, canvas) {

        const rect = canvas.getBoundingClientRect();

        const clientX =
            event.touches && event.touches.length
                ? event.touches[0].clientX
                : event.clientX;

        const clientY =
            event.touches && event.touches.length
                ? event.touches[0].clientY
                : event.clientY;

        return {
            x:
                (clientX - rect.left) *
                (canvas.width / rect.width),

            y:
                (clientY - rect.top) *
                (canvas.height / rect.height)
        };
    }


    /*
    |--------------------------------------------------------------------------
    | PUNTO DENTRO DE POLÍGONO
    |--------------------------------------------------------------------------
    */

    function puntoDentroPoligono(x, y, puntos) {

        let dentro = false;

        for (
            let i = 0, j = puntos.length - 1;
            i < puntos.length;
            j = i++
        ) {
            const xi = puntos[i][0];
            const yi = puntos[i][1];
            const xj = puntos[j][0];
            const yj = puntos[j][1];

            const cruza =
                ((yi > y) !== (yj > y)) &&
                (
                    x <
                    ((xj - xi) * (y - yi)) /
                    ((yj - yi) || Number.EPSILON) +
                    xi
                );

            if (cruza) {
                dentro = !dentro;
            }
        }

        return dentro;
    }


    /*
    |--------------------------------------------------------------------------
    | IDENTIFICAR LOTE PULSADO
    |--------------------------------------------------------------------------
    */

    function buscarLote(posicion) {

        if (
            canvasDibujo.width <= 0 ||
            canvasDibujo.height <= 0
        ) {
            return null;
        }

        const x = posicion.x / canvasDibujo.width;
        const y = posicion.y / canvasDibujo.height;

        for (const loteId in lotesActuales) {

            const lote = lotesActuales[loteId];

            if (puntoDentroPoligono(x, y, lote.puntos)) {
                return lote;
            }
        }

        return null;
    }


    /*
    |--------------------------------------------------------------------------
    | CREAR RUTA DEL LOTE PARA LIMITAR EL PINCEL
    |--------------------------------------------------------------------------
    |
    | Las coordenadas de los lotes están normalizadas entre 0 y 1.
    | Esta función las transforma al tamaño real del canvas y crea
    | una ruta cerrada que después se utiliza con ctx.clip().
    |
    */

    function crearRutaLoteEnCanvas(ctx, lote, canvas) {

        if (
            !lote ||
            !Array.isArray(lote.puntos) ||
            lote.puntos.length < 3 ||
            canvas.width <= 0 ||
            canvas.height <= 0
        ) {
            return false;
        }

        ctx.beginPath();

        lote.puntos.forEach(function (punto, indice) {

            const x =
                Number(punto[0]) *
                canvas.width;

            const y =
                Number(punto[1]) *
                canvas.height;

            if (indice === 0) {
                ctx.moveTo(x, y);
            } else {
                ctx.lineTo(x, y);
            }
        });

        ctx.closePath();

        return true;
    }


    /*
    |--------------------------------------------------------------------------
    | COLOR Y OPACIDAD
    |--------------------------------------------------------------------------
    */


    tamanoPincel.addEventListener('input', function () {
        textoTamanoPincel.textContent =
            this.value + ' px';
    });

    separacionRayado.addEventListener('input', function () {
        textoSeparacionRayado.textContent = this.value + ' px';
    });

    grosorRayado.addEventListener('input', function () {
        textoGrosorRayado.textContent = this.value + ' px';
    });



    /*
    |--------------------------------------------------------------------------
    | HERRAMIENTAS
    |--------------------------------------------------------------------------
    */

    function actualizarHerramientaActiva() {

        document
            .querySelectorAll('.boton-herramienta')
            .forEach(function (boton) {

                const activa =
                    boton.id === ({
                        pintarLote: 'btnPintarLote',
                        rayarLote: 'btnRayarLote',
                        rayarZona: 'btnRayarZona',
                        pincel: 'btnPincel',
                        borrador: 'btnBorrador'
                    })[herramientaActual];

                boton.classList.toggle('ring-4', activa);
                boton.classList.toggle('ring-green-300', activa);
                boton.classList.toggle('border-green-800', activa);
                boton.classList.toggle('shadow-md', activa);

                boton.setAttribute(
                    'aria-pressed',
                    activa ? 'true' : 'false'
                );
            });
    }


    function activarHerramienta(herramienta) {

        herramientaActual = herramienta;

        actualizarHerramientaActiva();

        const mensajes = {
            pintarLote:
                'Haga clic dentro de un lote para rellenar todo su polígono.',
            rayarLote:
                'Haga clic dentro de un lote para generar rayas paralelas automáticamente.',
            rayarZona:
                'Arrastre el dedo dentro de un lote para rayar solamente la parte recorrida.',
            pincel:
                'Haga clic dentro de un lote y arrastre. El pincel no podrá salir de sus límites.',
            borrador:
                'Arrastre sobre una raya para borrarla.'
        };

        mensajeHerramienta.textContent =
            mensajes[herramienta] ||
            'Seleccione una herramienta.';
    }

    btnPintarLote.addEventListener('click', function () {
        cancelarZonaParcial();
        activarHerramienta('pintarLote');
    });

    btnRayarLote.addEventListener('click', function () {
        cancelarZonaParcial();
        activarHerramienta('rayarLote');
    });


    btnRayarZona.addEventListener('click', function () {

        cancelarZonaParcial();
        activarHerramienta('rayarZona');

        mensajeHerramienta.textContent =
            'Arrastre el dedo dentro de un lote para rayar solamente la parte recorrida.';
    });

    btnPincel.addEventListener('click', function () {
        cancelarZonaParcial();
        activarHerramienta('pincel');
    });


    btnBorrador.addEventListener('click', function () {
        cancelarZonaParcial();
        activarHerramienta('borrador');
    });

    actualizarHerramientaActiva();


    /*
    |--------------------------------------------------------------------------
    | CONTROLES DE LA ZONA PARCIAL
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | HISTORIAL UNIVERSAL
    |--------------------------------------------------------------------------
    |
    | Guarda todos los tipos de marcas:
    | - lotes pintados completos;
    | - lotes rayados completos;
    | - zonas pintadas;
    | - zonas rayadas;
    | - pincel y líneas del canvas.
    |--------------------------------------------------------------------------
    */

    function copiarCanvasDibujo() {

        const copia =
            document.createElement('canvas');

        copia.width =
            canvasDibujo.width;

        copia.height =
            canvasDibujo.height;

        copia
            .getContext('2d')
            .drawImage(
                canvasDibujo,
                0,
                0
            );

        return copia;
    }



    function copiarCanvasRayadoZona() {

        const copia =
            document.createElement('canvas');

        copia.width =
            canvasRayadoZona.width;

        copia.height =
            canvasRayadoZona.height;

        copia
            .getContext('2d')
            .drawImage(
                canvasRayadoZona,
                0,
                0
            );

        return copia;
    }


    function clonarDatos(datos) {

        return JSON.parse(
            JSON.stringify(datos)
        );
    }


    function guardarEstado() {

        historialAcciones.push({

            coloresLotes:
                clonarDatos(coloresLotes),

            rayadosLotes:
                clonarDatos(rayadosLotes),

            zonasPintadas:
                clonarDatos(zonasPintadas),

            zonasRayadas:
                clonarDatos(zonasRayadas),

            canvas:
                copiarCanvasDibujo(),

            canvasRayadoZona:
                copiarCanvasRayadoZona()

        });


        if (
            historialAcciones.length > 50
        ) {
            historialAcciones.shift();
        }
    }


    function restaurarEstado(estado) {

        coloresLotes =
            clonarDatos(
                estado.coloresLotes || {}
            );

        rayadosLotes =
            clonarDatos(
                estado.rayadosLotes || {}
            );

        zonasPintadas =
            clonarDatos(
                estado.zonasPintadas || []
            );

        zonasRayadas =
            clonarDatos(
                estado.zonasRayadas || []
            );


        ctxRayadoZona.clearRect(
            0,
            0,
            canvasRayadoZona.width,
            canvasRayadoZona.height
        );

        if (estado.canvasRayadoZona) {
            ctxRayadoZona.drawImage(
                estado.canvasRayadoZona,
                0,
                0,
                estado.canvasRayadoZona.width,
                estado.canvasRayadoZona.height,
                0,
                0,
                canvasRayadoZona.width,
                canvasRayadoZona.height
            );
        }

        ctxDibujo.clearRect(
            0,
            0,
            canvasDibujo.width,
            canvasDibujo.height
        );


        if (estado.canvas) {

            ctxDibujo.drawImage(
                estado.canvas,
                0,
                0,
                estado.canvas.width,
                estado.canvas.height,
                0,
                0,
                canvasDibujo.width,
                canvasDibujo.height
            );
        }


        cancelarZonaParcial();

        dibujarColoresLotes();
    }


    function configurarDibujo() {

        ctxDibujo.lineWidth = Number(tamanoPincel.value);
        ctxDibujo.lineCap = 'round';
        ctxDibujo.lineJoin = 'round';
        ctxDibujo.strokeStyle = colorActual;

        /*
        | El pincel se dibuja sólido en su propia capa.
        | La capa canvasDibujo tiene la misma opacidad fija del lote (55 %),
        | evitando que los trazos superpuestos se vuelvan más intensos.
        */
        ctxDibujo.globalAlpha = 1;
    }


    /*
    |--------------------------------------------------------------------------
    | DETECTAR UNA ZONA PARCIAL
    |--------------------------------------------------------------------------
    */

    function puntoDentroZona(
        posicion,
        zona
    ) {

        if (
            !zona ||
            !Array.isArray(zona.puntos) ||
            zona.puntos.length < 3
        ) {
            return false;
        }

        return puntoDentroPoligono(
            posicion.x / canvasDibujo.width,
            posicion.y / canvasDibujo.height,
            zona.puntos
        );
    }


    /*
    |--------------------------------------------------------------------------
    | BORRAR CUALQUIER OBJETO EN EL PUNTO
    |--------------------------------------------------------------------------
    |
    | Prioridad:
    | 1. Zona parcial sólida.
    | 2. Zona parcial rayada.
    | 3. Rayado completo.
    | 4. Pintura completa.
    | 5. Trazos de pincel/línea mediante destination-out.
    |--------------------------------------------------------------------------
    */

    function borrarObjetoEnPunto(
        posicion
    ) {

        for (
            let indice =
                zonasPintadas.length - 1;

            indice >= 0;

            indice--
        ) {

            if (
                puntoDentroZona(
                    posicion,
                    zonasPintadas[indice]
                )
            ) {

                zonasPintadas.splice(
                    indice,
                    1
                );

                dibujarColoresLotes();

                mensajeHerramienta.textContent =
                    'Zona pintada eliminada.';

                return true;
            }
        }


        for (
            let indice =
                zonasRayadas.length - 1;

            indice >= 0;

            indice--
        ) {

            if (
                puntoDentroZona(
                    posicion,
                    zonasRayadas[indice]
                )
            ) {

                zonasRayadas.splice(
                    indice,
                    1
                );

                dibujarColoresLotes();

                mensajeHerramienta.textContent =
                    'Zona rayada eliminada.';

                return true;
            }
        }


        const lote =
            buscarLote(posicion);


        if (lote) {

            const loteId =
                String(lote.id);


            if (
                Object.prototype.hasOwnProperty.call(
                    rayadosLotes,
                    loteId
                )
            ) {

                delete rayadosLotes[loteId];

                dibujarColoresLotes();

                mensajeHerramienta.textContent =
                    'Rayado completo del LOTE ' +
                    lote.nombre +
                    ' eliminado.';

                return true;
            }


            if (
                Object.prototype.hasOwnProperty.call(
                    coloresLotes,
                    loteId
                )
            ) {

                delete coloresLotes[loteId];

                dibujarColoresLotes();

                mensajeHerramienta.textContent =
                    'Color completo del LOTE ' +
                    lote.nombre +
                    ' eliminado.';

                return true;
            }
        }


        return false;
    }



    /*
    |--------------------------------------------------------------------------
    | RAYAR UNA ZONA ARRASTRANDO EL DEDO
    |--------------------------------------------------------------------------
    |
    | Se crea un patrón con la dirección, separación y grosor seleccionados.
    | Después se limita a la franja recorrida por el usuario y al lote donde
    | comenzó el trazo.
    |
    */

    function crearCanvasRayadoRectoZona() {

        const patronCanvas = document.createElement('canvas');
        patronCanvas.width = canvasRayadoZona.width;
        patronCanvas.height = canvasRayadoZona.height;

        const ctxPatron = patronCanvas.getContext('2d');
        const separacion = Math.max(4, Number(separacionRayado.value));
        const grosor = Math.max(1, Number(grosorRayado.value));
        const angulo = Number(direccionRayado.value) * Math.PI / 180;
        const diagonal = Math.sqrt(
            patronCanvas.width ** 2 + patronCanvas.height ** 2
        ) * 1.5;

        ctxPatron.save();
        ctxPatron.globalAlpha = Number(opacidadRayado.value) / 100;
        ctxPatron.strokeStyle = colorActual;
        ctxPatron.lineWidth = grosor;
        ctxPatron.lineCap = 'round';
        ctxPatron.translate(
            patronCanvas.width / 2,
            patronCanvas.height / 2
        );
        ctxPatron.rotate(angulo);

        for (let x = -diagonal; x <= diagonal; x += separacion) {
            ctxPatron.beginPath();
            ctxPatron.moveTo(x, -diagonal);
            ctxPatron.lineTo(x, diagonal);
            ctxPatron.stroke();
        }

        ctxPatron.restore();
        return patronCanvas;
    }


    function dibujarSegmentoRayadoZona(
        desdeX,
        desdeY,
        hastaX,
        hastaY,
        lote
    ) {

        if (
            !lote ||
            canvasRayadoZona.width <= 0 ||
            canvasRayadoZona.height <= 0
        ) {
            return;
        }

        const mascara = document.createElement('canvas');
        mascara.width = canvasRayadoZona.width;
        mascara.height = canvasRayadoZona.height;

        const ctxMascara = mascara.getContext('2d');

        /*
        | El ancho de “Rayar zona” debe ser preciso en celular.
        |
        | Antes se utilizaba un mínimo fijo de 18 px. En mapas pequeños ese
        | valor podía ocupar casi toda la altura de lotes angostos. Ahora la
        | brocha se adapta al ancho visible del mapa y, en celular, también
        | se limita según la altura real del lote seleccionado.
        */
        function obtenerAnchoRayadoZonaAdaptable() {

            const anchoMapa = canvasRayadoZona.width;
            const tamanoConfigurado = Math.max(
                1,
                Number(tamanoPincel.value) || 8
            );

            let anchoAdaptable;

            if (anchoMapa <= 480) {
                anchoAdaptable = Math.max(
                    4,
                    Math.min(7, anchoMapa * 0.016)
                );
            } else if (anchoMapa <= 768) {
                anchoAdaptable = Math.max(
                    6,
                    Math.min(11, anchoMapa * 0.016)
                );
            } else {
                anchoAdaptable = Math.max(
                    14,
                    tamanoConfigurado * 3
                );
            }

            /*
            | En pantallas pequeñas evitamos que una sola pasada cubra todo
            | un lote horizontal y delgado, como LOTE 1 o LOTE 2.
            */
            if (
                anchoMapa <= 768 &&
                lote &&
                Array.isArray(lote.puntos) &&
                lote.puntos.length >= 3
            ) {
                const coordenadasY = lote.puntos.map(function (punto) {
                    return Number(punto[1]) * canvasRayadoZona.height;
                });

                const altoLote =
                    Math.max(...coordenadasY) -
                    Math.min(...coordenadasY);

                if (Number.isFinite(altoLote) && altoLote > 0) {
                    anchoAdaptable = Math.min(
                        anchoAdaptable,
                        Math.max(3.5, altoLote * 0.28)
                    );
                }
            }

            return anchoAdaptable;
        }

        const anchoZona = obtenerAnchoRayadoZonaAdaptable();

        ctxMascara.save();

        if (crearRutaLoteEnCanvas(ctxMascara, lote, mascara)) {
            ctxMascara.clip();
            ctxMascara.strokeStyle = '#ffffff';
            ctxMascara.lineWidth = anchoZona;
            ctxMascara.lineCap = 'round';
            ctxMascara.lineJoin = 'round';
            ctxMascara.beginPath();
            ctxMascara.moveTo(desdeX, desdeY);
            ctxMascara.lineTo(hastaX, hastaY);
            ctxMascara.stroke();
        }

        ctxMascara.restore();

        const resultado = crearCanvasRayadoRectoZona();
        const ctxResultado = resultado.getContext('2d');

        ctxResultado.globalCompositeOperation = 'destination-in';
        ctxResultado.drawImage(mascara, 0, 0);
        ctxResultado.globalCompositeOperation = 'source-over';

        ctxRayadoZona.save();
        ctxRayadoZona.globalAlpha = 1;
        ctxRayadoZona.globalCompositeOperation = 'source-over';
        ctxRayadoZona.drawImage(resultado, 0, 0);
        ctxRayadoZona.restore();
    }

    /*
    |--------------------------------------------------------------------------
    | INICIAR ACCIÓN SOBRE EL MAPA
    |--------------------------------------------------------------------------
    */

    function iniciarAccion(event) {

        if (event.cancelable) {
            event.preventDefault();
        }

        if (!haciendaActual) {
            mensajeHerramienta.textContent =
                'Seleccione una hacienda primero.';
            return;
        }

        const posicion = obtenerPosicion(event, canvasDibujo);

        if (herramientaActual === 'pintarLote') {

            const lote = buscarLote(posicion);

            if (!lote) {
                mensajeHerramienta.textContent =
                    'No se encontró un polígono guardado en ese punto.';
                return;
            }

            guardarEstado();

            coloresLotes[String(lote.id)] = colorActual;
            dibujarColoresLotes();

            mensajeHerramienta.textContent =
                'LOTE ' +
                lote.nombre +
                ' coloreado completamente.';

            return;
        }

        if (herramientaActual === 'rayarLote') {

            const lote = buscarLote(posicion);

            if (!lote) {
                mensajeHerramienta.textContent =
                    'No se encontró un polígono guardado en ese punto.';
                return;
            }

            guardarEstado();

            rayadosLotes[String(lote.id)] = {
                color: colorActual,
                angulo: Number(direccionRayado.value),
                separacion: Number(separacionRayado.value),
                grosor: Number(grosorRayado.value),
                opacidad: Number(opacidadRayado.value)
            };

            dibujarColoresLotes();

            mensajeHerramienta.textContent =
                'LOTE ' +
                lote.nombre +
                ' rayado automáticamente.';

            return;
        }

        if (herramientaActual === 'rayarZona') {

            loteRayadoZonaActual =
                buscarLote(posicion);

            if (!loteRayadoZonaActual) {
                mensajeHerramienta.textContent =
                    'El rayado de zona debe comenzar dentro de un lote configurado.';
                return;
            }

            guardarEstado();

            dibujando = true;

            inicioX = posicion.x;
            inicioY = posicion.y;
            ultimoX = posicion.x;
            ultimoY = posicion.y;

            /*
            | Dibujar un primer punto para que un toque corto también deje marca.
            */
            dibujarSegmentoRayadoZona(
                posicion.x,
                posicion.y,
                posicion.x + 0.01,
                posicion.y + 0.01,
                loteRayadoZonaActual
            );

            mensajeHerramienta.textContent =
                'Rayando una parte del LOTE ' +
                loteRayadoZonaActual.nombre +
                '. Arrastre el dedo por la zona deseada.';

            return;
        }

        /*
        | El pincel debe comenzar dentro de un lote configurado.
        | Ese lote será la máscara de recorte durante todo el trazo.
        */
        if (herramientaActual === 'pincel') {

            lotePincelActual =
                buscarLote(posicion);

            if (!lotePincelActual) {

                mensajeHerramienta.textContent =
                    'El pincel debe comenzar dentro de un lote configurado.';

                return;
            }

        } else {

            lotePincelActual = null;
        }


        /*
        | Pincel y borrador guardan el estado antes de comenzar.
        */
        guardarEstado();


        if (
            herramientaActual === 'borrador'
        ) {

            /*
            | Primero intenta eliminar una marca estructurada.
            | Si no encuentra ninguna, borra trazos del canvas.
            */
            borrarObjetoEnPunto(
                posicion
            );
        }


        dibujando =
            true;

        inicioX =
            posicion.x;

        inicioY =
            posicion.y;

        ultimoX =
            posicion.x;

        ultimoY =
            posicion.y;


        configurarDibujo();


        if (
            herramientaActual === 'pincel'
        ) {

            ctxDibujo.globalCompositeOperation =
                'source-over';

            ctxDibujo.beginPath();

            ctxDibujo.moveTo(
                ultimoX,
                ultimoY
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | MOVER MOUSE O DEDO
    |--------------------------------------------------------------------------
    */

    function moverAccion(event) {

        if (!dibujando) {
            return;
        }

        event.preventDefault();

        const posicion = obtenerPosicion(event, canvasDibujo);

        if (herramientaActual === 'rayarZona') {

            if (!loteRayadoZonaActual) {
                terminarAccion();
                return;
            }

            dibujarSegmentoRayadoZona(
                ultimoX,
                ultimoY,
                posicion.x,
                posicion.y,
                loteRayadoZonaActual
            );

            ultimoX = posicion.x;
            ultimoY = posicion.y;

            return;
        }

        if (herramientaActual === 'pincel') {

            if (!lotePincelActual) {
                terminarAccion();
                return;
            }

            /*
            | Guardamos el contexto para que el recorte afecte únicamente
            | a este segmento del pincel.
            */
            ctxDibujo.save();

            if (
                crearRutaLoteEnCanvas(
                    ctxDibujo,
                    lotePincelActual,
                    canvasDibujo
                )
            ) {

                /*
                | Todo lo que se dibuje después de clip() quedará
                | estrictamente dentro del polígono seleccionado.
                */
                ctxDibujo.clip();

                ctxDibujo.globalCompositeOperation =
                    'source-over';

                configurarDibujo();

                ctxDibujo.beginPath();

                ctxDibujo.moveTo(
                    ultimoX,
                    ultimoY
                );

                ctxDibujo.lineTo(
                    posicion.x,
                    posicion.y
                );

                ctxDibujo.stroke();
            }

            ctxDibujo.restore();

            ultimoX =
                posicion.x;

            ultimoY =
                posicion.y;
        }


        if (herramientaActual === 'borrador') {

            /*
            | El arrastre borra pincel y marcas del rayado parcial.
            | También permite eliminar objetos estructurados al pasar sobre ellos.
            */
            borrarObjetoEnPunto(
                posicion
            );

            ctxDibujo.globalCompositeOperation =
                'destination-out';

            ctxDibujo.beginPath();

            ctxDibujo.moveTo(
                ultimoX,
                ultimoY
            );

            ctxDibujo.lineTo(
                posicion.x,
                posicion.y
            );

            ctxDibujo.stroke();

            /*
            | El mismo borrador elimina también el rayado parcial
            | realizado con “Rayar zona”.
            */
            ctxRayadoZona.save();

            ctxRayadoZona.globalCompositeOperation =
                'destination-out';

            ctxRayadoZona.lineWidth =
                Number(tamanoPincel.value);

            ctxRayadoZona.lineCap =
                'round';

            ctxRayadoZona.lineJoin =
                'round';

            ctxRayadoZona.beginPath();

            ctxRayadoZona.moveTo(
                ultimoX,
                ultimoY
            );

            ctxRayadoZona.lineTo(
                posicion.x,
                posicion.y
            );

            ctxRayadoZona.stroke();
            ctxRayadoZona.restore();

            ultimoX =
                posicion.x;

            ultimoY =
                posicion.y;
        }

    }

    function terminarAccion() {

        dibujando = false;
        lotePincelActual = null;
        loteRayadoZonaActual = null;

        ctxDibujo.globalCompositeOperation =
            'source-over';

        ctxDibujo.globalAlpha = 1;
    }

    canvasDibujo.addEventListener('mousedown', iniciarAccion);
    canvasDibujo.addEventListener('mousemove', moverAccion);
    canvasDibujo.addEventListener('mouseup', terminarAccion);
    canvasDibujo.addEventListener('mouseleave', terminarAccion);

    function crearEventoTactilSimulado(clientX, clientY) {
        return {
            cancelable: true,
            preventDefault: function () {},
            touches: [
                {
                    clientX: clientX,
                    clientY: clientY
                }
            ]
        };
    }

    canvasDibujo.addEventListener(
        'touchstart',
        function (event) {

            if (event.touches.length >= 2) {
                toquePendiente = null;
                gestoMultitactilActivo = true;
                terminarAccion();

                /*
                | No usamos preventDefault: el navegador puede ampliar
                | toda la página, no solamente el cuadro del mapa.
                */
                return;
            }

            const toque = event.touches[0];

            toquePendiente = {
                inicioX: toque.clientX,
                inicioY: toque.clientY,
                ultimoX: toque.clientX,
                ultimoY: toque.clientY,
                accionIniciada: false
            };
        },
        { passive: false }
    );

    canvasDibujo.addEventListener(
        'touchmove',
        function (event) {

            if (event.touches.length >= 2) {
                toquePendiente = null;
                gestoMultitactilActivo = true;
                terminarAccion();
                return;
            }

            if (gestoMultitactilActivo || !toquePendiente) {
                return;
            }

            /*
            | Con una sola pulsación sobre el mapa, el gesto pertenece
            | exclusivamente a la herramienta seleccionada. La regla CSS
            | touch-action: pinch-zoom conserva el zoom de dos dedos, pero
            | bloquea el desplazamiento de la página con un solo dedo.
            */
            if (event.cancelable) {
                event.preventDefault();
            }

            const toque = event.touches[0];
            const distancia = Math.hypot(
                toque.clientX - toquePendiente.inicioX,
                toque.clientY - toquePendiente.inicioY
            );

            if (
                !toquePendiente.accionIniciada &&
                distancia >= UMBRAL_MOVIMIENTO_TOQUE
            ) {
                event.preventDefault();

                iniciarAccion(
                    crearEventoTactilSimulado(
                        toquePendiente.inicioX,
                        toquePendiente.inicioY
                    )
                );

                toquePendiente.accionIniciada = true;
            }

            if (toquePendiente.accionIniciada) {
                event.preventDefault();
                moverAccion(event);
            }

            toquePendiente.ultimoX = toque.clientX;
            toquePendiente.ultimoY = toque.clientY;
        },
        { passive: false }
    );

    canvasDibujo.addEventListener('touchend', function (event) {

        if (gestoMultitactilActivo) {
            if (event.touches.length === 0) {
                gestoMultitactilActivo = false;
            }

            toquePendiente = null;
            terminarAccion();
            return;
        }

        if (toquePendiente && !toquePendiente.accionIniciada) {
            /*
            | Un toque corto se procesa al soltar. Así, si aparece un
            | segundo dedo, nunca se pinta un lote por accidente.
            */
            iniciarAccion(
                crearEventoTactilSimulado(
                    toquePendiente.inicioX,
                    toquePendiente.inicioY
                )
            );
        }

        toquePendiente = null;
        terminarAccion();
    });

    canvasDibujo.addEventListener('touchcancel', function () {
        toquePendiente = null;
        gestoMultitactilActivo = false;
        terminarAccion();
    });


    /*
    |--------------------------------------------------------------------------
    | RESTAURAR EL MAPA GUARDADO DE LA SEMANA
    |--------------------------------------------------------------------------
    */

    function cargarImagenEnCanvasDibujo(imagenBase64) {

        return new Promise(function (resolve) {

            ctxDibujo.clearRect(
                0,
                0,
                canvasDibujo.width,
                canvasDibujo.height
            );

            if (
                !imagenBase64 ||
                typeof imagenBase64 !== 'string'
            ) {
                resolve();
                return;
            }

            const imagenGuardada = new Image();

            imagenGuardada.onload = function () {

                ctxDibujo.save();
                ctxDibujo.globalCompositeOperation = 'source-over';
                ctxDibujo.globalAlpha = 1;

                ctxDibujo.drawImage(
                    imagenGuardada,
                    0,
                    0,
                    imagenGuardada.width,
                    imagenGuardada.height,
                    0,
                    0,
                    canvasDibujo.width,
                    canvasDibujo.height
                );

                ctxDibujo.restore();
                resolve();
            };

            imagenGuardada.onerror = function () {
                console.warn(
                    'No se pudo restaurar el canvas guardado.'
                );
                resolve();
            };

            imagenGuardada.src = imagenBase64;
        });
    }



    function cargarImagenEnCanvasRayadoZona(imagenBase64) {

        return new Promise(function (resolve) {

            ctxRayadoZona.clearRect(
                0,
                0,
                canvasRayadoZona.width,
                canvasRayadoZona.height
            );

            if (
                !imagenBase64 ||
                typeof imagenBase64 !== 'string'
            ) {
                resolve();
                return;
            }

            const imagenGuardada = new Image();

            imagenGuardada.onload = function () {

                ctxRayadoZona.drawImage(
                    imagenGuardada,
                    0,
                    0,
                    imagenGuardada.width,
                    imagenGuardada.height,
                    0,
                    0,
                    canvasRayadoZona.width,
                    canvasRayadoZona.height
                );

                resolve();
            };

            imagenGuardada.onerror = function () {
                resolve();
            };

            imagenGuardada.src = imagenBase64;
        });
    }


    async function restaurarConfiguracionMapa(configuracion) {

    limpiarMapaDelDia();

    if (
        !configuracion ||
        typeof configuracion !== 'object'
    ) {
        mensajeHerramienta.textContent =
            'Semana nueva: el mapa está vacío.';

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Restaurar lotes pintados
    |--------------------------------------------------------------------------
    */

    coloresLotes =
        configuracion.lotes_pintados &&
        typeof configuracion.lotes_pintados === 'object' &&
        !Array.isArray(configuracion.lotes_pintados)
            ? clonarDatos(
                configuracion.lotes_pintados
            )
            : {};

    /*
    |--------------------------------------------------------------------------
    | Restaurar lotes rayados de forma segura
    |--------------------------------------------------------------------------
    |
    | Se eliminan entradas null o inválidas de semanas antiguas para que
    | rayarPoligono nunca reciba una configuración inexistente.
    |
    */

    rayadosLotes = {};

    if (
        configuracion.lotes_rayados &&
        typeof configuracion.lotes_rayados === 'object' &&
        !Array.isArray(configuracion.lotes_rayados)
    ) {
        Object.entries(
            configuracion.lotes_rayados
        ).forEach(function ([loteId, rayado]) {

            if (
                !rayado ||
                typeof rayado !== 'object' ||
                Array.isArray(rayado)
            ) {
                return;
            }

            rayadosLotes[String(loteId)] = {
                color:
                    rayado.color ||
                    '#FF0000',

                angulo:
                    Number.isFinite(
                        Number(rayado.angulo)
                    )
                        ? Number(rayado.angulo)
                        : -45,

                separacion:
                    Number.isFinite(
                        Number(rayado.separacion)
                    )
                        ? Number(rayado.separacion)
                        : 9,

                grosor:
                    Number.isFinite(
                        Number(rayado.grosor)
                    )
                        ? Number(rayado.grosor)
                        : 2,

                opacidad:
                    Number.isFinite(
                        Number(rayado.opacidad)
                    )
                        ? Number(rayado.opacidad)
                        : 100,

                palanca:
                    rayado.palanca ??
                    null,
            };
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Compatibilidad con zonas antiguas
    |--------------------------------------------------------------------------
    */

    zonasPintadas =
        Array.isArray(
            configuracion.zonas_pintadas
        )
            ? clonarDatos(
                configuracion.zonas_pintadas
            ).filter(function (zona) {
                return (
                    zona &&
                    typeof zona === 'object' &&
                    Array.isArray(zona.puntos)
                );
            })
            : [];

    zonasRayadas =
        Array.isArray(
            configuracion.zonas_rayadas
        )
            ? clonarDatos(
                configuracion.zonas_rayadas
            ).filter(function (zona) {
                return (
                    zona &&
                    typeof zona === 'object' &&
                    Array.isArray(zona.puntos)
                );
            })
            : [];

    dibujarColoresLotes();

    await cargarImagenEnCanvasRayadoZona(
        configuracion.canvas_rayado_zona ||
        null
    );

    await cargarImagenEnCanvasDibujo(
        configuracion.canvas_dibujo ||
        null
    );

    historialAcciones = [];

    mensajeHerramienta.textContent =
        'Mapa y matriz de la semana restaurados correctamente.';
}


    /*
    |--------------------------------------------------------------------------
    | LIMPIAR SOLO EL MAPA DEL DÍA
    |--------------------------------------------------------------------------
    |
    | La matriz semanal permanece intacta. Solamente se eliminan las marcas
    | visuales utilizadas para preparar el reporte diario.
    |--------------------------------------------------------------------------
    */

    function limpiarMapaDelDia(
        mensaje = null
    ) {

        /*
        | Vaciar completamente todos los estados lógicos.
        */
        coloresLotes = {};
        rayadosLotes = {};
        zonasPintadas = [];
        zonasRayadas = [];
        puntosZonaActual = [];
        loteZonaActual = null;
        tipoZonaParcial = null;
        loteRayadoZonaActual = null;
        dibujando = false;
        historialAcciones = [];


        /*
        | Reiniciar físicamente los canvas.
        |
        | Asignar nuevamente width y height elimina cualquier
        | píxel previo, transformación, transparencia o modo de
        | composición que haya quedado activo.
        */
        const ancho =
            mapa.clientWidth ||
            canvasLotes.width ||
            1;

        const alto =
            mapa.clientHeight ||
            canvasLotes.height ||
            1;


        canvasLotes.width =
            ancho;

        canvasLotes.height =
            alto;


        canvasRayadoZona.width =
            ancho;

        canvasRayadoZona.height =
            alto;

        canvasDibujo.width =
            ancho;

        canvasDibujo.height =
            alto;


        canvasZona.width =
            ancho;

        canvasZona.height =
            alto;


        /*
        | Restaurar valores seguros de los contextos.
        */
        ctxLotes.globalAlpha =
            1;

        ctxLotes.globalCompositeOperation =
            'source-over';


        ctxRayadoZona.globalAlpha =
            1;

        ctxRayadoZona.globalCompositeOperation =
            'source-over';

        ctxDibujo.globalAlpha =
            1;

        ctxDibujo.globalCompositeOperation =
            'source-over';


        ctxZona.globalAlpha =
            1;

        ctxZona.globalCompositeOperation =
            'source-over';


        ctxLotes.clearRect(
            0,
            0,
            ancho,
            alto
        );

        ctxRayadoZona.clearRect(
            0,
            0,
            ancho,
            alto
        );

        ctxDibujo.clearRect(
            0,
            0,
            ancho,
            alto
        );

        ctxZona.clearRect(
            0,
            0,
            ancho,
            alto
        );


        /*
        | No se restaura ninguna configuración previa del mapa.
        */
        dibujarColoresLotes();

        dibujarVistaPreviaZona();


        if (mensaje) {

            mensajeHerramienta.textContent =
                mensaje;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | DESHACER Y LIMPIAR
    |--------------------------------------------------------------------------
    */

    btnDeshacer.addEventListener('click', function () {

        if (
            historialAcciones.length === 0
        ) {

            mensajeHerramienta.textContent =
                'No hay acciones para deshacer.';

            return;
        }


        const estadoAnterior =
            historialAcciones.pop();


        restaurarEstado(
            estadoAnterior
        );


        mensajeHerramienta.textContent =
            'Última acción deshecha correctamente.';
    });


    btnLimpiarMapa.addEventListener('click', function () {

        if (
            !confirm(
                '¿Desea eliminar todos los colores y todas las rayas del mapa?'
            )
        ) {
            return;
        }

        guardarEstado();

        limpiarMapaDelDia(
            'Mapa limpiado correctamente.'
        );
    });


    /*
    |--------------------------------------------------------------------------
    | CAMBIAR HACIENDA
    |--------------------------------------------------------------------------
    */

    hacienda.addEventListener('change', function () {

        haciendaActual =
            buscarHaciendaSeleccionada();

        limpiarMapaDelDia();
        lotesActuales = {};

        /*
        | Cambiar únicamente las palancas visibles según la hacienda.
        | Toda la lógica de pintura, rayado, pincel y línea se conserva.
        */
        renderizarPalancas();

        cargarLotesDesdeBaseDatos();
        cargarImagenHacienda();
    });

    fecha.addEventListener('change', function () {

        mensajeHerramienta.textContent =
            'Fecha cambiada. El mapa semanal se conserva; pulse “Abrir Semana” si necesita recargarlo.';
    });


    semana.addEventListener('change', function () {

        limpiarMapaDelDia(
            'Nueva semana seleccionada. Pulse “Abrir Semana” para cargar la matriz.'
        );

        matriz.classList.add('hidden');
        matriz.innerHTML = '';
    });


    mapa.addEventListener('load', function () {

        ajustarCanvas();
    });

    window.addEventListener('resize', function () {
        ajustarCanvas();
    });


    /*
    |--------------------------------------------------------------------------
    | ABRIR SEMANA Y CONSTRUIR MATRIZ
    |--------------------------------------------------------------------------
    */

    btnAbrir.addEventListener('click', async function () {

        if (!hacienda.value) {
            alert('Seleccione una hacienda.');
            return;
        }

        if (!semana.value) {
            alert('Seleccione una semana.');
            return;
        }


        /*
        | Se limpia temporalmente antes de consultar. Si la semana ya
        | existe, su mapa completo se restaurará desde la base de datos.
        */
        limpiarMapaDelDia(
            'Consultando la matriz y el mapa de la semana...'
        );


        matriz.classList.remove('hidden');

        matriz.innerHTML = `
            <div class="text-center py-10">
                <p class="font-semibold text-gray-700">
                    Consultando información...
                </p>
            </div>
        `;

        try {

            const csrf =
                document
                    .querySelector('meta[name="csrf-token"]')
                    ?.getAttribute('content');

            if (!csrf) {
                throw new Error('No se encontró el token CSRF.');
            }

            const respuesta = await fetch(
                "{{ route('recorridos.abrir') }}",
                {
                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrf
                    },

                    body: JSON.stringify({
                        hacienda_id: hacienda.value,
                        semana: semana.value,
                        anio: new Date().getFullYear()
                    })
                }
            );

            const datos = await respuesta.json();

            if (!respuesta.ok) {
                throw new Error(
                    datos.message ||
                    `Error HTTP ${respuesta.status}`
                );
            }

            let lotes = [];
            const detallesExistentes = {};

            let configuracionMapaGuardada = null;

            if (datos.existe === true) {

                configuracionMapaGuardada =
                    datos.recorrido?.mapa || null;

                const detalles =
                    Array.isArray(datos.detalles)
                        ? datos.detalles
                        : (
                            Array.isArray(datos.recorrido?.detalles)
                                ? datos.recorrido.detalles
                                : []
                        );

                detalles.forEach(function (detalle) {
                    detallesExistentes[detalle.lote_id] = detalle;
                });

                lotes = detalles
                    .map(function (detalle) {
                        return detalle.lote;
                    })
                    .filter(Boolean);

                /*
                | Si el recorrido existente no tenía todavía todos los lotes,
                | se completa la matriz con los lotes de la hacienda cargada.
                */
                if (
                    haciendaActual &&
                    Array.isArray(haciendaActual.lotes)
                ) {
                    haciendaActual.lotes.forEach(function (lote) {

                        const existe = lotes.some(function (item) {
                            return String(item.id) === String(lote.id);
                        });

                        if (!existe) {
                            lotes.push(lote);
                        }
                    });
                }

            } else {
                lotes = Array.isArray(datos.lotes)
                    ? datos.lotes
                    : [];
            }

            /*
            | Restaurar el mapa acumulado de la semana. Una semana nueva
            | permanece vacía; una existente recupera todas sus marcas.
            */
            await restaurarConfiguracionMapa(
                configuracionMapaGuardada
            );

            lotes.sort(function (a, b) {
                return String(a.nombre).localeCompare(
                    String(b.nombre),
                    undefined,
                    { numeric: true }
                );
            });

            let filas = '';
            let totalHasProd = 0;

            lotes.forEach(function (lote) {

                const detalle =
                    detallesExistentes[lote.id] || {};

                const lunes = detalle.lunes ?? '';
                const martes = detalle.martes ?? '';
                const miercoles = detalle.miercoles ?? '';
                const jueves = detalle.jueves ?? '';
                const viernes = detalle.viernes ?? '';
                const sabado = detalle.sabado ?? '';

                const hasProd =
                    Number.parseFloat(lote.has_prod) || 0;

                totalHasProd += hasProd;

                filas += `
                    <tr
                        data-lote-id="${lote.id}"
                        data-has-prod="${hasProd}"
                        class="hover:bg-green-50"
                    >
                        <td class="border px-2 py-2 text-center font-semibold whitespace-nowrap">
                            ${lote.nombre}
                        </td>

                        <td class="border px-2 py-2 text-center whitespace-nowrap">
                            ${hasProd.toFixed(2)}
                        </td>

                        <td class="border px-2 py-2">
                            <input type="number" step="0.01" min="0"
                                value="${lunes}"
                                class="campo-dia lunes w-full min-w-[80px] border border-gray-300 rounded px-2 py-2 text-center">
                        </td>

                        <td class="border px-2 py-2">
                            <input type="number" step="0.01" min="0"
                                value="${martes}"
                                class="campo-dia martes w-full min-w-[80px] border border-gray-300 rounded px-2 py-2 text-center">
                        </td>

                        <td class="border px-2 py-2">
                            <input type="number" step="0.01" min="0"
                                value="${miercoles}"
                                class="campo-dia miercoles w-full min-w-[80px] border border-gray-300 rounded px-2 py-2 text-center">
                        </td>

                        <td class="border px-2 py-2">
                            <input type="number" step="0.01" min="0"
                                value="${jueves}"
                                class="campo-dia jueves w-full min-w-[80px] border border-gray-300 rounded px-2 py-2 text-center">
                        </td>

                        <td class="border px-2 py-2">
                            <input type="number" step="0.01" min="0"
                                value="${viernes}"
                                class="campo-dia viernes w-full min-w-[80px] border border-gray-300 rounded px-2 py-2 text-center">
                        </td>

                        <td class="border px-2 py-2">
                            <input type="number" step="0.01" min="0"
                                value="${sabado}"
                                class="campo-dia sabado w-full min-w-[80px] border border-gray-300 rounded px-2 py-2 text-center">
                        </td>

                        <td class="border px-2 py-2 text-center font-bold whitespace-nowrap">
                            <span class="total-semana">0.00</span>
                        </td>

                        <td class="border px-2 py-2 text-center font-bold whitespace-nowrap">
                            <span class="porcentaje">0.00%</span>
                        </td>
                    </tr>
                `;
            });

            matriz.innerHTML = `
                <div class="w-full">

                    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4 mb-6">

                        <div>
                            <h2 class="text-2xl font-bold text-green-800">
                                Matriz de Área Recorrida
                            </h2>

                            <p class="text-gray-600 mt-1">
                                Semana ${semana.value}
                            </p>
                        </div>

                        <div class="text-left lg:text-right">
                            <span class="font-semibold text-gray-700">
                                Total Has. Productivas:
                            </span>

                            <span class="font-bold text-green-800">
                                ${totalHasProd.toFixed(2)}
                            </span>
                        </div>

                    </div>

                    <div class="w-full overflow-x-auto">

                        <table
                            class="w-full border-collapse border border-gray-300 text-sm"
                            style="min-width:950px;"
                        >
                            <thead>
                                <tr class="bg-green-800 text-white">
                                    <th class="border px-3 py-3">Lotes</th>
                                    <th class="border px-3 py-3">Has-prod</th>
                                    <th class="border px-3 py-3">Lunes</th>
                                    <th class="border px-3 py-3">Martes</th>
                                    <th class="border px-3 py-3">Miércoles</th>
                                    <th class="border px-3 py-3">Jueves</th>
                                    <th class="border px-3 py-3">Viernes</th>
                                    <th class="border px-3 py-3">Sábado</th>
                                    <th class="border px-3 py-3">Total Semana</th>
                                    <th class="border px-3 py-3">% Área</th>
                                </tr>
                            </thead>

                            <tbody>
                                ${filas}
                            </tbody>

                            <tfoot>
                                <tr class="bg-gray-100 font-bold">
                                    <td class="border px-3 py-3 text-center">
                                        TOTAL
                                    </td>

                                    <td class="border px-3 py-3 text-center">
                                        ${totalHasProd.toFixed(2)}
                                    </td>

                                    <td colspan="6" class="border"></td>

                                    <td
                                        id="totalSemanaGeneral"
                                        class="border px-3 py-3 text-center"
                                    >
                                        0.00
                                    </td>

                                    <td
                                        id="porcentajeGeneral"
                                        class="border px-3 py-3 text-center"
                                    >
                                        0.00%
                                    </td>
                                </tr>
                            </tfoot>
                        </table>

                    </div>

                    <div class="mt-6 flex flex-wrap justify-end gap-3">
                        <button
                            id="btnGuardarRecorrido"
                            type="button"
                            class="bg-green-800 text-white px-6 py-3 rounded-lg font-bold hover:bg-green-900"
                        >
                            Guardar Recorrido
                        </button>

                        <button
                            id="btnGenerarPdf"
                            type="button"
                            class="bg-red-700 text-white px-6 py-3 rounded-lg font-bold hover:bg-red-800"
                        >
                            📄 Generar PDF
                        </button>
                    </div>

                </div>
            `;


            /*
            |--------------------------------------------------------------------------
            | CALCULAR TOTALES
            |--------------------------------------------------------------------------
            */

            function calcularTotales() {

                let totalGeneral = 0;

                document
                    .querySelectorAll('#contenedorMatriz tbody tr')
                    .forEach(function (fila) {

                        const hasProd =
                            Number.parseFloat(fila.dataset.hasProd) || 0;

                        let total = 0;

                        fila
                            .querySelectorAll('.campo-dia')
                            .forEach(function (input) {
                                total +=
                                    Number.parseFloat(input.value) || 0;
                            });

                        fila
                            .querySelector('.total-semana')
                            .textContent =
                            total.toFixed(2);

                        const porcentaje =
                            hasProd > 0
                                ? (total / hasProd) * 100
                                : 0;

                        fila
                            .querySelector('.porcentaje')
                            .textContent =
                            porcentaje.toFixed(2) + '%';

                        totalGeneral += total;
                    });

                document
                    .getElementById('totalSemanaGeneral')
                    .textContent =
                    totalGeneral.toFixed(2);

                const porcentajeGeneral =
                    totalHasProd > 0
                        ? (totalGeneral / totalHasProd) * 100
                        : 0;

                document
                    .getElementById('porcentajeGeneral')
                    .textContent =
                    porcentajeGeneral.toFixed(2) + '%';
            }

            document
                .querySelectorAll('#contenedorMatriz .campo-dia')
                .forEach(function (input) {
                    input.addEventListener(
                        'input',
                        calcularTotales
                    );
                });

            calcularTotales();


            /*
            |--------------------------------------------------------------------------
            | DATOS PARA GUARDAR Y GENERAR PDF
            |--------------------------------------------------------------------------
            */

            function obtenerDetallesMatriz() {

                const detalles = [];

                document
                    .querySelectorAll('#contenedorMatriz tbody tr')
                    .forEach(function (fila) {

                        function valor(selector) {

                            const campo =
                                fila.querySelector(selector);

                            return campo
                                ? (campo.value || null)
                                : null;
                        }

                        detalles.push({
                            lote_id:
                                fila.dataset.loteId,

                            nombre:
                                fila
                                    .querySelector('td:first-child')
                                    ?.textContent
                                    ?.trim() ||
                                '',

                            has_prod:
                                Number.parseFloat(
                                    fila.dataset.hasProd
                                ) ||
                                0,

                            lunes:
                                valor('.lunes'),

                            martes:
                                valor('.martes'),

                            miercoles:
                                valor('.miercoles'),

                            jueves:
                                valor('.jueves'),

                            viernes:
                                valor('.viernes'),

                            sabado:
                                valor('.sabado'),

                            total_semana:
                                Number.parseFloat(
                                    fila
                                        .querySelector('.total-semana')
                                        ?.textContent
                                ) ||
                                0,

                            porcentaje:
                                fila
                                    .querySelector('.porcentaje')
                                    ?.textContent
                                    ?.trim() ||
                                '0.00%'
                        });
                    });

                return detalles;
            }


            function obtenerConfiguracionMapa() {

                return {
                    version: 2,

                    lotes_pintados:
                        clonarDatos(coloresLotes),

                    lotes_rayados:
                        clonarDatos(rayadosLotes),

                    zonas_pintadas:
                        clonarDatos(zonasPintadas),

                    zonas_rayadas:
                        clonarDatos(zonasRayadas),

                    opacidad_lote:
                        Number(opacidadLote.value),

                    /*
                    | Guarda pincel y borrados como una
                    | capa transparente que puede recuperarse y editarse.
                    */
                    canvas_rayado_zona:
                        canvasRayadoZona.toDataURL('image/png'),

                    canvas_dibujo:
                        canvasDibujo.toDataURL('image/png')
                };
            }


            async function capturarMapaComoImagen() {

                if (
                    !mapa.src ||
                    mapa.naturalWidth <= 0
                ) {
                    throw new Error(
                        'No existe un mapa cargado para generar el PDF.'
                    );
                }


                /*
                | Reducimos el tamaño antes de enviarlo.
                | Esto evita errores 413 o post_max_size al enviar
                | imágenes demasiado grandes en Base64.
                */
                const anchoOriginal =
                    canvasLotes.width;

                const altoOriginal =
                    canvasLotes.height;

                const anchoMaximo =
                    1400;

                const escala =
                    Math.min(
                        1,
                        anchoMaximo / anchoOriginal
                    );

                const anchoFinal =
                    Math.max(
                        1,
                        Math.round(
                            anchoOriginal * escala
                        )
                    );

                const altoFinal =
                    Math.max(
                        1,
                        Math.round(
                            altoOriginal * escala
                        )
                    );


                const canvasFinal =
                    document.createElement(
                        'canvas'
                    );

                canvasFinal.width =
                    anchoFinal;

                canvasFinal.height =
                    altoFinal;


                const contextoFinal =
                    canvasFinal.getContext(
                        '2d'
                    );


                if (!contextoFinal) {
                    throw new Error(
                        'No se pudo preparar la imagen del mapa.'
                    );
                }


                contextoFinal.fillStyle =
                    '#ffffff';

                contextoFinal.fillRect(
                    0,
                    0,
                    anchoFinal,
                    altoFinal
                );


                /*
                | Imagen original.
                */
                contextoFinal.globalAlpha =
                    1;

                contextoFinal.globalCompositeOperation =
                    'source-over';

                contextoFinal.drawImage(
                    mapa,
                    0,
                    0,
                    anchoFinal,
                    altoFinal
                );


                /*
                | Pinturas y rayados.
                */
                contextoFinal.drawImage(
                    canvasLotes,
                    0,
                    0,
                    anchoOriginal,
                    altoOriginal,
                    0,
                    0,
                    anchoFinal,
                    altoFinal
                );


                /*
                | Rayado parcial realizado con el dedo.
                | Se conserva al 100 % para que destaque sobre el relleno.
                */
                contextoFinal.globalAlpha =
                    1;

                contextoFinal.drawImage(
                    canvasRayadoZona,
                    0,
                    0,
                    anchoOriginal,
                    altoOriginal,
                    0,
                    0,
                    anchoFinal,
                    altoFinal
                );


                /*
                | Pincel y borrados.
                | Se aplica la misma opacidad fija del relleno del lote.
                */
                contextoFinal.globalAlpha =
                    Number(opacidadLote.value) / 100;

                contextoFinal.drawImage(
                    canvasDibujo,
                    0,
                    0,
                    anchoOriginal,
                    altoOriginal,
                    0,
                    0,
                    anchoFinal,
                    altoFinal
                );

                contextoFinal.globalAlpha = 1;


                /*
                | Bordes y textos superiores.
                */
                if (
                    mapaSuperior &&
                    mapaSuperior.src &&
                    mapaSuperior.naturalWidth > 0
                ) {

                    contextoFinal.globalCompositeOperation =
                        'multiply';

                    contextoFinal.globalAlpha =
                        1;

                    contextoFinal.drawImage(
                        mapaSuperior,
                        0,
                        0,
                        anchoFinal,
                        altoFinal
                    );
                }


                contextoFinal.globalCompositeOperation =
                    'source-over';

                contextoFinal.globalAlpha =
                    1;


                /*
                | JPEG reduce notablemente el tamaño del POST.
                | Calidad 0.88 mantiene el mapa legible.
                */
                return canvasFinal.toDataURL(
                    'image/jpeg',
                    0.88
                );
            }


            function descargarBlob(
                blob,
                nombreArchivo
            ) {

                const url =
                    URL.createObjectURL(blob);

                const enlace =
                    document.createElement('a');

                enlace.href =
                    url;

                enlace.download =
                    nombreArchivo;

                document.body.appendChild(
                    enlace
                );

                enlace.click();
                enlace.remove();

                URL.revokeObjectURL(url);
            }


            /*
            |--------------------------------------------------------------------------
            | GUARDAR RECORRIDO
            |--------------------------------------------------------------------------
            */

            const btnGuardarRecorrido =
                document.getElementById('btnGuardarRecorrido');

            btnGuardarRecorrido.addEventListener(
                'click',
                async function () {

                    btnGuardarRecorrido.disabled = true;
                    btnGuardarRecorrido.textContent = 'Guardando...';

                    try {

                        const detalles =
                            obtenerDetallesMatriz()
                                .map(function (detalle) {

                                    return {
                                        lote_id:
                                            detalle.lote_id,

                                        lunes:
                                            detalle.lunes,

                                        martes:
                                            detalle.martes,

                                        miercoles:
                                            detalle.miercoles,

                                        jueves:
                                            detalle.jueves,

                                        viernes:
                                            detalle.viernes,

                                        sabado:
                                            detalle.sabado
                                    };
                                });

                        const respuestaGuardar = await fetch(
                            "{{ route('recorridos.store') }}",
                            {
                                method: 'POST',

                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': csrf
                                },

                                body: JSON.stringify({
                                    hacienda_id: hacienda.value,
                                    semana: semana.value,
                                    anio: new Date().getFullYear(),
                                    fecha: fecha.value,

                                    mapa:
                                        obtenerConfiguracionMapa(),

                                    detalles: detalles
                                })
                            }
                        );

                        const resultado =
                            await respuestaGuardar.json();

                        if (!respuestaGuardar.ok) {
                            throw new Error(
                                resultado.message ||
                                'Error al guardar el recorrido.'
                            );
                        }

                        alert(
                            resultado.message ||
                            'Recorrido guardado correctamente.'
                        );

                    } catch (error) {

                        console.error(error);

                        alert(
                            'Error al guardar: ' +
                            error.message
                        );

                    } finally {

                        btnGuardarRecorrido.disabled = false;
                        btnGuardarRecorrido.textContent =
                            'Guardar Recorrido';
                    }
                }
            );


            /*
            |--------------------------------------------------------------------------
            | GENERAR PDF
            |--------------------------------------------------------------------------
            */

            const btnGenerarPdf =
                document.getElementById('btnGenerarPdf');

            btnGenerarPdf.addEventListener(
                'click',
                async function () {

                    btnGenerarPdf.disabled =
                        true;

                    btnGenerarPdf.textContent =
                        'Generando PDF...';

                    try {

                        if (!hacienda.value) {
                            throw new Error(
                                'Seleccione una hacienda.'
                            );
                        }


                        if (!semana.value) {
                            throw new Error(
                                'Seleccione y abra una semana.'
                            );
                        }


                        if (
                            document.querySelectorAll(
                                '#contenedorMatriz tbody tr'
                            ).length === 0
                        ) {
                            throw new Error(
                                'Primero pulse “Abrir Semana” para cargar la matriz.'
                            );
                        }


                        const imagenMapa =
                            await capturarMapaComoImagen();

                        const detalles =
                            obtenerDetallesMatriz();

                        const totalHas =
                            detalles.reduce(
                                function (total, detalle) {

                                    return total +
                                        (
                                            Number(
                                                detalle.has_prod
                                            ) ||
                                            0
                                        );
                                },
                                0
                            );

                        const totalSemana =
                            detalles.reduce(
                                function (total, detalle) {

                                    return total +
                                        (
                                            Number(
                                                detalle.total_semana
                                            ) ||
                                            0
                                        );
                                },
                                0
                            );

                        /*
                        | Antes de generar el PDF se guarda automáticamente
                        | la matriz y el mapa acumulado de la semana.
                        */
                        const detallesParaGuardar =
                            detalles.map(function (detalle) {
                                return {
                                    lote_id: detalle.lote_id,
                                    lunes: detalle.lunes,
                                    martes: detalle.martes,
                                    miercoles: detalle.miercoles,
                                    jueves: detalle.jueves,
                                    viernes: detalle.viernes,
                                    sabado: detalle.sabado
                                };
                            });

                        const respuestaGuardadoAutomatico =
                            await fetch(
                                "{{ route('recorridos.store') }}",
                                {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/json',
                                        'X-CSRF-TOKEN': csrf
                                    },
                                    body: JSON.stringify({
                                        hacienda_id: hacienda.value,
                                        semana: semana.value,
                                        anio: fecha.value
                                            ? new Date(
                                                fecha.value + 'T12:00:00'
                                            ).getFullYear()
                                            : new Date().getFullYear(),
                                        fecha: fecha.value,
                                        mapa: obtenerConfiguracionMapa(),
                                        detalles: detallesParaGuardar
                                    })
                                }
                            );

                        const resultadoGuardadoAutomatico =
                            await respuestaGuardadoAutomatico.json();

                        if (!respuestaGuardadoAutomatico.ok) {
                            throw new Error(
                                resultadoGuardadoAutomatico.message ||
                                'No se pudo guardar la semana antes de generar el PDF.'
                            );
                        }


                        const respuestaPdf =
                            await fetch(
                                "{{ route('recorridos.generar-pdf') }}",
                                {
                                    method:
                                        'POST',

                                    headers: {
                                        'Content-Type':
                                            'application/json',

                                        'Accept':
                                            'application/pdf',

                                        'X-CSRF-TOKEN':
                                            csrf
                                    },

                                    body:
                                        JSON.stringify({
                                            hacienda_id:
                                                hacienda.value,

                                            hacienda:
                                                haciendaActual
                                                    ?.nombre ||
                                                '',

                                            semana:
                                                semana.value,

                                            anio:
                                                new Date()
                                                    .getFullYear(),

                                            fecha:
                                                fecha.value,

                                            usuario:
                                                @json(
                                                    auth()
                                                        ->user()
                                                        ->name
                                                ),

                                            imagen_mapa:
                                                imagenMapa,

                                            configuracion_mapa:
                                                obtenerConfiguracionMapa(),

                                            detalles:
                                                detalles,

                                            total_has:
                                                totalHas,

                                            total_semana:
                                                totalSemana,

                                            porcentaje_general:
                                                totalHas > 0
                                                    ? (
                                                        totalSemana /
                                                        totalHas
                                                    ) *
                                                    100
                                                    : 0
                                        })
                                }
                            );

                        if (!respuestaPdf.ok) {

                            const tipoContenido =
                                respuestaPdf
                                    .headers
                                    .get(
                                        'content-type'
                                    ) ||
                                '';

                            let mensajeError =
                                'Error HTTP ' +
                                respuestaPdf.status;


                            if (
                                tipoContenido.includes(
                                    'application/json'
                                )
                            ) {

                                const errorJson =
                                    await respuestaPdf.json();


                                mensajeError =
                                    errorJson.message ||
                                    errorJson.detalle ||
                                    mensajeError;


                                if (errorJson.errors) {

                                    mensajeError +=
                                        '\n\n' +
                                        Object.values(
                                            errorJson.errors
                                        )
                                        .flat()
                                        .join('\n');
                                }

                            } else {

                                const respuestaTexto =
                                    await respuestaPdf.text();


                                console.error(
                                    'Respuesta completa del servidor:',
                                    respuestaTexto
                                );


                                /*
                                | Intentar extraer el título del error
                                | de la página HTML de Laravel.
                                */
                                const documentoError =
                                    new DOMParser()
                                        .parseFromString(
                                            respuestaTexto,
                                            'text/html'
                                        );


                                const tituloError =
                                    documentoError
                                        .querySelector(
                                            'title'
                                        )
                                        ?.textContent
                                        ?.trim();


                                const encabezadoError =
                                    documentoError
                                        .querySelector(
                                            'h1'
                                        )
                                        ?.textContent
                                        ?.trim();


                                mensajeError =
                                    encabezadoError ||
                                    tituloError ||
                                    (
                                        'Error HTTP ' +
                                        respuestaPdf.status +
                                        '. Revise storage/logs/laravel.log.'
                                    );
                            }


                            throw new Error(
                                mensajeError
                            );
                        }

                        const archivoPdf =
                            await respuestaPdf.blob();

                        const nombreHacienda =
                            (
                                haciendaActual
                                    ?.nombre ||
                                'hacienda'
                            )
                            .toLowerCase()
                            .replace(
                                /[^a-z0-9]+/g,
                                '_'
                            )
                            .replace(
                                /^_+|_+$/g,
                                ''
                            );

                        descargarBlob(
                            archivoPdf,
                            'recorrido_' +
                            nombreHacienda +
                            '_semana_' +
                            semana.value +
                            '.pdf'
                        );

                        mensajeHerramienta.textContent =
                            'PDF descargado. El mapa semanal se conserva.';

                    } catch (error) {

                        console.error(error);

                        alert(
                            'Error al generar el PDF: ' +
                            error.message
                        );

                    } finally {

                        btnGenerarPdf.disabled =
                            false;

                        btnGenerarPdf.textContent =
                            '📄 Generar PDF';
                    }
                }
            );

        } catch (error) {

            console.error(error);

            matriz.innerHTML = `
                <div class="p-6">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-4 rounded-lg">
                        <h3 class="font-bold text-lg mb-2">
                            Error al consultar la información
                        </h3>

                        <p>${error.message}</p>
                    </div>
                </div>
            `;
        }
    });


    /*
    |--------------------------------------------------------------------------
    | INICIALIZACIÓN
    |--------------------------------------------------------------------------
    */

    activarHerramienta('pintarLote');

});

</script>

@endsection