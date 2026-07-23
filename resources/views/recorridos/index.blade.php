@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 py-6">

    {{-- ========================================================= --}}
    {{-- CABECERA --}}
    {{-- ========================================================= --}}

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


    {{-- ========================================================= --}}
    {{-- MAPA --}}
    {{-- ========================================================= --}}

    <div class="bg-white rounded-xl shadow-lg mt-8 overflow-hidden">

        <div class="bg-green-800 text-white px-5 py-3">
            <h2 class="font-semibold">
                Mapa de Hacienda
            </h2>
        </div>

        <div class="p-4 bg-gray-50 border-b">

            <div class="flex flex-wrap items-center gap-2 mb-4">

                <span class="font-semibold text-gray-700 mr-2">
                    Colores:
                </span>

                {{-- COLORES PRIMARIOS PRIMERO --}}
                <button type="button" class="color-lote w-8 h-8 rounded border-2 border-gray-300"
                    data-color="#FF0000" style="background:#FF0000" title="Rojo"></button>

                <button type="button" class="color-lote w-8 h-8 rounded border-2 border-gray-300"
                    data-color="#FFD700" style="background:#FFD700" title="Amarillo"></button>

                <button type="button" class="color-lote w-8 h-8 rounded border-2 border-gray-300"
                    data-color="#0066FF" style="background:#0066FF" title="Azul"></button>

                <button type="button" class="color-lote w-8 h-8 rounded border-2 border-gray-300"
                    data-color="#00A651" style="background:#00A651" title="Verde"></button>

                <button type="button" class="color-lote w-8 h-8 rounded border-2 border-gray-300"
                    data-color="#FF8C00" style="background:#FF8C00" title="Naranja"></button>

                <button type="button" class="color-lote w-8 h-8 rounded border-2 border-gray-300"
                    data-color="#8000FF" style="background:#8000FF" title="Morado"></button>

                <button type="button" class="color-lote w-8 h-8 rounded border-2 border-gray-300"
                    data-color="#8B4513" style="background:#8B4513" title="Café"></button>

                <button type="button" class="color-lote w-8 h-8 rounded border-2 border-gray-300"
                    data-color="#000000" style="background:#000000" title="Negro"></button>

                <span class="font-semibold text-gray-700 ml-4">
                    Color:
                </span>

                <input
                    id="colorPincel"
                    type="color"
                    value="#FF0000"
                    class="w-10 h-8 cursor-pointer rounded border"
                >

                <span class="font-semibold text-gray-700 ml-2">
                    Opacidad lote:
                </span>

                <input
                    id="opacidadLote"
                    type="range"
                    min="10"
                    max="90"
                    value="45"
                    class="cursor-pointer"
                >

                <span id="textoOpacidad" class="text-gray-700 font-semibold min-w-[45px]">
                    45%
                </span>

                <span class="font-semibold text-gray-700 ml-2">
                    Opacidad pincel:
                </span>

                <input
                    id="opacidadPincel"
                    type="range"
                    min="10"
                    max="100"
                    value="70"
                    class="cursor-pointer"
                >

                <span id="textoOpacidadPincel" class="text-gray-700 font-semibold min-w-[45px]">
                    70%
                </span>

                <span class="font-semibold text-gray-700 ml-2">
                    Tamaño:
                </span>

                <input
                    id="tamanoPincel"
                    type="range"
                    min="2"
                    max="40"
                    value="8"
                    class="cursor-pointer"
                >

            </div>

            {{-- CONTROLES DEL RAYADO AUTOMÁTICO --}}
            <div class="flex flex-wrap items-center gap-3 mb-4 p-3 rounded-lg border border-gray-200 bg-white">

                <span class="font-semibold text-gray-700">
                    Rayado:
                </span>

                <label class="text-sm text-gray-700" for="direccionRayado">
                    Dirección
                </label>

                <select
                    id="direccionRayado"
                    class="rounded border border-gray-300 bg-white text-black px-2 py-1"
                >
                    <option value="-45">Diagonal /</option>
                    <option value="45">Diagonal \</option>
                    <option value="0">Vertical |</option>
                    <option value="90">Horizontal —</option>
                </select>

                <label class="text-sm text-gray-700" for="separacionRayado">
                    Separación
                </label>

                <input
                    id="separacionRayado"
                    type="range"
                    min="6"
                    max="40"
                    value="16"
                    class="cursor-pointer"
                >

                <span id="textoSeparacionRayado" class="text-sm font-semibold text-gray-700 min-w-[40px]">
                    16 px
                </span>

                <label class="text-sm text-gray-700" for="grosorRayado">
                    Grosor
                </label>

                <input
                    id="grosorRayado"
                    type="range"
                    min="1"
                    max="10"
                    value="3"
                    class="cursor-pointer"
                >

                <span id="textoGrosorRayado" class="text-sm font-semibold text-gray-700 min-w-[35px]">
                    3 px
                </span>

                <label class="text-sm text-gray-700" for="opacidadRayado">
                    Opacidad
                </label>

                <input
                    id="opacidadRayado"
                    type="range"
                    min="10"
                    max="100"
                    value="75"
                    class="cursor-pointer"
                >

                <span id="textoOpacidadRayado" class="text-sm font-semibold text-gray-700 min-w-[45px]">
                    75%
                </span>

            </div>

            <div class="flex flex-wrap gap-2">

                <button id="btnPintarLote" type="button"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700">
                    🎨 Pintar Lote
                </button>

                <button id="btnRayarLote" type="button"
                    class="bg-pink-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-pink-700">
                    ▨ Rayar Lote
                </button>

                <button id="btnPintarZona" type="button"
                    class="bg-cyan-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-cyan-700">
                    🖍️ Pintar zona
                </button>

                <button id="btnRayarZona" type="button"
                    class="bg-fuchsia-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-fuchsia-700">
                    ✂️ Rayar zona
                </button>

                <button id="btnCerrarZona" type="button"
                    class="bg-teal-700 text-white px-4 py-2 rounded-lg font-semibold hover:bg-teal-800">
                    🔷 Cerrar zona
                </button>

                <button id="btnDeshacerPuntoZona" type="button"
                    class="bg-slate-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-slate-700">
                    ↩️ Deshacer punto
                </button>

                <button id="btnCancelarZona" type="button"
                    class="bg-rose-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-rose-700">
                    ❌ Cancelar zona
                </button>

                <button id="btnPincel" type="button"
                    class="bg-green-700 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-800">
                    🖌️ Pincel
                </button>

                <button id="btnLinea" type="button"
                    class="bg-gray-700 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-800">
                    📏 Línea recta
                </button>

                <button id="btnBorrador" type="button"
                    class="bg-yellow-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-yellow-600">
                    🧹 Borrador
                </button>

                <button id="btnDeshacer" type="button"
                    class="bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-700">
                    ↩️ Deshacer
                </button>
