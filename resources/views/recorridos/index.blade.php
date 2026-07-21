@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 py-6">

    <!-- ========================================================= -->
    <!-- CABECERA -->
    <!-- ========================================================= -->

    <div class="bg-green-800 rounded-xl shadow-lg p-6 text-white">

        <h1 class="text-3xl md:text-4xl font-bold">
            Registro de Área Recorrida
        </h1>

        <p class="text-green-200 mt-1">
            Agrícola Quintana
        </p>


        <!-- FORMULARIO DE SELECCIÓN -->

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mt-8">


            <!-- HACIENDA -->

            <div>

                <label class="block mb-2 font-semibold">
                    Hacienda
                </label>

                <select
                    id="hacienda"
                    class="w-full rounded-lg border border-gray-300 bg-white text-black px-3 py-2">

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


            <!-- SEMANA -->

            <div>

                <label class="block mb-2 font-semibold">
                    Semana
                </label>

                <select
                    id="semana"
                    class="w-full rounded-lg border border-gray-300 bg-white text-black px-3 py-2">

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


            <!-- FECHA -->

            <div>

                <label class="block mb-2 font-semibold">
                    Fecha
                </label>

                <input
                    id="fecha"
                    type="date"
                    value="{{ date('Y-m-d') }}"
                    class="w-full rounded-lg border border-gray-300 bg-white text-black px-3 py-2">

            </div>


            <!-- USUARIO -->

            <div>

                <label class="block mb-2 font-semibold">
                    Usuario
                </label>

                <input
                    readonly
                    value="{{ auth()->user()->name }}"
                    class="w-full rounded-lg border border-gray-300 bg-gray-200 text-black px-3 py-2">

            </div>

        </div>


        <!-- BOTÓN ABRIR -->

        <div class="mt-6">

            <button
                id="btnAbrir"
                type="button"
                class="bg-white text-green-800 px-6 py-3 rounded-lg font-bold hover:bg-green-100 transition">

                Abrir Semana

            </button>

        </div>

    </div>


    <!-- ========================================================= -->
    <!-- MAPA -->
    <!-- ========================================================= -->

    <div class="bg-white rounded-xl shadow-lg mt-8 overflow-hidden">

        <div class="bg-green-800 text-white px-5 py-3">

            <h2 class="font-semibold">
                Mapa de Hacienda
            </h2>

        </div>


        <div class="p-4 sm:p-6">

            <img
                id="mapa"
                src="{{ asset('mapas/domenica.png') }}"
                class="mx-auto border rounded-lg w-full h-auto object-contain">

        </div>

    </div>


    <!-- ========================================================= -->
    <!-- MATRIZ -->
    <!-- ========================================================= -->

    <div
        id="contenedorMatriz"
        class="hidden bg-white rounded-xl shadow-lg mt-8 p-4 sm:p-6 overflow-hidden">

    </div>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {


    /*
    |--------------------------------------------------------------------------
    | ELEMENTOS
    |--------------------------------------------------------------------------
    */

    const hacienda =
        document.getElementById('hacienda');

    const semana =
        document.getElementById('semana');

    const fecha =
        document.getElementById('fecha');

    const mapa =
        document.getElementById('mapa');

    const btnAbrir =
        document.getElementById('btnAbrir');

    const matriz =
        document.getElementById('contenedorMatriz');


    /*
    |--------------------------------------------------------------------------
    | CAMBIAR MAPA SEGÚN HACIENDA
    |--------------------------------------------------------------------------
    */

    hacienda.addEventListener('change', function () {

        const texto =
            this.options[this.selectedIndex]
                .text
                .toUpperCase();


        if (texto.includes('DOMENICA')) {

            mapa.src =
                "{{ asset('mapas/domenica.png') }}";

        } else {

            mapa.src =
                "{{ asset('mapas/maria_maria.png') }}";

        }

    });


    /*
    |--------------------------------------------------------------------------
    | ABRIR SEMANA
    |--------------------------------------------------------------------------
    */

    btnAbrir.addEventListener(
        'click',
        async function () {


            /*
            |--------------------------------------------------------------------------
            | VALIDACIONES
            |--------------------------------------------------------------------------
            */

            if (hacienda.value === '') {

                alert(
                    'Seleccione una hacienda'
                );

                return;

            }


            if (semana.value === '') {

                alert(
                    'Seleccione una semana'
                );

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | MOSTRAR MATRIZ
            |--------------------------------------------------------------------------
            */

            matriz.classList.remove('hidden');


            matriz.innerHTML = `

                <div class="text-center py-10">

                    <p class="font-semibold text-gray-700">

                        Consultando información...

                    </p>

                </div>

            `;


            try {


                /*
                |--------------------------------------------------------------------------
                | CONSULTAR BACKEND
                |--------------------------------------------------------------------------
                */

                const respuesta =
                    await fetch(
                        "{{ route('recorridos.abrir') }}",
                        {

                            method: "POST",

                            headers: {

                                "Content-Type":
                                    "application/json",

                                "Accept":
                                    "application/json",

                                "X-CSRF-TOKEN":
                                    document
                                        .querySelector(
                                            'meta[name="csrf-token"]'
                                        )
                                        .getAttribute('content')

                            },


                            body:
                                JSON.stringify({

                                    hacienda_id:
                                        hacienda.value,

                                    semana:
                                        semana.value,

                                    anio:
                                        new Date()
                                            .getFullYear()

                                })

                        }
                    );


                /*
                |--------------------------------------------------------------------------
                | LEER RESPUESTA
                |--------------------------------------------------------------------------
                */

                const datos =
                    await respuesta.json();


                console.log(
                    'Respuesta Laravel:',
                    datos
                );


                if (!respuesta.ok) {

                    throw new Error(

                        datos.message ||
                        `Error HTTP ${respuesta.status}`

                    );

                }


                /*
                |--------------------------------------------------------------------------
                | PREPARAR VARIABLES
                |--------------------------------------------------------------------------
                */

                let lotes = [];

                let detallesExistentes = {};


                /*
                |--------------------------------------------------------------------------
                | RECORRIDO EXISTENTE
                |--------------------------------------------------------------------------
                */

                if (datos.existe === true) {


                    /*
                    |--------------------------------------------------------------
                    | Si Laravel devuelve detalles directamente
                    |--------------------------------------------------------------
                    */

                    if (
                        datos.detalles &&
                        Array.isArray(datos.detalles)
                    ) {

                        datos.detalles.forEach(
                            detalle => {

                                detallesExistentes[
                                    detalle.lote_id
                                ] = detalle;

                            }
                        );


                        lotes =
                            datos.detalles.map(
                                detalle =>
                                    detalle.lote
                            );

                    }


                    /*
                    |--------------------------------------------------------------
                    | Si vienen dentro del recorrido
                    |--------------------------------------------------------------
                    */

                    else if (
                        datos.recorrido &&
                        datos.recorrido.detalles
                    ) {

                        datos.recorrido
                            .detalles
                            .forEach(
                                detalle => {

                                    detallesExistentes[
                                        detalle.lote_id
                                    ] = detalle;

                                }
                            );


                        lotes =
                            datos.recorrido
                                .detalles
                                .map(
                                    detalle =>
                                        detalle.lote
                                );

                    }

                }


                /*
                |--------------------------------------------------------------------------
                | RECORRIDO NUEVO
                |--------------------------------------------------------------------------
                */

                else {

                    lotes =
                        datos.lotes || [];

                }


                /*
                |--------------------------------------------------------------------------
                | GENERAR FILAS
                |--------------------------------------------------------------------------
                */

                let filas = '';

                let totalHasProd = 0;


                lotes.forEach(
                    lote => {


                        /*
                        |----------------------------------------------------------
                        | DETALLE EXISTENTE
                        |----------------------------------------------------------
                        */

                        const detalle =
                            detallesExistentes[
                                lote.id
                            ] || {};


                        /*
                        |----------------------------------------------------------
                        | VALORES
                        |----------------------------------------------------------
                        */

                        const lunes =
                            detalle.lunes ?? '';

                        const martes =
                            detalle.martes ?? '';

                        const miercoles =
                            detalle.miercoles ?? '';

                        const jueves =
                            detalle.jueves ?? '';

                        const viernes =
                            detalle.viernes ?? '';

                        const sabado =
                            detalle.sabado ?? '';


                        /*
                        |----------------------------------------------------------
                        | SUMAR HAS PROD
                        |----------------------------------------------------------
                        */

                        totalHasProd +=
                            parseFloat(
                                lote.has_prod
                            ) || 0;


                        /*
                        |----------------------------------------------------------
                        | FILA
                        |----------------------------------------------------------
                        */

                        filas += `

                            <tr
                                data-lote-id="${lote.id}"
                                data-has-prod="${lote.has_prod}"
                                class="hover:bg-green-50"
                            >

                                <!-- LOTE -->

                                <td class="border px-2 py-2 text-center font-semibold whitespace-nowrap">

                                    ${lote.nombre}

                                </td>


                                <!-- HAS PROD -->

                                <td class="border px-2 py-2 text-center whitespace-nowrap">

                                    ${parseFloat(
                                        lote.has_prod || 0
                                    ).toFixed(2)}

                                </td>


                                <!-- LUNES -->

                                <td class="border px-2 py-2">

                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        value="${lunes}"
                                        class="campo-dia lunes w-full min-w-[80px] border border-gray-300 rounded px-2 py-2 text-center"
                                    >

                                </td>


                                <!-- MARTES -->

                                <td class="border px-2 py-2">

                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        value="${martes}"
                                        class="campo-dia martes w-full min-w-[80px] border border-gray-300 rounded px-2 py-2 text-center"
                                    >

                                </td>


                                <!-- MIÉRCOLES -->

                                <td class="border px-2 py-2">

                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        value="${miercoles}"
                                        class="campo-dia miercoles w-full min-w-[80px] border border-gray-300 rounded px-2 py-2 text-center"
                                    >

                                </td>


                                <!-- JUEVES -->

                                <td class="border px-2 py-2">

                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        value="${jueves}"
                                        class="campo-dia jueves w-full min-w-[80px] border border-gray-300 rounded px-2 py-2 text-center"
                                    >

                                </td>


                                <!-- VIERNES -->

                                <td class="border px-2 py-2">

                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        value="${viernes}"
                                        class="campo-dia viernes w-full min-w-[80px] border border-gray-300 rounded px-2 py-2 text-center"
                                    >

                                </td>


                                <!-- SÁBADO -->

                                <td class="border px-2 py-2">

                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        value="${sabado}"
                                        class="campo-dia sabado w-full min-w-[80px] border border-gray-300 rounded px-2 py-2 text-center"
                                    >

                                </td>


                                <!-- TOTAL SEMANA -->

                                <td class="border px-2 py-2 text-center font-bold whitespace-nowrap">

                                    <span class="total-semana">
                                        0.00
                                    </span>

                                </td>


                                <!-- PORCENTAJE -->

                                <td class="border px-2 py-2 text-center font-bold whitespace-nowrap">

                                    <span class="porcentaje">
                                        0.00%
                                    </span>

                                </td>

                            </tr>

                        `;

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | DIBUJAR MATRIZ
                |--------------------------------------------------------------------------
                */

                matriz.innerHTML = `

                    <div class="w-full">


                        <!-- CABECERA MATRIZ -->

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


                                <span
                                    id="totalHasProd"
                                    class="font-bold text-green-800"
                                >

                                    ${totalHasProd.toFixed(2)}

                                </span>

                            </div>

                        </div>


                        <!-- TABLA -->

                        <div class="w-full overflow-x-auto">

                            <table
                                class="w-full border-collapse border border-gray-300 text-sm"
                                style="min-width: 950px;"
                            >


                                <thead>

                                    <tr class="bg-green-800 text-white">


                                        <th class="border px-3 py-3 text-center whitespace-nowrap">
                                            Lotes
                                        </th>


                                        <th class="border px-3 py-3 text-center whitespace-nowrap">
                                            Has-prod
                                        </th>


                                        <th class="border px-3 py-3 text-center whitespace-nowrap">
                                            Lunes
                                        </th>


                                        <th class="border px-3 py-3 text-center whitespace-nowrap">
                                            Martes
                                        </th>


                                        <th class="border px-3 py-3 text-center whitespace-nowrap">
                                            Miércoles
                                        </th>


                                        <th class="border px-3 py-3 text-center whitespace-nowrap">
                                            Jueves
                                        </th>


                                        <th class="border px-3 py-3 text-center whitespace-nowrap">
                                            Viernes
                                        </th>


                                        <th class="border px-3 py-3 text-center whitespace-nowrap">
                                            Sábado
                                        </th>


                                        <th class="border px-3 py-3 text-center whitespace-nowrap">
                                            Total Semana
                                        </th>


                                        <th class="border px-3 py-3 text-center whitespace-nowrap">
                                            % Área
                                        </th>


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


                                        <td
                                            id="totalHasProdFooter"
                                            class="border px-3 py-3 text-center"
                                        >

                                            ${totalHasProd.toFixed(2)}

                                        </td>


                                        <td
                                            colspan="6"
                                            class="border"
                                        >

                                        </td>


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


                        <!-- BOTÓN GUARDAR -->

                        <div class="mt-6 flex justify-end">

                            <button
                                id="btnGuardarRecorrido"
                                type="button"
                                class="bg-green-800 text-white px-6 py-3 rounded-lg font-bold hover:bg-green-900 transition"
                            >

                                Guardar Recorrido

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
                        .querySelectorAll(
                            '#contenedorMatriz tbody tr'
                        )
                        .forEach(
                            fila => {


                                /*
                                |--------------------------------------------------
                                | HAS PROD
                                |--------------------------------------------------
                                */

                                const hasProd =
                                    parseFloat(
                                        fila.dataset.hasProd
                                    ) || 0;


                                /*
                                |--------------------------------------------------
                                | CALCULAR TOTAL FILA
                                |--------------------------------------------------
                                */

                                let total = 0;


                                fila
                                    .querySelectorAll(
                                        '.campo-dia'
                                    )
                                    .forEach(
                                        input => {

                                            total +=
                                                parseFloat(
                                                    input.value
                                                ) || 0;

                                        }
                                    );


                                /*
                                |--------------------------------------------------
                                | MOSTRAR TOTAL
                                |--------------------------------------------------
                                */

                                const totalElemento =
                                    fila.querySelector(
                                        '.total-semana'
                                    );


                                totalElemento.textContent =
                                    total.toFixed(2);


                                /*
                                |--------------------------------------------------
                                | CALCULAR PORCENTAJE
                                |--------------------------------------------------
                                */

                                let porcentaje = 0;


                                if (hasProd > 0) {

                                    porcentaje =
                                        (
                                            total /
                                            hasProd
                                        ) * 100;

                                }


                                const porcentajeElemento =
                                    fila.querySelector(
                                        '.porcentaje'
                                    );


                                porcentajeElemento.textContent =
                                    porcentaje.toFixed(2) +
                                    '%';


                                /*
                                |--------------------------------------------------
                                | ACUMULAR TOTAL
                                |--------------------------------------------------
                                */

                                totalGeneral += total;

                            }
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | TOTAL GENERAL
                    |--------------------------------------------------------------------------
                    */

                    const totalSemanaGeneral =
                        document.getElementById(
                            'totalSemanaGeneral'
                        );


                    if (totalSemanaGeneral) {

                        totalSemanaGeneral.textContent =
                            totalGeneral.toFixed(2);

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | PORCENTAJE GENERAL
                    |--------------------------------------------------------------------------
                    */

                    let porcentajeGeneral = 0;


                    if (totalHasProd > 0) {

                        porcentajeGeneral =
                            (
                                totalGeneral /
                                totalHasProd
                            ) * 100;

                    }


                    const porcentajeGeneralElemento =
                        document.getElementById(
                            'porcentajeGeneral'
                        );


                    if (porcentajeGeneralElemento) {

                        porcentajeGeneralElemento.textContent =
                            porcentajeGeneral.toFixed(2) +
                            '%';

                    }

                }


                /*
                |--------------------------------------------------------------------------
                | EVENTOS DE LOS INPUTS
                |--------------------------------------------------------------------------
                */

                document
                    .querySelectorAll(
                        '#contenedorMatriz .campo-dia'
                    )
                    .forEach(
                        input => {

                            input.addEventListener(
                                'input',
                                calcularTotales
                            );

                        }
                    );


                /*
                |--------------------------------------------------------------------------
                | CALCULAR AL ABRIR
                |--------------------------------------------------------------------------
                */

                calcularTotales();


                /*
                |--------------------------------------------------------------------------
                | BOTÓN GUARDAR
                |--------------------------------------------------------------------------
                */

                const btnGuardar =
                    document.getElementById(
                        'btnGuardarRecorrido'
                    );


                if (btnGuardar) {


                    btnGuardar.addEventListener(
                        'click',
                        async function () {


                            /*
                            |------------------------------------------------------
                            | DESACTIVAR BOTÓN
                            |------------------------------------------------------
                            */

                            btnGuardar.disabled = true;

                            btnGuardar.textContent =
                                'Guardando...';


                            try {


                                /*
                                |--------------------------------------------------
                                | RECOPILAR DETALLES
                                |--------------------------------------------------
                                */

                                const detalles = [];


                                document
                                    .querySelectorAll(
                                        '#contenedorMatriz tbody tr'
                                    )
                                    .forEach(
                                        fila => {


                                            detalles.push({

                                                lote_id:
                                                    fila.dataset.loteId,

                                                lunes:
                                                    fila
                                                        .querySelector(
                                                            '.lunes'
                                                        )
                                                        .value ||
                                                    null,

                                                martes:
                                                    fila
                                                        .querySelector(
                                                            '.martes'
                                                        )
                                                        .value ||
                                                    null,

                                                miercoles:
                                                    fila
                                                        .querySelector(
                                                            '.miercoles'
                                                        )
                                                        .value ||
                                                    null,

                                                jueves:
                                                    fila
                                                        .querySelector(
                                                            '.jueves'
                                                        )
                                                        .value ||
                                                    null,

                                                viernes:
                                                    fila
                                                        .querySelector(
                                                            '.viernes'
                                                        )
                                                        .value ||
                                                    null,

                                                sabado:
                                                    fila
                                                        .querySelector(
                                                            '.sabado'
                                                        )
                                                        .value ||
                                                    null

                                            });

                                        }
                                    );


                                /*
                                |--------------------------------------------------
                                | DATOS
                                |--------------------------------------------------
                                */

                                const datosGuardar = {


                                    hacienda_id:
                                        hacienda.value,


                                    semana:
                                        semana.value,


                                    anio:
                                        new Date()
                                            .getFullYear(),


                                    fecha:
                                        fecha.value,


                                    detalles:
                                        detalles

                                };


                                console.log(
                                    'Datos a guardar:',
                                    datosGuardar
                                );


                                /*
                                |--------------------------------------------------
                                | ENVIAR AL SERVIDOR
                                |--------------------------------------------------
                                */

                                const respuestaGuardar =
                                    await fetch(
                                        "{{ route('recorridos.store') }}",
                                        {

                                            method:
                                                'POST',

                                            headers: {

                                                'Content-Type':
                                                    'application/json',

                                                'Accept':
                                                    'application/json',

                                                'X-CSRF-TOKEN':
                                                    document
                                                        .querySelector(
                                                            'meta[name="csrf-token"]'
                                                        )
                                                        .getAttribute(
                                                            'content'
                                                        )

                                            },


                                            body:
                                                JSON.stringify(
                                                    datosGuardar
                                                )

                                        }
                                    );


                                /*
                                |--------------------------------------------------
                                | RESPUESTA
                                |--------------------------------------------------
                                */

                                const datos =
                                    await respuestaGuardar.json();


                                console.log(
                                    'Respuesta guardar:',
                                    datos
                                );


                                if (
                                    !respuestaGuardar.ok
                                ) {

                                    throw new Error(

                                        datos.message ||
                                        'Error al guardar el recorrido.'

                                    );

                                }


                                /*
                                |--------------------------------------------------
                                | ÉXITO
                                |--------------------------------------------------
                                */

                                alert(
                                    'Recorrido guardado correctamente.'
                                );


                                btnGuardar.disabled =
                                    false;


                                btnGuardar.textContent =
                                    'Guardar Recorrido';


                            } catch (error) {


                                console.error(
                                    'ERROR AL GUARDAR:',
                                    error
                                );


                                alert(
                                    'Error al guardar: ' +
                                    error.message
                                );


                                btnGuardar.disabled =
                                    false;


                                btnGuardar.textContent =
                                    'Guardar Recorrido';

                            }

                        }
                    );

                }


            } catch (error) {


                console.error(
                    'ERROR AL ABRIR SEMANA:',
                    error
                );


                matriz.innerHTML = `

                    <div class="p-6">

                        <div
                            class="bg-red-100 border border-red-400 text-red-700 px-4 py-4 rounded-lg"
                        >


                            <h3 class="font-bold text-lg mb-2">

                                Error al consultar la información

                            </h3>


                            <p>

                                ${error.message}

                            </p>


                        </div>

                    </div>

                `;

            }

        }
    );

});

</script>

@endsection