<button id="btnLimpiarMapa" type="button"
                    class="bg-red-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-700">
                    🗑️ Limpiar todo
                </button>

            </div>

            <div id="mensajeHerramienta" class="mt-3 text-sm text-gray-600">
                Seleccione una hacienda. Después use “Pintar Lote” y haga clic dentro del lote.
            </div>

        </div>

        <div class="p-4 sm:p-6">

            <div
                id="contenedorMapa"
                class="relative mx-auto w-full max-w-6xl overflow-hidden border rounded-lg bg-white"
                style="line-height:0;"
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

                {{-- LÍNEA, BORRADOR Y SELECCIÓN DE ZONAS PARCIALES --}}
                <canvas
                    id="canvasDibujo"
                    class="absolute inset-0 w-full h-full"
                    style="z-index:3; touch-action:none;"
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
                        z-index:4;
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
                    style="z-index:4;"
                ></canvas>
            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- MATRIZ --}}
    {{-- ========================================================= --}}

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
    const mapaSuperior = document.getElementById('mapaSuperior');
    const canvasLotes = document.getElementById('canvasLotes');
    const canvasDibujo = document.getElementById('canvasDibujo');
    const canvasZona = document.getElementById('canvasZona');
    const btnAbrir = document.getElementById('btnAbrir');
    const matriz = document.getElementById('contenedorMatriz');

    const colorPincel = document.getElementById('colorPincel');
    const opacidadLote = document.getElementById('opacidadLote');
    const textoOpacidad = document.getElementById('textoOpacidad');
    const opacidadPincel = document.getElementById('opacidadPincel');
    const textoOpacidadPincel = document.getElementById('textoOpacidadPincel');
    const tamanoPincel = document.getElementById('tamanoPincel');

    const direccionRayado = document.getElementById('direccionRayado');
    const separacionRayado = document.getElementById('separacionRayado');
    const textoSeparacionRayado = document.getElementById('textoSeparacionRayado');
    const grosorRayado = document.getElementById('grosorRayado');
    const textoGrosorRayado = document.getElementById('textoGrosorRayado');
    const opacidadRayado = document.getElementById('opacidadRayado');
    const textoOpacidadRayado = document.getElementById('textoOpacidadRayado');

    const btnPintarLote = document.getElementById('btnPintarLote');
    const btnRayarLote = document.getElementById('btnRayarLote');
    const btnPintarZona = document.getElementById('btnPintarZona');
    const btnRayarZona = document.getElementById('btnRayarZona');
    const btnCerrarZona = document.getElementById('btnCerrarZona');
    const btnDeshacerPuntoZona = document.getElementById('btnDeshacerPuntoZona');
    const btnCancelarZona = document.getElementById('btnCancelarZona');
    const btnPincel = document.getElementById('btnPincel');
    const btnLinea = document.getElementById('btnLinea');
    const btnBorrador = document.getElementById('btnBorrador');
    const btnDeshacer = document.getElementById('btnDeshacer');
    const btnLimpiarMapa = document.getElementById('btnLimpiarMapa');
    const mensajeHerramienta = document.getElementById('mensajeHerramienta');

    const ctxLotes = canvasLotes.getContext('2d');
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
    let colorActual = '#FF0000';

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

        if (canvasDibujo.width > 0 && canvasDibujo.height > 0) {
            imagenAnterior = document.createElement('canvas');
            imagenAnterior.width = canvasDibujo.width;
            imagenAnterior.height = canvasDibujo.height;

            imagenAnterior
                .getContext('2d')
                .drawImage(canvasDibujo, 0, 0);
        }

        canvasLotes.width = ancho;
        canvasLotes.height = alto;

        canvasDibujo.width = ancho;
        canvasDibujo.height = alto;

        canvasZona.width = ancho;
        canvasZona.height = alto;

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

        if (!Array.isArray(puntos) || puntos.length < 3) {
            return;
        }

        const angulo =
            Number(configuracion.angulo ?? -45) *
            Math.PI /
            180;

        const separacion =
            Math.max(4, Number(configuracion.separacion ?? 16));

        const grosor =
            Math.max(1, Number(configuracion.grosor ?? 3));

        const alpha =
            Math.min(
                1,
                Math.max(
                    0.1,
                    Number(configuracion.opacidad ?? 75) / 100
                )
            );

        const diagonal =
            Math.sqrt(
                canvasLotes.width ** 2 +
                canvasLotes.height ** 2
            ) * 1.5;

        ctx.save();

        /*
        | Recortar las rayas dentro del polígono.
        */
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
        ctx.clip();

        ctx.globalAlpha = alpha;
        ctx.strokeStyle = configuracion.color || '#FF0000';
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
            Math.max(4, Number(zona.separacion ?? 16));

        const grosor =
            Math.max(1, Number(zona.grosor ?? 3));

        const alpha =
            Math.min(
                1,
                Math.max(
                    0.1,
                    Number(zona.opacidad ?? 75) / 100
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
            ctxZona.arc(x, y, 5, 0, Math.PI * 2);
            ctxZona.fillStyle = '#dc2626';
            ctxZona.fill();
            ctxZona.strokeStyle = '#ffffff';
            ctxZona.lineWidth = 2;
            ctxZona.stroke();

            ctxZona.fillStyle = '#111827';
            ctxZona.font = 'bold 12px Arial';
            ctxZona.textAlign = 'center';
            ctxZona.fillText(indice + 1, x, y - 10);
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
    | COLOR Y OPACIDAD
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('.color-lote').forEach(function (boton) {
        boton.addEventListener('click', function () {
            colorActual = this.dataset.color;
            colorPincel.value = colorActual;
        });
    });

    colorPincel.addEventListener('input', function () {
        colorActual = this.value;
    });

    opacidadLote.addEventListener('input', function () {
        textoOpacidad.textContent = this.value + '%';
        dibujarColoresLotes();
    });

    opacidadPincel.addEventListener('input', function () {
        textoOpacidadPincel.textContent = this.value + '%';
    });

    separacionRayado.addEventListener('input', function () {
        textoSeparacionRayado.textContent = this.value + ' px';
    });

    grosorRayado.addEventListener('input', function () {
        textoGrosorRayado.textContent = this.value + ' px';
    });

    opacidadRayado.addEventListener('input', function () {
        textoOpacidadRayado.textContent = this.value + '%';
    });


    /*
    |--------------------------------------------------------------------------
    | HERRAMIENTAS
    |--------------------------------------------------------------------------
    */

    function activarHerramienta(herramienta) {

        herramientaActual = herramienta;

        const mensajes = {
            pintarLote:
                'Haga clic dentro de un lote para rellenar todo su polígono.',
            rayarLote:
                'Haga clic dentro de un lote para generar rayas paralelas automáticamente.',
            rayarZona:
                'Marque con clics el contorno de la parte que desea rayar y después pulse “Cerrar zona”.',
            pincel:
                'Arrastre el mouse sobre el mapa para dibujar libremente.',
            linea:
                'Arrastre desde el punto inicial hasta el punto final.',
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

    btnPintarZona.addEventListener('click', function () {

        cancelarZonaParcial();

        tipoZonaParcial =
            'solido';

        activarHerramienta(
            'zonaParcial'
        );

        mensajeHerramienta.textContent =
            'Marque con clics la parte que desea pintar y después pulse “Cerrar zona”.';
    });


    btnRayarZona.addEventListener('click', function () {

        cancelarZonaParcial();

        tipoZonaParcial =
            'rayado';

        activarHerramienta(
            'zonaParcial'
        );

        mensajeHerramienta.textContent =
            'Marque con clics la parte que desea rayar y después pulse “Cerrar zona”.';
    });

    btnPincel.addEventListener('click', function () {
        cancelarZonaParcial();
        activarHerramienta('pincel');
    });

    btnLinea.addEventListener('click', function () {
        cancelarZonaParcial();
        activarHerramienta('linea');
    });

    btnBorrador.addEventListener('click', function () {
        cancelarZonaParcial();
        activarHerramienta('borrador');
    });


    /*
    |--------------------------------------------------------------------------
    | CONTROLES DE LA ZONA PARCIAL
    |--------------------------------------------------------------------------
    */

    btnCerrarZona.addEventListener('click', function () {

        if (herramientaActual !== 'zonaParcial') {
            mensajeHerramienta.textContent =
                'Primero pulse “Zona parcial”.';
            return;
        }

        if (!loteZonaActual) {
            mensajeHerramienta.textContent =
                'Primero marque un punto dentro de un lote.';
            return;
        }

        if (puntosZonaActual.length < 3) {
            mensajeHerramienta.textContent =
                'Debe marcar al menos 3 puntos para cerrar la zona.';
            return;
        }

        guardarEstado();

        const puntosGuardados =
            puntosZonaActual.map(function (punto) {
                return [
                    Number(punto[0]),
                    Number(punto[1])
                ];
            });

        const nombreLote =
            loteZonaActual.nombre;

        if (tipoZonaParcial === 'solido') {

            zonasPintadas.push({
                lote_id: loteZonaActual.id,
                color: colorActual,
                opacidad: Number(opacidadLote.value),
                puntos: puntosGuardados
            });

        } else {

            zonasRayadas.push({
                lote_id: loteZonaActual.id,
                color: colorActual,
                angulo: Number(direccionRayado.value),
                separacion: Number(separacionRayado.value),
                grosor: Number(grosorRayado.value),
                opacidad: Number(opacidadRayado.value),
                puntos: puntosGuardados
            });
        }

        const tipoAplicado =
            tipoZonaParcial === 'solido'
                ? 'pintada'
                : 'rayada';

        cancelarZonaParcial();
        dibujarColoresLotes();

        mensajeHerramienta.textContent =
            'Zona parcial del LOTE ' +
            nombreLote +
            ' ' +
            tipoAplicado +
            ' correctamente. Puede marcar otra zona.';
    });

    btnDeshacerPuntoZona.addEventListener('click', function () {

        if (
            herramientaActual !== 'zonaParcial' ||
            puntosZonaActual.length === 0
        ) {
            mensajeHerramienta.textContent =
                'No hay puntos de una zona parcial para deshacer.';
            return;
        }

        puntosZonaActual.pop();

        if (puntosZonaActual.length === 0) {
            loteZonaActual = null;
        }

        dibujarVistaPreviaZona();

        mensajeHerramienta.textContent =
            puntosZonaActual.length +
            ' punto(s) marcado(s) en la zona parcial.';
    });

    btnCancelarZona.addEventListener('click', function () {
        cancelarZonaParcial(
            'Selección de zona parcial cancelada.'
        );
    });


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
                copiarCanvasDibujo()

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

        ctxDibujo.globalAlpha =
            herramientaActual === 'borrador'
                ? 1
                : Number(opacidadPincel.value) / 100;
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
    | INICIAR ACCIÓN SOBRE EL MAPA
    |--------------------------------------------------------------------------
    */

    function iniciarAccion(event) {

        event.preventDefault();

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

        if (herramientaActual === 'zonaParcial') {

            if (
                tipoZonaParcial !== 'solido' &&
                tipoZonaParcial !== 'rayado'
            ) {
                mensajeHerramienta.textContent =
                    'Seleccione “Pintar zona” o “Rayar zona”.';

                return;
            }

            const loteDetectado = buscarLote(posicion);

            /*
            | El primer punto determina el lote al que pertenecerá la zona.
            */
            if (!loteZonaActual) {

                if (!loteDetectado) {
                    mensajeHerramienta.textContent =
                        'El primer punto debe estar dentro de un lote configurado.';
                    return;
                }

                loteZonaActual = loteDetectado;
            }

            /*
            | Los siguientes puntos deben permanecer dentro del mismo lote.
            */
            const xNormalizado =
                posicion.x / canvasDibujo.width;

            const yNormalizado =
                posicion.y / canvasDibujo.height;

            if (
                !puntoDentroPoligono(
                    xNormalizado,
                    yNormalizado,
                    loteZonaActual.puntos
                )
            ) {
                mensajeHerramienta.textContent =
                    'Ese punto está fuera del LOTE ' +
                    loteZonaActual.nombre +
                    '. Marque la zona dentro del mismo lote.';
                return;
            }

            puntosZonaActual.push([
                xNormalizado,
                yNormalizado
            ]);

            dibujarVistaPreviaZona();

            mensajeHerramienta.textContent =
                'LOTE ' +
                loteZonaActual.nombre +
                ': ' +
                puntosZonaActual.length +
                ' punto(s). Cuando termine pulse “Cerrar zona”.';

            return;
        }

        /*
        | Pincel, línea y borrador guardan el estado antes de comenzar.
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

        if (herramientaActual === 'pincel') {

            ctxDibujo.globalCompositeOperation =
                'source-over';

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

            ultimoX =
                posicion.x;

            ultimoY =
                posicion.y;
        }


        if (herramientaActual === 'borrador') {

            /*
            | El arrastre borra pincel y líneas.
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

            ultimoX =
                posicion.x;

            ultimoY =
                posicion.y;
        }

        if (herramientaActual === 'linea') {

            const base =
                historialDibujo[historialDibujo.length - 1];

            ctxDibujo.clearRect(
                0,
                0,
                canvasDibujo.width,
                canvasDibujo.height
            );

            if (base) {
                ctxDibujo.globalCompositeOperation = 'source-over';
                ctxDibujo.drawImage(base, 0, 0);
            }

            ctxDibujo.globalCompositeOperation = 'source-over';
            configurarDibujo();
            ctxDibujo.beginPath();
            ctxDibujo.moveTo(inicioX, inicioY);
            ctxDibujo.lineTo(posicion.x, posicion.y);
            ctxDibujo.stroke();
        }
    }

    function terminarAccion() {

        dibujando = false;
        ctxDibujo.globalCompositeOperation = 'source-over';
        ctxDibujo.globalAlpha = 1;
    }

    canvasDibujo.addEventListener('mousedown', iniciarAccion);
    canvasDibujo.addEventListener('mousemove', moverAccion);
    canvasDibujo.addEventListener('mouseup', terminarAccion);
    canvasDibujo.addEventListener('mouseleave', terminarAccion);

    canvasDibujo.addEventListener(
        'touchstart',
        iniciarAccion,
        { passive: false }
    );

    canvasDibujo.addEventListener(
        'touchmove',
        moverAccion,
        { passive: false }
    );

    canvasDibujo.addEventListener('touchend', terminarAccion);


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

        haciendaActual = buscarHaciendaSeleccionada();

        limpiarMapaDelDia();
        lotesActuales = {};

        cargarLotesDesdeBaseDatos();
        cargarImagenHacienda();
    });

    fecha.addEventListener('change', function () {

        limpiarMapaDelDia(
            'Nueva fecha seleccionada. El mapa está listo para registrar este día.'
        );
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

        /*
        | Si todavía no hay acciones del día, garantizar que el
        | cambio o recarga de imagen no restaure marcas anteriores.
        */
        if (
            Object.keys(coloresLotes).length === 0 &&
            Object.keys(rayadosLotes).length === 0 &&
            zonasPintadas.length === 0 &&
            zonasRayadas.length === 0 &&
            historialAcciones.length === 0
        ) {
            limpiarMapaDelDia();
        }
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
        | El mapa siempre comienza limpio al abrir una semana.
        | La matriz sí se recupera desde la base de datos.
        */
        limpiarMapaDelDia(
            'Mapa limpio. Cargando únicamente la matriz semanal...'
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

            /*
            | El mapa es diario y temporal.
            | Al abrir una semana solamente recuperamos la matriz.
            */
            limpiarMapaDelDia();

            if (datos.existe === true) {

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
                    lotes_pintados:
                        coloresLotes,

                    lotes_rayados:
                        rayadosLotes,

                    zonas_pintadas:
                        zonasPintadas,

                    zonas_rayadas:
                        zonasRayadas,

                    opacidad_lote:
                        Number(opacidadLote.value)
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
                | Pincel, líneas y borrados.
                */
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

                        limpiarMapaDelDia(
                            'PDF descargado. El mapa quedó limpio para registrar el siguiente día.'
                        );

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